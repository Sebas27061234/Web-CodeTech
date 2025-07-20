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
        Schema::create('cursos_opciones_preguntas', function (Blueprint $table) {
            $table->id('idOpcionPreg');
            $table->text('opcion');
            $table->boolean('esCorrecta');
            $table->unsignedBigInteger('idPregunta');
            $table->boolean('estado');

            $table->foreign('idPregunta')->references('idPregunta')->on('cursos_pregunta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos_opciones_preguntas');
    }
};
