<?php

namespace App\Models\Tienda;

use Illuminate\Database\Eloquent\Model;

class Tienda_Productos extends Model
{
    protected $table = 'tienda_productos';
    protected $primaryKey = 'idProducto';
    public $timestamps = false;
    protected $fillable = [
        'sku',
        'titulo',
        'descripcion',
        'contenido',
        'fecha_publicacion',
        'precio',
        'imagen',
        'galeria_imagenes',
        'descripcion_imagenes',
        'demo',
        'archivo',
        'estado'
    ];
    protected $guarded = [];
    public function categorias(){
        return $this->belongsToMany(Tienda_Categorias::class,'tienda_productos_categorias','idProducto','idCategoria');
    }
}
