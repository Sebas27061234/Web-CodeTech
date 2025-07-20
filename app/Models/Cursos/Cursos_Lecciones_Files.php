<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;

class Cursos_Lecciones_Files extends Model
{
    protected $table = 'cursos_leccion_files';
    protected $primaryKey = 'idLeccionFile';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'extension',
        'tamaño',
        'url',
        'idLeccion',
        'poster'
    ];
    protected $guarded = [];
}
