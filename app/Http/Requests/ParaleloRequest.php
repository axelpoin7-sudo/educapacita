<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParaleloRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $paraleloId = $this->route('paralelo')?->id ?? $this->route('paralelo');

        return [
            'curso_id' => 'required|exists:cursos,id',
            'instructor_id' => 'required|exists:instructores,id',
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('paralelos', 'nombre')
                    ->where('curso_id', $this->curso_id)
                    ->ignore($paraleloId),
            ],
            'aula' => 'required|string|max:255',
            'dias' => 'required|string|max:255',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'cupo_maximo' => 'required|integer|min:1|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'curso_id.required' => 'Debe seleccionar un curso.',
            'instructor_id.required' => 'Debe asignar un instructor.',
            'nombre.required' => 'El nombre del paralelo es obligatorio.',
            'nombre.unique' => 'Ya existe un paralelo con este nombre para el curso seleccionado.',
            'aula.required' => 'El aula o laboratorio es obligatorio.',
            'dias.required' => 'Debe indicar los días de clases.',
            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_fin.required' => 'La hora de fin es obligatoria.',
            'hora_fin.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_fin.required' => 'La fecha de fin es obligatoria.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio.',
            'cupo_maximo.required' => 'El cupo máximo es obligatorio.',
            'cupo_maximo.min' => 'El cupo debe ser de al menos 1 participante.',
        ];
    }
}
