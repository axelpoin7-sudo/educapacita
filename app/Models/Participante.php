<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    use HasFactory;

    protected $table = 'participantes';

    protected $fillable = [
        'dni',
        'nombre',
        'email',
        'telefono',
    ];

    /**
     * Inscripciones realizadas por este participante.
     */
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'participante_id');
    }

    /**
     * Paralelos en los que está matriculado.
     */
    public function paralelos()
    {
        return $this->belongsToMany(Paralelo::class, 'inscripciones', 'participante_id', 'paralelo_id')
                    ->withPivot(['id', 'fecha_inscripcion', 'monto_pagado', 'estado'])
                    ->withTimestamps();
    }

    /**
     * Busca si el participante tiene alguna inscripción activa con horario cruzado con el paralelo objetivo.
     */
    public function buscarParaleloEnConflicto(Paralelo $paraleloObjetivo, ?int $ignorarInscripcionId = null): ?Paralelo
    {
        $inscripcionesActivas = $this->inscripciones()
            ->where('estado', '!=', 'anulada')
            ->when($ignorarInscripcionId, function ($query, $id) {
                $query->where('id', '!=', $id);
            })
            ->with(['paralelo.curso'])
            ->get();

        foreach ($inscripcionesActivas as $inscripcion) {
            $paraleloExistente = $inscripcion->paralelo;
            if ($paraleloExistente && $paraleloExistente->tieneConflictoHorarioCon($paraleloObjetivo)) {
                return $paraleloExistente;
            }
        }

        return null;
    }
}
