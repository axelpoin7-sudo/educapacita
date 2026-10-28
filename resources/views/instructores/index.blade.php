@extends('layouts.app')

@section('titulo', 'Cuerpo Docente')

@section('contenido')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <span class="text-xs font-bold text-teal-600 uppercase tracking-widest">Facultad y Profesores</span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Cuerpo Docente e Instructores</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Especialistas y capacitadores asignados a la oferta formativa.</p>
        </div>
        @can('admin')
        <a href="{{ route('instructores.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-gradient-to-r from-teal-500 via-emerald-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-slate-950 font-black text-xs uppercase tracking-wider shadow-md shadow-teal-500/20 transition-all hover:scale-102">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Nuevo Docente
        </a>
        @endcan
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/80 text-slate-500 text-[11px] uppercase font-black tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Instructor</th>
                        <th class="px-6 py-4">Especialidad Técnica</th>
                        <th class="px-6 py-4">Contacto Directo</th>
                        <th class="px-6 py-4 text-center">Grupos Asignados</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($instructores as $instructor)
                        <tr class="hover:bg-teal-50/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3.5">
                                    <img src="{{ $instructor->foto_url }}" class="w-11 h-11 rounded-2xl object-cover border border-slate-200 shadow-xs" alt="{{ $instructor->nombre }}">
                                    <div>
                                        <a href="{{ route('instructores.show', $instructor) }}" class="font-black text-slate-900 hover:text-teal-700 block transition">
                                            {{ $instructor->nombre }}
                                        </a>
                                        <p class="text-xs text-slate-400 font-mono">ID: #{{ $instructor->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-800 font-bold text-xs">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800">
                                    {{ $instructor->especialidad }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">
                                <p class="text-slate-800 font-bold">{{ $instructor->email }}</p>
                                <p class="text-slate-500 mt-0.5">{{ $instructor->telefono ?? 'Sin teléfono' }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-black bg-teal-50 text-teal-800 border border-teal-200">
                                    {{ $instructor->paralelos_count }} paralelos
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-1 whitespace-nowrap">
                                <a href="{{ route('instructores.show', $instructor) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-teal-50 hover:bg-teal-100 text-teal-800 text-xs font-bold transition">
                                    Ficha
                                </a>
                                @can('admin')
                                <a href="{{ route('instructores.edit', $instructor) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                    Editar
                                </a>
                                <form action="{{ route('instructores.destroy', $instructor) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de eliminar este instructor?');">
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
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-medium">
                                No se encontraron instructores registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($instructores->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $instructores->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
