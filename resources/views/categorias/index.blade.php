@extends('layouts.app')

@section('titulo', 'Áreas y Categorías')

@section('contenido')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <span class="text-xs font-bold text-teal-600 uppercase tracking-widest">Especialidades</span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Categorías de Cursos</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Organización de áreas formativas (Ofimática, Programación, Multimedia, Redes, Marketing, IA).</p>
        </div>
        @can('admin')
        <a href="{{ route('categorias.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-gradient-to-r from-teal-500 via-emerald-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-slate-950 font-black text-xs uppercase tracking-wider shadow-md shadow-teal-500/20 transition-all hover:scale-102">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Nueva Categoría
        </a>
        @endcan
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/80 text-slate-500 text-[11px] uppercase font-black tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Nombre de la Categoría</th>
                        <th class="px-6 py-4">Descripción General</th>
                        <th class="px-6 py-4 text-center">Cursos Asociados</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($categorias as $categoria)
                        <tr class="hover:bg-teal-50/20 transition-colors">
                            <td class="px-6 py-4 text-xs font-mono font-bold text-slate-400">#{{ $categoria->id }}</td>
                            <td class="px-6 py-4">
                                <span class="font-black text-slate-900 block text-sm">{{ $categoria->nombre }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-500 text-xs max-w-md truncate">{{ $categoria->descripcion ?? 'Sin descripción detallada' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-black bg-teal-50 text-teal-800 border border-teal-200">
                                    {{ $categoria->cursos_count }} cursos
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-1 whitespace-nowrap">
                                @can('admin')
                                <a href="{{ route('categorias.edit', $categoria) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                    Editar
                                </a>
                                <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de eliminar esta categoría? Se eliminarán todos los cursos vinculados.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-rose-600 hover:text-rose-800 hover:bg-rose-50 text-xs font-bold transition">
                                        Eliminar
                                    </button>
                                </form>
                                @else
                                <span class="text-xs text-slate-400 font-medium">Solo Lectura</span>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-medium">
                                No se encontraron categorías registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categorias->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $categorias->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
