<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;

class Cursos_Lecciones extends Model
{
    protected $table = 'cursos_leccion';
    protected $primaryKey = 'idLeccion';
    public $timestamps = false;
    protected $fillable = [
        'titulo',
        'tipo_leccion',
        'contenido',
        'orden',
        'idModulo',
        'visible',
        'estado'
    ];
    protected $guarded = [];
}
