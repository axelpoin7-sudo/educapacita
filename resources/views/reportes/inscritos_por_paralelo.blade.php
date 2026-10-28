@extends('layouts.app')

@section('titulo', 'Nómina de Inscritos por Paralelo')

@section('contenido')
<div class="space-y-6 max-w-6xl mx-auto">
    <!-- Encabezado con Botón de Impresión -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-slate-200 no-print">
        <div>
            <span class="text-xs font-bold text-teal-600 uppercase tracking-widest">Reportes Académicos</span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Nómina de Inscritos por Paralelo</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Reporte oficial de alumnos matriculados, asistencia y control de aforo por grupo.</p>
        </div>
        <button onclick="window.print()" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-teal-300 text-xs font-black uppercase tracking-wider shadow-sm transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Imprimir Reporte
        </button>
    </div>

    <!-- Formulario Selector de Paralelo -->
    <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-xs no-print">
        <form method="GET" action="{{ route('reportes.inscritos_por_paralelo') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
            <div class="sm:col-span-8">
                <label for="paralelo_id" class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Seleccionar Paralelo a Consultar</label>
                <select name="paralelo_id" id="paralelo_id" onchange="this.form.submit()"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-bold focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    @foreach($paralelos as $p)
                        <option value="{{ $p->id }}" {{ $paraleloSeleccionadoId == $p->id ? 'selected' : '' }}>
                            {{ $p->curso->titulo }} &bull; {{ $p->nombre }} ({{ $p->aula }} - {{ substr($p->hora_inicio, 0, 5) }} a {{ substr($p->hora_fin, 0, 5) }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-3">
                <label for="estado" class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Filtrar por Estado</label>
                <select name="estado" id="estado" onchange="this.form.submit()"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-xs font-bold focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    <option value="">Todos los inscritos</option>
                    <option value="pagada" {{ request('estado') === 'pagada' ? 'selected' : '' }}>Solo Pagadas</option>
                    <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Solo Pendientes</option>
                    <option value="anulada" {{ request('estado') === 'anulada' ? 'selected' : '' }}>Solo Anuladas</option>
                </select>
            </div>
            <div class="sm:col-span-1">
                <button type="submit" class="w-full py-2.5 px-3 rounded-xl bg-slate-900 text-teal-300 text-xs font-black uppercase tracking-wider transition">Ver</button>
            </div>
        </form>
    </div>

    @if($paraleloSeleccionado)
        <!-- Ficha Resumen del Paralelo Consultado -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-4">
                <div>
                    <span class="text-[10px] font-black px-2.5 py-1 rounded-md bg-teal-50 text-teal-800 uppercase tracking-wider border border-teal-200">
                        {{ $paraleloSeleccionado->curso->categoria->nombre }}
                    </span>
                    <h2 class="text-xl font-black text-slate-900 mt-2">{{ $paraleloSeleccionado->curso->titulo }} &bull; {{ $paraleloSeleccionado->nombre }}</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Instructor a cargo: <strong class="text-slate-900">{{ $paraleloSeleccionado->instructor->nombre }}</strong></p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-400 font-medium">Aforo Registrado</p>
                    <p class="text-2xl font-black text-slate-900 mt-0.5">{{ $inscripciones->count() }} / {{ $paraleloSeleccionado->cupo_maximo }} cupos</p>
                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-black {{ $paraleloSeleccionado->estaLleno() ? 'bg-rose-100 text-rose-800 border border-rose-300' : 'bg-emerald-100 text-emerald-800 border border-emerald-300' }}">
                        {{ $paraleloSeleccionado->estaLleno() ? 'Cupo Completo' : $paraleloSeleccionado->cupos_disponibles . ' cupos libres' }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 text-xs">
                <div>
                    <span class="text-slate-400 block font-bold text-[10px] uppercase">Aula / Laboratorio</span>
                    <strong class="text-slate-900 text-sm">{{ $paraleloSeleccionado->aula }}</strong>
                </div>
                <div>
                    <span class="text-slate-400 block font-bold text-[10px] uppercase">Días de Clases</span>
                    <strong class="text-slate-900 text-sm">{{ $paraleloSeleccionado->dias }}</strong>
                </div>
                <div>
                    <span class="text-slate-400 block font-bold text-[10px] uppercase">Horario</span>
                    <strong class="text-slate-900 text-sm">{{ substr($paraleloSeleccionado->hora_inicio, 0, 5) }} - {{ substr($paraleloSeleccionado->hora_fin, 0, 5) }}</strong>
                </div>
                <div>
                    <span class="text-slate-400 block font-bold text-[10px] uppercase">Periodo de Vigencia</span>
                    <strong class="text-slate-900 text-sm">{{ $paraleloSeleccionado->fecha_inicio->format('d/m/Y') }} al {{ $paraleloSeleccionado->fecha_fin->format('d/m/Y') }}</strong>
                </div>
            </div>
        </div>

        <!-- Nómina Oficial de Estudiantes -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-black text-slate-900 tracking-tight">Nómina de Alumnos Matriculados</h3>
                    <p class="text-xs text-slate-500">Total listados: {{ $inscripciones->count() }} alumnos</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-[11px] uppercase font-black tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3.5">Nº</th>
                            <th class="px-6 py-3.5">C.I. / DNI</th>
                            <th class="px-6 py-3.5">Nombre Completo del Participante</th>
                            <th class="px-6 py-3.5">Correo Electrónico</th>
                            <th class="px-6 py-3.5">Teléfono</th>
                            <th class="px-6 py-3.5">Fecha Inscripción</th>
                            <th class="px-6 py-3.5 text-center">Estado Pago</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($inscripciones as $indice => $ins)
                            <tr class="hover:bg-teal-50/20 transition-colors">
                                <td class="px-6 py-3.5 text-xs font-mono font-bold text-slate-400">{{ $indice + 1 }}</td>
                                <td class="px-6 py-3.5 font-mono text-xs font-bold text-slate-700">{{ $ins->participante->dni }}</td>
                                <td class="px-6 py-3.5 font-black text-slate-900">{{ $ins->participante->nombre }}</td>
                                <td class="px-6 py-3.5 text-xs text-slate-500 font-medium">{{ $ins->participante->email }}</td>
                                <td class="px-6 py-3.5 text-xs text-slate-500">{{ $ins->participante->telefono ?? 'N/A' }}</td>
                                <td class="px-6 py-3.5 text-xs text-slate-600 font-semibold">{{ $ins->fecha_inscripcion->format('d/m/Y') }}</td>
                                <td class="px-6 py-3.5 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black border {{ $ins->badge_estado }}">
                                        {{ ucfirst($ins->estado) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-400 font-medium">
                                    No hay alumnos registrados con el criterio seleccionado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Firma / Certificación de Reporte -->
            <div class="p-8 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <p class="font-medium">EduCapacita &bull; Reporte oficial emitido el {{ date('d/m/Y H:i') }}</p>
                <div class="text-center pt-6 border-t border-slate-300 w-48 font-bold text-slate-700">
                    Firma Coordinación Académica
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center text-slate-400 font-medium">
            Seleccione un paralelo para ver su nómina oficial.
        </div>
    @endif
</div>
@endsection
