<?php

namespace Database\Factories;

use App\Models\Participante;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParticipanteFactory extends Factory
{
    protected $model = Participante::class;

    public function definition(): array
    {
        return [
            'dni' => fake()->unique()->numerify('########'),
            'nombre' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'telefono' => fake()->phoneNumber(),
        ];
    }
}
