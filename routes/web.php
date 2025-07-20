<?php

use App\Http\Controllers\Cursos\Cursos_ExtrasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blog;
use App\Http\Controllers\Tienda;
use App\Http\Controllers\Cursos;
use App\Http\Controllers;

Route::get('/', function () {
    return view('welcome');
});

Route::name('admin.')->prefix('admin')->group(function(){
    //Blog
    Route::name('dashboard')->get('dashboard',[Controllers\DashboardAdmin::class,'index']);
    Route::name('blog')->resource('blog/categoria', Blog\Blog_CategoriasController::class);
    Route::name('blog')->resource('blog/autor', Blog\Blog_AutoresController::class);
    Route::name('blog')->resource('blog/video', Blog\Blog_VideosController::class);
    Route::name('blog')->resource('blog/listavideo', Blog\Blog_ListaVideosController::class);
    Route::name('blog')->resource('blog/posts', Blog\Blog_PostsController::class);

    //Tienda
    Route::name('tienda')->resource('tienda/categoria',Tienda\Tienda_CategoriasController::class);
    Route::name('tienda')->resource('tienda/productos',Tienda\Tienda_ProductosController::class);

    //Cursos
    Route::name('cursos')->resource('cursos/categoria',Cursos\Cursos_CategoriasController::class);
    Route::name('cursos')->resource('cursos/autor',Cursos\Cursos_AutoresController::class);
    Route::name('cursos')->resource('cursos/cursos',Cursos\Cursos_CursosController::class);
    Route::post('/cursos/module/store', [Cursos\Cursos_ExtrasController::class, 'storeModule'])->name('cursos.module.store');
    Route::post('/cursos/lection/store', [Cursos\Cursos_ExtrasController::class, 'storeLection'])->name('cursos.lection.store');
    Route::post('/cursos/lection/update', [Cursos\Cursos_ExtrasController::class, 'updateLection'])->name('cursos.lection.update');
    Route::post('/cursos/lectionl/update', [Cursos\Cursos_ExtrasController::class, 'updateLectionLec'])->name('cursos.lectionl.update');
    Route::get('cursos/cursos/{curso_id}/leccion/edit', [Cursos\Cursos_ExtrasController::class, 'editLection'])->name('cursos.leccion.edit');
    Route::post('/cursos/lectionc/update', [Cursos\Cursos_ExtrasController::class, 'updateLectionQuiz'])->name('cursos.lectionc.update');
});

Route::post('/filetiny', [Controllers\Extras::class, 'saveFilesTiny'])->name('filesTinyLoad');
Route::post('/admin/cursos/lection/loadVideo', [Cursos_ExtrasController::class, 'subir'])->name('subirVideo');
Route::get('/vv/e/{video}', [Blog\Blog_VideosController::class, 'show'])->name('reproBlog');
Route::get('/vv/embed/{video}', [Cursos\Cursos_ExtrasController::class, 'showVideos'])->name('reproCursos');