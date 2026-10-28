<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;

    protected $table = 'inscripciones';

    protected $fillable = [
        'participante_id',
        'paralelo_id',
        'fecha_inscripcion',
        'monto_pagado',
        'estado',
    ];

    protected $casts = [
        'fecha_inscripcion' => 'date',
        'monto_pagado' => 'decimal:2',
    ];

    /**
     * El participante inscrito.
     */
    public function participante()
    {
        return $this->belongsTo(Participante::class, 'participante_id');
    }

    /**
     * El paralelo en el que está inscrito.
     */
    public function paralelo()
    {
        return $this->belongsTo(Paralelo::class, 'paralelo_id');
    }

    /**
     * Clases Tailwind CSS para el badge de estado.
     */
    public function getBadgeEstadoAttribute(): string
    {
        return match ($this->estado) {
            'pagada' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'pendiente' => 'bg-amber-100 text-amber-800 border-amber-200',
            'anulada' => 'bg-rose-100 text-rose-800 border-rose-200',
            default => 'bg-slate-100 text-slate-800 border-slate-200',
        };
    }
}
