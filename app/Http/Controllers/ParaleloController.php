<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParaleloRequest;
use App\Models\Curso;
use App\Models\Instructor;
use App\Models\Paralelo;
use Illuminate\Http\Request;

class ParaleloController extends Controller
{
    public function index(Request $request)
    {
        $query = Paralelo::with(['curso.categoria', 'instructor'])
            ->withCount(['inscripciones as inscritos_activos_count' => function ($q) {
                $q->where('estado', '!=', 'anulada');
            }]);

        if ($request->filled('curso_id')) {
            $query->where('curso_id', $request->curso_id);
        }

        if ($request->filled('instructor_id')) {
            $query->where('instructor_id', $request->instructor_id);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('aula', 'like', "%{$buscar}%");
            });
        }

        $paralelos = $query->orderBy('fecha_inicio', 'desc')->paginate(10)->withQueryString();
        $cursos = Curso::orderBy('titulo')->get();
        $instructores = Instructor::orderBy('nombre')->get();

        return view('paralelos.index', compact('paralelos', 'cursos', 'instructores'));
    }

    public function create()
    {
        $cursos = Curso::orderBy('titulo')->get();
        $instructores = Instructor::orderBy('nombre')->get();

        return view('paralelos.create', compact('cursos', 'instructores'));
    }

    public function store(ParaleloRequest $request)
    {
        Paralelo::create($request->validated());

        return redirect()->route('paralelos.index')
            ->with('success', 'Paralelo y horario programado exitosamente.');
    }

    public function show(Paralelo $paralelo)
    {
        $paralelo->load([
            'curso.categoria',
            'instructor',
            'inscripciones' => function ($q) {
                $q->with('participante')->latest('fecha_inscripcion');
            },
        ]);

        return view('paralelos.show', compact('paralelo'));
    }

    public function edit(Paralelo $paralelo)
    {
        $cursos = Curso::orderBy('titulo')->get();
        $instructores = Instructor::orderBy('nombre')->get();

        return view('paralelos.edit', compact('paralelo', 'cursos', 'instructores'));
    }

    public function update(ParaleloRequest $request, Paralelo $paralelo)
    {
        $paralelo->update($request->validated());

        return redirect()->route('paralelos.index')
            ->with('success', 'Paralelo actualizado exitosamente.');
    }

    public function destroy(Paralelo $paralelo)
    {
        if ($paralelo->inscripciones()->where('estado', '!=', 'anulada')->exists()) {
            return back()->with('error', 'No se puede eliminar el paralelo porque tiene inscripciones activas.');
        }

        $paralelo->delete();

        return redirect()->route('paralelos.index')
            ->with('success', 'Paralelo eliminado exitosamente.');
    }
}
