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
        Schema::create('cursos_leccion_files', function (Blueprint $table) {
            $table->id('idLeccionFile');
            $table->unsignedBigInteger('idLeccion');
            $table->string('nombre', 512);
            $table->string('extension', 50);
            $table->decimal('tamaño',10,2);
            $table->string('url', 1024);

            $table->foreign('idLeccion')->references('idLeccion')->on('cursos_leccion')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos_leccion_files');
    }
};
