<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InstructorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $instructorId = $this->route('instructor')?->id ?? $this->route('instructor');

        return [
            'nombre' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('instructores', 'email')->ignore($instructorId),
            ],
            'telefono' => 'nullable|string|max:50',
            'especialidad' => 'required|string|max:255',
            'biografia' => 'nullable|string|max:2000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del instructor es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo electrónico válido.',
            'email.unique' => 'Este correo ya pertenece a otro instructor.',
            'especialidad.required' => 'La especialidad del instructor es obligatoria.',
            'foto.image' => 'El archivo adjunto debe ser una imagen válida.',
            'foto.max' => 'La fotografía no debe pesar más de 2MB.',
        ];
    }
}
