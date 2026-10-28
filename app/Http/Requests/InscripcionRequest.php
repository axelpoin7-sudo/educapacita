<?php

namespace App\Http\Requests;

use App\Models\Inscripcion;
use App\Models\Paralelo;
use App\Models\Participante;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class InscripcionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'curso_id' => 'nullable|exists:cursos,id',
            'participante_id' => 'required|exists:participantes,id',
            'paralelo_id' => 'required|exists:paralelos,id',
            'fecha_inscripcion' => 'required|date',
            'monto_pagado' => 'required|numeric|min:0',
            'estado' => 'required|in:pendiente,pagada,anulada',
        ];
    }

    public function messages(): array
    {
        return [
            'curso_id.exists' => 'El curso seleccionado no es válido.',
            'participante_id.required' => 'Debe seleccionar un participante.',
            'participante_id.exists' => 'El participante seleccionado no existe.',
            'paralelo_id.required' => 'Debe seleccionar un paralelo y horario.',
            'paralelo_id.exists' => 'El paralelo seleccionado no existe.',
            'fecha_inscripcion.required' => 'La fecha de inscripción es obligatoria.',
            'fecha_inscripcion.date' => 'La fecha de inscripción debe ser una fecha válida.',
            'monto_pagado.required' => 'El monto pagado es obligatorio.',
            'monto_pagado.numeric' => 'El monto debe ser un valor numérico.',
            'estado.required' => 'El estado de la inscripción es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',
        ];
    }

    /**
     * Validaciones personalizadas de reglas de negocio:
     * 1. Correspondencia de Curso y Paralelo/Horario.
     * 2. Rango de Fechas válido (no después de fecha_fin, no antes de fecha_inicio).
     * 3. No duplicar participante en el mismo curso (ni en el mismo ni en otro paralelo).
     * 4. Cupo máximo disponible en el paralelo.
     * 5. Prevención de horario cruzado o solapado con otros cursos del participante.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            if ($this->estado === 'anulada') {
                return; // Una inscripción anulada no ocupa cupo ni genera cruces
            }

            $participanteId = $this->input('participante_id');
            $paraleloId = $this->input('paralelo_id');

            if (! $participanteId || ! $paraleloId) {
                return;
            }

            $inscripcionActual = $this->route('inscripcione') ?? $this->route('inscripcion');
            $inscripcionActualId = $inscripcionActual instanceof Inscripcion ? $inscripcionActual->id : (int) $inscripcionActual;

            $paralelo = Paralelo::with(['curso'])->find($paraleloId);
            $participante = Participante::find($participanteId);

            if (! $paralelo || ! $participante) {
                return;
            }

            // 1. Validar correspondencia: si se envió curso_id, el paralelo debe pertenecer a ese curso
            if ($this->filled('curso_id') && (int) $this->input('curso_id') !== (int) $paralelo->curso_id) {
                $validator->errors()->add('paralelo_id', 'Inscripción rechazada: El paralelo y horario seleccionado no corresponde al curso elegido.');

                return;
            }

            // 2. Validar rango de fechas de inscripción con respecto al curso/paralelo
            if ($this->filled('fecha_inscripcion')) {
                $fechaInscripcion = Carbon::parse($this->input('fecha_inscripcion'))->startOfDay();
                $fechaInicio = Carbon::parse($paralelo->fecha_inicio)->startOfDay();
                $fechaFin = Carbon::parse($paralelo->fecha_fin)->endOfDay();

                if ($fechaInscripcion->gt($fechaFin)) {
                    $validator->errors()->add('fecha_inscripcion', "Inscripción rechazada: La fecha de inscripción ({$fechaInscripcion->format('d/m/Y')}) es posterior a la fecha de finalización del curso ({$paralelo->fecha_fin->format('d/m/Y')}). No es posible inscribirse una vez culminado el curso.");
                }

                if ($fechaInscripcion->lt($fechaInicio)) {
                    $validator->errors()->add('fecha_inscripcion', "Inscripción rechazada: La fecha de inscripción ({$fechaInscripcion->format('d/m/Y')}) es anterior a la fecha de inicio del curso ({$paralelo->fecha_inicio->format('d/m/Y')}).");
                }
            }

            // 3. Validar que el participante NO esté ya inscrito en el mismo curso (en ningún paralelo activo)
            $yaInscritoEnCurso = Inscripcion::where('participante_id', $participanteId)
                ->where('estado', '!=', 'anulada')
                ->whereHas('paralelo', function ($query) use ($paralelo) {
                    $query->where('curso_id', $paralelo->curso_id);
                })
                ->when($inscripcionActualId, function ($query, $id) {
                    $query->where('id', '!=', $id);
                })
                ->with('paralelo')
                ->first();

            if ($yaInscritoEnCurso) {
                $validator->errors()->add('participante_id', "Inscripción rechazada: El participante '{$participante->nombre}' ya se encuentra inscrito en este curso ('{$paralelo->curso->titulo}') en el paralelo '{$yaInscritoEnCurso->paralelo->nombre}'. No se permiten participantes duplicados en el mismo curso.");

                return;
            }

            // 4. Rechazar inscripción si el paralelo está lleno (Cupo Máximo)
            $cuposOcupados = Inscripcion::where('paralelo_id', $paraleloId)
                ->where('estado', '!=', 'anulada')
                ->when($inscripcionActualId, function ($query, $id) {
                    $query->where('id', '!=', $id);
                })
                ->count();

            if ($cuposOcupados >= $paralelo->cupo_maximo) {
                $validator->errors()->add('paralelo_id', "Inscripción rechazada: El paralelo '{$paralelo->nombre}' del curso '{$paralelo->curso->titulo}' ha alcanzado su cupo máximo ({$paralelo->cupo_maximo} cupos).");
            }

            // 5. Rechazar inscripción si hay horario cruzado (mismo horario o solapamiento con otro curso activo)
            $conflicto = $participante->buscarParaleloEnConflicto($paralelo, $inscripcionActualId);
            if ($conflicto) {
                $horaInicio = substr($conflicto->hora_inicio, 0, 5);
                $horaFin = substr($conflicto->hora_fin, 0, 5);
                $validator->errors()->add('paralelo_id', "Inscripción rechazada: Conflicto de horario cruzado. El participante ya está inscrito en el paralelo '{$conflicto->nombre}' ({$conflicto->curso->titulo}) con horario: {$conflicto->dias} de {$horaInicio} a {$horaFin}.");
            }
        });
    }
}
