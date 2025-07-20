<?php

namespace App\Models\Cursos\Cursos_Cuestionarios;

use Illuminate\Database\Eloquent\Model;

class Cursos_Opciones_Preguntas extends Model
{
    protected $table = 'cursos_opciones_preguntas';
    protected $primaryKey = 'idOpcionPreg';
    public $timestamps = false;
    protected $fillable = [
        'opcion',
        'esCorrecta',
        'idPregunta',
        'estado'
    ];
    protected $guarded = [];
}
