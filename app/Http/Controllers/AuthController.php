<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Procesa la autenticación del usuario.
     */
    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingrese un formato de correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $recordar = $request->boolean('remember');

        if (Auth::attempt($credenciales, $recordar)) {
            $request->session()->regenerate();

            $usuario = Auth::user();
            $mensajeRol = $usuario->esAdmin() ? ' (Sesión como Administrador)' : '';

            return redirect()->intended(route('dashboard'))
                ->with('success', "¡Bienvenido/a {$usuario->name}{$mensajeRol}!");
        }

        return back()->withErrors([
            'email' => 'Las credenciales ingresadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Cierra la sesión activa del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('info', 'Has cerrado sesión exitosamente.');
    }
}
