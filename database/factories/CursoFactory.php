<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

class CursoFactory extends Factory
{
    protected $model = Curso::class;

    public function definition(): array
    {
        $imagenesEjemplo = [
            'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1587620962725-abab7fe55159?w=600&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=600&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1531403009284-440f080d1e12?w=600&auto=format&fit=crop&q=80',
        ];

        return [
            'categoria_id' => Categoria::factory(),
            'titulo' => 'Curso de '.fake()->words(3, true),
            'descripcion' => fake()->paragraph(2),
            'precio' => fake()->randomElement([120.00, 150.00, 180.00, 200.00, 250.00]),
            'duracion_horas' => fake()->randomElement([20, 30, 40, 60]),
            'imagen' => fake()->randomElement($imagenesEjemplo),
        ];
    }
}
