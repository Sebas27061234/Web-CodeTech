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
        Schema::create('tienda_producto', function (Blueprint $table) {
            $table->id('idProducto');
            $table->string('sku',256);
            $table->string('titulo',512);
            $table->text('descripcion');
            $table->text('contenido');
            $table->date('fecha_publicacion');
            $table->decimal('precio',11,4);
            $table->string('imagen',1024);
            $table->text('galeria_imagenes');
            $table->text('descripcion_imagenes');
            $table->string('demo',512);
            $table->string('archivo',1024);
            $table->boolean('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tienda_producto');
    }
};
