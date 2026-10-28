<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $cursoId = $this->route('curso')?->id ?? $this->route('curso');

        return [
            'categoria_id' => 'required|exists:categorias,id',
            'titulo' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cursos', 'titulo')->ignore($cursoId),
            ],
            'descripcion' => 'nullable|string|max:5000',
            'precio' => 'required|numeric|min:0',
            'duracion_horas' => 'required|integer|min:1|max:1000',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'categoria_id.required' => 'Debe seleccionar una categoría.',
            'categoria_id.exists' => 'La categoría seleccionada no existe.',
            'titulo.required' => 'El título del curso es obligatorio.',
            'titulo.unique' => 'Ya existe un curso registrado con este título.',
            'precio.required' => 'El precio del curso es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número válido.',
            'precio.min' => 'El precio no puede ser negativo.',
            'duracion_horas.required' => 'La duración en horas es obligatoria.',
            'imagen.image' => 'El archivo debe ser una imagen válida (jpeg, png, jpg, webp, svg).',
            'imagen.max' => 'La imagen no debe superar los 2MB de tamaño.',
        ];
    }
}
