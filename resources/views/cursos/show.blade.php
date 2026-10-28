@extends('layouts.app')

@section('titulo', $curso->titulo)

@section('contenido')
<div class="space-y-6 max-w-6xl mx-auto">
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <a href="{{ route('cursos.index') }}" class="inline-flex items-center text-xs font-bold text-slate-500 hover:text-slate-900 transition">
            &larr; Volver al catálogo de cursos
        </a>
        @can('admin')
        <div class="flex items-center gap-2.5">
            <a href="{{ route('paralelos.create') }}?curso_id={{ $curso->id }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold shadow-sm transition">
                + Aperturar Paralelo
            </a>
            <a href="{{ route('cursos.edit', $curso) }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold shadow-sm transition">
                Editar Curso
            </a>
        </div>
        @endcan
    </div>

    <!-- Main Course Hero Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm grid grid-cols-1 md:grid-cols-12">
        <div class="md:col-span-5 h-64 md:h-auto bg-slate-950 relative overflow-hidden flex items-center justify-center">
            @if($curso->imagen)
                <img src="{{ $curso->imagen_url }}" alt="{{ $curso->titulo }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-tr from-slate-900 via-emerald-950 to-teal-900 flex flex-col items-center justify-center p-8 text-center text-white">
                    <span class="text-4xl mb-3">🎓</span>
                    <span class="text-xs uppercase font-black tracking-widest text-emerald-400">EduCapacita Master</span>
                    <p class="text-sm font-bold mt-1 text-slate-300">{{ $curso->categoria->nombre }}</p>
                </div>
            @endif
            <div class="absolute top-4 left-4">
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-950/80 backdrop-blur-md text-emerald-400 border border-emerald-500/30">
                    {{ $curso->categoria->nombre }}
                </span>
            </div>
        </div>
        <div class="md:col-span-7 p-6 sm:p-9 flex flex-col justify-between space-y-6">
            <div>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Programa Certificado</span>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight mt-1">{{ $curso->titulo }}</h1>
                <p class="text-sm text-slate-600 mt-3.5 leading-relaxed">{{ $curso->descripcion ?? 'Capacitación teórico-práctica con certificación oficial y control estricto de asistencia y horarios.' }}</p>
            </div>

            <div class="pt-5 border-t border-slate-100 grid grid-cols-3 gap-3">
                <div class="p-3.5 bg-slate-50/80 rounded-2xl border border-slate-100 text-center">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Arancel</p>
                    <p class="text-xl font-black text-emerald-600 mt-0.5">${{ number_format($curso->precio, 2) }}</p>
                </div>
                <div class="p-3.5 bg-slate-50/80 rounded-2xl border border-slate-100 text-center">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Carga Horaria</p>
                    <p class="text-xl font-black text-slate-800 mt-0.5">{{ $curso->duracion_horas }} <span class="text-xs font-medium text-slate-400">hrs</span></p>
                </div>
                <div class="p-3.5 bg-slate-50/80 rounded-2xl border border-slate-100 text-center">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Paralelos</p>
                    <p class="text-xl font-black text-slate-800 mt-0.5">{{ $curso->paralelos->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Paralelos Section -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-black text-slate-900">Paralelos y Horarios Disponibles</h2>
                <p class="text-xs text-slate-500">Aforo, instructores asignados, rango de fechas y estado de matrículas.</p>
            </div>
            @can('admin')
            <a href="{{ route('paralelos.create') }}?curso_id={{ $curso->id }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
                + Aperturar Horario &rarr;
            </a>
            @endcan
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($curso->paralelos as $paralelo)
                @php
                    $estaLleno = $paralelo->estaLleno();
                @endphp
                <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                    <div class="space-y-1.5">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-black px-2.5 py-0.5 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200/60">
                                {{ $paralelo->nombre }}
                            </span>
                            <span class="text-xs text-slate-500 font-medium">&bull; Aula: <strong class="text-slate-800 font-bold">{{ $paralelo->aula }}</strong></span>
                            @if($estaLleno)
                                <span class="text-[10px] font-black px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-700 border border-rose-200">Cupo Completo</span>
                            @else
                                <span class="text-[10px] font-black px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">Cupos Disponibles</span>
                            @endif
                        </div>
                        <p class="text-sm font-bold text-slate-900">
                            {{ $paralelo->dias }} &bull; {{ substr($paralelo->hora_inicio, 0, 5) }} - {{ substr($paralelo->hora_fin, 0, 5) }}
                        </p>
                        <p class="text-xs text-slate-500 font-medium">
                            Instructor: <span class="text-slate-800 font-bold">{{ $paralelo->instructor->nombre }}</span> &bull; 
                            Vigencia: <span class="text-slate-800 font-bold">{{ $paralelo->fecha_inicio->format('d/m/Y') }}</span> al <span class="text-slate-800 font-bold">{{ $paralelo->fecha_fin->format('d/m/Y') }}</span>
                        </p>
                    </div>

                    <div class="flex items-center gap-5">
                        <!-- Medidor de Aforo -->
                        <div class="w-40 text-right">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-slate-400 font-medium text-[11px]">Ocupación:</span>
                                <span class="font-black text-slate-800 text-[11px]">{{ $paralelo->inscritos_activos_count }} / {{ $paralelo->cupo_maximo }}</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                <div class="h-2.5 rounded-full {{ $estaLleno ? 'bg-rose-500' : 'bg-emerald-500' }}" style="width: {{ $paralelo->porcentaje_ocupacion }}%"></div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('paralelos.show', $paralelo) }}" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
                                Ver Ficha
                            </a>
                            @if(!$estaLleno)
                                <a href="{{ route('inscripciones.create') }}?paralelo_id={{ $paralelo->id }}" class="px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-emerald-600 text-white text-xs font-bold shadow-sm transition">
                                    Matricular
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-slate-400 text-sm">
                    No hay paralelos aperturados para este curso actualmente.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
