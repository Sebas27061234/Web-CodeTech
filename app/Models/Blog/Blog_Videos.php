<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Blog_Videos extends Model
{
    protected $table = 'blog_videos';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'idVideo';
    public $timestamps = false;
    protected $fillable = [
        'idVideo',
        'titulo',
        'video',
        'poster',
        'subtitulos',
        'idListaVideo',
        'estado'
    ];
    protected $guarded = [];
}
