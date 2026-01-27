<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('════════════════════════════════════════════════════════════');
        $this->command->info('👤 CREANDO USUARIOS DEL SISTEMA');
        $this->command->info('════════════════════════════════════════════════════════════');
        $this->command->info('');

        // Administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@seguros.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Agente 1
        User::create([
            'name' => 'Juan Pérez Martínez',
            'email' => 'juan.perez@seguros.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Agente 2
        User::create([
            'name' => 'María García López',
            'email' => 'maria.garcia@seguros.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ 3 usuarios creados exitosamente');
        $this->command->info('');
        $this->command->info('🔐 CREDENCIALES DE ACCESO:');
        $this->command->info('   Admin:');
        $this->command->info('   • Email: admin@seguros.com');
        $this->command->info('   • Password: password');
        $this->command->info('');
        $this->command->info('   Agentes:');
        $this->command->info('   • Email: juan.perez@seguros.com');
        $this->command->info('   • Email: maria.garcia@seguros.com');
        $this->command->info('   • Password: password');
        $this->command->info('');
        $this->command->info('════════════════════════════════════════════════════════════');
        $this->command->info('✅ USUARIOS LISTOS');
        $this->command->info('════════════════════════════════════════════════════════════');
        $this->command->info('');
    }
}