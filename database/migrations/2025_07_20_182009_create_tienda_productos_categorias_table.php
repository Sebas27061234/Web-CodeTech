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
        Schema::create('tienda_productos_categorias', function (Blueprint $table) {
            $table->foreignId('idProducto')->constrained('tienda_productos', 'idProducto');
            $table->foreignId('idCategoria')->constrained('tienda_categorias', 'idCategoria');
            $table->primary(['idProducto', 'idCategoria']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tienda_productos_categorias');
    }
};
