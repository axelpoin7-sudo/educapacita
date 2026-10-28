@extends('layouts.app')

@section('titulo', 'Nuevo Participante')

@section('contenido')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-cyan-50 text-cyan-800 border border-cyan-200">
                    Directorio Estudiantil
                </span>
                <span class="text-xs text-slate-400 font-medium">Registro de Alumnos</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">Registrar Nuevo Participante</h1>
            <p class="text-xs text-slate-500">Crea el perfil del alumno para habilitar su matrícula en los cursos activos.</p>
        </div>
        <a href="{{ route('participantes.index') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 shadow-sm transition">
            &larr; Volver al listado
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 sm:p-8 bg-gradient-to-r from-slate-900 via-cyan-950 to-slate-900 text-white">
            <h2 class="text-lg font-black text-white">Datos de Identificación del Estudiante</h2>
            <p class="text-xs text-slate-300 mt-1">La cédula/DNI y correo deben ser únicos para evitar duplicidad de certificados.</p>
        </div>

        <form action="{{ route('participantes.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="dni" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Cédula de Identidad / DNI *</label>
                    <input type="text" name="dni" id="dni" value="{{ old('dni') }}" required placeholder="Ej: 8492019"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 font-mono text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 focus:outline-none transition">
                </div>
                <div>
                    <label for="nombre" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nombres y Apellidos Completos *</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required placeholder="Ej: Andrea Rios Gómez"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 focus:outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Correo Electrónico *</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="alumno@correo.com"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 focus:outline-none transition">
                </div>
                <div>
                    <label for="telefono" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Teléfono Celular / WhatsApp</label>
                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" placeholder="+591 76543210"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 focus:outline-none transition">
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('participantes.index') }}" class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-500 hover:to-teal-500 text-white text-xs font-bold shadow-lg shadow-cyan-950/20 transition transform hover:-translate-y-0.5">
                    Guardar Participante &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
