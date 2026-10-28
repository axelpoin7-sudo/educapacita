@extends('layouts.app')

@section('titulo', $instructor->nombre . ' - Perfil Docente')

@section('contenido')
<div class="space-y-6 max-w-6xl mx-auto">
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <a href="{{ route('instructores.index') }}" class="inline-flex items-center text-xs font-bold text-slate-500 hover:text-slate-900 transition">
            &larr; Volver al listado de instructores
        </a>
        @can('admin')
        <div class="flex items-center gap-2.5">
            <a href="{{ route('instructores.edit', $instructor) }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold shadow-lg shadow-emerald-950/20 transition transform hover:-translate-y-0.5">
                Editar Perfil
            </a>
        </div>
        @endcan
    </div>

    <!-- Instructor Profile Hero Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-9 flex flex-col sm:flex-row items-center sm:items-start gap-6">
        @if($instructor->foto)
            <img src="{{ $instructor->foto_url }}" class="w-24 h-24 rounded-2xl object-cover border-2 border-slate-200 shadow-md shrink-0" alt="{{ $instructor->nombre }}">
        @else
            <div class="w-24 h-24 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white font-black flex items-center justify-center text-3xl shadow-xl shadow-emerald-600/20 shrink-0">
                {{ strtoupper(substr($instructor->nombre, 0, 2)) }}
            </div>
        @endif

        <div class="space-y-2 text-center sm:text-left flex-1">
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                    {{ $instructor->especialidad }}
                </span>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                    Cuerpo Docente
                </span>
            </div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">{{ $instructor->nombre }}</h1>
            <p class="text-sm text-slate-600 max-w-2xl leading-relaxed">{{ $instructor->biografia ?? 'Instructor certificado con amplia experiencia profesional y docente en el área de especialidad.' }}</p>

            <div class="pt-3 flex flex-wrap gap-5 text-xs text-slate-500 justify-center sm:justify-start font-medium">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    {{ $instructor->email }}
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    {{ $instructor->telefono ?? 'Sin teléfono registrado' }}
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    {{ $instructor->paralelos->count() }} paralelos asignados
                </span>
            </div>
        </div>
    </div>

    <!-- Listado de Paralelos Asignados -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-black text-slate-900">Paralelos a Cargo</h2>
                <p class="text-xs text-slate-500">Cursos, horarios y aulas dictados por este instructor.</p>
            </div>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($instructor->paralelos as $paralelo)
                <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-black text-slate-900">{{ $paralelo->curso->titulo }}</span>
                            <span class="text-xs px-2.5 py-0.5 rounded-lg bg-teal-50 text-teal-800 font-bold border border-teal-200/60">{{ $paralelo->nombre }}</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1 font-medium">
                            Aula: <strong class="text-slate-800">{{ $paralelo->aula }}</strong> &bull;
                            Días: {{ $paralelo->dias }} &bull;
                            Horario: {{ substr($paralelo->hora_inicio, 0, 5) }} - {{ substr($paralelo->hora_fin, 0, 5) }} &bull;
                            Vigencia: {{ $paralelo->fecha_inicio->format('d/m/Y') }} al {{ $paralelo->fecha_fin->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-4">
                        <span class="text-xs text-slate-500 font-medium">
                            Aforo: <strong class="text-slate-800 font-bold">{{ $paralelo->inscritos_activos_count }} / {{ $paralelo->cupo_maximo }}</strong>
                        </span>
                        <a href="{{ route('paralelos.show', $paralelo) }}" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
                            Ver Paralelo &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="p-10 text-center text-slate-400 text-xs">
                    El instructor no tiene paralelos asignados en este ciclo.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
