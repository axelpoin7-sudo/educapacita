@extends('layouts.app')

@section('titulo', 'Participantes')

@section('contenido')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <span class="text-xs font-bold text-teal-600 uppercase tracking-widest">Padrón Estudiantil</span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Estudiantes y Participantes</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Padrón oficial de alumnos registrados con cédula de identidad y datos de contacto.</p>
        </div>
        <a href="{{ route('participantes.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-gradient-to-r from-teal-500 via-emerald-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-slate-950 font-black text-xs uppercase tracking-wider shadow-md shadow-teal-500/20 transition-all hover:scale-102">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Nuevo Participante
        </a>
    </div>

    <!-- Barra de Filtros -->
    <div class="bg-white rounded-3xl border border-slate-200/90 p-4 sm:p-5 shadow-xs">
        <form method="GET" action="{{ route('participantes.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-10">
                <label class="block text-[10px] font-black uppercase text-slate-400 mb-1">Buscar por Nombre, DNI o Correo</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre completo, cédula o email..."
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-medium focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>
            </div>
            <div class="sm:col-span-2 flex items-end gap-2">
                <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-teal-300 text-xs font-black uppercase tracking-wider transition">
                    Buscar
                </button>
                @if(request('buscar'))
                    <a href="{{ route('participantes.index') }}" title="Limpiar" class="p-2.5 rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-100 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabla de Participantes -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/80 text-slate-500 text-[11px] uppercase font-black tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">DNI / Identificación</th>
                        <th class="px-6 py-4">Nombre Completo</th>
                        <th class="px-6 py-4">Correo Electrónico</th>
                        <th class="px-6 py-4">Teléfono</th>
                        <th class="px-6 py-4 text-center">Matrículas</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($participantes as $participante)
                        <tr class="hover:bg-teal-50/20 transition-colors">
                            <td class="px-6 py-4 font-mono text-xs font-bold text-slate-600">{{ $participante->dni }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('participantes.show', $participante) }}" class="font-black text-slate-900 hover:text-teal-700 block transition">
                                    {{ $participante->nombre }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-slate-600 text-xs font-medium">{{ $participante->email }}</td>
                            <td class="px-6 py-4 text-slate-500 text-xs">{{ $participante->telefono ?? 'Sin teléfono' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-black bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    {{ $participante->inscripciones_count }} cursos
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-1 whitespace-nowrap">
                                <a href="{{ route('participantes.show', $participante) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-teal-50 hover:bg-teal-100 text-teal-800 text-xs font-bold transition">
                                    Ficha
                                </a>
                                <a href="{{ route('participantes.edit', $participante) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                    Editar
                                </a>
                                <form action="{{ route('participantes.destroy', $participante) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de eliminar a este participante? Se eliminarán todas sus inscripciones asociadas.');">
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
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-medium">
                                No se encontraron participantes registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($participantes->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $participantes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
