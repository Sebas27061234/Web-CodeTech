<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cursos_cursos', function (Blueprint $table) {
            $table->id('idCurso');
            $table->string('slug',255);
            $table->string('titulo',255);
            $table->text('descripcion');
            $table->text('contenido');
            $table->integer('duracion');
            $table->integer('cantidad_clases');
            $table->integer('cantidad_recursos');
            $table->decimal('precio',11,2);
            $table->text('imagen');
            $table->date('fecha_publicacion');
            $table->unsignedBigInteger('idCategoria');
            $table->unsignedBigInteger('idAutor');
            $table->boolean('estado');

            $table->foreign('idCategoria')->references('idCategoria')->on('cursos_categorias');
            $table->foreign('idAutor')->references('idAutor')->on('cursos_autores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos_cursos');
    }
};
