@extends('layouts.app')

@section('titulo', $participante->nombre . ' - Historial')

@section('contenido')
<div class="space-y-6 max-w-6xl mx-auto">
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <a href="{{ route('participantes.index') }}" class="inline-flex items-center text-xs font-bold text-slate-500 hover:text-slate-900 transition">
            &larr; Volver al listado de participantes
        </a>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('inscripciones.create') }}?participante_id={{ $participante->id }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold shadow-lg shadow-emerald-950/20 transition transform hover:-translate-y-0.5">
                + Matricular en Curso
            </a>
            <a href="{{ route('participantes.edit', $participante) }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold shadow-sm transition">
                Editar Datos
            </a>
        </div>
    </div>

    <!-- Student Profile Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-9 flex flex-col sm:flex-row items-center sm:items-start gap-6">
        <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-cyan-600 to-teal-500 text-white font-black flex items-center justify-center text-2xl shadow-xl shadow-cyan-600/20 shrink-0">
            {{ strtoupper(substr($participante->nombre, 0, 2)) }}
        </div>
        <div class="space-y-2 text-center sm:text-left flex-1">
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-mono font-bold bg-slate-100 text-slate-700 border border-slate-200">
                    DNI: {{ $participante->dni }}
                </span>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    Alumno Activo
                </span>
            </div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">{{ $participante->nombre }}</h1>
            <div class="pt-2 flex flex-wrap gap-5 text-xs text-slate-500 justify-center sm:justify-start font-medium">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    {{ $participante->email }}
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    {{ $participante->telefono ?? 'Sin teléfono registrado' }}
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    {{ $participante->inscripciones->count() }} cursos inscritos
                </span>
            </div>
        </div>
    </div>

    <!-- Historial Académico del Alumno -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-black text-slate-900">Historial de Cursos Matriculados</h2>
                <p class="text-xs text-slate-500">Detalle de matrículas realizadas, montos y paralelos cursados.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/75 text-slate-600 text-xs uppercase font-bold border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Curso</th>
                        <th class="px-6 py-4">Paralelo y Aula</th>
                        <th class="px-6 py-4">Horario</th>
                        <th class="px-6 py-4">Fecha Inscripción</th>
                        <th class="px-6 py-4">Monto Pagado</th>
                        <th class="px-6 py-4 text-center">Estado</th>
                        <th class="px-6 py-4 text-right">Comprobante</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($participante->inscripciones as $inscripcion)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 font-bold text-slate-900">{{ $inscripcion->paralelo->curso->titulo }}</td>
                            <td class="px-6 py-4 text-xs text-slate-600">
                                <span class="font-bold text-slate-800">{{ $inscripcion->paralelo->nombre }}</span> ({{ $inscripcion->paralelo->aula }})
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">
                                {{ $inscripcion->paralelo->dias }} &bull; {{ substr($inscripcion->paralelo->hora_inicio, 0, 5) }}-{{ substr($inscripcion->paralelo->hora_fin, 0, 5) }}
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">{{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-xs font-black text-slate-900">${{ number_format($inscripcion->monto_pagado, 2) }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $inscripcion->badge_estado }}">
                                    {{ ucfirst($inscripcion->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('inscripciones.show', $inscripcion) }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-800">
                                    Voucher &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-slate-400 text-xs">
                                El alumno aún no cuenta con inscripciones registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
