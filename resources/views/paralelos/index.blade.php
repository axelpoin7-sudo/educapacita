@extends('layouts.app')

@section('titulo', 'Paralelos y Horarios')

@section('contenido')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <span class="text-xs font-bold text-teal-600 uppercase tracking-widest">Programación Académica</span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Paralelos, Aulas y Horarios</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Control de aforo, asignación docente, turnos y cupos máximos por materia.</p>
        </div>
        @can('admin')
        <a href="{{ route('paralelos.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-gradient-to-r from-teal-500 via-emerald-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-slate-950 font-black text-xs uppercase tracking-wider shadow-md shadow-teal-500/20 transition-all hover:scale-102">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Nuevo Paralelo
        </a>
        @endcan
    </div>

    <!-- Barra de Filtros -->
    <div class="bg-white rounded-3xl border border-slate-200/90 p-4 sm:p-5 shadow-xs">
        <form method="GET" action="{{ route('paralelos.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-4">
                <label class="block text-[10px] font-black uppercase text-slate-400 mb-1">Buscar por Paralelo o Aula</label>
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre de grupo o aula..."
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-medium focus:ring-2 focus:ring-teal-500 focus:outline-none">
            </div>
            <div class="sm:col-span-4">
                <label class="block text-[10px] font-black uppercase text-slate-400 mb-1">Filtrar por Curso</label>
                <select name="curso_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-semibold focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    <option value="">Todos los cursos</option>
                    @foreach($cursos as $c)
                        <option value="{{ $c->id }}" {{ request('curso_id') == $c->id ? 'selected' : '' }}>{{ $c->titulo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-4 flex items-end gap-2">
                <div class="flex-1">
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-1">Filtrar por Docente</label>
                    <select name="instructor_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-semibold focus:ring-2 focus:ring-teal-500 focus:outline-none">
                        <option value="">Todos los docentes</option>
                        @foreach($instructores as $inst)
                            <option value="{{ $inst->id }}" {{ request('instructor_id') == $inst->id ? 'selected' : '' }}>{{ $inst->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-teal-300 text-xs font-black uppercase tracking-wider transition">
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Tabla de Paralelos -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/80 text-slate-500 text-[11px] uppercase font-black tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Curso y Paralelo</th>
                        <th class="px-6 py-4">Docente Asignado</th>
                        <th class="px-6 py-4">Aula y Horario</th>
                        <th class="px-6 py-4">Periodo de Clases</th>
                        <th class="px-6 py-4 text-center">Ocupación / Aforo</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($paralelos as $paralelo)
                        @php
                            $estaLleno = $paralelo->estaLleno();
                        @endphp
                        <tr class="hover:bg-teal-50/20 transition-colors">
                            <td class="px-6 py-4">
                                <a href="{{ route('paralelos.show', $paralelo) }}" class="font-black text-slate-900 hover:text-teal-700 block transition">
                                    {{ $paralelo->curso->titulo }}
                                </a>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-black bg-slate-900 text-teal-300">
                                        {{ $paralelo->nombre }}
                                    </span>
                                    <span class="text-xs text-slate-400 font-mono">#ID-{{ $paralelo->id }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                <a href="{{ route('instructores.show', $paralelo->instructor) }}" class="hover:underline font-bold text-slate-900">
                                    {{ $paralelo->instructor->nombre }}
                                </a>
                                <p class="text-xs text-slate-400 font-medium">{{ $paralelo->instructor->especialidad }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                <div class="flex items-center text-xs font-black text-slate-900 mb-0.5">
                                    <svg class="w-3.5 h-3.5 mr-1 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    {{ $paralelo->aula }}
                                </div>
                                <p class="text-xs text-slate-600 font-semibold">{{ $paralelo->dias }}</p>
                                <p class="text-xs font-mono text-slate-500 font-bold">{{ substr($paralelo->hora_inicio, 0, 5) }} - {{ substr($paralelo->hora_fin, 0, 5) }}</p>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap">
                                <p>Inicio: <span class="font-bold text-slate-800">{{ $paralelo->fecha_inicio->format('d/m/Y') }}</span></p>
                                <p>Fin: <span class="font-bold text-slate-800">{{ $paralelo->fecha_fin->format('d/m/Y') }}</span></p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="w-36 mx-auto">
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="font-black text-slate-800">{{ $paralelo->inscritos_activos_count }}/{{ $paralelo->cupo_maximo }}</span>
                                        <span class="text-[11px] font-black {{ $estaLleno ? 'text-rose-600' : 'text-emerald-700' }}">
                                            {{ $estaLleno ? '¡Lleno!' : $paralelo->cupos_disponibles . ' libres' }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="h-2 rounded-full transition-all {{ $estaLleno ? 'bg-rose-500' : 'bg-gradient-to-r from-teal-500 to-emerald-500' }}" style="width: {{ $paralelo->porcentaje_ocupacion }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right space-x-1 whitespace-nowrap">
                                <a href="{{ route('paralelos.show', $paralelo) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-teal-50 hover:bg-teal-100 text-teal-800 text-xs font-bold transition">
                                    Ver
                                </a>
                                @can('admin')
                                <a href="{{ route('paralelos.edit', $paralelo) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                    Editar
                                </a>
                                <form action="{{ route('paralelos.destroy', $paralelo) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de eliminar este paralelo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-rose-600 hover:text-rose-800 hover:bg-rose-50 text-xs font-bold transition">
                                        Eliminar
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-medium">
                                No se encontraron paralelos programados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($paralelos->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $paralelos->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
