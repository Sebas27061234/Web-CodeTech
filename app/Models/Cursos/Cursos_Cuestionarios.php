<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;

class Cursos_Cuestionarios extends Model
{
    protected $table = 'cursos_cuestionario';
    protected $primaryKey = 'idCuestionario';
    public $timestamps = false;
    protected $fillable = [
        'titulo',
        'descripcion',
        'puntaje_aprobacion',
        'es_final',
        'idLeccion',
        'estado'
    ];
    protected $guarded = [];
}
