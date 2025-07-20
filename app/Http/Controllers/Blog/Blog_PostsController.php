<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog\Blog_Posts;
use App\Models\Blog\Blog_Autores;
use App\Models\Blog\Blog_Categorias;
use App\Models\Blog\Blog_Videos;
use App\Models\Blog\Blog_ListaVideos;
use App\Http\Requests\Blog\Blog_PostsRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Blog_PostsController extends Controller
{
    public function index()
    {
        $posts=DB::table('blog_posts as pos')
        ->select('pos.idPost', 'pos.titulo', 'pos.imagen', 'pos.descripcion', 'pos.fecha_publicacion', 'pos.estado', 'aut.nombre as autor', DB::raw('GROUP_CONCAT(cat.nombre ORDER BY cat.nombre) as categorias'), 'vid.idVideo as video')
        ->join('blog_autores as aut', 'aut.idAutor', '=', 'pos.idAutor')
        ->join('blog_videos as vid', 'vid.idVideo', '=', 'pos.idVideo')
        ->join('blog_posts_categorias as etc', 'etc.idPost', '=', 'pos.idPost')
        ->join('blog_categorias as cat', 'cat.idCategoria', '=', 'etc.idCategoria')
        ->groupBy('pos.idPost', 'pos.titulo', 'pos.imagen', 'pos.descripcion', 'pos.fecha_publicacion', 'pos.estado', 'aut.nombre', 'vid.idVideo')
        ->get();
        $nav = $this->sections();
        return view('admin.blog.posts.index',compact('posts','nav'));
    }

    public function create()
    {
        $categorias = Blog_Categorias::whereNotNull('padre_id')->get();
        $categoriasP = Blog_Categorias::whereNull('padre_id')->pluck("nombre","idCategoria");
        $videos = Blog_Videos::all()->mapWithKeys(function ($video) {
            return [$video->idVideo => ['titulo' => $video->titulo, 'poster' => $video->poster, 'lista' => $video->idListaVideo]];
        });
        $listasVideos = Blog_ListaVideos::all()->pluck("nombre","idListaVideo");
        $autores = Blog_Autores::all()->pluck("nombre","idAutor");
        $nav = $this->sections();
        return view('admin.blog.posts.create',compact('categorias','videos','autores','listasVideos','categoriasP','nav'));
    }

    public function store(Blog_PostsRequest $request)
    {
        $posts=new Blog_Posts([
            'titulo'=>$request->get('titulo'),
            'slug'=>$request->get('slug'),
            'descripcion'=>$request->get('descripcion'),
            'contenido'=>$request->get('contenido'),
            'fecha_publicacion'=>Carbon::createFromFormat('d/m/Y', $request->get('fecha_publicacion')),
            'idVideo'=>$request->get('idVideo'),
            'idAutor'=>$request->get('idAutor'),
            'estado'=>'1',
        ]);

        $imagen = $request->file('imagen');
        $carpeta = 'files/blog/posts/'.$request->get('slug').'/';
        $imagen->storeAs($carpeta, $imagen->getClientOriginalName(), 'public');
        $nombre = 'blog/posts/'.$request->get('slug').'/'.$imagen->getClientOriginalName();
        $posts->imagen = $nombre;

        $posts->save();
        $posts->categorias()->attach($request->get('idCategoria'));
        return Redirect::route('admin.blog.posts.index')->with('success', 'Post creado');
    }

    public function show($id)
    {
        return view('admin.blog.posts.show',["post"=> Blog_Posts::findOrFail($id)]);
    }

    public function edit($id)
    {
        $categorias = Blog_Categorias::whereNotNull('padre_id')->get();
        $categoriasP = Blog_Categorias::whereNull('padre_id')->pluck("nombre","idCategoria");
        $videos = Blog_Videos::all()->mapWithKeys(function ($video) {
            return [$video->idVideo => ['titulo' => $video->titulo, 'poster' => $video->poster, 'lista' => $video->idListaVideo]];
        });
        $listasVideos = Blog_ListaVideos::all()->pluck("nombre","idListaVideo");
        $autores = Blog_Autores::all()->pluck("nombre","idAutor");
        $post = DB::table('blog_posts as pos')
        ->select('pos.idPost', 'pos.titulo', 'pos.imagen', 'pos.descripcion', 'pos.fecha_publicacion', 'pos.estado', 'pos.idAutor', 'pos.idVideo', 'pos.contenido', 'pos.slug', DB::raw('GROUP_CONCAT(cat.idCategoria ORDER BY cat.idCategoria) as categorias'))
        ->join('blog_posts_categorias as etc', 'etc.idPost', '=', 'pos.idPost')
        ->join('blog_categorias as cat', 'cat.idCategoria', '=', 'etc.idCategoria')
        ->where('pos.idPost','=', $id)
        ->groupBy('pos.idPost', 'pos.titulo', 'pos.imagen', 'pos.descripcion', 'pos.fecha_publicacion', 'pos.estado', 'pos.idAutor', 'pos.idVideo', 'pos.contenido', 'pos.slug')
        ->first();
        $nav = $this->sections();
        return view('admin.blog.posts.edit',compact('categorias','videos','autores','post','categoriasP','listasVideos','nav'));
    }

    public function update(Blog_PostsRequest $request,$id)
    {
        $post= Blog_Posts::findOrFail($id);

        if ($request->file('imagen')){
            $imagen = $request->file('imagen');
            $carpeta = 'files/blog/posts/'.$request->get('slug').'/';
            $imagen->storeAs($carpeta, $imagen->getClientOriginalName(), 'public');
            $nombre = 'blog/posts/'.$request->get('slug').'/'.$imagen->getClientOriginalName();
            $imagenNombre = $nombre;
        } else $imagenNombre = $post->imagen;

        $post->update([
            'titulo'=>$request->get('titulo'),
            'slug'=>$request->get('slug'),
            'descripcion'=>$request->get('descripcion'),
            'contenido'=>$request->get('contenido'),
            'fecha_publicacion'=>Carbon::createFromFormat('d/m/Y', $request->get('fecha_publicacion')),
            'imagen'=>$imagenNombre,
            'idVideo'=>$request->get('idVideo'),
            'idAutor'=>$request->get('idAutor'),
            'estado'=>'1',
        ]);
        $post->categorias()->sync($request->get('idCategoria'));
        return Redirect::route('admin.blog.posts.index')->with('success', 'Post actualizado');
    }

    public function destroy($id)
    {
        $entrada=Blog_Posts::findOrFail($id);
        $entrada->update([
            'estado'=>0,
        ]);
        return response()->json(['success' => true]);
    }
}
