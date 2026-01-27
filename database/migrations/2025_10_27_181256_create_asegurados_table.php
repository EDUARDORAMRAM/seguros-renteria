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
    Schema::create('asegurados', function (Blueprint $table) {
        $table->id('IdAsegurado');
        $table->string('Nombre');
        $table->string('ApellidoPaterno');
        $table->string('ApellidoMaterno')->nullable();
        $table->string('Telefono')->nullable();
        $table->string('Email')->nullable();
        $table->string('RFC')->unique();
        $table->string('Referencia')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asegurados');
    }
};
