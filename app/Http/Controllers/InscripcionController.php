<?php

namespace App\Http\Controllers;

use App\Http\Requests\InscripcionRequest;
use App\Models\Curso;
use App\Models\Inscripcion;
use App\Models\Paralelo;
use App\Models\Participante;
use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    public function index(Request $request)
    {
        $query = Inscripcion::with(['participante', 'paralelo.curso', 'paralelo.instructor']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('paralelo_id')) {
            $query->where('paralelo_id', $request->paralelo_id);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('participante', function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('dni', 'like', "%{$buscar}%");
            });
        }

        $inscripciones = $query->latest('fecha_inscripcion')->latest('id')->paginate(15)->withQueryString();
        $paralelos = Paralelo::with('curso')->get();

        return view('inscripciones.index', compact('inscripciones', 'paralelos'));
    }

    public function create(Request $request)
    {
        $paraleloSeleccionadoId = $request->input('paralelo_id');
        $participantes = Participante::orderBy('nombre')->get();
        $cursos = Curso::with('categoria')->orderBy('titulo')->get();
        $paralelos = Paralelo::with(['curso', 'instructor'])
            ->withCount(['inscripciones as inscritos_activos_count' => function ($q) {
                $q->where('estado', '!=', 'anulada');
            }])
            ->get();

        return view('inscripciones.create', compact('participantes', 'cursos', 'paralelos', 'paraleloSeleccionadoId'));
    }

    public function store(InscripcionRequest $request)
    {
        $inscripcion = Inscripcion::create($request->validated());

        return redirect()->route('inscripciones.show', $inscripcion)
            ->with('success', 'Inscripción registrada exitosamente.');
    }

    public function show(Inscripcion $inscripcion)
    {
        $inscripcion->load(['participante', 'paralelo.curso.categoria', 'paralelo.instructor']);

        return view('inscripciones.show', compact('inscripcion'));
    }

    public function edit(Inscripcion $inscripcion)
    {
        $participantes = Participante::orderBy('nombre')->get();
        $cursos = Curso::with('categoria')->orderBy('titulo')->get();
        $paralelos = Paralelo::with(['curso', 'instructor'])
            ->withCount(['inscripciones as inscritos_activos_count' => function ($q) {
                $q->where('estado', '!=', 'anulada');
            }])
            ->get();

        return view('inscripciones.edit', compact('inscripcion', 'participantes', 'cursos', 'paralelos'));
    }

    public function update(InscripcionRequest $request, Inscripcion $inscripcion)
    {
        $inscripcion->update($request->validated());

        return redirect()->route('inscripciones.show', $inscripcion)
            ->with('success', 'Inscripción actualizada exitosamente.');
    }

    public function destroy(Inscripcion $inscripcion)
    {
        $inscripcion->delete();

        return redirect()->route('inscripciones.index')
            ->with('success', 'Inscripción eliminada correctamente.');
    }
}
