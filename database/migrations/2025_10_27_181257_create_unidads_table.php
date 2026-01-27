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
    Schema::create('unidads', function (Blueprint $table) {
        $table->id('IdUnidad');
        $table->string('VIN')->unique();
        $table->string('Marca');
        $table->string('Submarca')->nullable();
        $table->year('Anio');
        $table->string('NoSerie')->nullable();
        $table->string('Motor')->nullable();
        $table->string('Placas')->nullable();
        $table->string('Color')->nullable();
        $table->string('Uso')->nullable();
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidads');
    }
};
