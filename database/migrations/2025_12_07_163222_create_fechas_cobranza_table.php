<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fechas_cobranza', function (Blueprint $table) {
            $table->id('IdFechaCobranza');
            $table->unsignedBigInteger('IdPoliza');
            $table->date('FechaCobranza');
            $table->decimal('MontoCobro', 10, 2);
            $table->enum('Estatus', ['Pendiente', 'Pagado', 'Vencido'])->default('Pendiente');
            $table->date('FechaPago')->nullable();
            $table->text('Observaciones')->nullable();
            $table->timestamps();

            $table->foreign('IdPoliza')->references('IdPoliza')->on('polizas')->onDelete('cascade');
            $table->index(['IdPoliza', 'FechaCobranza']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fechas_cobranza');
    }
};