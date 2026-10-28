@extends('layouts.app')

@section('titulo', 'Comprobante de Matrícula #' . $inscripcion->id)

@section('contenido')
<div class="space-y-6 max-w-3xl mx-auto">
    <div class="flex items-center justify-between no-print">
        <a href="{{ route('inscripciones.index') }}" class="inline-flex items-center text-xs font-bold text-slate-600 hover:text-slate-900">
            &larr; Volver a Matrículas
        </a>
        <div class="flex space-x-2">
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-teal-300 text-xs font-black uppercase tracking-wider shadow-sm transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Imprimir Comprobante
            </button>
            @can('admin')
            <a href="{{ route('inscripciones.edit', $inscripcion) }}" class="inline-flex items-center px-4 py-2 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-bold transition">
                Editar
            </a>
            @endcan
        </div>
    </div>

    <!-- Comprobante Académico Oficial -->
    <div class="bg-white rounded-3xl border border-slate-200/90 p-8 shadow-sm print:border-none print:shadow-none space-y-6">
        <!-- Encabezado del Comprobante -->
        <div class="flex items-center justify-between border-b border-slate-200 pb-6">
            <div class="flex items-center space-x-3.5">
                <div class="w-13 h-13 rounded-2xl bg-gradient-to-tr from-teal-400 via-emerald-500 to-cyan-500 flex items-center justify-center text-slate-950 font-black text-2xl shadow-md">
                    E
                </div>
                <div>
                    <h2 class="text-xl font-black text-slate-900 leading-tight">EduCapacita</h2>
                    <p class="text-xs text-slate-500 font-medium">Centro de Capacitación y Formación Continua</p>
                </div>
            </div>
            <div class="text-right">
                <span class="text-[10px] uppercase tracking-widest font-black text-teal-700 bg-teal-50 px-2 py-0.5 rounded-md border border-teal-200">Comprobante Oficial</span>
                <p class="text-xl font-mono font-black text-slate-900 mt-1">#MAT-{{ str_pad($inscripcion->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p class="text-xs text-slate-500 font-semibold">Fecha: {{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}</p>
            </div>
        </div>

        <!-- Ficha de Datos del Alumno y del Paralelo -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 bg-slate-50/80 p-5 rounded-2xl border border-slate-200 text-xs">
            <div>
                <h4 class="font-black text-slate-400 uppercase tracking-widest text-[10px] mb-2">Datos del Estudiante</h4>
                <p class="text-base font-black text-slate-900">{{ $inscripcion->participante->nombre }}</p>
                <p class="text-slate-600 mt-1"><strong>C.I. / DNI:</strong> {{ $inscripcion->participante->dni }}</p>
                <p class="text-slate-600"><strong>Correo:</strong> {{ $inscripcion->participante->email }}</p>
                <p class="text-slate-600"><strong>Teléfono:</strong> {{ $inscripcion->participante->telefono ?? 'No registrado' }}</p>
            </div>
            <div>
                <h4 class="font-black text-slate-400 uppercase tracking-widest text-[10px] mb-2">Datos del Paralelo y Horario</h4>
                <p class="text-base font-black text-slate-900">{{ $inscripcion->paralelo->curso->titulo }}</p>
                <p class="text-slate-600 mt-1"><strong>Paralelo:</strong> <span class="font-bold text-teal-700">{{ $inscripcion->paralelo->nombre }}</span> &bull; <strong>Aula:</strong> {{ $inscripcion->paralelo->aula }}</p>
                <p class="text-slate-600"><strong>Horario:</strong> {{ $inscripcion->paralelo->dias }} ({{ substr($inscripcion->paralelo->hora_inicio, 0, 5) }} - {{ substr($inscripcion->paralelo->hora_fin, 0, 5) }})</p>
                <p class="text-slate-600"><strong>Docente:</strong> {{ $inscripcion->paralelo->instructor->nombre }}</p>
            </div>
        </div>

        <!-- Detalle de Liquidación / Pago -->
        <div>
            <table class="w-full text-left text-xs border border-slate-200 rounded-2xl overflow-hidden">
                <thead class="bg-slate-100 text-slate-700 font-black uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="p-3.5">Curso y Especialidad</th>
                        <th class="p-3.5">Periodo Lectivo</th>
                        <th class="p-3.5 text-center">Estado</th>
                        <th class="p-3.5 text-right">Monto Liquidado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <tr>
                        <td class="p-3.5">
                            <span class="font-black text-slate-900 text-sm">{{ $inscripcion->paralelo->curso->titulo }}</span>
                            <span class="block text-slate-500 font-medium">{{ $inscripcion->paralelo->curso->categoria->nombre }} &bull; Carga: {{ $inscripcion->paralelo->curso->duracion_horas }} horas académicas</span>
                        </td>
                        <td class="p-3.5 text-slate-600 font-semibold">
                            {{ $inscripcion->paralelo->fecha_inicio->format('d/m/Y') }} al {{ $inscripcion->paralelo->fecha_fin->format('d/m/Y') }}
                        </td>
                        <td class="p-3.5 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-black border {{ $inscripcion->badge_estado }}">
                                {{ ucfirst($inscripcion->estado) }}
                            </span>
                        </td>
                        <td class="p-3.5 text-right font-black text-sm text-slate-900">
                            ${{ number_format($inscripcion->monto_pagado, 2) }}
                        </td>
                    </tr>
                </tbody>
                <tfoot class="bg-slate-50 font-black">
                    <tr>
                        <td colspan="3" class="p-4 text-right text-slate-700 uppercase tracking-wider">Total Liquidado:</td>
                        <td class="p-4 text-right text-lg text-teal-800 font-black">${{ number_format($inscripcion->monto_pagado, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Pie y Firma -->
        <div class="pt-8 border-t border-slate-200 flex items-center justify-between text-xs text-slate-400">
            <p class="font-medium">Documento generado automáticamente por EduCapacita Academic Pro.</p>
            <div class="text-center">
                <div class="w-40 border-b border-slate-300 pb-1"></div>
                <p class="font-bold text-slate-700 text-[11px] mt-1">Firma / Sello Académico</p>
            </div>
        </div>
    </div>
</div>
@endsection
