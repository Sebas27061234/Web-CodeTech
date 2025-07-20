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
        Schema::create('blog_categorias', function (Blueprint $table) {
            $table->id('idCategoria');
            $table->string('nombre',250);
            $table->text('descripcion');
            $table->unsignedBigInteger('padre_id')->nullable();
            $table->string('imagen',1024);
            $table->boolean('estado');

            $table->foreign('padre_id')->references('idCategoria')->on('blog_categorias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_categorias');
    }
};
