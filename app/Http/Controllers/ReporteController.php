<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Curso;
use App\Models\Inscripcion;
use App\Models\Paralelo;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    /**
     * Reporte: Lista de inscritos por paralelo.
     */
    public function inscritosPorParalelo(Request $request)
    {
        $paralelos = Paralelo::with(['curso', 'instructor'])
            ->orderBy('nombre')
            ->get();

        $paraleloSeleccionadoId = $request->input('paralelo_id', $paralelos->first()?->id);
        $paraleloSeleccionado = null;
        $inscripciones = collect();

        if ($paraleloSeleccionadoId) {
            $paraleloSeleccionado = Paralelo::with(['curso.categoria', 'instructor'])->find($paraleloSeleccionadoId);

            if ($paraleloSeleccionado) {
                $filtroEstado = $request->input('estado');

                $inscripciones = Inscripcion::with('participante')
                    ->where('paralelo_id', $paraleloSeleccionadoId)
                    ->when($filtroEstado, function ($q, $estado) {
                        $q->where('estado', $estado);
                    })
                    ->orderBy('fecha_inscripcion', 'asc')
                    ->get();
            }
        }

        return view('reportes.inscritos_por_paralelo', compact('paralelos', 'paraleloSeleccionado', 'inscripciones', 'paraleloSeleccionadoId'));
    }

    /**
     * Reporte: Ingresos por curso.
     */
    public function ingresosPorCurso(Request $request)
    {
        $categorias = Categoria::orderBy('nombre')->get();

        $query = Curso::with(['categoria', 'paralelos'])
            ->withCount('paralelos');

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        $cursos = $query->get()->map(function ($curso) {
            $inscripcionesPagadas = Inscripcion::whereHas('paralelo', function ($q) use ($curso) {
                $q->where('curso_id', $curso->id);
            })->where('estado', 'pagada');

            $inscripcionesPendientes = Inscripcion::whereHas('paralelo', function ($q) use ($curso) {
                $q->where('curso_id', $curso->id);
            })->where('estado', 'pendiente');

            $todasInscripcionesActivas = Inscripcion::whereHas('paralelo', function ($q) use ($curso) {
                $q->where('curso_id', $curso->id);
            })->where('estado', '!=', 'anulada');

            $totalIngresos = (float) $inscripcionesPagadas->sum('monto_pagado');
            $ingresosPendientes = (float) $inscripcionesPendientes->sum('monto_pagado');
            $conteoPagados = $inscripcionesPagadas->count();
            $conteoPendientes = $inscripcionesPendientes->count();
            $conteoTotal = $todasInscripcionesActivas->count();

            $curso->ingresos_recaudados = $totalIngresos;
            $curso->ingresos_pendientes = $ingresosPendientes;
            $curso->conteo_pagados = $conteoPagados;
            $curso->conteo_pendientes = $conteoPendientes;
            $curso->total_alumnos = $conteoTotal;

            return $curso;
        })->sortByDesc('ingresos_recaudados');

        $totalGeneralRecaudado = $cursos->sum('ingresos_recaudados');
        $totalGeneralPendiente = $cursos->sum('ingresos_pendientes');
        $totalAlumnosGeneral = $cursos->sum('total_alumnos');
        $cursoMasRentable = $cursos->first();

        return view('reportes.ingresos_por_curso', compact(
            'cursos',
            'categorias',
            'totalGeneralRecaudado',
            'totalGeneralPendiente',
            'totalAlumnosGeneral',
            'cursoMasRentable'
        ));
    }
}
