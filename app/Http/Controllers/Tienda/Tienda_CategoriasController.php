<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tienda\Tienda_Categorias;
use App\Http\Requests\Tienda\Tienda_CategoriasRequest;
use Illuminate\Support\Facades\Redirect;

class Tienda_CategoriasController extends Controller
{
    public function index()
    {
        $categorias = Tienda_Categorias::select('tienda_categorias.idCategoria','tienda_categorias.nombre','tienda_categorias.descripcion','tienda_categorias.imagen','tienda_categorias.estado','bg2.nombre as padre')
        ->leftJoin('tienda_categorias as bg2','tienda_categorias.padre_id','=','bg2.idCategoria')
        ->get();
        $nav = $this->sections();
        return view('admin.tienda.categorias.index', compact('categorias','nav'));
    }

    public function create()
    {
        $categoriasPadre = Tienda_Categorias::whereNull('padre_id')->get();
        return view('admin.tienda.categorias.create', compact('categoriasPadre'));
    }

    public function store(Tienda_CategoriasRequest $request)
    {
        $categoria = new Tienda_Categorias([
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
            'padre_id' => $request->get('padre_id') ?? null,
            'estado' => '1'
        ]);

        $imagen = $request->file('imagen');
        $imagen->storeAs('files/tienda/categorias/',$imagen->getClientOriginalName(),'public');
        $categoria->imagen = 'tienda/categorias/'.$imagen->getClientOriginalName();
        $categoria->save();
        return Redirect::route('admin.tienda.categoria.index')->with('success', 'Categoria creada');
    }

    public function show(Tienda_Categorias $categoria)
    {
        return view('admin.tienda.categorias.show'.compact('categoria'));
    }

    public function edit($id)
    {
        $categoria = Tienda_Categorias::findOrFail($id);
        $categoriasPadre = Tienda_Categorias::whereNull('padre_id')->get();
        return view('admin.tienda.categorias.edit', compact('categoria','categoriasPadre'));
    }

    public function update(Tienda_CategoriasRequest $request, $id)
    {
        $categoria = Tienda_Categorias::findOrFail($id);
        if ($request->file('imagen')){
            $imagen = $request->file('imagen');
            $imagen->storeAs('files/tienda/categorias/',$imagen->getClientOriginalName(),'public');
            $imagenNombre = 'tienda/categorias/'.$imagen->getClientOriginalName();
        } else $imagenNombre = $categoria->imagen;
        $categoria->update([
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
            'padre_id' => $request->get('padre_id') ?? $categoria->padre_id,
            'imagen' => $imagenNombre
        ]);
        return Redirect::route('admin.tienda.categoria.index')->with('success', 'Categoria actualizada');
    }

    public function destroy($id)
    {
        $categoria = Tienda_Categorias::findOrFail($id);
        $categoria->update([
            'estado' => '0'
        ]);
        return response()->json(['success' => true]);
    }
}
