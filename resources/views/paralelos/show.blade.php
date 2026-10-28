@extends('layouts.app')

@section('titulo', $paralelo->curso->titulo . ' - ' . $paralelo->nombre)

@section('contenido')
<div class="space-y-6 max-w-6xl mx-auto">
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <a href="{{ route('paralelos.index') }}" class="inline-flex items-center text-xs font-bold text-slate-500 hover:text-slate-900 transition">
            &larr; Volver al listado de paralelos
        </a>
        <div class="flex items-center gap-2.5">
            @if(!$paralelo->estaLleno())
                <a href="{{ route('inscripciones.create') }}?paralelo_id={{ $paralelo->id }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold shadow-lg shadow-emerald-950/20 transition transform hover:-translate-y-0.5">
                    + Inscribir Participante
                </a>
            @endif
            @can('admin')
            <a href="{{ route('paralelos.edit', $paralelo) }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold shadow-sm transition">
                Editar Paralelo
            </a>
            @endcan
        </div>
    </div>

    <!-- Ficha del Paralelo -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-9">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 pb-6 border-b border-slate-100">
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-black px-3 py-1 rounded-full bg-teal-50 text-teal-800 border border-teal-200/80 uppercase tracking-wider">
                        {{ $paralelo->nombre }}
                    </span>
                    <span class="text-xs text-slate-400 font-mono">ID: #{{ $paralelo->id }}</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight mt-2">{{ $paralelo->curso->titulo }}</h1>
                <p class="text-sm text-slate-500 mt-1 font-medium">
                    Instructor Asignado: <strong class="text-slate-800 font-bold">{{ $paralelo->instructor->nombre }}</strong> ({{ $paralelo->instructor->especialidad }})
                </p>
            </div>

            <div class="bg-slate-50/80 p-5 rounded-2xl border border-slate-100 w-full md:w-72">
                <div class="flex justify-between items-center text-xs mb-1.5">
                    <span class="font-bold text-slate-500 uppercase tracking-wider text-[10px]">Aforo Ocupado</span>
                    <span class="font-black text-slate-900 text-sm">{{ $paralelo->inscritos_activos_count }} / {{ $paralelo->cupo_maximo }}</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-3 overflow-hidden mb-2">
                    <div class="h-3 rounded-full {{ $paralelo->estaLleno() ? 'bg-rose-500' : 'bg-emerald-500' }}" style="width: {{ $paralelo->porcentaje_ocupacion }}%"></div>
                </div>
                <p class="text-xs text-center font-bold">
                    @if($paralelo->estaLleno())
                        <span class="text-rose-600">Aforo Completo (Sin cupos)</span>
                    @else
                        <span class="text-emerald-700">{{ $paralelo->cupos_disponibles }} cupos libres disponibles</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-6 text-xs">
            <div class="p-3 bg-slate-50 rounded-xl">
                <p class="text-slate-400 font-bold uppercase text-[10px]">Aula / Laboratorio</p>
                <p class="font-black text-slate-900 text-sm mt-0.5">{{ $paralelo->aula }}</p>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl">
                <p class="text-slate-400 font-bold uppercase text-[10px]">Días de Clases</p>
                <p class="font-black text-slate-900 text-sm mt-0.5">{{ $paralelo->dias }}</p>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl">
                <p class="text-slate-400 font-bold uppercase text-[10px]">Horario de Clases</p>
                <p class="font-black text-slate-900 text-sm mt-0.5">{{ substr($paralelo->hora_inicio, 0, 5) }} - {{ substr($paralelo->hora_fin, 0, 5) }}</p>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl">
                <p class="text-slate-400 font-bold uppercase text-[10px]">Vigencia de Matrícula</p>
                <p class="font-black text-slate-900 text-xs mt-0.5">{{ $paralelo->fecha_inicio->format('d/m/Y') }} al {{ $paralelo->fecha_fin->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Lista de Estudiantes Inscritos en este Paralelo -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-black text-slate-900">Estudiantes Matriculados</h2>
                <p class="text-xs text-slate-500">Nómina oficial de participantes registrados para este periodo lectivo.</p>
            </div>
            <a href="{{ route('reportes.inscritos_por_paralelo') }}?paralelo_id={{ $paralelo->id }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
                Imprimir Nómina &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/75 text-slate-600 text-xs uppercase font-bold border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Estudiante</th>
                        <th class="px-6 py-4">DNI / Cédula</th>
                        <th class="px-6 py-4">Fecha Inscripción</th>
                        <th class="px-6 py-4">Monto Abonado</th>
                        <th class="px-6 py-4 text-center">Estado</th>
                        <th class="px-6 py-4 text-right">Comprobante</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($paralelo->inscripciones as $inscripcion)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-900 text-white font-black text-xs flex items-center justify-center">
                                        {{ substr($inscripcion->participante->nombre, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-slate-900">{{ $inscripcion->participante->nombre }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $inscripcion->participante->dni }}</td>
                            <td class="px-6 py-4 text-xs text-slate-600">{{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-xs font-black text-slate-900">${{ number_format($inscripcion->monto_pagado, 2) }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $inscripcion->badge_estado }}">
                                    {{ ucfirst($inscripcion->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('inscripciones.show', $inscripcion) }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-800">
                                    Ver Voucher &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400 text-xs">
                                No hay inscripciones registradas en este paralelo todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
