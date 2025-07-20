<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog\Blog_Categorias;
use App\Http\Requests\Blog\Blog_CategoriasRequest;
use Illuminate\Support\Facades\Redirect;

class Blog_CategoriasController extends Controller
{
    public function index()
    {
        $categorias = Blog_Categorias::select('blog_categorias.idCategoria','blog_categorias.nombre','blog_categorias.descripcion','blog_categorias.imagen','blog_categorias.estado','bg2.nombre as padre')
        ->leftJoin('blog_categorias as bg2','blog_categorias.padre_id','=','bg2.idCategoria')
        ->get();
        $nav = $this->sections();
        return view('admin.blog.categorias.index', compact('categorias','nav'));
    }

    public function create()
    {
        $categoriasPadre = Blog_Categorias::whereNull('padre_id')->get();
        return view('admin.blog.categorias.create', compact('categoriasPadre'));
    }

    public function store(Blog_CategoriasRequest $request)
    {
        $categoria = new Blog_Categorias([
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
            'padre_id' => $request->get('padre_id') ?? null,
            'estado' => '1'
        ]);

        $imagen = $request->file('imagen');
        $imagen->storeAs('files/blog/categorias/',$imagen->getClientOriginalName(),'public');
        $categoria->imagen = 'blog/categorias/'.$imagen->getClientOriginalName();
        $categoria->save();
        return Redirect::route('admin.blog.categoria.index')->with('success', 'Categoria creada');
    }

    public function show(Blog_Categorias $categoria)
    {
        return view('admin.blog.categorias.show'.compact('categoria'));
    }

    public function edit($id)
    {
        $categoria = Blog_Categorias::findOrFail($id);
        $categoriasPadre = Blog_Categorias::whereNull('padre_id')->get();
        return view('admin.blog.categorias.edit', compact('categoria','categoriasPadre'));
    }

    public function update(Blog_CategoriasRequest $request, $id)
    {
        $categoria = Blog_Categorias::findOrFail($id);
        if ($request->file('imagen')){
            $imagen = $request->file('imagen');
            $imagen->storeAs('files/blog/categorias/',$imagen->getClientOriginalName(),'public');
            $imagenNombre = 'blog/categorias/'.$imagen->getClientOriginalName();
        } else $imagenNombre = $categoria->imagen;
        $categoria->update([
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
            'padre_id' => $request->get('padre_id') ?? $categoria->padre_id,
            'imagen' => $imagenNombre
        ]);
        return Redirect::route('admin.blog.categoria.index')->with('success', 'Categoria actualizada');
    }

    public function destroy($id)
    {
        $categoria = Blog_Categorias::findOrFail($id);
        $categoria->update([
            'estado' => '0'
        ]);
        return response()->json(['success' => true]);
    }
}
