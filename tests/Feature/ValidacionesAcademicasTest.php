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

class ValidacionesAcademicasTest extends TestCase
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

    public function test_rechaza_inscripcion_despues_de_fecha_fin_del_curso(): void
    {
        $this->actingAs($this->usuario);

        $curso = Curso::factory()->create(['precio' => 100.00]);
        $instructor = Instructor::factory()->create();
        $paralelo = Paralelo::factory()->create([
            'curso_id' => $curso->id,
            'instructor_id' => $instructor->id,
            'fecha_inicio' => '2026-05-01',
            'fecha_fin' => '2026-05-31',
        ]);
        $participante = Participante::factory()->create();

        // Intento de inscripción después de la fecha de fin (2026-06-05 > 2026-05-31)
        $response = $this->post(route('inscripciones.store'), [
            'participante_id' => $participante->id,
            'paralelo_id' => $paralelo->id,
            'fecha_inscripcion' => '2026-06-05',
            'monto_pagado' => 100.00,
            'estado' => 'pagada',
        ]);

        $response->assertSessionHasErrors('fecha_inscripcion');
        $this->assertDatabaseMissing('inscripciones', [
            'participante_id' => $participante->id,
            'paralelo_id' => $paralelo->id,
        ]);
    }

    public function test_rechaza_inscripcion_antes_de_fecha_inicio_del_curso(): void
    {
        $this->actingAs($this->usuario);

        $curso = Curso::factory()->create(['precio' => 100.00]);
        $instructor = Instructor::factory()->create();
        $paralelo = Paralelo::factory()->create([
            'curso_id' => $curso->id,
            'instructor_id' => $instructor->id,
            'fecha_inicio' => '2026-05-01',
            'fecha_fin' => '2026-05-31',
        ]);
        $participante = Participante::factory()->create();

        // Intento de inscripción antes de la fecha de inicio (2026-04-15 < 2026-05-01)
        $response = $this->post(route('inscripciones.store'), [
            'participante_id' => $participante->id,
            'paralelo_id' => $paralelo->id,
            'fecha_inscripcion' => '2026-04-15',
            'monto_pagado' => 100.00,
            'estado' => 'pagada',
        ]);

        $response->assertSessionHasErrors('fecha_inscripcion');
        $this->assertDatabaseMissing('inscripciones', [
            'participante_id' => $participante->id,
            'paralelo_id' => $paralelo->id,
        ]);
    }

    public function test_rechaza_inscripcion_con_paralelo_que_no_corresponde_al_curso_elegido(): void
    {
        $this->actingAs($this->usuario);

        $cursoA = Curso::factory()->create(['titulo' => 'Curso A']);
        $cursoB = Curso::factory()->create(['titulo' => 'Curso B']);
        $instructor = Instructor::factory()->create();

        // Paralelo perteneciente a Curso B
        $paraleloB = Paralelo::factory()->create([
            'curso_id' => $cursoB->id,
            'instructor_id' => $instructor->id,
            'fecha_inicio' => Carbon::now()->subDays(5)->format('Y-m-d'),
            'fecha_fin' => Carbon::now()->addWeeks(4)->format('Y-m-d'),
        ]);

        $participante = Participante::factory()->create();

        // Se envía curso_id de Curso A pero paralelo_id de Curso B
        $response = $this->post(route('inscripciones.store'), [
            'curso_id' => $cursoA->id,
            'participante_id' => $participante->id,
            'paralelo_id' => $paraleloB->id,
            'fecha_inscripcion' => Carbon::now()->format('Y-m-d'),
            'monto_pagado' => 100.00,
            'estado' => 'pagada',
        ]);

        $response->assertSessionHasErrors('paralelo_id');
        $this->assertDatabaseMissing('inscripciones', [
            'participante_id' => $participante->id,
            'paralelo_id' => $paraleloB->id,
        ]);
    }

    public function test_rechaza_participante_duplicado_en_el_mismo_curso(): void
    {
        $this->actingAs($this->usuario);

        $curso = Curso::factory()->create(['titulo' => 'Base de Datos Avanzada', 'precio' => 150.00]);
        $instructor = Instructor::factory()->create();

        // Dos paralelos diferentes pero del MISMO curso
        $paralelo1 = Paralelo::factory()->create([
            'curso_id' => $curso->id,
            'instructor_id' => $instructor->id,
            'nombre' => 'Paralelo 1',
            'dias' => 'Lunes, Miércoles',
            'hora_inicio' => '08:00:00',
            'hora_fin' => '10:00:00',
            'fecha_inicio' => Carbon::now()->subDays(2)->format('Y-m-d'),
            'fecha_fin' => Carbon::now()->addWeeks(4)->format('Y-m-d'),
        ]);

        $paralelo2 = Paralelo::factory()->create([
            'curso_id' => $curso->id,
            'instructor_id' => $instructor->id,
            'nombre' => 'Paralelo 2',
            'dias' => 'Martes, Jueves', // Horario no cruzado para probar la regla específica de curso duplicado
            'hora_inicio' => '18:00:00',
            'hora_fin' => '20:00:00',
            'fecha_inicio' => Carbon::now()->subDays(2)->format('Y-m-d'),
            'fecha_fin' => Carbon::now()->addWeeks(4)->format('Y-m-d'),
        ]);

        $participante = Participante::factory()->create();

        // 1. Inscribir en Paralelo 1 del curso
        Inscripcion::create([
            'participante_id' => $participante->id,
            'paralelo_id' => $paralelo1->id,
            'fecha_inscripcion' => Carbon::now()->format('Y-m-d'),
            'monto_pagado' => 150.00,
            'estado' => 'pagada',
        ]);

        // 2. Intentar inscribir al mismo participante en Paralelo 2 del MISMO curso
        $response = $this->post(route('inscripciones.store'), [
            'participante_id' => $participante->id,
            'paralelo_id' => $paralelo2->id,
            'fecha_inscripcion' => Carbon::now()->format('Y-m-d'),
            'monto_pagado' => 150.00,
            'estado' => 'pagada',
        ]);

        $response->assertSessionHasErrors('participante_id');
        $this->assertDatabaseMissing('inscripciones', [
            'participante_id' => $participante->id,
            'paralelo_id' => $paralelo2->id,
        ]);
    }

    public function test_rechaza_creacion_de_curso_con_titulo_duplicado(): void
    {
        $this->actingAs($this->usuario);
        $categoria = Categoria::factory()->create();

        Curso::factory()->create([
            'categoria_id' => $categoria->id,
            'titulo' => 'Inteligencia Artificial Aplicada',
        ]);

        // Intentar crear otro curso con el mismo título
        $response = $this->post(route('cursos.store'), [
            'categoria_id' => $categoria->id,
            'titulo' => 'Inteligencia Artificial Aplicada',
            'descripcion' => 'Curso duplicado.',
            'precio' => 200.00,
            'duracion_horas' => 50,
        ]);

        $response->assertSessionHasErrors('titulo');
    }

    public function test_rechaza_creacion_de_paralelo_con_nombre_duplicado_en_mismo_curso(): void
    {
        $this->actingAs($this->usuario);
        $curso = Curso::factory()->create();
        $instructor = Instructor::factory()->create();

        Paralelo::factory()->create([
            'curso_id' => $curso->id,
            'instructor_id' => $instructor->id,
            'nombre' => 'Grupo Alfa',
        ]);

        // Intentar crear otro paralelo con 'Grupo Alfa' en el mismo curso
        $response = $this->post(route('paralelos.store'), [
            'curso_id' => $curso->id,
            'instructor_id' => $instructor->id,
            'nombre' => 'Grupo Alfa',
            'aula' => 'Aula 105',
            'dias' => 'Sábados',
            'hora_inicio' => '08:00',
            'hora_fin' => '12:00',
            'fecha_inicio' => '2026-06-01',
            'fecha_fin' => '2026-07-01',
            'cupo_maximo' => 20,
        ]);

        $response->assertSessionHasErrors('nombre');
    }

    public function test_rechaza_paralelo_con_hora_fin_anterior_a_hora_inicio(): void
    {
        $this->actingAs($this->usuario);
        $curso = Curso::factory()->create();
        $instructor = Instructor::factory()->create();

        $response = $this->post(route('paralelos.store'), [
            'curso_id' => $curso->id,
            'instructor_id' => $instructor->id,
            'nombre' => 'Grupo Beta',
            'aula' => 'Aula 202',
            'dias' => 'Lunes',
            'hora_inicio' => '12:00',
            'hora_fin' => '10:00', // hora_fin anterior a hora_inicio
            'fecha_inicio' => '2026-06-01',
            'fecha_fin' => '2026-07-01',
            'cupo_maximo' => 20,
        ]);

        $response->assertSessionHasErrors('hora_fin');
    }
}
