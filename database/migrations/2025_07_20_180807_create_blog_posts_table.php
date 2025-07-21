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
        Schema::create('blog_posts_categorias', function (Blueprint $table) {
            $table->foreignId('idPost')->constrained('blog_posts', 'idPost');
            $table->foreignId('idCategoria')->constrained('blog_categorias', 'idCategoria');
            $table->primary(['idPost', 'idCategoria']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts_categorias');
    }
};
