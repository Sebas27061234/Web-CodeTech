<?php

namespace App\Models\Cursos\Cursos_Cuestionarios;

use Illuminate\Database\Eloquent\Model;

class Cursos_Preguntas extends Model
{
    protected $table = 'cursos_pregunta';
    protected $primaryKey = 'idPregunta';
    public $timestamps = false;
    protected $fillable = [
        'enunciado',
        'tipo_pregunta',
        'puntaje',
        'idCuestionario',
        'estado'
    ];
    protected $guarded = [];
}
