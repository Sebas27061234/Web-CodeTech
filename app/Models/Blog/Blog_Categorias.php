<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Blog_Categorias extends Model
{
    protected $table = 'blog_categorias';
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
        return $this->hasMany(Blog_Categorias::class, 'padre_id', 'idCategoria');
    }
    public function posts(){
        return $this->belongsToMany(Blog_Posts::class,'blog_posts_categorias','idCategoria','idPost');
    }
}
