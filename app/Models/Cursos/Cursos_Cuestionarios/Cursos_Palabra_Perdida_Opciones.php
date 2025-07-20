<?php

namespace App\Models\Cursos\Cursos_Cuestionarios;

use Illuminate\Database\Eloquent\Model;

class Cursos_Palabra_Perdida_Opciones extends Model
{
    protected $table = 'cursos_palabra_perdida_opciones';
    protected $primaryKey = 'idPPOpcion';
    public $timestamps = false;
    protected $fillable = [
        'indice',
        'opcion',
        'esCorrecta',
        'idPalabraPerd',
        'estado'
    ];
    protected $guarded = [];
}
