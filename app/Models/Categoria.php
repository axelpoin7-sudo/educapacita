<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Una categoría tiene muchos cursos.
     */
    public function cursos()
    {
        return $this->hasMany(Curso::class, 'categoria_id');
    }
}
