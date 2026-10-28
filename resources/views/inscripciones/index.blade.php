@extends('layouts.app')

@section('titulo', 'Registro de Matrículas')

@section('contenido')
<div class="space-y-6">
    <!-- Encabezado con Botón de Creación -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <span class="text-xs font-bold text-teal-600 uppercase tracking-widest">Control Académico</span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Registro General de Inscripciones</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Gestión de matrículas, verificación de cupos, control de pagos y emisión de comprobantes.</p>
        </div>
        <a href="{{ route('inscripciones.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-gradient-to-r from-teal-500 via-emerald-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-slate-950 font-black text-xs uppercase tracking-wider shadow-md shadow-teal-500/20 transition-all hover:scale-102">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Nueva Matrícula
        </a>
    </div>

    <!-- Barra de Filtros Refinada -->
    <div class="bg-white rounded-3xl border border-slate-200/90 p-4 sm:p-5 shadow-xs">
        <form method="GET" action="{{ route('inscripciones.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5">
                <label class="block text-[10px] font-black uppercase text-slate-400 mb-1">Buscar por Alumno o DNI</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre o número de documento..."
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-medium focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>
            </div>

            <div class="sm:col-span-4">
                <label class="block text-[10px] font-black uppercase text-slate-400 mb-1">Filtrar por Paralelo</label>
                <select name="paralelo_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-semibold focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    <option value="">Todos los paralelos</option>
                    @foreach($paralelos as $p)
                        <option value="{{ $p->id }}" {{ request('paralelo_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->curso->titulo }} &bull; {{ $p->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-3">
                <label class="block text-[10px] font-black uppercase text-slate-400 mb-1">Estado de Pago</label>
                <div class="flex gap-2">
                    <select name="estado" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-semibold focus:ring-2 focus:ring-teal-500 focus:outline-none">
                        <option value="">Todos</option>
                        <option value="pagada" {{ request('estado') === 'pagada' ? 'selected' : '' }}>Pagada</option>
                        <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="anulada" {{ request('estado') === 'anulada' ? 'selected' : '' }}>Anulada</option>
                    </select>
                    <button type="submit" class="py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-teal-300 text-xs font-black uppercase tracking-wider transition">
                        Filtrar
                    </button>
                    @if(request()->hasAny(['buscar', 'paralelo_id', 'estado']))
                        <a href="{{ route('inscripciones.index') }}" title="Limpiar Filtros" class="p-2.5 rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-100 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Tabla de Inscripciones Estilizada -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/80 text-slate-500 text-[11px] uppercase font-black tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Estudiante / Participante</th>
                        <th class="px-6 py-4">Curso y Horario</th>
                        <th class="px-6 py-4">Fecha Inscripción</th>
                        <th class="px-6 py-4">Monto Cobrado</th>
                        <th class="px-6 py-4 text-center">Estado</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($inscripciones as $inscripcion)
                        <tr class="hover:bg-teal-50/20 transition-colors">
                            <td class="px-6 py-4 text-xs font-mono font-bold text-slate-400">#{{ $inscripcion->id }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('participantes.show', $inscripcion->participante) }}" class="font-black text-slate-900 hover:text-teal-600 block transition">
                                    {{ $inscripcion->participante->nombre }}
                                </a>
                                <p class="text-xs text-slate-400 font-mono">DNI: {{ $inscripcion->participante->dni }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-extrabold text-slate-900">{{ $inscripcion->paralelo->curso->titulo }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    <span class="text-teal-700 font-bold">{{ $inscripcion->paralelo->nombre }}</span> &bull; {{ $inscripcion->paralelo->aula }} &bull; {{ $inscripcion->paralelo->dias }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-600 font-semibold whitespace-nowrap">
                                {{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-xs font-black text-slate-900 whitespace-nowrap">
                                ${{ number_format($inscripcion->monto_pagado, 2) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-black border {{ $inscripcion->badge_estado }}">
                                    {{ ucfirst($inscripcion->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-1 whitespace-nowrap">
                                <a href="{{ route('inscripciones.show', $inscripcion) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-teal-50 hover:bg-teal-100 text-teal-800 text-xs font-bold transition shadow-2xs" title="Ver Comprobante">
                                    Comprobante
                                </a>
                                <a href="{{ route('inscripciones.edit', $inscripcion) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                    Editar
                                </a>
                                <form action="{{ route('inscripciones.destroy', $inscripcion) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de eliminar esta matrícula?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-rose-600 hover:text-rose-800 hover:bg-rose-50 text-xs font-bold transition">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400 font-medium">
                                No se encontraron registros de matrícula que coincidan con la búsqueda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($inscripciones->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $inscripciones->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
