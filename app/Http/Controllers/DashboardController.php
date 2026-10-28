<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Curso;
use App\Models\Inscripcion;
use App\Models\Instructor;
use App\Models\Paralelo;
use App\Models\Participante;

class DashboardController extends Controller
{
    public function index()
    {
        $estadisticas = [
            'categorias' => Categoria::count(),
            'instructores' => Instructor::count(),
            'cursos' => Curso::count(),
            'paralelos' => Paralelo::count(),
            'participantes' => Participante::count(),
            'inscripciones' => Inscripcion::count(),
            'inscripciones_pagadas' => Inscripcion::where('estado', 'pagada')->count(),
            'inscripciones_pendientes' => Inscripcion::where('estado', 'pendiente')->count(),
            'inscripciones_anuladas' => Inscripcion::where('estado', 'anulada')->count(),
            'ingresos_totales' => Inscripcion::where('estado', 'pagada')->sum('monto_pagado'),
        ];

        // Últimas 6 inscripciones
        $ultimasInscripciones = Inscripcion::with(['participante', 'paralelo.curso'])
            ->latest('id')
            ->take(6)
            ->get();

        // Paralelos monitoreados
        $paralelos = Paralelo::with(['curso', 'instructor'])
            ->withCount(['inscripciones as inscritos_activos_count' => function ($query) {
                $query->where('estado', '!=', 'anulada');
            }])
            ->orderBy('fecha_inicio', 'asc')
            ->take(8)
            ->get();

        return view('dashboard', compact('estadisticas', 'ultimasInscripciones', 'paralelos'));
    }
}
