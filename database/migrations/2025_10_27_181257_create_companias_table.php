<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companias', function (Blueprint $table) {
            $table->id('IdCompania');
            $table->string('Nombre'); // Puede repetirse
            $table->string('Cobertura'); // Puede repetirse
            $table->timestamps();

            // ═══════════════════════════════════════════════════════════
            // ÍNDICE ÚNICO COMPUESTO: No se puede repetir Nombre + Cobertura
            // ═══════════════════════════════════════════════════════════
            $table->unique(['Nombre', 'Cobertura'], 'unique_nombre_cobertura');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companias');
    }
};