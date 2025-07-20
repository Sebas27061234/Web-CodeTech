<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;

class Cursos_Cursos extends Model
{
    protected $table = 'cursos_cursos';
    protected $primaryKey = 'idCurso';
    public $timestamps = false;
    protected $fillable = [
        'slug',
        'titulo',
        'descripcion',
        'contenido',
        'duracion',
        'cantidad_clases',
        'cantidad_recursos',
        'precio',
        'imagen',
        'fecha_publicacion',
        'idCategoria',
        'idAutor',
        'estado'
    ];
    protected $guarded = [];

    public function categorias(){
        return $this->hasOne(Cursos_Categorias::class,'idCategoria','idCategoria');
    }

    public function autores(){
        return $this->hasOne(Cursos_Autores::class,'idAutor','idAutor');
    }
}
