@extends('layouts.app')

@section('titulo', 'Editar Curso: ' . $curso->titulo)

@section('contenido')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                    Edición de Programa
                </span>
                <span class="text-xs text-slate-400 font-medium">ID #{{ $curso->id }}</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">Editar Curso</h1>
            <p class="text-xs text-slate-500">Actualiza los datos del curso, duración o arancel de matrícula.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('cursos.show', $curso) }}" class="inline-flex items-center px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 shadow-sm transition">
                Ver Ficha
            </a>
            <a href="{{ route('cursos.index') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 shadow-sm transition">
                &larr; Volver
            </a>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 sm:p-8 bg-gradient-to-r from-slate-900 to-slate-800 text-white">
            <h2 class="text-lg font-black text-white">Modificar Parámetros Académicos</h2>
            <p class="text-xs text-slate-300 mt-1">Si cambias el precio, afectará únicamente a las futuras inscripciones.</p>
        </div>

        <form action="{{ route('cursos.update', $curso) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="categoria_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Categoría Académica *</label>
                    <select name="categoria_id" id="categoria_id" required
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ old('categoria_id', $curso->categoria_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="titulo" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Título del Curso *</label>
                    <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $curso->titulo) }}" required
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">
                    <p class="text-[11px] text-slate-400 mt-1">Debe ser único en el sistema.</p>
                </div>
            </div>

            <div>
                <label for="descripcion" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Descripción y Competencias del Programa</label>
                <textarea name="descripcion" id="descripcion" rows="4"
                          class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">{{ old('descripcion', $curso->descripcion) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="precio" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Arancel de Matrícula ($ USD) *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 font-bold text-sm">$</span>
                        <input type="number" step="0.01" name="precio" id="precio" value="{{ old('precio', $curso->precio) }}" required
                               class="w-full pl-8 pr-4 py-3 rounded-2xl border border-slate-200 text-sm font-black text-slate-800 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">
                    </div>
                </div>
                <div>
                    <label for="duracion_horas" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Carga Horaria Certificada (Horas) *</label>
                    <div class="relative">
                        <input type="number" name="duracion_horas" id="duracion_horas" value="{{ old('duracion_horas', $curso->duracion_horas) }}" required
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-black text-slate-800 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">
                        <span class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 text-xs font-bold uppercase">Horas</span>
                    </div>
                </div>
            </div>

            <!-- Image Section -->
            <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 bg-slate-50/50">
                <label for="imagen" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-2">Imagen de Portada</label>
                @if($curso->imagen)
                    <div class="flex items-center gap-4 mb-4 p-3 bg-white rounded-2xl border border-slate-200 shadow-sm max-w-md">
                        <img src="{{ $curso->imagen_url }}" class="w-20 h-14 rounded-xl object-cover" alt="Actual">
                        <div>
                            <p class="text-xs font-bold text-slate-800">Portada actual</p>
                            <p class="text-[11px] text-slate-400">Selecciona un nuevo archivo sólo si deseas reemplazarla.</p>
                        </div>
                    </div>
                @endif
                <input type="file" name="imagen" id="imagen" accept="image/*"
                       class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white hover:file:bg-slate-800 file:transition cursor-pointer">
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('cursos.index') }}" class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold shadow-lg shadow-emerald-950/20 transition transform hover:-translate-y-0.5">
                    Actualizar Curso &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
