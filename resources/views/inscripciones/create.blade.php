@extends('layouts.app')

@section('titulo', 'Nueva Matrícula')

@section('contenido')
<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Encabezado con Botón Volver -->
    <div class="flex items-center justify-between pb-2 border-b border-slate-200">
        <div>
            <span class="text-xs font-bold text-teal-600 uppercase tracking-widest">Admisión y Registro</span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Nueva Matrícula Académica</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Registre la inscripción del participante con validación automática de cupo, horario y fechas.</p>
        </div>
        <a href="{{ route('inscripciones.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition shadow-xs">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Volver a Matrículas
        </a>
    </div>

    <!-- Banner de Reglas Académicas Activas en Tiempo Real -->
    <div class="rounded-2xl bg-gradient-to-r from-teal-500/10 via-emerald-500/5 to-cyan-500/10 border border-teal-200/80 p-5 shadow-xs">
        <div class="flex items-center space-x-2 text-teal-900 font-black text-xs uppercase tracking-wider mb-3">
            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            <span>Validaciones y Reglas Académicas Automáticas</span>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs">
            <div class="p-3 rounded-xl bg-white/90 border border-teal-100 flex items-start space-x-2.5">
                <div class="w-6 h-6 rounded-lg bg-teal-500/20 text-teal-700 font-bold flex items-center justify-center flex-shrink-0 mt-0.5">1</div>
                <div>
                    <strong class="font-bold text-slate-900 block">Rango de Fechas:</strong>
                    <span class="text-slate-600 text-[11px]">No se permite inscribir antes del inicio ni después de que finalice el curso.</span>
                </div>
            </div>

            <div class="p-3 rounded-xl bg-white/90 border border-teal-100 flex items-start space-x-2.5">
                <div class="w-6 h-6 rounded-lg bg-teal-500/20 text-teal-700 font-bold flex items-center justify-center flex-shrink-0 mt-0.5">2</div>
                <div>
                    <strong class="font-bold text-slate-900 block">Sin Alumnos Duplicados:</strong>
                    <span class="text-slate-600 text-[11px]">El alumno no puede inscribirse dos veces al mismo curso.</span>
                </div>
            </div>

            <div class="p-3 rounded-xl bg-white/90 border border-teal-100 flex items-start space-x-2.5">
                <div class="w-6 h-6 rounded-lg bg-teal-500/20 text-teal-700 font-bold flex items-center justify-center flex-shrink-0 mt-0.5">3</div>
                <div>
                    <strong class="font-bold text-slate-900 block">Sin Cruce de Horarios:</strong>
                    <span class="text-slate-600 text-[11px]">Comprobación en vivo contra otros cursos activos del participante.</span>
                </div>
            </div>

            <div class="p-3 rounded-xl bg-white/90 border border-teal-100 flex items-start space-x-2.5">
                <div class="w-6 h-6 rounded-lg bg-teal-500/20 text-teal-700 font-bold flex items-center justify-center flex-shrink-0 mt-0.5">4</div>
                <div>
                    <strong class="font-bold text-slate-900 block">Control de Aforo:</strong>
                    <span class="text-slate-600 text-[11px]">Rechazo automático si el paralelo supera el cupo máximo autorizado.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de Matrícula -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-8">
        <form action="{{ route('inscripciones.store') }}" method="POST" id="form-inscripcion" class="space-y-6">
            @csrf

            <!-- 1. Selección de Participante -->
            <div class="p-5 rounded-2xl bg-slate-50/70 border border-slate-200/80 space-y-2">
                <div class="flex items-center justify-between">
                    <label for="participante_id" class="block text-xs font-black text-slate-800 uppercase tracking-wider flex items-center">
                        <span class="w-5 h-5 rounded-full bg-slate-900 text-white flex items-center justify-center text-[10px] font-bold mr-2">1</span>
                        Participante / Estudiante *
                    </label>
                    <a href="{{ route('participantes.create') }}" target="_blank" class="text-xs font-bold text-teal-600 hover:text-teal-800 flex items-center">
                        + Registrar Nuevo Alumno
                    </a>
                </div>
                <select name="participante_id" id="participante_id" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:outline-none font-medium">
                    <option value="">-- Seleccione al alumno que se matriculará --</option>
                    @foreach($participantes as $part)
                        <option value="{{ $part->id }}" {{ (old('participante_id', request('participante_id')) == $part->id) ? 'selected' : '' }}>
                            {{ $part->nombre }} &bull; C.I. / DNI: {{ $part->dni }} &bull; Correo: {{ $part->email }}
                        </option>
                    @endforeach
                </select>
                @error('participante_id')
                    <p class="text-xs font-semibold text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 2. Selección de Curso y Paralelo Correspondiente -->
            <div class="p-5 rounded-2xl bg-slate-50/70 border border-slate-200/80 space-y-4">
                <label class="block text-xs font-black text-slate-800 uppercase tracking-wider flex items-center">
                    <span class="w-5 h-5 rounded-full bg-slate-900 text-white flex items-center justify-center text-[10px] font-bold mr-2">2</span>
                    Selección de Curso y Horario Académico *
                </label>

                <!-- Selector de Curso -->
                <div>
                    <label for="curso_id" class="block text-xs font-bold text-slate-600 uppercase mb-1">Paso A: Seleccionar Curso de Capacitación</label>
                    <select name="curso_id" id="curso_id" onchange="alCambiarCurso()" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:outline-none font-bold text-slate-900">
                        <option value="">-- Primero elija el curso al que desea inscribir --</option>
                        @foreach($cursos as $c)
                            <option value="{{ $c->id }}"
                                    data-precio="{{ $c->precio }}"
                                    data-horas="{{ $c->duracion_horas }}"
                                    data-categoria="{{ $c->categoria->nombre ?? 'General' }}"
                                    {{ old('curso_id', request('curso_id')) == $c->id ? 'selected' : '' }}>
                                {{ $c->titulo }} &bull; [{{ $c->categoria->nombre ?? 'General' }}] &bull; ${{ number_format($c->precio, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Selector de Paralelo y Horario (Filtrado por curso) -->
                <div>
                    <label for="paralelo_id" class="block text-xs font-bold text-slate-600 uppercase mb-1">Paso B: Seleccionar Paralelo y Horario Correspondiente</label>
                    <select name="paralelo_id" id="paralelo_id" onchange="alCambiarParalelo()" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:outline-none font-semibold text-slate-900">
                        <option value="">-- Seleccione un paralelo disponible --</option>
                        @foreach($paralelos as $p)
                            @php
                                $estaLleno = $p->estaLleno();
                                $cuposLibres = $p->cupos_disponibles;
                                $fechaIniFmt = $p->fecha_inicio ? \Carbon\Carbon::parse($p->fecha_inicio)->format('d/m/Y') : '';
                                $fechaFinFmt = $p->fecha_fin ? \Carbon\Carbon::parse($p->fecha_fin)->format('d/m/Y') : '';
                                $fechaIniRaw = $p->fecha_inicio ? \Carbon\Carbon::parse($p->fecha_inicio)->format('Y-m-d') : '';
                                $fechaFinRaw = $p->fecha_fin ? \Carbon\Carbon::parse($p->fecha_fin)->format('Y-m-d') : '';
                            @endphp
                            <option value="{{ $p->id }}"
                                    data-curso-id="{{ $p->curso_id }}"
                                    data-precio="{{ $p->curso->precio }}"
                                    data-nombre="{{ $p->nombre }}"
                                    data-aula="{{ $p->aula }}"
                                    data-dias="{{ $p->dias }}"
                                    data-hora-inicio="{{ substr($p->hora_inicio, 0, 5) }}"
                                    data-hora-fin="{{ substr($p->hora_fin, 0, 5) }}"
                                    data-fecha-inicio="{{ $fechaIniRaw }}"
                                    data-fecha-fin="{{ $fechaFinRaw }}"
                                    data-fecha-inicio-fmt="{{ $fechaIniFmt }}"
                                    data-fecha-fin-fmt="{{ $fechaFinFmt }}"
                                    data-cupos-libres="{{ $cuposLibres }}"
                                    data-cupo-maximo="{{ $p->cupo_maximo }}"
                                    data-lleno="{{ $estaLleno ? '1' : '0' }}"
                                    {{ (old('paralelo_id', $paraleloSeleccionadoId ?? request('paralelo_id')) == $p->id) ? 'selected' : '' }}
                                    {{ $estaLleno ? 'class=text-rose-600 bg-rose-50' : '' }}>
                                {{ $p->curso->titulo }} &bull; {{ $p->nombre }} ({{ $p->aula }}) &bull; [{{ $p->dias }} {{ substr($p->hora_inicio, 0, 5) }}-{{ substr($p->hora_fin, 0, 5) }}] &bull; Del {{ $fechaIniFmt }} al {{ $fechaFinFmt }} — {{ $estaLleno ? '¡CUPO LLENO!' : $cuposLibres . ' cupos libres' }}
                            </option>
                        @endforeach
                    </select>
                    @error('paralelo_id')
                        <p class="text-xs font-semibold text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tarjeta Dinámica de Resumen del Paralelo Seleccionado -->
                <div id="paralelo-info-card" class="hidden p-4 rounded-xl bg-white border border-teal-200/90 shadow-xs space-y-2 text-xs">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <div class="flex items-center space-x-2">
                            <span id="badge-paralelo-nombre" class="px-2 py-0.5 rounded-md bg-teal-500 text-slate-950 font-black">Paralelo</span>
                            <span id="info-aula" class="text-slate-600 font-bold">Aula</span>
                        </div>
                        <span id="badge-cupo-estado" class="px-2 py-0.5 rounded-full text-[11px] font-bold">Cupos</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-slate-700">
                        <p><strong>Horario de Clases:</strong> <span id="info-horario" class="font-semibold text-slate-900">-</span></p>
                        <p><strong>Vigencia del Curso:</strong> <span id="info-fechas" class="font-semibold text-slate-900">-</span></p>
                    </div>
                    <div id="alerta-fechas-paralelo" class="hidden p-2.5 rounded-lg bg-amber-50 border border-amber-200 text-amber-900 font-semibold text-[11px]">
                    </div>
                </div>
            </div>

            <!-- 3. Fechas, Cobro y Estado -->
            <div class="p-5 rounded-2xl bg-slate-50/70 border border-slate-200/80 space-y-4">
                <label class="block text-xs font-black text-slate-800 uppercase tracking-wider flex items-center">
                    <span class="w-5 h-5 rounded-full bg-slate-900 text-white flex items-center justify-center text-[10px] font-bold mr-2">3</span>
                    Detalles del Cobro y Fecha de Registro
                </label>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Fecha de Inscripción con Validación de Rango -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="fecha_inscripcion" class="block text-xs font-bold text-slate-700 uppercase">Fecha de Inscripción *</label>
                        </div>
                        <input type="date" name="fecha_inscripcion" id="fecha_inscripcion" 
                               value="{{ old('fecha_inscripcion', date('Y-m-d')) }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none font-medium">
                        <p id="help-fecha-inscripcion" class="text-[11px] text-slate-500 mt-1">Debe estar comprendida en la duración del curso.</p>
                        @error('fecha_inscripcion')
                            <p class="text-xs font-semibold text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Monto a Cobrar -->
                    <div>
                        <label for="monto_pagado" class="block text-xs font-bold text-slate-700 uppercase mb-1">Monto de Matrícula ($) *</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 font-bold">$</span>
                            <input type="number" step="0.01" name="monto_pagado" id="monto_pagado" 
                                   value="{{ old('monto_pagado', '150.00') }}" required
                                   class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none font-black text-slate-900">
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1">Costo según el catálogo del curso.</p>
                        @error('monto_pagado')
                            <p class="text-xs font-semibold text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estado del Pago -->
                    <div>
                        <label for="estado" class="block text-xs font-bold text-slate-700 uppercase mb-1">Estado de la Matrícula *</label>
                        <select name="estado" id="estado" required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none font-bold text-slate-900">
                            <option value="pagada" {{ old('estado', 'pagada') === 'pagada' ? 'selected' : '' }}>Pagada (Matriculado)</option>
                            <option value="pendiente" {{ old('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente (Por Pagar)</option>
                            <option value="anulada" {{ old('estado') === 'anulada' ? 'selected' : '' }}>Anulada</option>
                        </select>
                        <p class="text-[11px] text-slate-500 mt-1">Estado actual del pago.</p>
                        @error('estado')
                            <p class="text-xs font-semibold text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="pt-4 flex items-center justify-end space-x-3 border-t border-slate-200">
                <a href="{{ route('inscripciones.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-sm font-bold text-slate-700 hover:bg-slate-50 transition">
                    Cancelar
                </a>
                <button type="submit" id="btn-submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-teal-500 via-emerald-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-slate-950 font-black text-sm uppercase tracking-wider shadow-lg shadow-teal-500/25 transition-all hover:scale-102">
                    Procesar Matrícula
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Almacén de opciones de paralelos para filtrado dinámico
    const todosLosParalelos = [];
    document.addEventListener('DOMContentLoaded', function () {
        const selectParalelo = document.getElementById('paralelo_id');
        for (let i = 0; i < selectParalelo.options.length; i++) {
            const opt = selectParalelo.options[i];
            if (opt.value) {
                todosLosParalelos.push({
                    value: opt.value,
                    cursoId: opt.dataset.cursoId,
                    precio: opt.dataset.precio,
                    nombre: opt.dataset.nombre,
                    aula: opt.dataset.aula,
                    dias: opt.dataset.dias,
                    horaInicio: opt.dataset.horaInicio,
                    horaFin: opt.dataset.horaFin,
                    fechaInicio: opt.dataset.fechaInicio,
                    fechaFin: opt.dataset.fechaFin,
                    fechaInicioFmt: opt.dataset.fechaInicioFmt,
                    fechaFinFmt: opt.dataset.fechaFinFmt,
                    cuposLibres: parseInt(opt.dataset.cuposLibres || '0'),
                    cupoMaximo: parseInt(opt.dataset.cupoMaximo || '0'),
                    estaLleno: opt.dataset.lleno === '1',
                    text: opt.text,
                    selected: opt.selected
                });
            }
        }

        // Si ya hay un paralelo seleccionado de inicio, preseleccionar su curso
        const paraleloInicialId = "{{ old('paralelo_id', $paraleloSeleccionadoId ?? request('paralelo_id')) }}";
        if (paraleloInicialId) {
            const item = todosLosParalelos.find(p => p.value == paraleloInicialId);
            if (item) {
                document.getElementById('curso_id').value = item.cursoId;
            }
        }

        // Ejecutar filtro inicial
        alCambiarCurso(true);
    });

    function alCambiarCurso(esCargaInicial = false) {
        const selectCurso = document.getElementById('curso_id');
        const cursoId = selectCurso.value;
        const selectParalelo = document.getElementById('paralelo_id');
        const valorActual = selectParalelo.value;

        // Limpiar opciones
        selectParalelo.innerHTML = '<option value="">-- Seleccione un paralelo disponible para este curso --</option>';

        if (!cursoId) {
            // Mostrar todos si no hay curso seleccionado
            todosLosParalelos.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.value;
                opt.text = p.text;
                Object.assign(opt.dataset, p);
                if (p.value == valorActual) opt.selected = true;
                if (p.estaLleno) {
                    opt.classList.add('text-rose-600', 'bg-rose-50');
                }
                selectParalelo.appendChild(opt);
            });
            document.getElementById('paralelo-info-card').classList.add('hidden');
            return;
        }

        // Filtrar paralelos pertenecientes al curso
        const filtrados = todosLosParalelos.filter(p => p.cursoId == cursoId);

        if (filtrados.length === 0) {
            const optVacio = document.createElement('option');
            optVacio.value = "";
            optVacio.text = "⚠️ No hay paralelos abiertos para este curso";
            selectParalelo.appendChild(optVacio);
        } else {
            filtrados.forEach((p, idx) => {
                const opt = document.createElement('option');
                opt.value = p.value;
                opt.text = `${p.nombre} (${p.aula}) • ${p.dias} [${p.horaInicio} - ${p.horaFin}] • Fechas: ${p.fechaInicioFmt} al ${p.fechaFinFmt} — ${p.estaLleno ? '¡CUPO LLENO!' : p.cuposLibres + ' cupos libres'}`;
                Object.assign(opt.dataset, p);
                if (p.value == valorActual || (!esCargaInicial && idx === 0)) {
                    opt.selected = true;
                }
                if (p.estaLleno) {
                    opt.classList.add('text-rose-600', 'bg-rose-50');
                }
                selectParalelo.appendChild(opt);
            });
        }

        // Actualizar precio automáticamente del curso
        const optCurso = selectCurso.options[selectCurso.selectedIndex];
        if (optCurso && optCurso.dataset.precio) {
            document.getElementById('monto_pagado').value = parseFloat(optCurso.dataset.precio).toFixed(2);
        }

        alCambiarParalelo();
    }

    function alCambiarParalelo() {
        const selectParalelo = document.getElementById('paralelo_id');
        const card = document.getElementById('paralelo-info-card');
        const inputFecha = document.getElementById('fecha_inscripcion');
        const helpFecha = document.getElementById('help-fecha-inscripcion');
        const alertaFechas = document.getElementById('alerta-fechas-paralelo');
        const btnSubmit = document.getElementById('btn-submit');

        const opt = selectParalelo.options[selectParalelo.selectedIndex];
        if (!opt || !opt.value) {
            card.classList.add('hidden');
            inputFecha.removeAttribute('min');
            inputFecha.removeAttribute('max');
            return;
        }

        card.classList.remove('hidden');

        // Mostrar datos en tarjeta
        document.getElementById('badge-paralelo-nombre').textContent = opt.dataset.nombre || 'Paralelo';
        document.getElementById('info-aula').textContent = 'Aula: ' + (opt.dataset.aula || '-');
        document.getElementById('info-horario').textContent = `${opt.dataset.dias || ''} de ${opt.dataset.horaInicio || ''} a ${opt.dataset.horaFin || ''}`;
        document.getElementById('info-fechas').textContent = `${opt.dataset.fechaInicioFmt} hasta ${opt.dataset.fechaFinFmt}`;

        const estaLleno = opt.dataset.estaLleno === 'true' || opt.dataset.lleno === '1';
        const badgeCupo = document.getElementById('badge-cupo-estado');
        if (estaLleno) {
            badgeCupo.textContent = '¡Aforo Completo (0 Libres)!';
            badgeCupo.className = 'px-2 py-0.5 rounded-full text-[11px] font-extrabold bg-rose-100 text-rose-800 border border-rose-300';
        } else {
            badgeCupo.textContent = `${opt.dataset.cuposLibres} de ${opt.dataset.cupoMaximo} cupos disponibles`;
            badgeCupo.className = 'px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300';
        }

        // Sincronizar precio
        if (opt.dataset.precio) {
            document.getElementById('monto_pagado').value = parseFloat(opt.dataset.precio).toFixed(2);
        }

        // Restringir fecha_inscripcion dentro del rango del paralelo
        if (opt.dataset.fechaInicio && opt.dataset.fechaFin) {
            inputFecha.setAttribute('min', opt.dataset.fechaInicio);
            inputFecha.setAttribute('max', opt.dataset.fechaFin);
            helpFecha.innerHTML = `Válido estrictamente entre <strong>${opt.dataset.fechaInicioFmt}</strong> y <strong>${opt.dataset.fechaFinFmt}</strong>.`;

            // Validación en tiempo real sobre la fecha ingresada
            const fechaValor = inputFecha.value;
            if (fechaValor) {
                if (fechaValor < opt.dataset.fechaInicio) {
                    alertaFechas.classList.remove('hidden');
                    alertaFechas.innerHTML = `⚠️ <strong>Fecha fuera de rango:</strong> La fecha seleccionada (${fechaValor}) es anterior al inicio del curso (${opt.dataset.fechaInicioFmt}). Por favor corrija la fecha antes de enviar.`;
                } else if (fechaValor > opt.dataset.fechaFin) {
                    alertaFechas.classList.remove('hidden');
                    alertaFechas.innerHTML = `⚠️ <strong>Curso Concluido:</strong> La fecha seleccionada (${fechaValor}) es posterior a la finalización del curso (${opt.dataset.fechaFinFmt}). No se permiten inscripciones fuera de término.`;
                } else {
                    alertaFechas.classList.add('hidden');
                }
            }
        }
    }

    document.getElementById('fecha_inscripcion').addEventListener('change', alCambiarParalelo);
</script>
@endsection
