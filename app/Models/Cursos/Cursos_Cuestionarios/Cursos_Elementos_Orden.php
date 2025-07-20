<?php

namespace App\Models\Cursos\Cursos_Cuestionarios;

use Illuminate\Database\Eloquent\Model;

class Cursos_Elementos_Orden extends Model
{
    protected $table = 'cursos_elementos_orden';
    protected $primaryKey = 'idElementoOrd';
    public $timestamps = false;
    protected $fillable = [
        'elemento',
        'orden',
        'idPregunta',
        'estado'
    ];
    protected $guarded = [];
}
