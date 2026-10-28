<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutorizacionRolesTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $usuarioRegular;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create([
            'email' => 'admin@test.com',
        ]);

        $this->usuarioRegular = User::factory()->create([
            'email' => 'usuario@test.com',
            'es_admin' => false,
        ]);
    }

    public function test_usuario_regular_puede_ver_catalogo_de_cursos(): void
    {
        $response = $this->actingAs($this->usuarioRegular)->get(route('cursos.index'));
        $response->assertStatus(200);
    }

    public function test_usuario_regular_puede_ver_paralelos_e_instructores(): void
    {
        $responseParalelos = $this->actingAs($this->usuarioRegular)->get(route('paralelos.index'));
        $responseParalelos->assertStatus(200);

        $responseInstructores = $this->actingAs($this->usuarioRegular)->get(route('instructores.index'));
        $responseInstructores->assertStatus(200);
    }

    public function test_usuario_regular_puede_acceder_al_formulario_de_inscripcion(): void
    {
        $response = $this->actingAs($this->usuarioRegular)->get(route('inscripciones.create'));
        $response->assertStatus(200);
    }

    public function test_usuario_regular_no_puede_crear_cursos(): void
    {
        $responseGet = $this->actingAs($this->usuarioRegular)->get(route('cursos.create'));
        $responseGet->assertStatus(403);

        $responsePost = $this->actingAs($this->usuarioRegular)->post(route('cursos.store'), [
            'titulo' => 'Curso No Autorizado',
        ]);
        $responsePost->assertStatus(403);
    }

    public function test_usuario_regular_no_puede_crear_paralelos(): void
    {
        $responseGet = $this->actingAs($this->usuarioRegular)->get(route('paralelos.create'));
        $responseGet->assertStatus(403);

        $responsePost = $this->actingAs($this->usuarioRegular)->post(route('paralelos.store'), [
            'nombre' => 'Paralelo No Autorizado',
        ]);
        $responsePost->assertStatus(403);
    }

    public function test_usuario_regular_no_puede_crear_instructores_ni_categorias(): void
    {
        $responseInst = $this->actingAs($this->usuarioRegular)->get(route('instructores.create'));
        $responseInst->assertStatus(403);

        $responseCat = $this->actingAs($this->usuarioRegular)->get(route('categorias.create'));
        $responseCat->assertStatus(403);
    }

    public function test_usuario_regular_no_puede_ver_reporte_financiero(): void
    {
        $response = $this->actingAs($this->usuarioRegular)->get(route('reportes.ingresos_por_curso'));
        $response->assertStatus(403);
    }

    public function test_administrador_tiene_acceso_total(): void
    {
        $responseCursoCreate = $this->actingAs($this->admin)->get(route('cursos.create'));
        $responseCursoCreate->assertStatus(200);

        $responseParaleloCreate = $this->actingAs($this->admin)->get(route('paralelos.create'));
        $responseParaleloCreate->assertStatus(200);

        $responseInstructorCreate = $this->actingAs($this->admin)->get(route('instructores.create'));
        $responseInstructorCreate->assertStatus(200);

        $responseReporteIngresos = $this->actingAs($this->admin)->get(route('reportes.ingresos_por_curso'));
        $responseReporteIngresos->assertStatus(200);
    }

    public function test_pagina_de_presentacion_es_accesible_publicamente(): void
    {
        $response = $this->get(route('presentacion'));
        $response->assertStatus(200);
    }
}
