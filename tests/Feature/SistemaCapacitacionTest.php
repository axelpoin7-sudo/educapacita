<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Curso;
use App\Models\Inscripcion;
use App\Models\Instructor;
use App\Models\Paralelo;
use App\Models\Participante;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SistemaCapacitacionTest extends TestCase
{
    use RefreshDatabase;

    protected User $usuario;

    protected function setUp(): void
    {
        parent::setUp();
        $this->usuario = User::factory()->create([
            'es_admin' => true,
        ]);
    }

    public function test_modulos_principales_cargan_correctamente(): void
    {
        $this->actingAs($this->usuario);

        $rutas = [
            route('dashboard'),
            route('categorias.index'),
            route('cursos.index'),
            route('instructores.index'),
            route('paralelos.index'),
            route('participantes.index'),
            route('inscripciones.index'),
            route('reportes.inscritos_por_paralelo'),
            route('reportes.ingresos_por_curso'),
        ];

        foreach ($rutas as $ruta) {
            $response = $this->get($ruta);
            $response->assertStatus(200);
        }
    }

    public function test_creacion_de_categoria(): void
    {
        $this->actingAs($this->usuario);

        $response = $this->post(route('categorias.store'), [
            'nombre' => 'Ciberseguridad y Redes',
            'descripcion' => 'Seguridad perimetral y administración de redes.',
        ]);

        $response->assertRedirect(route('categorias.index'));
        $this->assertDatabaseHas('categorias', [
            'nombre' => 'Ciberseguridad y Redes',
        ]);
    }

    public function test_creacion_de_curso(): void
    {
        $this->actingAs($this->usuario);
        $categoria = Categoria::factory()->create();

        $response = $this->post(route('cursos.store'), [
            'categoria_id' => $categoria->id,
            'titulo' => 'Laravel 12 desde Cero',
            'descripcion' => 'Desarrollo web moderno con PHP y Laravel.',
            'precio' => 180.00,
            'duracion_horas' => 40,
        ]);

        $response->assertRedirect(route('cursos.index'));
        $this->assertDatabaseHas('cursos', [
            'titulo' => 'Laravel 12 desde Cero',
            'precio' => 180.00,
        ]);
    }

    public function test_validacion_de_cupo_maximo_en_inscripcion(): void
    {
        $this->actingAs($this->usuario);

        $curso = Curso::factory()->create(['precio' => 100.00]);
        $instructor = Instructor::factory()->create();
        $paralelo = Paralelo::factory()->create([
            'curso_id' => $curso->id,
            'instructor_id' => $instructor->id,
            'cupo_maximo' => 1,
            'dias' => 'Lunes, Miércoles, Viernes',
            'hora_inicio' => '08:00:00',
            'hora_fin' => '10:00:00',
        ]);

        $participante1 = Participante::factory()->create();
        $participante2 = Participante::factory()->create();

        // 1. Inscribir alumno 1 (llena el cupo de 1)
        Inscripcion::create([
            'participante_id' => $participante1->id,
            'paralelo_id' => $paralelo->id,
            'fecha_inscripcion' => Carbon::now()->format('Y-m-d'),
            'monto_pagado' => 100.00,
            'estado' => 'pagada',
        ]);

        // 2. Intentar inscribir alumno 2 al mismo paralelo lleno
        $response = $this->post(route('inscripciones.store'), [
            'participante_id' => $participante2->id,
            'paralelo_id' => $paralelo->id,
            'fecha_inscripcion' => Carbon::now()->format('Y-m-d'),
            'monto_pagado' => 100.00,
            'estado' => 'pagada',
        ]);

        // Debe fallar con error de validación en paralelo_id
        $response->assertSessionHasErrors('paralelo_id');
        $this->assertDatabaseMissing('inscripciones', [
            'participante_id' => $participante2->id,
            'paralelo_id' => $paralelo->id,
        ]);
    }

    public function test_validacion_de_horario_cruzado_en_inscripcion(): void
    {
        $this->actingAs($this->usuario);

        $curso1 = Curso::factory()->create(['precio' => 100.00]);
        $curso2 = Curso::factory()->create(['precio' => 120.00]);
        $instructor = Instructor::factory()->create();

        // Paralelo 1: Lunes, Miércoles de 08:00 a 10:00
        $paralelo1 = Paralelo::factory()->create([
            'curso_id' => $curso1->id,
            'instructor_id' => $instructor->id,
            'cupo_maximo' => 20,
            'dias' => 'Lunes, Miércoles',
            'hora_inicio' => '08:00:00',
            'hora_fin' => '10:00:00',
            'fecha_inicio' => Carbon::now()->format('Y-m-d'),
            'fecha_fin' => Carbon::now()->addWeeks(4)->format('Y-m-d'),
        ]);

        // Paralelo 2: Coincide en días (Lunes, Miércoles) y horario (09:00 a 11:00 se cruza con 08:00 a 10:00)
        $paralelo2 = Paralelo::factory()->create([
            'curso_id' => $curso2->id,
            'instructor_id' => $instructor->id,
            'cupo_maximo' => 20,
            'dias' => 'Lunes, Miércoles',
            'hora_inicio' => '09:00:00',
            'hora_fin' => '11:00:00',
            'fecha_inicio' => Carbon::now()->format('Y-m-d'),
            'fecha_fin' => Carbon::now()->addWeeks(4)->format('Y-m-d'),
        ]);

        $participante = Participante::factory()->create();

        // Inscribir en Paralelo 1
        Inscripcion::create([
            'participante_id' => $participante->id,
            'paralelo_id' => $paralelo1->id,
            'fecha_inscripcion' => Carbon::now()->format('Y-m-d'),
            'monto_pagado' => 100.00,
            'estado' => 'pagada',
        ]);

        // Intentar inscribir al mismo alumno en Paralelo 2 (debe dar choque de horario)
        $response = $this->post(route('inscripciones.store'), [
            'participante_id' => $participante->id,
            'paralelo_id' => $paralelo2->id,
            'fecha_inscripcion' => Carbon::now()->format('Y-m-d'),
            'monto_pagado' => 120.00,
            'estado' => 'pagada',
        ]);

        $response->assertSessionHasErrors('paralelo_id');
        $this->assertDatabaseMissing('inscripciones', [
            'participante_id' => $participante->id,
            'paralelo_id' => $paralelo2->id,
        ]);
    }
}
