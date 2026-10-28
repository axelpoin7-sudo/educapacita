<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paralelo extends Model
{
    use HasFactory;

    protected $table = 'paralelos';

    protected $fillable = [
        'curso_id',
        'instructor_id',
        'nombre',
        'aula',
        'dias',
        'hora_inicio',
        'hora_fin',
        'fecha_inicio',
        'fecha_fin',
        'cupo_maximo',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'cupo_maximo' => 'integer',
    ];

    /**
     * El curso al que pertenece este paralelo.
     */
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    /**
     * El instructor asignado al paralelo.
     */
    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    /**
     * Inscripciones en este paralelo.
     */
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'paralelo_id');
    }

    /**
     * Participantes matriculados en este paralelo.
     */
    public function participantes()
    {
        return $this->belongsToMany(Participante::class, 'inscripciones', 'paralelo_id', 'participante_id')
                    ->withPivot(['id', 'fecha_inscripcion', 'monto_pagado', 'estado'])
                    ->withTimestamps();
    }

    /**
     * Cantidad de inscripciones activas (excluyendo anuladas).
     */
    public function getInscritosActivosCountAttribute(): int
    {
        return $this->inscripciones()->where('estado', '!=', 'anulada')->count();
    }

    /**
     * Verifica si el paralelo alcanzó su cupo máximo.
     */
    public function estaLleno(): bool
    {
        return $this->inscritos_activos_count >= $this->cupo_maximo;
    }

    /**
     * Cupos disponibles restantes.
     */
    public function getCuposDisponiblesAttribute(): int
    {
        return max(0, $this->cupo_maximo - $this->inscritos_activos_count);
    }

    /**
     * Porcentaje de ocupación del cupo.
     */
    public function getPorcentajeOcupacionAttribute(): float
    {
        if ($this->cupo_maximo <= 0) {
            return 0;
        }
        return min(100, round(($this->inscritos_activos_count / $this->cupo_maximo) * 100, 1));
    }

    /**
     * Lista de días formateados en minúsculas para comparaciones.
     */
    public function getListaDiasAttribute(): array
    {
        if (empty($this->dias)) {
            return [];
        }
        return array_map(function ($dia) {
            return mb_strtolower(trim($dia));
        }, explode(',', $this->dias));
    }

    /**
     * Comprueba si este paralelo tiene conflicto de horario cruzado con otro paralelo.
     */
    public function tieneConflictoHorarioCon(Paralelo $otro): bool
    {
        if ($this->id && $otro->id && $this->id === $otro->id) {
            return false;
        }

        // 1. Solapamiento de rango de fechas
        $inicioEste = Carbon::parse($this->fecha_inicio)->startOfDay();
        $finEste = Carbon::parse($this->fecha_fin)->endOfDay();
        $inicioOtro = Carbon::parse($otro->fecha_inicio)->startOfDay();
        $finOtro = Carbon::parse($otro->fecha_fin)->endOfDay();

        if ($inicioEste->gt($finOtro) || $finEste->lt($inicioOtro)) {
            return false;
        }

        // 2. Solapamiento de días
        $diasEste = $this->lista_dias;
        $diasOtro = $otro->lista_dias;
        $diasCompartidos = array_intersect($diasEste, $diasOtro);
        if (empty($diasCompartidos)) {
            return false;
        }

        // 3. Solapamiento de horarios (horas)
        $horaInicioEste = Carbon::parse($this->hora_inicio)->format('H:i:s');
        $horaFinEste = Carbon::parse($this->hora_fin)->format('H:i:s');
        $horaInicioOtro = Carbon::parse($otro->hora_inicio)->format('H:i:s');
        $horaFinOtro = Carbon::parse($otro->hora_fin)->format('H:i:s');

        return ($horaInicioEste < $horaFinOtro) && ($horaFinEste > $horaInicioOtro);
    }
}
