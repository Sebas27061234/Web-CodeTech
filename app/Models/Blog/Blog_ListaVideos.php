<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Blog_ListaVideos extends Model
{
    protected $table = 'blog_lista_videos';
    protected $primaryKey = 'idListaVideo';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'estado'
    ];
    protected $guarded = [];
}
