<?php

namespace App\Http\Controllers;

use App\Http\Requests\CursoRequest;
use App\Models\Categoria;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        $query = Curso::with(['categoria'])->withCount('paralelos');

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                    ->orWhere('descripcion', 'like', "%{$buscar}%");
            });
        }

        $cursos = $query->latest('id')->paginate(9)->withQueryString();
        $categorias = Categoria::orderBy('nombre')->get();

        return view('cursos.index', compact('cursos', 'categorias'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('cursos.create', compact('categorias'));
    }

    public function store(CursoRequest $request)
    {
        $datos = $request->validated();

        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            $nombreArchivo = time().'_'.uniqid().'.'.$archivo->getClientOriginalExtension();
            $rutaDestino = public_path('uploads/cursos');

            if (! File::isDirectory($rutaDestino)) {
                File::makeDirectory($rutaDestino, 0775, true, true);
            }

            $archivo->move($rutaDestino, $nombreArchivo);
            $datos['imagen'] = 'uploads/cursos/'.$nombreArchivo;
        }

        Curso::create($datos);

        return redirect()->route('cursos.index')
            ->with('success', 'Curso de capacitación creado exitosamente.');
    }

    public function show(Curso $curso)
    {
        $curso->load(['categoria', 'paralelos.instructor', 'paralelos.inscripciones']);

        return view('cursos.show', compact('curso'));
    }

    public function edit(Curso $curso)
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('cursos.edit', compact('curso', 'categorias'));
    }

    public function update(CursoRequest $request, Curso $curso)
    {
        $datos = $request->validated();

        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            $nombreArchivo = time().'_'.uniqid().'.'.$archivo->getClientOriginalExtension();
            $rutaDestino = public_path('uploads/cursos');

            if (! File::isDirectory($rutaDestino)) {
                File::makeDirectory($rutaDestino, 0775, true, true);
            }

            if ($curso->imagen && File::exists(public_path($curso->imagen))) {
                File::delete(public_path($curso->imagen));
            }

            $archivo->move($rutaDestino, $nombreArchivo);
            $datos['imagen'] = 'uploads/cursos/'.$nombreArchivo;
        }

        $curso->update($datos);

        return redirect()->route('cursos.index')
            ->with('success', 'Curso actualizado exitosamente.');
    }

    public function destroy(Curso $curso)
    {
        if ($curso->paralelos()->exists()) {
            return back()->with('error', 'No se puede eliminar el curso porque tiene paralelos programados.');
        }

        if ($curso->imagen && File::exists(public_path($curso->imagen))) {
            File::delete(public_path($curso->imagen));
        }

        $curso->delete();

        return redirect()->route('cursos.index')
            ->with('success', 'Curso eliminado exitosamente.');
    }
}
