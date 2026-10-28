<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParticipanteRequest;
use App\Models\Participante;
use Illuminate\Http\Request;

class ParticipanteController extends Controller
{
    public function index(Request $request)
    {
        $query = Participante::withCount('inscripciones');

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('dni', 'like', "%{$buscar}%")
                    ->orWhere('email', 'like', "%{$buscar}%");
            });
        }

        $participantes = $query->latest('id')->paginate(10)->withQueryString();

        return view('participantes.index', compact('participantes'));
    }

    public function create()
    {
        return view('participantes.create');
    }

    public function store(ParticipanteRequest $request)
    {
        Participante::create($request->validated());

        return redirect()->route('participantes.index')
            ->with('success', 'Participante registrado exitosamente.');
    }

    public function show(Participante $participante)
    {
        $participante->load(['inscripciones.paralelo.curso', 'inscripciones.paralelo.instructor']);

        return view('participantes.show', compact('participante'));
    }

    public function edit(Participante $participante)
    {
        return view('participantes.edit', compact('participante'));
    }

    public function update(ParticipanteRequest $request, Participante $participante)
    {
        $participante->update($request->validated());

        return redirect()->route('participantes.index')
            ->with('success', 'Datos del participante actualizados exitosamente.');
    }

    public function destroy(Participante $participante)
    {
        if ($participante->inscripciones()->where('estado', '!=', 'anulada')->exists()) {
            return back()->with('error', 'No se puede eliminar el participante porque tiene inscripciones activas.');
        }

        $participante->delete();

        return redirect()->route('participantes.index')
            ->with('success', 'Participante eliminado exitosamente.');
    }
}
