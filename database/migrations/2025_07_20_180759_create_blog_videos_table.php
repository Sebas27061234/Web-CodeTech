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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id('idPost');
            $table->string('slug',255);
            $table->string('titulo',512);
            $table->text('descripcion');
            $table->text('contenido');
            $table->date('fecha_publicacion');
            $table->string('imagen',1024);
            $table->unsignedBigInteger('idAutor');
            $table->string('idVideo');
            $table->boolean('estado');

            $table->foreign('idAutor')->references('idAutor')->on('blog_autores')->onDelete('cascade');
            $table->foreign('idVideo')->references('idVideo')->on('blog_videos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
