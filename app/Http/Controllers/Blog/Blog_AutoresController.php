<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog\Blog_Autores;
use App\Http\Requests\Blog\Blog_AutoresRequest;
use Illuminate\Support\Facades\Redirect;

class Blog_AutoresController extends Controller
{
    public function index()
    {
        $autores = Blog_Autores::select('blog_autores.idAutor','blog_autores.nombre','blog_autores.descripcion','blog_autores.imagen','blog_autores.estado')
        ->get();
        $nav = $this->sections();
        return view('admin.blog.autores.index', compact('autores','nav'));
    }

    public function create()
    {
        return view('admin.blog.autores.create');
    }

    public function store(Blog_AutoresRequest $request)
    {
        $autor = new Blog_Autores([
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
            'estado' => '1'
        ]);

        $imagen = $request->file('imagen');
        $imagen->storeAs('files/blog/autores/',$imagen->getClientOriginalName(),'public');
        $autor->imagen = 'blog/autores/'.$imagen->getClientOriginalName();
        $autor->save();
        return Redirect::route('admin.blog.autor.index')->with('success', 'Autor creado');
    }

    public function show(Blog_Autores $categoria)
    {
        return view('admin.blog.autores.show'.compact('categoria'));
    }

    public function edit($id)
    {
        $autor = Blog_Autores::findOrFail($id);
        return view('admin.blog.autores.edit', compact('autor'));
    }

    public function update(Blog_AutoresRequest $request, $id)
    {
        $autor = Blog_Autores::findOrFail($id);
        if ($request->file('imagen')){
            $imagen = $request->file('imagen');
            $imagen->storeAs('files/blog/autores/',$imagen->getClientOriginalName(),'public');
            $imagenNombre = 'blog/autores/'.$imagen->getClientOriginalName();
        } else $imagenNombre = $autor->imagen;
        $autor->update([
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
            'imagen' => $imagenNombre
        ]);
        return Redirect::route('admin.blog.autor.index')->with('success', 'Autor actualizado');
    }

    public function destroy($id)
    {
        $autor = Blog_Autores::findOrFail($id);
        $autor->update([
            'estado' => '0'
        ]);
        return response()->json(['success' => true]);
    }
}
