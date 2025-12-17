<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('endosos', function (Blueprint $table) {
            $table->id('IdEndoso');
            $table->unsignedBigInteger('IdPoliza');
            $table->string('NumEndoso')->unique(); // END-2024-001
            $table->date('FechaEndoso');
            $table->enum('TipoEndoso', [
                'Modificacion',
                'Renovacion',
                'Cancelacion',
                'Cambio Suma Asegurada',
                'Cambio Beneficiario',
                'Cambio Unidad',
                'Otro'
            ]);
            $table->text('Descripcion');
            $table->decimal('MontoAfectado', 10, 2)->nullable();
            $table->string('ArchivoAdjunto')->nullable(); // PDF del endoso oficial
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('IdPoliza')
                ->references('IdPoliza')
                ->on('polizas')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            // Índices
            $table->index('IdPoliza');
            $table->index('FechaEndoso');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('endosos');
    }
};