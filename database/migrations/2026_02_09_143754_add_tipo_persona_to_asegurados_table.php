<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asegurados', function (Blueprint $table) {
            $table->string('TipoPersona', 10)->default('Física')->after('IdAsegurado');
            $table->string('ApellidoPaterno')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('asegurados', function (Blueprint $table) {
            $table->dropColumn('TipoPersona');
            $table->string('ApellidoPaterno')->nullable(false)->change();
        });
    }
};
