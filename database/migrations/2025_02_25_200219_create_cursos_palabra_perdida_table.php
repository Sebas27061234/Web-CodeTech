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
        Schema::create('cursos_palabra_perdida', function (Blueprint $table) {
            $table->id('idPalabraPerd');
            $table->text('texto');
            $table->integer('num_huecos');
            $table->unsignedBigInteger('idPregunta')->unique();
            $table->boolean('estado');

            $table->foreign('idPregunta')->references('idPregunta')->on('cursos_pregunta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos_palabra_perdida');
    }
};
