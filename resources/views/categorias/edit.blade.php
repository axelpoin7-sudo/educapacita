@extends('layouts.app')

@section('titulo', 'Editar Categoría: ' . $categoria->nombre)

@section('contenido')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                    Modificación de Área
                </span>
                <span class="text-xs text-slate-400 font-medium">{{ $categoria->cursos->count() }} cursos asignados</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">Editar Categoría</h1>
            <p class="text-xs text-slate-500">Actualiza el nombre o la descripción del área formativa.</p>
        </div>
        <a href="{{ route('categorias.index') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 shadow-sm transition">
            &larr; Volver
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 sm:p-8 bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 text-white">
            <h2 class="text-lg font-black text-white">Editar Parámetros de la Categoría</h2>
            <p class="text-xs text-slate-300 mt-1">El cambio se reflejará inmediatamente en todos los cursos asociados.</p>
        </div>

        <form action="{{ route('categorias.update', $categoria) }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="nombre" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nombre de la Categoría *</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $categoria->nombre) }}" required
                       class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">
            </div>

            <div>
                <label for="descripcion" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Descripción de la Especialidad</label>
                <textarea name="descripcion" id="descripcion" rows="4"
                          class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">{{ old('descripcion', $categoria->descripcion) }}</textarea>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('categorias.index') }}" class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold shadow-lg shadow-emerald-950/20 transition transform hover:-translate-y-0.5">
                    Actualizar Categoría &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
