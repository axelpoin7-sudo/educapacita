<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    protected $fillable = [
        'categoria_id',
        'titulo',
        'descripcion',
        'precio',
        'duracion_horas',
        'imagen',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'duracion_horas' => 'integer',
    ];

    /**
     * Categoría a la que pertenece el curso.
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Paralelos que ofertan este curso.
     */
    public function paralelos()
    {
        return $this->hasMany(Paralelo::class, 'curso_id');
    }

    /**
     * Inscripciones a través de todos los paralelos del curso.
     */
    public function inscripciones()
    {
        return $this->hasManyThrough(Inscripcion::class, Paralelo::class, 'curso_id', 'paralelo_id');
    }

    /**
     * Calcular los ingresos totales generados por inscripciones pagadas.
     */
    public function getIngresosTotalesAttribute(): float
    {
        return (float) $this->inscripciones()->where('estado', 'pagada')->sum('monto_pagado');
    }

    /**
     * Obtener URL de la imagen o placeholder.
     */
    public function getImagenUrlAttribute(): string
    {
        if ($this->imagen) {
            if (str_starts_with($this->imagen, 'http://') || str_starts_with($this->imagen, 'https://')) {
                return $this->imagen;
            }
            if (str_starts_with($this->imagen, 'uploads/')) {
                return asset($this->imagen);
            }
            return asset('storage/' . $this->imagen);
        }

        return 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&auto=format&fit=crop&q=80';
    }
}
