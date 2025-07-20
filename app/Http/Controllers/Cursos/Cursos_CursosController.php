<?php

namespace App\Http\Controllers\Cursos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cursos\Cursos_Autores;
use App\Models\Cursos\Cursos_Categorias;
use App\Models\Cursos\Cursos_Cursos;
use App\Models\Cursos\Cursos_Modulos;
use App\Http\Requests\Cursos\Cursos_CursosRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Cursos_CursosController extends Controller
{
    public function index()
    {
        $cursos=DB::table('cursos_cursos as cur')
        ->select('cur.idCurso', 'cur.titulo', 'cur.imagen', 'cur.descripcion', 'cur.fecha_publicacion', 'cur.estado', 'aut.nombre as autor', 'cat.nombre as categoria')
        ->join('cursos_autores as aut', 'aut.idAutor', '=', 'cur.idAutor')
        ->join('cursos_categorias as cat', 'cat.idCategoria', '=', 'cur.idCategoria')
        ->get();
        $nav = $this->sections();
        return view('admin.cursos.cursos.index',compact('cursos','nav'));
    }

    public function create()
    {
        $categorias = Cursos_Categorias::all()->pluck("nombre","idCategoria");
        $autores = Cursos_Autores::all()->pluck("nombre","idAutor");
        $nav = $this->sections();
        return view('admin.cursos.cursos.create',compact('categorias','autores','nav'));
    }

    public function store(Cursos_CursosRequest $request)
    {
        $curso=new Cursos_Cursos([
            'titulo'=>$request->get('titulo'),
            'slug'=>$request->get('slug'),
            'descripcion'=>$request->get('descripcion'),
            'contenido'=>$request->get('contenido'),
            'duracion'=>0,
            'cantidad_clases' => 0,
            'cantidad_recursos' => 0,
            'precio' => $request->get('precio'),
            'fecha_publicacion'=>Carbon::createFromFormat('d/m/Y', $request->get('fecha_publicacion')),
            'idCategoria'=>$request->get('idCategoria'),
            'idAutor'=>$request->get('idAutor'),
            'estado'=>'1',
        ]);

        $imagen = $request->file('imagen');
        $carpeta = 'files/cursos/cursos/'.$request->get('slug').'/';
        $imagen->storeAs($carpeta, $imagen->getClientOriginalName(), 'public');
        $nombre = 'cursos/cursos/'.$request->get('slug').'/'.$imagen->getClientOriginalName();
        $curso->imagen = $nombre;

        $curso->save();
        return Redirect::route('admin.cursos.cursos.index')->with('success', 'Curso creado');
    }

    public function show($id)
    {
        $curso = Cursos_Cursos::findOrFail($id);
        $modulos = Cursos_Modulos::where('idCurso','=',$id)->with('lecciones')->orderBy('orden')->get();
        $nav = $this->sections();
        return view('admin.cursos.cursos.show',compact('curso','modulos','nav'));
    }

    public function edit($id)
    {
        $categorias = Cursos_Categorias::all()->pluck("nombre","idCategoria");
        $autores = Cursos_Autores::all()->pluck("nombre","idAutor");
        $curso = DB::table('cursos_cursos as cur')
        ->select('cur.idCurso', 'cur.titulo', 'cur.imagen', 'cur.descripcion', 'cur.fecha_publicacion', 'cur.estado', 'cur.idAutor', 'cur.contenido', 'cur.slug', 'cat.idCategoria','cur.precio')
        ->join('cursos_autores as aut', 'aut.idAutor', '=', 'cur.idAutor')
        ->join('cursos_categorias as cat', 'cat.idCategoria', '=', 'cur.idCategoria')
        ->where('cur.idCurso','=', $id)
        ->first();
        $nav = $this->sections();
        return view('admin.cursos.cursos.edit',compact('categorias','autores','curso','nav'));
    }

    public function update(Cursos_CursosRequest $request,$id)
    {
        $curso= Cursos_Cursos::findOrFail($id);

        if ($request->file('imagen')){
            $imagen = $request->file('imagen');
            $carpeta = 'files/cursos/cursos/'.$request->get('slug').'/';
            $imagen->storeAs($carpeta, $imagen->getClientOriginalName(), 'public');
            $nombre = 'cursos/cursos/'.$request->get('slug').'/'.$imagen->getClientOriginalName();
            $imagenNombre = $nombre;
        } else $imagenNombre = $curso->imagen;

        $curso->update([
            'titulo'=>$request->get('titulo'),
            'slug'=>$request->get('slug'),
            'descripcion'=>$request->get('descripcion'),
            'contenido'=>$request->get('contenido'),
            'duracion'=>$curso->duracion,
            'cantidad_clases' => $curso->cantidad_clases,
            'cantidad_recursos' => $curso->cantidad_recursos,
            'precio' => $request->get('precio'),
            'fecha_publicacion'=>Carbon::createFromFormat('d/m/Y', $request->get('fecha_publicacion')),
            'imagen'=>$imagenNombre,
            'idCategoria'=>$request->get('idCategoria'),
            'idAutor'=>$request->get('idAutor'),
            'estado'=>'1',
        ]);
        return Redirect::route('admin.cursos.cursos.index')->with('success', 'Curso actualizado');
    }

    public function destroy($id)
    {
        $curso=Cursos_Cursos::findOrFail($id);
        $curso->update([
            'estado'=>0,
        ]);
        return response()->json(['success' => true]);
    }
}
