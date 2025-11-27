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
    Schema::create('polizas', function (Blueprint $table) {
        $table->id('IdPoliza');
        $table->string('NumPoliza')->unique();
        $table->string('FormaPago');
        $table->date('FechaInicio');
        $table->date('FechaVencimiento');
        $table->decimal('Prima', 10, 2);
        $table->string('Estatus');

        // Llaves foráneas
        $table->unsignedBigInteger('IdCompania');
        $table->unsignedBigInteger('IdUnidad');
        $table->unsignedBigInteger('IdAsegurado');

        $table->foreign('IdCompania')->references('IdCompania')->on('companias')->onDelete('cascade');
        $table->foreign('IdUnidad')->references('IdUnidad')->on('unidads')->onDelete('cascade');
        $table->foreign('IdAsegurado')->references('IdAsegurado')->on('asegurados')->onDelete('cascade');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polizas');
    }
};
