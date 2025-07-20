<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;

class Cursos_Modulos extends Model
{
    protected $table = 'cursos_modulo';
    protected $primaryKey = 'idModulo';
    public $timestamps = false;
    protected $fillable = [
        'titulo',
        'descripcion',
        'orden',
        'idCurso',
        'visible',
        'estado'
    ];
    protected $guarded = [];

    public function lecciones(){
        return $this->hasMany(Cursos_Lecciones::class,'idModulo','idModulo')->orderBy('orden');
    }
}
