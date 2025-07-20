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
        Schema::create('cursos_palabra_perdida_opciones', function (Blueprint $table) {
            $table->id('idPPOpcion');
            $table->integer('indice');
            $table->text('opcion');
            $table->boolean('esCorrecta');
            $table->unsignedBigInteger('idPalabraPerd');
            $table->boolean('estado');

            $table->foreign('idPalabraPerd')->references('idPalabraPerd')->on('cursos_palabra_perdida');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos_palabra_perdida_opciones');
    }
};
