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
        Schema::create('cursos_pregunta', function (Blueprint $table) {
            $table->id('idPregunta');
            $table->string('enunciado',255);
            $table->string('tipo_pregunta',255);
            $table->integer('puntaje');
            $table->unsignedBigInteger('idCuestionario');
            $table->boolean('estado');
            
            $table->foreign('idCuestionario')->references('idCuestionario')->on('cursos_cuestionario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos_pregunta');
    }
};
