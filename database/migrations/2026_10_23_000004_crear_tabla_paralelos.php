<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     */
    public function up(): void
    {
        Schema::create('paralelos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->cascadeOnDelete();
            $table->foreignId('instructor_id')->constrained('instructores')->cascadeOnDelete();
            $table->string('nombre');
            $table->string('aula');
            $table->string('dias');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->unsignedInteger('cupo_maximo')->default(25);
            $table->timestamps();
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('paralelos');
    }
};
