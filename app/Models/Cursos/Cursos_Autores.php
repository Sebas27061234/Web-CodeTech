<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;

class Cursos_Autores extends Model
{
    protected $table = 'cursos_autores';
    protected $primaryKey = 'idAutor';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'estado'
    ];
    protected $guarded = [];
}
