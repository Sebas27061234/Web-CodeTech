<?php

namespace App\Http\Requests\Tienda;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Tienda_ProductosRequest extends FormRequest
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
            'sku' => 'required|max:255',
            'titulo' => 'required|max:512',
            'descripcion' => 'required',
            'contenido' => 'required',
            'fecha_publicacion' => 'required|date_format:d/m/Y',
            'precio' => 'required|decimal:2',
            'imagen' => 'nullable',
            'galeria_imagenes' => 'nullable',
            'galeria_imagenes.*' => 'mimes:png,jpg,jpeg',
            'descripcion_imagenes' => [
                'nullable','array',
                function ($attribute, $value, $fail) {
                    $galeria = $this->input('galeria_imagenes');
                    $imagen = $this->input('imagen');

                    // Si imagen y galeria_imagenes tienen valor, la longitud de descripcion_imagenes debe ser igual a galeria_imagenes + 1
                    if (!empty($imagen) && !empty($galeria) && count($value) !== count($galeria) + 1) {
                        $fail('El campo descripcion_imagenes debe tener exactamente ' . (count($galeria) + 1) . ' elementos.');
                    }

                    // Si solo imagen tiene valor y galeria_imagenes es nulo, la longitud de descripcion_imagenes debe ser 1
                    if (!empty($imagen) && empty($galeria) && count($value) !== 1) {
                        $fail('El campo descripcion_imagenes debe contener exactamente 1 elemento cuando no hay galeria de imagenes.');
                    }
                }
            ],
            'demo' => 'required|url',
            'archivo' => 'nullable',
            'idCategoria' => 'required|array|exists:tienda_categorias,idCategoria',
            'estado' => 'boolean',
        ];
    }

    public function withValidator($validator){
        $validator->after(function ($validator) {
            $this->validatePoster($validator);
            $this->validateArchivo($validator);
            $this->validateGaleria($validator);
        });
    }

    protected function validatePoster($validator){
        $validator->sometimes('imagen', 'mimes:png,jpg,jpeg',function($input){
            return $input->imagen !== null;
        });
    }

    protected function validateGaleria($validator){
        $validator->sometimes('galeria_imagenes', 'array',function($input){
            return $input->galeria_imagenes !== null;
        });
    }

    protected function validateArchivo($validator){
        $validator->sometimes('archivo', 'mimes:zip',function($input){
            return $input->imagen !== null;
        });
    }

    protected function prepareForValidation()
    {
        // Convertir el campo descripcion_imagenes de texto a array
        if ($this->has('descripcion_imagenes') && is_string($this->descripcion_imagenes)) {
            $this->merge([
                'descripcion_imagenes' => explode(';', $this->descripcion_imagenes),
            ]);
        }
    }
}
