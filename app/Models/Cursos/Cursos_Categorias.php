<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;

class Cursos_Categorias extends Model
{
    protected $table = 'cursos_categorias';
    protected $primaryKey = 'idCategoria';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'estado'
    ];
    protected $guarded = [];
    public function cursos(){
        return $this->belongsToMany(Cursos_Categorias::class,'tienda_productos_categorias','idCategoria','idProducto');
    }
}
