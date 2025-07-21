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
        Schema::create('blog_videos', function (Blueprint $table) {
            $table->string('idVideo')->primary();
            $table->string('titulo',255);
            $table->text('video');
            $table->text('poster');
            $table->text('subtitulos')->nullable();
            $table->unsignedBigInteger('idListaVideo');
            $table->boolean('estado');

            $table->foreign('idListaVideo')->references('idVideo')->on('blog_lista_videos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_videos');
    }
};
