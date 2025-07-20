<?php

namespace App\Models\Tienda;

use Illuminate\Database\Eloquent\Model;

class Tienda_Categorias extends Model
{
    protected $table = 'tienda_categorias';
    protected $primaryKey = 'idCategoria';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'descripcion',
        'padre_id',
        'imagen',
        'estado'
    ];
    protected $guarded = [];
    public function childs(){
        return $this->hasMany(Tienda_Categorias::class, 'padre_id', 'idCategoria');
    }
    public function productos(){
        return $this->belongsToMany(Tienda_Productos::class,'tienda_productos_categorias','idCategoria','idProducto');
    }
}
