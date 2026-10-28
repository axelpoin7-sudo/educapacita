@extends('layouts.app')

@section('titulo', 'Ingresos Económicos por Curso')

@section('contenido')
<div class="space-y-6 max-w-6xl mx-auto">
    <!-- Encabezado con Botón de Impresión -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-slate-200 no-print">
        <div>
            <span class="text-xs font-bold text-teal-600 uppercase tracking-widest">Reportes Financieros</span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Consolidado de Ingresos por Curso</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Recaudación pagada, cobros pendientes y rentabilidad económica por programa formativo.</p>
        </div>
        <button onclick="window.print()" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-teal-300 text-xs font-black uppercase tracking-wider shadow-sm transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Imprimir Balance
        </button>
    </div>

    <!-- Tarjetas de Métricas Resumen (KPIs) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Gran Total Recaudado</span>
            <p class="text-3xl font-black text-emerald-600 mt-1">${{ number_format($totalGeneralRecaudado, 2) }}</p>
            <p class="text-xs text-slate-400 mt-2 font-medium">Pagos completados y confirmados</p>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Montos por Cobrar</span>
            <p class="text-3xl font-black text-amber-600 mt-1">${{ number_format($totalGeneralPendiente, 2) }}</p>
            <p class="text-xs text-slate-400 mt-2 font-medium">Matrículas en estado pendiente</p>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Total Alumnos</span>
            <p class="text-3xl font-black text-slate-900 mt-1">{{ number_format($totalAlumnosGeneral) }}</p>
            <p class="text-xs text-slate-400 mt-2 font-medium">Inscritos en todos los cursos</p>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Curso Más Rentable</span>
            <p class="text-base font-black text-slate-900 mt-1 line-clamp-1" title="{{ $cursoMasRentable?->titulo }}">{{ $cursoMasRentable?->titulo ?? 'N/A' }}</p>
            <p class="text-xs text-emerald-700 font-bold mt-2">${{ number_format($cursoMasRentable?->ingresos_recaudados ?? 0, 2) }} recaudados</p>
        </div>
    </div>

    <!-- Filtro por Categoría -->
    <div class="bg-white rounded-3xl border border-slate-200/90 p-4 sm:p-5 shadow-xs no-print">
        <form method="GET" action="{{ route('reportes.ingresos_por_curso') }}" class="flex flex-col sm:flex-row gap-3 items-center justify-between">
            <div class="flex items-center space-x-3 w-full sm:w-auto">
                <label for="categoria_id" class="text-xs font-black text-slate-700 uppercase whitespace-nowrap">Filtrar por Área:</label>
                <select name="categoria_id" id="categoria_id" onchange="this.form.submit()"
                        class="px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-bold focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>
            @if(request()->filled('categoria_id'))
                <a href="{{ route('reportes.ingresos_por_curso') }}" class="text-xs font-bold text-teal-600 hover:underline">Mostrar todos los cursos</a>
            @endif
        </form>
    </div>

    <!-- Tabla Detallada de Ingresos por Curso -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-black text-slate-900 tracking-tight">Desglose Financiero por Programa Formativo</h2>
                <p class="text-xs text-slate-500">Recaudación pagada, cuentas por cobrar y balance por curso.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/80 text-slate-500 text-[11px] uppercase font-black tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Curso y Área</th>
                        <th class="px-6 py-4">Precio Oficial</th>
                        <th class="px-6 py-4 text-center">Paralelos</th>
                        <th class="px-6 py-4 text-center">Alumnos</th>
                        <th class="px-6 py-4 text-center">Pagados / Pend.</th>
                        <th class="px-6 py-4 text-right">Por Cobrar</th>
                        <th class="px-6 py-4 text-right">Total Recaudado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($cursos as $curso)
                        <tr class="hover:bg-teal-50/20 transition-colors">
                            <td class="px-6 py-4">
                                <a href="{{ route('cursos.show', $curso) }}" class="font-black text-slate-900 hover:text-teal-700 block transition">
                                    {{ $curso->titulo }}
                                </a>
                                <p class="text-xs text-slate-400 font-medium">{{ $curso->categoria->nombre }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-700 text-xs font-bold">
                                ${{ number_format($curso->precio, 2) }}
                            </td>
                            <td class="px-6 py-4 text-center text-xs text-slate-600 font-semibold">
                                {{ $curso->paralelos_count }}
                            </td>
                            <td class="px-6 py-4 text-center text-xs font-black text-slate-900">
                                {{ $curso->total_alumnos }}
                            </td>
                            <td class="px-6 py-4 text-center text-xs">
                                <span class="text-emerald-700 font-black">{{ $curso->conteo_pagados }}</span>
                                <span class="text-slate-300 mx-1">/</span>
                                <span class="text-amber-700 font-black">{{ $curso->conteo_pendientes }}</span>
                            </td>
                            <td class="px-6 py-4 text-right text-xs text-amber-700 font-bold">
                                ${{ number_format($curso->ingresos_pendientes, 2) }}
                            </td>
                            <td class="px-6 py-4 text-right font-black text-sm text-emerald-700">
                                ${{ number_format($curso->ingresos_recaudados, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400 font-medium">
                                No se encontraron cursos para esta categoría.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-slate-50 text-slate-900 font-black text-sm border-t border-slate-200">
                    <tr>
                        <td colspan="5" class="px-6 py-4 uppercase tracking-wider">Totales Consolidados:</td>
                        <td class="px-6 py-4 text-right text-amber-700">${{ number_format($totalGeneralPendiente, 2) }}</td>
                        <td class="px-6 py-4 text-right text-emerald-700 text-base">${{ number_format($totalGeneralRecaudado, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
