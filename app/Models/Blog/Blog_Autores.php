<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Blog_Autores extends Model
{
    protected $table = 'blog_autores';
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
