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
        Schema::create('cursos_leccion', function (Blueprint $table) {
            $table->id('idLeccion');
            $table->string('titulo',255);
            $table->string('tipo_leccion',255);
            $table->text('url_contenido')->nullable();
            $table->integer('orden');
            $table->unsignedBigInteger('idModulo');
            $table->boolean('visible');
            $table->boolean('estado');

            $table->foreign('idModulo')->references('idModulo')->on('cursos_modulo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos_leccion');
    }
};
