@extends('layouts.app')

@section('titulo', 'Nuevo Paralelo')

@section('contenido')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-teal-50 text-teal-700 border border-teal-200">
                    Apertura de Horarios
                </span>
                <span class="text-xs text-slate-400 font-medium">Planificación Académica</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">Aperturar Nuevo Paralelo</h1>
            <p class="text-xs text-slate-500">Asigna aula, cupo máximo, instructor responsable y franja horaria.</p>
        </div>
        <a href="{{ route('paralelos.index') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 shadow-sm transition">
            &larr; Volver a paralelos
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 sm:p-8 bg-gradient-to-r from-slate-900 via-teal-950 to-slate-900 text-white">
            <h2 class="text-lg font-black text-white">Reglas y Asignación de Horario</h2>
            <p class="text-xs text-slate-300 mt-1">Validaciones activas: Nombres de paralelo únicos por curso y control estricto de hora fin posterior a la hora inicio.</p>
        </div>

        <form action="{{ route('paralelos.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="curso_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Curso de Capacitación *</label>
                    <select name="curso_id" id="curso_id" required
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 focus:outline-none transition">
                        <option value="">Seleccione el curso</option>
                        @foreach($cursos as $c)
                            <option value="{{ $c->id }}" {{ (old('curso_id', request('curso_id')) == $c->id) ? 'selected' : '' }}>
                                {{ $c->titulo }} (${{ number_format($c->precio, 2) }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="instructor_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Instructor Docente *</label>
                    <select name="instructor_id" id="instructor_id" required
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 focus:outline-none transition">
                        <option value="">Seleccione el instructor</option>
                        @foreach($instructores as $inst)
                            <option value="{{ $inst->id }}" {{ old('instructor_id') == $inst->id ? 'selected' : '' }}>
                                {{ $inst->nombre }} ({{ $inst->especialidad }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label for="nombre" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nombre del Paralelo *</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', 'Paralelo A') }}" required placeholder="Ej: Paralelo A"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 focus:outline-none transition">
                    <p class="text-[11px] text-slate-400 mt-1">Único dentro del curso seleccionado.</p>
                </div>
                <div>
                    <label for="aula" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Aula / Laboratorio *</label>
                    <input type="text" name="aula" id="aula" value="{{ old('aula') }}" required placeholder="Ej: Lab Cómputo 1"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 focus:outline-none transition">
                </div>
                <div>
                    <label for="cupo_maximo" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Cupo Máximo (Aforo) *</label>
                    <input type="number" name="cupo_maximo" id="cupo_maximo" value="{{ old('cupo_maximo', '25') }}" min="1" max="500" required
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-black text-slate-800 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 focus:outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="sm:col-span-1">
                    <label for="dias" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Días de Clases *</label>
                    <input type="text" name="dias" id="dias" value="{{ old('dias', 'Lunes, Miércoles, Viernes') }}" required placeholder="Ej: Lunes a Viernes"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 focus:outline-none transition">
                </div>
                <div>
                    <label for="hora_inicio" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Hora Inicio *</label>
                    <input type="time" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio', '08:00') }}" required
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-bold text-slate-800 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 focus:outline-none transition">
                </div>
                <div>
                    <label for="hora_fin" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Hora Fin (Posterior) *</label>
                    <input type="time" name="hora_fin" id="hora_fin" value="{{ old('hora_fin', '10:00') }}" required
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-bold text-slate-800 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 focus:outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 p-5 bg-teal-50/30 rounded-2xl border border-teal-100">
                <div>
                    <label for="fecha_inicio" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">Fecha de Inicio de Clases *</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio', date('Y-m-d')) }}" required
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white text-sm font-bold text-slate-800 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 focus:outline-none transition">
                </div>
                <div>
                    <label for="fecha_fin" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">Fecha de Culminación *</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin', date('Y-m-d', strtotime('+6 weeks'))) }}" required
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white text-sm font-bold text-slate-800 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 focus:outline-none transition">
                    <p class="text-[11px] text-teal-700 mt-1">Las inscripciones sólo serán admitidas dentro de este periodo lectivo.</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('paralelos.index') }}" class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-500 hover:to-emerald-500 text-white text-xs font-bold shadow-lg shadow-teal-950/20 transition transform hover:-translate-y-0.5">
                    Guardar Paralelo y Horario &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
