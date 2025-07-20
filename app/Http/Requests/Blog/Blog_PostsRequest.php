<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class Blog_PostsRequest extends FormRequest
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
            'titulo' => 'required|max:100',
            'imagen' => 'nullable',
            'descripcion' => 'required',
            'contenido' => 'required',
            'fecha_publicacion' => 'required|date_format:d/m/Y',
            'idVideo' => 'required|exists:blog_videos,idVideo',
            'idAutor' => 'required|exists:blog_autores,idAutor',
            'idCategoria' => 'required|array|exists:blog_categorias,idCategoria',
            'estado' => 'boolean',
        ];
    }

    public function withValidator($validator){
        $validator->after(function ($validator) {
            $this->validatePoster($validator);
        });
    }

    protected function validatePoster($validator){
        $validator->sometimes('imagen', 'mimes:png,jpg,jpeg',function($input){
            return $input->imagen !== null;
        });
    }
}
