@extends('layouts.app')

@section('titulo', 'Catálogo de Cursos')

@section('contenido')
<div class="space-y-6">
    <!-- Encabezado con Botón de Creación -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <span class="text-xs font-bold text-teal-600 uppercase tracking-widest">Oferta Formativa</span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Cursos de Capacitación</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Catálogo oficial de programas técnicos, de programación, ofimática y multimedia.</p>
        </div>
        @can('admin')
        <a href="{{ route('cursos.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-gradient-to-r from-teal-500 via-emerald-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-slate-950 font-black text-xs uppercase tracking-wider shadow-md shadow-teal-500/20 transition-all hover:scale-102">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Nuevo Curso
        </a>
        @endcan
    </div>

    <!-- Barra de Búsqueda y Filtros -->
    <div class="bg-white rounded-3xl border border-slate-200/90 p-4 sm:p-5 shadow-xs">
        <form method="GET" action="{{ route('cursos.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-7">
                <label class="block text-[10px] font-black uppercase text-slate-400 mb-1">Buscar por Título o Contenido</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre del curso, palabras clave..."
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-medium focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>
            </div>

            <div class="sm:col-span-3">
                <label class="block text-[10px] font-black uppercase text-slate-400 mb-1">Categoría / Área</label>
                <select name="categoria_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-semibold focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2 flex items-end gap-2">
                <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-teal-300 text-xs font-black uppercase tracking-wider transition">
                    Filtrar
                </button>
                @if(request()->hasAny(['buscar', 'categoria_id']))
                    <a href="{{ route('cursos.index') }}" title="Limpiar Filtros" class="p-2.5 rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-100 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Cuadrícula de Cursos (Tarjetas) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($cursos as $curso)
            <div class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-lg transition-all duration-300 flex flex-col group hover:-translate-y-1">
                <div class="relative h-48 w-full bg-slate-900 overflow-hidden">
                    <img src="{{ $curso->imagen_url }}" alt="{{ $curso->titulo }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90 group-hover:opacity-100">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                    <div class="absolute top-3.5 left-3.5">
                        <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-black bg-slate-950/85 backdrop-blur-md text-teal-300 shadow-sm border border-teal-500/20">
                            {{ $curso->categoria->nombre }}
                        </span>
                    </div>
                    <div class="absolute bottom-3.5 right-3.5">
                        <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-black bg-gradient-to-r from-teal-400 to-cyan-400 text-slate-950 shadow-md">
                            ${{ number_format($curso->precio, 2) }}
                        </span>
                    </div>
                </div>

                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <h2 class="text-base font-black text-slate-900 group-hover:text-teal-700 transition leading-snug">
                            <a href="{{ route('cursos.show', $curso) }}">{{ $curso->titulo }}</a>
                        </h2>
                        <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed font-medium">
                            {{ $curso->descripcion ?? 'Capacitación teórico-práctica con certificación oficial.' }}
                        </p>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <div class="flex items-center space-x-3">
                            <span class="flex items-center font-semibold text-slate-700">
                                <svg class="w-3.5 h-3.5 mr-1 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $curso->duracion_horas }} horas
                            </span>
                            <span class="flex items-center font-semibold text-slate-700">
                                <svg class="w-3.5 h-3.5 mr-1 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                {{ $curso->paralelos_count }} paralelos
                            </span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <a href="{{ route('cursos.show', $curso) }}" class="p-1.5 text-slate-400 hover:text-teal-700 hover:bg-teal-50 rounded-lg transition" title="Ver Detalle">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            @can('admin')
                            <a href="{{ route('cursos.edit', $curso) }}" class="p-1.5 text-slate-400 hover:text-teal-700 hover:bg-teal-50 rounded-lg transition" title="Editar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-3xl border border-slate-200 p-12 text-center text-slate-400 font-medium space-y-4">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <p class="text-base text-slate-600 font-semibold">No se encontraron cursos registrados en la base de datos.</p>
                <p class="text-xs text-slate-400 max-w-md mx-auto">Como administrador, puedes poblar el sistema automáticamente con 50 cursos, 100 paralelos, 25 docentes y 320 alumnos de demostración.</p>
                @can('admin')
                <div class="pt-2">
                    <form action="{{ route('admin.ejecutar_seeders') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center space-x-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 text-slate-950 font-black text-xs shadow-lg shadow-emerald-500/25 hover:scale-105 active:scale-95 transition-all cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <span>Poblar Base de Datos (Ejecutar Seeders)</span>
                        </button>
                    </form>
                </div>
                @endcan
            </div>
        @endforelse
    </div>

    @if($cursos->hasPages())
        <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-sm">
            {{ $cursos->links() }}
        </div>
    @endif
</div>
@endsection
