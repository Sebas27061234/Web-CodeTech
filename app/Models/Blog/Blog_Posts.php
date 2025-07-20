<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Blog_Posts extends Model
{
    protected $table = 'blog_posts';
    protected $primaryKey = 'idPost';
    public $timestamps = false;
    protected $fillable = [
        'slug',
        'titulo',
        'descripcion',
        'contenido',
        'fecha_publicacion',
        'imagen',
        'idAutor',
        'idVideo',
        'estado'
    ];
    protected $guarded = [];
    public function categorias(){
        return $this->belongsToMany(Blog_Categorias::class,'blog_posts_categorias','idPost','idCategoria');
    }
}
