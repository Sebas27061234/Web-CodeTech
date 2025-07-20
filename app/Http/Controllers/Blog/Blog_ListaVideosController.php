<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Blog\Blog_ListaVideosRequest;
use App\Models\Blog\Blog_ListaVideos;
use Illuminate\Support\Facades\Redirect;

class Blog_ListaVideosController extends Controller
{
    public function store(Blog_ListaVideosRequest $request)
    {
        $video = new Blog_ListaVideos([
            'nombre' => $request->get('nombre'),
            'estado' => '1'
        ]);
        $video->save();
        $listVideos = Blog_ListaVideos::where('estado','=',1)->get();
        return response()->json(['success' => true,'listas' => $listVideos]);
    }
}
