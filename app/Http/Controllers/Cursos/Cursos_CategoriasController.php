<?php

namespace App\Http\Controllers\Cursos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cursos\Cursos_Categorias;
use App\Http\Requests\Cursos\Cursos_CategoriasRequest;
use Illuminate\Support\Facades\Redirect;

class Cursos_CategoriasController extends Controller
{
    public function index()
    {
        $categorias = Cursos_Categorias::select('cursos_categorias.idCategoria','cursos_categorias.nombre','cursos_categorias.descripcion','cursos_categorias.imagen','cursos_categorias.estado')
        ->get();
        $nav = $this->sections();
        return view('admin.cursos.categorias.index', compact('categorias','nav'));
    }

    public function create()
    {
        return view('admin.cursos.categorias.create');
    }

    public function store(Cursos_CategoriasRequest $request)
    {
        $categoria = new Cursos_Categorias([
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
            'estado' => '1'
        ]);

        $imagen = $request->file('imagen');
        $imagen->storeAs('files/cursos/categorias/',$imagen->getClientOriginalName(),'public');
        $categoria->imagen = 'cursos/categorias/'.$imagen->getClientOriginalName();
        $categoria->save();
        return Redirect::route('admin.cursos.categoria.index')->with('success', 'Categoria creada');
    }

    public function show(Cursos_Categorias $categoria)
    {
        return view('admin.cursos.categorias.show');
    }

    public function edit($id)
    {
        $categoria = Cursos_Categorias::findOrFail($id);
        return view('admin.cursos.categorias.edit', compact('categoria'));
    }

    public function update(Cursos_CategoriasRequest $request, $id)
    {
        $categoria = Cursos_Categorias::findOrFail($id);
        if ($request->file('imagen')){
            $imagen = $request->file('imagen');
            $imagen->storeAs('files/cursos/categorias/',$imagen->getClientOriginalName(),'public');
            $imagenNombre = 'cursos/categorias/'.$imagen->getClientOriginalName();
        } else $imagenNombre = $categoria->imagen;
        $categoria->update([
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
            'imagen' => $imagenNombre
        ]);
        return Redirect::route('admin.cursos.categoria.index')->with('success', 'Categoria actualizada');
    }

    public function destroy($id)
    {
        $categoria = Cursos_Categorias::findOrFail($id);
        $categoria->update([
            'estado' => '0'
        ]);
        return response()->json(['success' => true]);
    }
}
