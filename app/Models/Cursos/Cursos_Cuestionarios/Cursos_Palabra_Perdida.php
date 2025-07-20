<?php

namespace App\Models\Cursos\Cursos_Cuestionarios;

use Illuminate\Database\Eloquent\Model;

class Cursos_Palabra_Perdida extends Model
{
    protected $table = 'cursos_palabra_perdida';
    protected $primaryKey = 'idPalabraPerd';
    public $timestamps = false;
    protected $fillable = [
        'texto',
        'num_huecos',
        'idPregunta',
        'estado'
    ];
    protected $guarded = [];
}
