<?php

namespace Database\Factories;

use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstructorFactory extends Factory
{
    protected $model = Instructor::class;

    public function definition(): array
    {
        $especialidades = [
            'Ofimática Avanzada y Gestión Documental',
            'Desarrollo Web Fullstack (Laravel & React)',
            'Diseño Gráfico Publicitario y Branding',
            'Programación en Python y Ciencia de Datos',
            'Diseño de Interfaces UI/UX con Figma',
            'Bases de Datos Relacionales y PostgreSQL',
            'Excel Financiero y Análisis de Datos (Power BI)',
            'Desarrollo Móvil con Flutter y Dart',
            'Edición y Producción Audiovisual con Premiere',
            'Ciberseguridad y Redes Informáticas',
        ];

        return [
            'nombre' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'telefono' => fake()->phoneNumber(),
            'especialidad' => fake()->randomElement($especialidades),
            'biografia' => fake()->paragraph(2),
            'foto' => null,
        ];
    }
}
