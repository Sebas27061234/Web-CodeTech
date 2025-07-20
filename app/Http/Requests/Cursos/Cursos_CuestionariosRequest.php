<?php

namespace App\Http\Requests\Cursos;

use Illuminate\Foundation\Http\FormRequest;

class Cursos_CuestionariosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'puntaje_aprobacion' => 'required|integer|min:0',
            'es_final' => 'required|boolean',
            'idLeccion' => 'required|exists:cursos_lecciones,idLeccion',
            'estado' => 'boolean'
        ];
    }
}
