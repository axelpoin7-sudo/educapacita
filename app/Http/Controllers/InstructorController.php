<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstructorRequest;
use App\Models\Instructor;
use Illuminate\Support\Facades\File;

class InstructorController extends Controller
{
    public function index()
    {
        $instructores = Instructor::withCount('paralelos')->latest('id')->paginate(10);

        return view('instructores.index', compact('instructores'));
    }

    public function create()
    {
        return view('instructores.create');
    }

    public function store(InstructorRequest $request)
    {
        $datos = $request->validated();

        if ($request->hasFile('foto')) {
            $archivo = $request->file('foto');
            $nombreArchivo = time().'_'.uniqid().'.'.$archivo->getClientOriginalExtension();
            $rutaDestino = public_path('uploads/instructores');

            if (! File::isDirectory($rutaDestino)) {
                File::makeDirectory($rutaDestino, 0755, true, true);
            }

            $archivo->move($rutaDestino, $nombreArchivo);
            $datos['foto'] = 'uploads/instructores/'.$nombreArchivo;
        }

        Instructor::create($datos);

        return redirect()->route('instructores.index')
            ->with('success', 'Instructor registrado exitosamente.');
    }

    public function show(Instructor $instructor)
    {
        $instructor->load(['paralelos.curso']);

        return view('instructores.show', compact('instructor'));
    }

    public function edit(Instructor $instructor)
    {
        return view('instructores.edit', compact('instructor'));
    }

    public function update(InstructorRequest $request, Instructor $instructor)
    {
        $datos = $request->validated();

        if ($request->hasFile('foto')) {
            $archivo = $request->file('foto');
            $nombreArchivo = time().'_'.uniqid().'.'.$archivo->getClientOriginalExtension();
            $rutaDestino = public_path('uploads/instructores');

            if (! File::isDirectory($rutaDestino)) {
                File::makeDirectory($rutaDestino, 0755, true, true);
            }

            if ($instructor->foto && File::exists(public_path($instructor->foto))) {
                File::delete(public_path($instructor->foto));
            }

            $archivo->move($rutaDestino, $nombreArchivo);
            $datos['foto'] = 'uploads/instructores/'.$nombreArchivo;
        }

        $instructor->update($datos);

        return redirect()->route('instructores.index')
            ->with('success', 'Instructor actualizado exitosamente.');
    }

    public function destroy(Instructor $instructor)
    {
        if ($instructor->paralelos()->exists()) {
            return back()->with('error', 'No se puede eliminar el instructor porque tiene paralelos asignados.');
        }

        if ($instructor->foto && File::exists(public_path($instructor->foto))) {
            File::delete(public_path($instructor->foto));
        }

        $instructor->delete();

        return redirect()->route('instructores.index')
            ->with('success', 'Instructor eliminado exitosamente.');
    }
}
