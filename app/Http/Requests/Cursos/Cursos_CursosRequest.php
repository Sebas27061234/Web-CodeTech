<?php

namespace App\Http\Requests\Cursos;

use Illuminate\Foundation\Http\FormRequest;

class Cursos_CursosRequest extends FormRequest
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
            'slug' => 'required|max:255',
            'titulo' => 'required|string|max:250',
            'descripcion' => 'required',
            'contenido' => 'required',
            'duracion' => 'nullable|integer',
            'cantidad_clases' => 'nullable|integer',
            'cantidad_recursos' => 'nullable|integer',
            'precio' => 'required|decimal:2',
            'imagen' => 'nullable',
            'fecha_publicacion' => 'required|date_format:d/m/Y',
            'idCategoria' => 'required|exists:cursos_categorias,idCategoria',
            'idAutor' => 'required|exists:cursos_autores,idAutor',
            'estado' => 'boolean'
        ];
    }

    public function withValidator($validator){
        $validator->after(function ($validator) {
            $this->validateImage($validator);
        });
    }

    protected function validateImage($validator){
        $validator->sometimes('imagen', 'mimes:png,jpg,jpeg',function($input){
            return $input->imagen !== null;
        });
    }
}
