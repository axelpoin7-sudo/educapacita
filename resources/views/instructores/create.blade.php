@extends('layouts.app')

@section('titulo', 'Nuevo Instructor')

@section('contenido')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                    Cuerpo Académico
                </span>
                <span class="text-xs text-slate-400 font-medium">Registro Docente</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">Registrar Nuevo Instructor</h1>
            <p class="text-xs text-slate-500">Añade a un docente o facilitador para asignarlo a cursos y paralelos.</p>
        </div>
        <a href="{{ route('instructores.index') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 shadow-sm transition">
            &larr; Volver al listado
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 sm:p-8 bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 text-white">
            <h2 class="text-lg font-black text-white">Perfil Profesional del Docente</h2>
            <p class="text-xs text-slate-300 mt-1">Completa los datos curriculares y de contacto del instructor.</p>
        </div>

        <form action="{{ route('instructores.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="nombre" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nombre Completo *</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required placeholder="Ej: Ing. Carlos Mendoza"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">
                </div>
                <div>
                    <label for="especialidad" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Especialidad Principal *</label>
                    <input type="text" name="especialidad" id="especialidad" value="{{ old('especialidad') }}" required placeholder="Ej: Bases de Datos & Backend"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Correo Electrónico *</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="instructor@correo.com"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">
                </div>
                <div>
                    <label for="telefono" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Teléfono Celular</label>
                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" placeholder="+591 70000000"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">
                </div>
            </div>

            <div>
                <label for="biografia" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Perfil Profesional / Resumen Curricular</label>
                <textarea name="biografia" id="biografia" rows="4" placeholder="Detalle la experiencia académica, certificaciones relevantes o trayectoria docente..."
                          class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition">{{ old('biografia') }}</textarea>
            </div>

            <!-- Fotografía -->
            <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 bg-slate-50/50">
                <label for="foto" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1">Fotografía del Instructor</label>
                <p class="text-xs text-slate-500 mb-3">Foto de perfil formal o profesional (JPG, PNG, WEBP máx 2MB).</p>
                <input type="file" name="foto" id="foto" accept="image/*"
                       class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white hover:file:bg-slate-800 file:transition cursor-pointer">
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('instructores.index') }}" class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold shadow-lg shadow-emerald-950/20 transition transform hover:-translate-y-0.5">
                    Guardar Instructor &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
