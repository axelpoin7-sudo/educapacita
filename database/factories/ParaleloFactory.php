<?php

namespace Database\Factories;

use App\Models\Curso;
use App\Models\Instructor;
use App\Models\Paralelo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParaleloFactory extends Factory
{
    protected $model = Paralelo::class;

    public function definition(): array
    {
        $nombres = ['Paralelo A', 'Paralelo B', 'Paralelo C', 'Grupo Matutino', 'Grupo Vespertino', 'Grupo Nocturno', 'Grupo Sábados'];
        $aulas = ['Aula 101', 'Aula 102', 'Aula 201', 'Lab Cómputo 1', 'Lab Cómputo 2', 'Lab Multimedia', 'Aula Virtual A'];
        $horarios = [
            ['dias' => 'Lunes, Miércoles, Viernes', 'inicio' => '08:00:00', 'fin' => '10:00:00'],
            ['dias' => 'Lunes, Miércoles, Viernes', 'inicio' => '10:00:00', 'fin' => '12:00:00'],
            ['dias' => 'Lunes, Miércoles, Viernes', 'inicio' => '18:30:00', 'fin' => '20:30:00'],
            ['dias' => 'Martes, Jueves', 'inicio' => '08:30:00', 'fin' => '11:30:00'],
            ['dias' => 'Martes, Jueves', 'inicio' => '18:30:00', 'fin' => '21:30:00'],
            ['dias' => 'Sábados', 'inicio' => '08:00:00', 'fin' => '13:00:00'],
        ];

        $horario = fake()->randomElement($horarios);
        $fechaInicio = fake()->dateTimeBetween('-1 month', '-1 day');
        $fechaFin = Carbon::parse($fechaInicio)->addWeeks(fake()->numberBetween(6, 10));

        return [
            'curso_id' => Curso::factory(),
            'instructor_id' => Instructor::factory(),
            'nombre' => fake()->randomElement($nombres),
            'aula' => fake()->randomElement($aulas),
            'dias' => $horario['dias'],
            'hora_inicio' => $horario['inicio'],
            'hora_fin' => $horario['fin'],
            'fecha_inicio' => $fechaInicio->format('Y-m-d'),
            'fecha_fin' => $fechaFin->format('Y-m-d'),
            'cupo_maximo' => fake()->randomElement([15, 20, 25, 30]),
        ];
    }
}
