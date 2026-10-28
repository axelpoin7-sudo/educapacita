<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Permite el acceso únicamente a usuarios con privilegios de Administrador (es_admin = true).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->esAdmin()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Acceso denegado: Se requieren permisos de Administrador del Sistema.',
                ], 403);
            }

            abort(403, 'Acceso Restringido: Esta acción o sección del sistema está reservada exclusivamente para el Administrador.');
        }

        return $next($request);
    }
}
