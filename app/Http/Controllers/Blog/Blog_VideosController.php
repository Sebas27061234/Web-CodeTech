<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Blog\Blog_VideosRequest;
use App\Models\Blog\Blog_Videos;
use App\Models\Blog\Blog_ListaVideos;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class Blog_VideosController extends Controller
{
    public function index()
    {
        $videos = Blog_Videos::select('blog_videos.idVideo','blog_videos.titulo','blog_videos.video','blog_videos.poster','blog_videos.subtitulos','blog_videos.estado','lvT.nombre as lista')
        ->leftJoin('blog_lista_videos as lvT','blog_videos.idListaVideo','=','lvT.idListaVideo')
        ->get();
        $nav = $this->sections();
        return view('admin.blog.videos.index', compact('videos','nav'));
    }

    public function create()
    {
        $listas = Blog_ListaVideos::where('estado','=','1')->get();
        return view('admin.blog.videos.create', compact('listas'));
    }

    public function store(Blog_VideosRequest $request)
    {
        $idVideo = substr(Str::uuid()->toString(), 0, 15);
        $video = new Blog_Videos([
            'idVideo' => $idVideo,
            'titulo' => $request->get('titulo'),
            'idListaVideo' => $request->get('idListaVideo') ?? null,
            'estado' => '1'
        ]);
        $videoFile = $request->file('video');
        $videoFile->storeAs('files/blog/videos/'.$idVideo.'/',$videoFile->getClientOriginalName(),'public');
        $video->video = 'blog/videos/'.$idVideo.'/'.$videoFile->getClientOriginalName();
        
        $posterFile = $request->file('poster');
        $posterFile->storeAs('files/blog/videos/'.$idVideo.'/poster/',$posterFile->getClientOriginalName(),'public');
        $video->poster = 'blog/videos/'.$idVideo.'/poster/'.$posterFile->getClientOriginalName();
        
        $subtitulosFiles = $request->file('subtitulos');
        $subtitulos = [];
        foreach ($subtitulosFiles as $subtitulo) {
            $subtitulo->storeAs('files/blog/videos/'.$idVideo.'/subtitulos/', $subtitulo->getClientOriginalName(),'public');
            $name = explode('_',pathinfo($subtitulo->getClientOriginalName(), PATHINFO_FILENAME));
            $subtitulos[] = [
                'kind' => 'captions',
                'label' => $name[0],
                'srclang' => $name[1],
                'src' => 'storage/files/blog/videos/'.$idVideo.'/subtitulos/'.$subtitulo->getClientOriginalName(),
                'default' => ($name[1] === 'es'),
            ];
        }
        $video->subtitulos = json_encode($subtitulos);
        $video->save();
        return Redirect::route('admin.blog.video.index')->with('success', 'Video creado');
    }

    public function show($id)
    {
        $video = Blog_Videos::findOrFail($id);
        $lista = Blog_ListaVideos::where('idListaVideo','=',$video->idListaVideo)->first();
        $videosLista = Blog_Videos::where('idListaVideo','=',$video->idListaVideo)->get();
        $videosArray = $videosLista->values();
        $siguienteVideo = null;

        foreach ($videosArray as $index => $videoA) {
            if ($videoA->id == $video->id) {
                if (isset($videosArray[$index + 1])) {
                    $siguienteVideo = $videosArray[$index + 1];
                }
                break;
            }
        }
        return view('admin.blog.videos.show',compact('video','lista','videosLista','siguienteVideo'));
    }

    public function edit($id)
    {
        $video = Blog_Videos::findOrFail($id);
        $listas = Blog_ListaVideos::where('estado','=','1')->get();
        return view('admin.blog.videos.edit', compact('video','listas'));
    }

    public function update(Blog_VideosRequest $request, $id)
    {
        $video = Blog_Videos::findOrFail($id);

        if ($request->file('video')) {
            $videoFile = $request->file('video');
            $videoFile->storeAs('files/blog/videos/'.$id.'/',$videoFile->getClientOriginalName(),'public');
            $videoName = 'blog/videos/'.$id.'/'.$videoFile->getClientOriginalName();
        } else $videoName = $video->video;
        
        if ($request->file('poster')) {
            $posterFile = $request->file('poster');
            $posterFile->storeAs('files/blog/videos/'.$id.'/poster/',$posterFile->getClientOriginalName(),'public');
            $posterName = 'blog/videos/'.$id.'/poster/'.$posterFile->getClientOriginalName();
        } else $posterName = $video->poster;
        
        if ($request->file('subtitulos')){
            $subtitulosFiles = $request->file('subtitulos');
            foreach ($subtitulosFiles as $subtitulo) {
                $subtitulo->storeAs('files/blog/videos/'.$id.'/subtitulos/', $subtitulo->getClientOriginalName(),'public');
                $name = explode('_',pathinfo($subtitulo->getClientOriginalName(), PATHINFO_FILENAME));
                $subtitulos[] = [
                    'kind' => 'captions',
                    'label' => $name[0],
                    'srclang' => $name[1],
                    'src' => 'storage/files/blog/videos/'.$id.'/subtitulos/'.$subtitulo->getClientOriginalName(),
                    'default' => ($name[1] === 'es') ? true : false,
                ];
            }
            $subtitulosName = $subtitulos;
        } else $subtitulosName = $video->subtitulos;

        $video->update([
            'titulo' => $request->get('nombre'),
            'video' => $videoName,
            'poster' => $posterName,
            'subtitulos' => $subtitulosName,
            'idListaVideo' => $request->get('idListaVideo') ?? null,
            'estado' => '1'
        ]);

        return Redirect::route('admin.blog.categoria.index')->with('success', 'Video actualizado');
    }

    public function destroy($id)
    {
        $video = Blog_Videos::findOrFail($id);
        $video->update([
            'estado' => '0'
        ]);
        return response()->json(['success' => true]);
    }
}
