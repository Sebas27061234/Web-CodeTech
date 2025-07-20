<?php

namespace App\Http\Requests\Cursos;

use Illuminate\Foundation\Http\FormRequest;

class Cursos_AutoresRequest extends FormRequest
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
            'nombre' => 'required|string|max:250',
            'descripcion' => 'nullable|string|max:500',
            'imagen' => 'nullable',
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
