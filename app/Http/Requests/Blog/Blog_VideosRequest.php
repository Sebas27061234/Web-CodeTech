<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class Blog_VideosRequest extends FormRequest
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
            'titulo' => 'required|string|max:250',
            'video' => 'nullable',
            'poster' => 'nullable',
            'subtitulos' => 'nullable',
            'subtitulos.*' => 'mimes:vtt,text/vtt,txt',
            'idListaVideo' => 'nullable',
            'estado' => 'boolean'
        ];
    }

    public function withValidator($validator){
        $validator->after(function ($validator) {
            $this->validateListaIfExists($validator);
            $this->validateVideo($validator);
            $this->validatePoster($validator);
            $this->validateSubtitulos($validator);
        });
    }

    protected function validateListaIfExists($validator){
        $validator->sometimes('idListaVideo', 'exists:blog_lista_videos,idListaVideo',function($input){
            return $input->idListaVideo !== null;
        });
    }

    protected function validateVideo($validator){
        $validator->sometimes('video', 'mimes:mp4,mkv',function($input){
            return $input->video !== null;
        });
    }

    protected function validatePoster($validator){
        $validator->sometimes('poster', 'mimes:png,jpg,jpeg',function($input){
            return $input->poster !== null;
        });
    }

    protected function validateSubtitulos($validator){
        $validator->sometimes('subtitulos', 'array',function($input){
            return $input->subtitulos !== null;
        });
    }
}
