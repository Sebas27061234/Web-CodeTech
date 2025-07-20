<?php

namespace App\Http\Controllers\Cursos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Cursos\Cursos_Autores;
use App\Http\Requests\Cursos\Cursos_AutoresRequest;
use Illuminate\Support\Facades\Redirect;

class Cursos_AutoresController extends Controller
{
    public function index()
    {
        $autores = Cursos_Autores::select('cursos_autores.idAutor','cursos_autores.nombre','cursos_autores.descripcion','cursos_autores.imagen','cursos_autores.estado')
        ->get();
        $nav = $this->sections();
        return view('admin.cursos.autores.index', compact('autores','nav'));
    }

    public function create()
    {
        return view('admin.cursos.autores.create');
    }

    public function store(Cursos_AutoresRequest $request)
    {
        $autor = new Cursos_Autores([
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
            'estado' => '1'
        ]);

        if ($request->file('imagen')){
            $imagen = $request->file('imagen');
            $nombreUnico = Str::random(20) . '.' . $imagen->getClientOriginalExtension();
            $imagen->storeAs('files/cursos/autores/',$nombreUnico,'public');
            $autor->imagen = 'cursos/autores/'.$nombreUnico;
        } else {
            $nombreCodificado = urlencode($request->get('nombre'));
            $autor->imagen = 'https://ui-avatars.com/api/?background=random&size=512&name='.$nombreCodificado;
        }
        
        $autor->save();
        return Redirect::route('admin.cursos.autor.index')->with('success', 'Autor creado');
    }

    public function show(Cursos_Autores $autor)
    {
        return view('admin.cursos.autores.show'.compact('autor'));
    }

    public function edit($id)
    {
        $autor = Cursos_Autores::findOrFail($id);
        return view('admin.cursos.autores.edit', compact('autor'));
    }

    public function update(Cursos_AutoresRequest $request, $id)
    {
        $autor = Cursos_Autores::findOrFail($id);
        if ($request->file('imagen')){
            $imagen = $request->file('imagen');
            $nombreUnico = Str::random(20) . '.' . $imagen->getClientOriginalExtension();
            $imagen->storeAs('files/cursos/autores/',$nombreUnico,'public');
            $imagenNombre = 'cursos/autores/'.$nombreUnico;
        } else $imagenNombre = $autor->imagen;
        $autor->update([
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
            'imagen' => $imagenNombre
        ]);
        return Redirect::route('admin.cursos.autor.index')->with('success', 'Autor actualizado');
    }

    public function destroy($id)
    {
        $autor = Cursos_Autores::findOrFail($id);
        $autor->update([
            'estado' => '0'
        ]);
        return response()->json(['success' => true]);
    }
}
