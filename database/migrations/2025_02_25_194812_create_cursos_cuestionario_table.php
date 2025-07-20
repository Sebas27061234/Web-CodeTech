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
        Schema::create('cursos_cuestionario', function (Blueprint $table) {
            $table->id('idCuestionario');
            $table->string('titulo',255);
            $table->text('descripcion');
            $table->integer('duracion');
            $table->integer('puntaje_aprobacion');
            $table->unsignedBigInteger('idLeccion')->unique();
            $table->boolean('estado');

            $table->foreign('idLeccion')->references('idLeccion')->on('cursos_leccion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos_cuestionario');
    }
};
