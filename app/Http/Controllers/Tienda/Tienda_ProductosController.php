<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tienda\Tienda_Productos;
use App\Models\Tienda\Tienda_Categorias;
use App\Http\Requests\Tienda\Tienda_ProductosRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Tienda_ProductosController extends Controller
{
    public function index()
    {
        $productos=DB::table('tienda_productos as prod')
        ->select('prod.idProducto', 'prod.titulo', 'prod.sku', 'prod.imagen', 'prod.precio', 'prod.fecha_publicacion', 'prod.estado', DB::raw('GROUP_CONCAT(cat.nombre ORDER BY cat.nombre) as categorias'))
        ->join('tienda_productos_categorias as etc', 'etc.idProducto', '=', 'prod.idProducto')
        ->join('tienda_categorias as cat', 'cat.idCategoria', '=', 'etc.idCategoria')
        ->groupBy('prod.idProducto', 'prod.titulo', 'prod.sku', 'prod.imagen', 'prod.precio', 'prod.fecha_publicacion', 'prod.estado')
        ->get();
        $nav = $this->sections();
        return view('admin.tienda.productos.index',compact('productos','nav'));
    }

    public function create()
    {
        $categorias = Tienda_Categorias::whereNotNull('padre_id')->get();
        $categoriasP = Tienda_Categorias::whereNull('padre_id')->pluck("nombre","idCategoria");
        $nav = $this->sections();
        return view('admin.tienda.productos.create',compact('categorias','categoriasP','nav'));
    }

    public function store(Tienda_ProductosRequest $request)
    {
        $producto=new Tienda_Productos([
            'titulo'=>$request->get('titulo'),
            'sku'=>$request->get('sku'),
            'descripcion'=>$request->get('descripcion'),
            'contenido'=>$request->get('contenido'),
            'fecha_publicacion'=>Carbon::createFromFormat('d/m/Y', $request->get('fecha_publicacion')),
            'precio'=>$request->get('precio'),
            'demo'=>$request->get('demo'),
            'descripcion_imagenes'=>implode(';',$request->get('descripcion_imagenes')),
            'estado'=>'1',
        ]);

        if ($request->file('imagen')) {
            $imagen = $request->file('imagen');
            $carpeta = 'files/tienda/producto/'.$request->get('sku').'/';
            $imagen->storeAs($carpeta, $imagen->getClientOriginalName(), 'public');
            $nombre = 'tienda/producto/'.$request->get('sku').'/'.$imagen->getClientOriginalName();
            $producto->imagen = $nombre;
        }

        if($request->file('galeria_imagenes')){
            $galeria_imagenes = $request->file('galeria_imagenes');
            $galeria = '';
            foreach ($galeria_imagenes as $imagen) {
                $carpeta = 'files/tienda/producto/'.$request->get('sku').'/';
                $imagen->storeAs($carpeta, $imagen->getClientOriginalName(), 'public');
                $nombre = 'tienda/producto/'.$request->get('sku').'/'.$imagen->getClientOriginalName();
                $galeria .= $nombre.';';
            }
            $producto->galeria_imagenes = $galeria;
        }

        if ($request->file('archivo')) {
            $archivo = $request->file('archivo');
            $carpeta = 'files/tienda/producto/'.$request->get('sku').'/archivo'.'/';
            $imagen->storeAs($carpeta, $archivo->getClientOriginalName(), 'public');
            $nombre = 'tienda/producto/'.$request->get('sku').'/archivo'.'/'.$archivo->getClientOriginalName();
            $producto->archivo = $nombre;
        }

        $producto->save();
        $producto->categorias()->attach($request->get('idCategoria'));
        return Redirect::route('admin.tienda.productos.index')->with('success', 'Producto creado');
    }

    public function show($id)
    {
        return view('admin.tienda.productos.show',["producto"=> Tienda_Productos::findOrFail($id)]);
    }

    public function edit($id)
    {
        $categorias = Tienda_Categorias::whereNotNull('padre_id')->get();
        $categoriasP = Tienda_Categorias::whereNull('padre_id')->pluck("nombre","idCategoria");
        $producto = DB::table('tienda_productos as prod')
        ->select('prod.idProducto', 'prod.titulo', 'prod.imagen', 'prod.descripcion', 'prod.fecha_publicacion', 'prod.estado', 'prod.contenido', 'prod.demo', 'prod.archivo', 'prod.galeria_imagenes', 'prod.descripcion_imagenes', 'prod.precio', 'prod.sku', DB::raw('GROUP_CONCAT(cat.idCategoria ORDER BY cat.idCategoria) as categorias'))
        ->join('tienda_productos_categorias as etc', 'etc.idProducto', '=', 'prod.idProducto')
        ->join('blog_categorias as cat', 'cat.idCategoria', '=', 'etc.idCategoria')
        ->where('prod.idProducto','=', $id)
        ->groupBy('prod.idProducto', 'prod.titulo', 'prod.imagen', 'prod.descripcion', 'prod.fecha_publicacion', 'prod.estado', 'prod.contenido', 'prod.demo', 'prod.archivo', 'prod.galeria_imagenes', 'prod.descripcion_imagenes', 'prod.precio', 'prod.sku')
        ->first();
        $nav = $this->sections();
        return view('admin.tienda.productos.edit',compact('categorias','producto','categoriasP','nav'));
    }

    public function update(Tienda_ProductosRequest $request,$id)
    {
        $producto= Tienda_Productos::findOrFail($id);

        if ($request->file('imagen')){
            $imagen = $request->file('imagen');
            $carpeta = 'files/tienda/producto/'.$request->get('sku').'/';
            $imagen->storeAs($carpeta, $imagen->getClientOriginalName(), 'public');
            $nombre = 'tienda/producto/'.$request->get('sku').'/'.$imagen->getClientOriginalName();
            $imagenNombre = $nombre;
        } else $imagenNombre = $producto->imagen;

        if($request->file('galeria_imagenes')){
            $galeria_imagenes = $request->file('galeria_imagenes');
            $galeria = '';
            foreach ($galeria_imagenes as $imagen) {
                $carpeta = 'files/tienda/producto/'.$request->get('sku').'/';
                $imagen->storeAs($carpeta, $imagen->getClientOriginalName(), 'public');
                $nombre = 'tienda/producto/'.$request->get('sku').'/'.$imagen->getClientOriginalName();
                $galeria += $nombre.';';
            }
            $galeria_imagen = $galeria;
        } else $galeria_imagen = $producto->galeria_imagenes;

        if ($request->file('archivo')) {
            $archivo = $request->file('archivo');
            $carpeta = 'files/tienda/producto/'.$request->get('sku').'/archivo'.'/';
            $imagen->storeAs($carpeta, $archivo->getClientOriginalName(), 'public');
            $nombre = 'tienda/producto/'.$request->get('sku').'/archivo'.'/'.$archivo->getClientOriginalName();
            $archivoNombre = $nombre;
        } else $archivoNombre = $producto->archivo;

        $producto->update([
            'titulo'=>$request->get('titulo'),
            'sku'=>$request->get('sku'),
            'descripcion'=>$request->get('descripcion'),
            'contenido'=>$request->get('contenido'),
            'fecha_publicacion'=>Carbon::createFromFormat('d/m/Y', $request->get('fecha_publicacion')),
            'precio'=>$request->get('precio'),
            'demo'=>$request->get('demo'),
            'descripcion_imagenes'=>$request->get('descripcion_imagenes'),
            'imagen'=>$imagenNombre,
            'galeria_imagenes'=>$galeria_imagen,
            'archivo'=>$archivoNombre,
            'estado'=>'1',
        ]);

        $producto->categorias()->sync($request->get('idCategoria'));
        return Redirect::route('admin.tienda.productos.index')->with('success', 'Producto actualizado');
    }

    public function destroy($id)
    {
        $producto=Tienda_Productos::findOrFail($id);
        $producto->update([
            'estado'=>0,
        ]);
        return response()->json(['success' => true]);
    }
}
