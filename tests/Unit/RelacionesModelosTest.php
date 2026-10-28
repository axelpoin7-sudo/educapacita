<?php

namespace Tests\Unit;

use App\Models\Categoria;
use App\Models\Curso;
use App\Models\Inscripcion;
use App\Models\Instructor;
use App\Models\Paralelo;
use App\Models\Participante;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RelacionesModelosTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Comprueba la relación 1 a N entre Categoría y Cursos.
     */
    public function test_relacion_categoria_con_cursos(): void
    {
        $categoria = Categoria::factory()->create();
        $curso = Curso::factory()->create(['categoria_id' => $categoria->id]);

        $this->assertTrue($categoria->cursos->contains($curso));
        $this->assertEquals($categoria->id, $curso->categoria->id);
    }

    /**
     * Comprueba las relaciones entre Curso, Instructor y Paralelo.
     */
    public function test_relaciones_paralelo_con_curso_e_instructor(): void
    {
        $curso = Curso::factory()->create();
        $instructor = Instructor::factory()->create();
        $paralelo = Paralelo::factory()->create([
            'curso_id' => $curso->id,
            'instructor_id' => $instructor->id,
        ]);

        $this->assertEquals($curso->id, $paralelo->curso->id);
        $this->assertEquals($instructor->id, $paralelo->instructor->id);
        $this->assertTrue($curso->paralelos->contains($paralelo));
        $this->assertTrue($instructor->paralelos->contains($paralelo));
    }

    /**
     * Comprueba la relación de Inscripción entre Participante y Paralelo (N a M).
     */
    public function test_relaciones_inscripcion_participante_y_paralelo(): void
    {
        $participante = Participante::factory()->create();
        $paralelo = Paralelo::factory()->create();

        $inscripcion = Inscripcion::create([
            'participante_id' => $participante->id,
            'paralelo_id' => $paralelo->id,
            'fecha_inscripcion' => Carbon::now()->format('Y-m-d'),
            'monto_pagado' => 150.00,
            'estado' => 'pagada',
        ]);

        // Verificación de pertenencia de la inscripción
        $this->assertEquals($participante->id, $inscripcion->participante->id);
        $this->assertEquals($paralelo->id, $inscripcion->paralelo->id);

        // Verificación de relaciones inversas
        $this->assertTrue($participante->inscripciones->contains($inscripcion));
        $this->assertTrue($paralelo->inscripciones->contains($inscripcion));

        // Verificación de relación Muchos a Muchos (belongsToMany con pivote)
        $this->assertTrue($paralelo->participantes->contains($participante));
        $this->assertTrue($participante->paralelos->contains($paralelo));
    }

    /**
     * Comprueba el cálculo de cupos y estado de aforo en Paralelo.
     */
    public function test_calculo_de_cupos_y_aforo(): void
    {
        $paralelo = Paralelo::factory()->create(['cupo_maximo' => 2]);
        $part1 = Participante::factory()->create();
        $part2 = Participante::factory()->create();

        $this->assertFalse($paralelo->estaLleno());
        $this->assertEquals(2, $paralelo->cupos_disponibles);

        Inscripcion::create([
            'participante_id' => $part1->id,
            'paralelo_id' => $paralelo->id,
            'fecha_inscripcion' => Carbon::now()->format('Y-m-d'),
            'monto_pagado' => 100.00,
            'estado' => 'pagada',
        ]);

        $this->assertEquals(1, $paralelo->fresh()->cupos_disponibles);
        $this->assertFalse($paralelo->fresh()->estaLleno());

        Inscripcion::create([
            'participante_id' => $part2->id,
            'paralelo_id' => $paralelo->id,
            'fecha_inscripcion' => Carbon::now()->format('Y-m-d'),
            'monto_pagado' => 100.00,
            'estado' => 'pagada',
        ]);

        $this->assertTrue($paralelo->fresh()->estaLleno());
        $this->assertEquals(0, $paralelo->fresh()->cupos_disponibles);
    }
}
