@extends('layouts.app')

@section('titulo', 'Nuevo Curso')

@section('contenido')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    Catálogo Académico
                </span>
                <span class="text-xs text-slate-400 font-medium">Paso 1 de Planificación</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">Registrar Nuevo Curso</h1>
            <p class="text-xs text-slate-500">Define los parámetros del programa, precio unitario y carga horaria oficial.</p>
        </div>
        <a href="{{ route('cursos.index') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 shadow-sm transition">
            &larr; Volver al catálogo
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 sm:p-8 bg-gradient-to-r from-slate-900 to-slate-800 text-white">
            <h2 class="text-lg font-black text-white">Ficha Técnica del Programa</h2>
            <p class="text-xs text-slate-300 mt-1">Los nombres de cursos son únicos para garantizar la trazabilidad de certificaciones.</p>
        </div>

        <form action="{{ route('cursos.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="categoria_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Categoría Académica *</label>
                    <select name="categoria_id" id="categoria_id" required
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">
                        <option value="">Seleccione una categoría</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="titulo" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Título del Curso (Único) *</label>
                    <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" required placeholder="Ej: Diplomado en Big Data e Inteligencia Artificial"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">
                    <p class="text-[11px] text-slate-400 mt-1">Validado por sistema: No se permiten títulos idénticos duplicados.</p>
                </div>
            </div>

            <div>
                <label for="descripcion" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Descripción y Competencias del Programa</label>
                <textarea name="descripcion" id="descripcion" rows="4" placeholder="Detalle los objetivos de aprendizaje, perfil del egresado y temario general..."
                          class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">{{ old('descripcion') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="precio" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Arancel de Matrícula ($ USD) *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 font-bold text-sm">$</span>
                        <input type="number" step="0.01" name="precio" id="precio" value="{{ old('precio', '150.00') }}" required
                               class="w-full pl-8 pr-4 py-3 rounded-2xl border border-slate-200 text-sm font-black text-slate-800 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">
                    </div>
                </div>
                <div>
                    <label for="duracion_horas" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Carga Horaria Certificada (Horas) *</label>
                    <div class="relative">
                        <input type="number" name="duracion_horas" id="duracion_horas" value="{{ old('duracion_horas', '40') }}" required
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-black text-slate-800 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">
                        <span class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 text-xs font-bold uppercase">Horas</span>
                    </div>
                </div>
            </div>

            <!-- Image Upload Card -->
            <div class="border-2 border-dashed border-emerald-200/80 rounded-2xl p-6 bg-emerald-50/20">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <label for="imagen" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1">Imagen de Portada del Curso</label>
                        <p class="text-xs text-slate-500 mb-3">Recomendado: 800x500px en formato JPG, PNG o WebP. Se generará una imagen vectorial automática si no se sube ninguna.</p>
                        <input type="file" name="imagen" id="imagen" accept="image/*"
                               class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white hover:file:bg-slate-800 file:transition cursor-pointer">
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('cursos.index') }}" class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold shadow-lg shadow-emerald-950/20 transition transform hover:-translate-y-0.5">
                    Registrar Curso Académico &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
