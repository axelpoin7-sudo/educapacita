@extends('layouts.app')

@section('titulo', 'Panel de Control')

@section('contenido')
<div class="space-y-8">
    
    <!-- Hero Header del Dashboard -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#09111e] via-[#0e1c2e] to-[#071322] border border-teal-500/20 p-6 sm:p-8 text-white shadow-xl">
        <div class="absolute -right-10 -top-10 w-64 h-64 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/3 -bottom-10 w-48 h-48 bg-cyan-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-teal-500/15 border border-teal-500/30 text-teal-300 text-xs font-bold mb-3">
                    <span class="w-2 h-2 rounded-full bg-teal-400 animate-pulse"></span>
                    <span>Sistema Académico Inteligente &bull; Semestre 2026</span>
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white">
                    Bienvenido, {{ Auth::user()->name ?? 'Administrador' }}
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm mt-1 max-w-2xl font-normal leading-relaxed">
                    Monitoreo en tiempo real de matriculaciones, validaciones de aforo, control de fechas y recaudación económica del centro.
                </p>
            </div>

            <!-- Accesos Directos Principales -->
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('inscripciones.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-gradient-to-r from-teal-400 via-emerald-400 to-cyan-400 hover:from-teal-500 hover:to-cyan-500 text-slate-950 text-xs font-black uppercase tracking-wider shadow-lg shadow-teal-500/25 transition-all hover:scale-102">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nueva Matrícula
                </a>
                <a href="{{ route('cursos.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 text-white text-xs font-bold uppercase tracking-wider backdrop-blur-md transition shadow-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Añadir Curso
                </a>
            </div>
        </div>
    </div>

    <!-- Cuadrícula de Métricas Clave (KPIs) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Recaudación / Ingresos -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs relative overflow-hidden transition-all hover:shadow-md hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest block">Recaudación Total</span>
                    <p class="text-3xl font-black text-slate-900 mt-1">${{ number_format($estadisticas['ingresos_totales'], 2) }}</p>
                </div>
                <div class="w-13 h-13 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 flex items-center justify-center shadow-xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center text-xs text-slate-500">
                <span class="text-emerald-700 font-bold mr-1">{{ $estadisticas['inscripciones_pagadas'] }}</span> matrículas confirmadas y abonadas
            </div>
        </div>

        <!-- Total Matrículas -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs relative overflow-hidden transition-all hover:shadow-md hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest block">Matrículas Totales</span>
                    <p class="text-3xl font-black text-slate-900 mt-1">{{ number_format($estadisticas['inscripciones']) }}</p>
                </div>
                <div class="w-13 h-13 rounded-2xl bg-teal-500/10 border border-teal-500/20 text-teal-600 flex items-center justify-center shadow-xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-1.5 text-[11px]">
                <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 font-bold">{{ $estadisticas['inscripciones_pagadas'] }} pagadas</span>
                <span class="px-2 py-0.5 rounded-md bg-amber-100 text-amber-800 font-bold">{{ $estadisticas['inscripciones_pendientes'] }} pend.</span>
                <span class="px-2 py-0.5 rounded-md bg-rose-100 text-rose-800 font-bold">{{ $estadisticas['inscripciones_anuladas'] }} anul.</span>
            </div>
        </div>

        <!-- Alumnos / Participantes -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs relative overflow-hidden transition-all hover:shadow-md hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest block">Alumnos Activos</span>
                    <p class="text-3xl font-black text-slate-900 mt-1">{{ number_format($estadisticas['participantes']) }}</p>
                </div>
                <div class="w-13 h-13 rounded-2xl bg-cyan-500/10 border border-cyan-500/20 text-cyan-600 flex items-center justify-center shadow-xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Registrados en el sistema</span>
                <a href="{{ route('participantes.index') }}" class="text-teal-600 hover:text-teal-800 font-bold">Ver todos &rarr;</a>
            </div>
        </div>

        <!-- Oferta de Cursos -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs relative overflow-hidden transition-all hover:shadow-md hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest block">Oferta Educativa</span>
                    <p class="text-3xl font-black text-slate-900 mt-1">{{ $estadisticas['cursos'] }}</p>
                </div>
                <div class="w-13 h-13 rounded-2xl bg-violet-500/10 border border-violet-500/20 text-violet-600 flex items-center justify-center shadow-xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center text-xs text-slate-500">
                <span>{{ $estadisticas['paralelos'] }} paralelos en {{ $estadisticas['categorias'] }} especialidades</span>
            </div>
        </div>
    </div>

    <!-- Sección: Monitoreo de Aforo y Cupos en Vivo -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold text-teal-600 uppercase tracking-wider">Control de Capacidad</span>
                <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight">Ocupación y Cupos por Paralelo</h2>
                <p class="text-xs text-slate-500">Monitoreo de aforo para evitar sobrecupos y coordinar nuevas aperturas de grupos.</p>
            </div>
            <a href="{{ route('paralelos.index') }}" class="text-xs font-bold text-teal-600 hover:text-teal-800 flex items-center">
                Ver todos los paralelos &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @forelse($paralelos as $paralelo)
                @php
                    $porcentaje = $paralelo->cupo_maximo > 0 ? min(100, round(($paralelo->inscritos_activos_count / $paralelo->cupo_maximo) * 100)) : 0;
                    $estaLleno = $paralelo->inscritos_activos_count >= $paralelo->cupo_maximo;
                @endphp
                <div class="bg-white rounded-3xl p-5 border {{ $estaLleno ? 'border-rose-300 bg-rose-50/20' : 'border-slate-200/90' }} shadow-xs flex flex-col justify-between transition-all hover:shadow-md">
                    <div>
                        <div class="flex items-center justify-between mb-2.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-black bg-slate-900 text-teal-400">
                                {{ $paralelo->nombre }}
                            </span>
                            @if($estaLleno)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-black bg-rose-100 text-rose-800 border border-rose-300 uppercase tracking-wider">
                                    ¡Lleno!
                                </span>
                            @else
                                <span class="text-xs text-emerald-700 font-extrabold flex items-center">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                    {{ max(0, $paralelo->cupo_maximo - $paralelo->inscritos_activos_count) }} libres
                                </span>
                            @endif
                        </div>

                        <h3 class="text-sm font-black text-slate-900 line-clamp-1" title="{{ $paralelo->curso->titulo }}">
                            <a href="{{ route('paralelos.show', $paralelo) }}" class="hover:text-teal-600 transition">
                                {{ $paralelo->curso->titulo }}
                            </a>
                        </h3>

                        <div class="text-[11px] text-slate-500 mt-2 space-y-1">
                            <p class="flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                {{ $paralelo->aula }}
                            </p>
                            <p class="flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $paralelo->dias }} ({{ substr($paralelo->hora_inicio, 0, 5) }}-{{ substr($paralelo->hora_fin, 0, 5) }})
                            </p>
                        </div>
                    </div>

                    <!-- Medidor de Aforo -->
                    <div class="mt-4 pt-3 border-t border-slate-100">
                        <div class="flex justify-between text-xs mb-1.5">
                            <span class="text-slate-400 font-semibold text-[11px]">Aforo Ocupado</span>
                            <span class="font-extrabold {{ $estaLleno ? 'text-rose-600' : 'text-slate-800' }}">{{ $paralelo->inscritos_activos_count }} / {{ $paralelo->cupo_maximo }} ({{ $porcentaje }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="h-2 rounded-full transition-all {{ $estaLleno ? 'bg-rose-500' : ($porcentaje >= 80 ? 'bg-amber-500' : 'bg-gradient-to-r from-teal-500 to-emerald-500') }}" style="width: {{ $porcentaje }}%"></div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-400 col-span-4 text-center py-8">No hay paralelos configurados aún.</p>
            @endforelse
        </div>
    </div>

    <!-- Sección: Últimas Matrículas Registradas -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <span class="text-[11px] font-bold text-teal-600 uppercase tracking-wider">Historial de Registro</span>
                <h2 class="text-lg font-black text-slate-900 tracking-tight">Últimas Inscripciones Procesadas</h2>
                <p class="text-xs text-slate-500">Transacciones y admisiones académicas más recientes.</p>
            </div>
            <a href="{{ route('inscripciones.index') }}" class="text-xs font-bold text-teal-600 hover:text-teal-800 flex items-center">
                Ver listado completo &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/75 text-slate-500 text-[11px] uppercase font-black tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Participante</th>
                        <th class="px-6 py-3.5">Curso / Paralelo</th>
                        <th class="px-6 py-3.5">Fecha</th>
                        <th class="px-6 py-3.5">Monto Pagado</th>
                        <th class="px-6 py-3.5">Estado</th>
                        <th class="px-6 py-3.5 text-right">Comprobante</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($ultimasInscripciones as $inscripcion)
                        <tr class="hover:bg-teal-50/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-extrabold text-slate-900">{{ $inscripcion->participante->nombre }}</div>
                                <div class="text-xs text-slate-500">C.I. / DNI: {{ $inscripcion->participante->dni }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-slate-900 font-bold">{{ $inscripcion->paralelo->curso->titulo }}</div>
                                <div class="text-xs text-teal-700 font-semibold">{{ $inscripcion->paralelo->nombre }} &bull; {{ $inscripcion->paralelo->aula }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 text-xs font-semibold">
                                {{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 font-black text-slate-900">
                                ${{ number_format($inscripcion->monto_pagado, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-black border {{ $inscripcion->badge_estado }}">
                                    {{ ucfirst($inscripcion->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('inscripciones.show', $inscripcion) }}" class="inline-flex items-center px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-teal-500 hover:text-slate-950 text-slate-700 text-xs font-bold transition shadow-2xs">
                                    Ver Matrícula
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400 font-medium">No hay inscripciones registradas en el período.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
