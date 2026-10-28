<?php

namespace Database\Factories;

use App\Models\Inscripcion;
use App\Models\Paralelo;
use App\Models\Participante;
use Illuminate\Database\Eloquent\Factories\Factory;

class InscripcionFactory extends Factory
{
    protected $model = Inscripcion::class;

    public function definition(): array
    {
        $estado = fake()->randomElement(['pagada', 'pagada', 'pagada', 'pendiente', 'anulada']);

        return [
            'participante_id' => Participante::factory(),
            'paralelo_id' => Paralelo::factory(),
            'fecha_inscripcion' => fake()->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),
            'monto_pagado' => fake()->randomElement([120.00, 150.00, 180.00, 200.00, 250.00]),
            'estado' => $estado,
        ];
    }
}
