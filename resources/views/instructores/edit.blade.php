@extends('layouts.app')

@section('titulo', 'Editar Instructor: ' . $instructor->nombre)

@section('contenido')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                    Modificación de Docente
                </span>
                <span class="text-xs text-slate-400 font-medium">{{ $instructor->especialidad }}</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">Editar Datos del Instructor</h1>
            <p class="text-xs text-slate-500">Actualiza la ficha profesional, bio y canales de comunicación.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('instructores.show', $instructor) }}" class="inline-flex items-center px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 shadow-sm transition">
                Ver Perfil
            </a>
            <a href="{{ route('instructores.index') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 shadow-sm transition">
                &larr; Volver
            </a>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 sm:p-8 bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 text-white">
            <h2 class="text-lg font-black text-white">Actualizar Currículum Docente</h2>
            <p class="text-xs text-slate-300 mt-1">Actualmente tiene {{ $instructor->paralelos->count() }} paralelos a su cargo.</p>
        </div>

        <form action="{{ route('instructores.update', $instructor) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="nombre" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nombre Completo *</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $instructor->nombre) }}" required
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">
                </div>
                <div>
                    <label for="especialidad" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Especialidad Principal *</label>
                    <input type="text" name="especialidad" id="especialidad" value="{{ old('especialidad', $instructor->especialidad) }}" required
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Correo Electrónico *</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $instructor->email) }}" required
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">
                </div>
                <div>
                    <label for="telefono" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Teléfono Celular</label>
                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $instructor->telefono) }}"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">
                </div>
            </div>

            <div>
                <label for="biografia" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Perfil Profesional / Resumen Curricular</label>
                <textarea name="biografia" id="biografia" rows="4"
                          class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">{{ old('biografia', $instructor->biografia) }}</textarea>
            </div>

            <!-- Fotografía con Vista Previa -->
            <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 bg-slate-50/50">
                <label for="foto" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-2">Fotografía del Instructor</label>
                @if($instructor->foto)
                    <div class="flex items-center gap-4 mb-4 p-3 bg-white rounded-2xl border border-slate-200 shadow-sm max-w-sm">
                        <img src="{{ $instructor->foto_url }}" class="w-14 h-14 rounded-full object-cover" alt="Actual">
                        <div>
                            <p class="text-xs font-bold text-slate-800">Foto actual</p>
                            <p class="text-[11px] text-slate-400">Selecciona un nuevo archivo si deseas sustituirla.</p>
                        </div>
                    </div>
                @endif
                <input type="file" name="foto" id="foto" accept="image/*"
                       class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white hover:file:bg-slate-800 file:transition cursor-pointer">
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('instructores.index') }}" class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold shadow-lg shadow-emerald-950/20 transition transform hover:-translate-y-0.5">
                    Actualizar Instructor &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
