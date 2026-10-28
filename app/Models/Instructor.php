<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $table = 'instructores';

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'especialidad',
        'biografia',
        'foto',
    ];

    /**
     * Paralelos a cargo de este instructor.
     */
    public function paralelos()
    {
        return $this->hasMany(Paralelo::class, 'instructor_id');
    }

    /**
     * URL de la fotografía o avatar generado.
     */
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
                return $this->foto;
            }
            if (str_starts_with($this->foto, 'uploads/')) {
                return asset($this->foto);
            }
            return asset('storage/' . $this->foto);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nombre) . '&background=4f46e5&color=fff&size=200';
    }
}
