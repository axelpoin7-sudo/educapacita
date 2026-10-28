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
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participante_id')->constrained('participantes')->cascadeOnDelete();
            $table->foreignId('paralelo_id')->constrained('paralelos')->cascadeOnDelete();
            $table->date('fecha_inscripcion');
            $table->decimal('monto_pagado', 10, 2)->default(0.00);
            $table->enum('estado', ['pendiente', 'pagada', 'anulada'])->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};
