<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParticipanteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $participanteId = $this->route('participante')?->id ?? $this->route('participante');

        return [
            'dni' => [
                'required',
                'string',
                'max:30',
                Rule::unique('participantes', 'dni')->ignore($participanteId),
            ],
            'nombre' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('participantes', 'email')->ignore($participanteId),
            ],
            'telefono' => 'nullable|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'dni.required' => 'El número de identificación (DNI / CI) es obligatorio.',
            'dni.unique' => 'Ya existe un participante registrado con este DNI / CI.',
            'nombre.required' => 'El nombre completo es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo electrónico válido.',
            'email.unique' => 'Este correo ya pertenece a otro participante.',
        ];
    }
}
