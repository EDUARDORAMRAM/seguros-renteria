<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar los seeders en orden
        $this->call([
            UsersSeeder::class,        // Primero los usuarios
               // Luego todo el contenido
        ]);
    }
}