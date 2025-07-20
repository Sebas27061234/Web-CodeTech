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
        Schema::create('cursos_modulo', function (Blueprint $table) {
            $table->id('idModulo');
            $table->string('titulo',255);
            $table->text('descripcion');
            $table->integer('orden');
            $table->unsignedBigInteger('idCurso');
            $table->boolean('visible');
            $table->boolean('estado');

            $table->foreign('idCurso')->references('idCurso')->on('cursos_cursos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos_modulo');
    }
};
