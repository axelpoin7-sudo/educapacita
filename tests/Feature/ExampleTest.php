<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verificar que la ruta de inicio redirige al login para invitados.
     */
    public function test_invitado_es_redirigido_a_login(): void
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }

    /**
     * Verificar que el formulario de login carga con éxito.
     */
    public function test_formulario_login_responde_correctamente(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /**
     * Verificar que un usuario autenticado puede acceder al panel principal.
     */
    public function test_usuario_autenticado_puede_ver_dashboard(): void
    {
        $usuario = User::first() ?? User::factory()->create();

        $response = $this->actingAs($usuario)->get('/dashboard');
        $response->assertStatus(200);
    }
}
