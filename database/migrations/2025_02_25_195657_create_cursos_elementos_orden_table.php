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
        Schema::create('cursos_elementos_orden', function (Blueprint $table) {
            $table->id('idElementoOrd');
            $table->text('elemento');
            $table->boolean('orden');
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
        Schema::dropIfExists('cursos_elementos_orden');
    }
};
