@extends('layouts.app')

@section('titulo', 'Editar Participante: ' . $participante->nombre)

@section('contenido')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                    Modificación de Estudiante
                </span>
                <span class="text-xs text-slate-400 font-mono">DNI: {{ $participante->dni }}</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">Editar Datos del Alumno</h1>
            <p class="text-xs text-slate-500">Actualiza la información personal y canales de contacto del participante.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('participantes.show', $participante) }}" class="inline-flex items-center px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 shadow-sm transition">
                Ver Historial
            </a>
            <a href="{{ route('participantes.index') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 shadow-sm transition">
                &larr; Volver
            </a>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 sm:p-8 bg-gradient-to-r from-slate-900 via-cyan-950 to-slate-900 text-white">
            <h2 class="text-lg font-black text-white">Actualización de Registro</h2>
            <p class="text-xs text-slate-300 mt-1">Posee {{ $participante->inscripciones->count() }} inscripciones asociadas a su historial académico.</p>
        </div>

        <form action="{{ route('participantes.update', $participante) }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="dni" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Cédula de Identidad / DNI *</label>
                    <input type="text" name="dni" id="dni" value="{{ old('dni', $participante->dni) }}" required
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 font-mono text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 focus:outline-none transition">
                </div>
                <div>
                    <label for="nombre" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nombre Completo *</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $participante->nombre) }}" required
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 focus:outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Correo Electrónico *</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $participante->email) }}" required
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 focus:outline-none transition">
                </div>
                <div>
                    <label for="telefono" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Teléfono Celular / WhatsApp</label>
                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $participante->telefono) }}"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 focus:outline-none transition">
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('participantes.index') }}" class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-500 hover:to-teal-500 text-white text-xs font-bold shadow-lg shadow-cyan-950/20 transition transform hover:-translate-y-0.5">
                    Actualizar Participante &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
