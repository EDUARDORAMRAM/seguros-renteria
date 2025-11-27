<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Compania;
use App\Models\Asegurado;
use App\Models\Unidad;
use App\Models\Poliza;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@seguros.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Crear usuario agente
        User::create([
            'name' => 'Juan Pérez',
            'email' => 'agente@seguros.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Crear Compañías Aseguradoras
        $companias = [
            ['Nombre' => 'GNP Seguros', 'Cobertura' => 'Amplia Plus'],
            ['Nombre' => 'Qualitas', 'Cobertura' => 'Amplia'],
            ['Nombre' => 'AXA Seguros', 'Cobertura' => 'Limitada'],
            ['Nombre' => 'MAPFRE', 'Cobertura' => 'Responsabilidad Civil'],
            ['Nombre' => 'HDI Seguros', 'Cobertura' => 'Amplia'],
            ['Nombre' => 'Banorte Seguros', 'Cobertura' => 'Amplia Plus'],
            ['Nombre' => 'Zurich', 'Cobertura' => 'Limitada'],
        ];

        foreach ($companias as $compania) {
            Compania::create($compania);
        }

        // Crear Asegurados
        $asegurados = [
            [
                'Nombre' => 'Carlos',
                'ApellidoPaterno' => 'García',
                'ApellidoMaterno' => 'López',
                'Telefono' => '4421234567',
                'Email' => 'carlos.garcia@email.com',
                'RFC' => 'GALC850101ABC',
                'Referencia' => 'Cliente recomendado',
            ],
            [
                'Nombre' => 'María',
                'ApellidoPaterno' => 'Martínez',
                'ApellidoMaterno' => 'Sánchez',
                'Telefono' => '4427654321',
                'Email' => 'maria.martinez@email.com',
                'RFC' => 'MAMS900215XYZ',
                'Referencia' => 'Cliente referido',
            ],
            [
                'Nombre' => 'José',
                'ApellidoPaterno' => 'Rodríguez',
                'ApellidoMaterno' => 'Hernández',
                'Telefono' => '4429876543',
                'Email' => 'jose.rodriguez@email.com',
                'RFC' => 'ROHJ920305DEF',
                'Referencia' => null,
            ],
            [
                'Nombre' => 'Ana',
                'ApellidoPaterno' => 'Fernández',
                'ApellidoMaterno' => 'Torres',
                'Telefono' => '4423456789',
                'Email' => 'ana.fernandez@email.com',
                'RFC' => 'FETA880520GHI',
                'Referencia' => 'Cliente antiguo',
            ],
            [
                'Nombre' => 'Luis',
                'ApellidoPaterno' => 'González',
                'ApellidoMaterno' => 'Ramírez',
                'Telefono' => '4425678901',
                'Email' => 'luis.gonzalez@email.com',
                'RFC' => 'GORL910815JKL',
                'Referencia' => null,
            ],
        ];

        foreach ($asegurados as $asegurado) {
            Asegurado::create($asegurado);
        }

        // Crear Unidades (Vehículos)
        $unidades = [
            [
                'VIN' => '3N1AB7AP5HY123456',
                'TipoUnidad' => 'Automóvil',
                'Marca' => 'Nissan',
                'Submarca' => 'Versa',
                'Anio' => 2022,
                'NoSerie' => 'NV2022-001',
                'Motor' => 'HR16DE',
                'Placas' => 'ABC-123-A',
                'Color' => 'Blanco',
                'Uso' => 'Particular',
            ],
            [
                'VIN' => '3VWFB7AT9GM123789',
                'TipoUnidad' => 'Automóvil',
                'Marca' => 'Volkswagen',
                'Submarca' => 'Jetta',
                'Anio' => 2021,
                'NoSerie' => 'VW2021-002',
                'Motor' => 'EA211',
                'Placas' => 'XYZ-456-B',
                'Color' => 'Gris',
                'Uso' => 'Particular',
            ],
            [
                'VIN' => '1HGCR2F3XFA123456',
                'TipoUnidad' => 'Automóvil',
                'Marca' => 'Honda',
                'Submarca' => 'Accord',
                'Anio' => 2023,
                'NoSerie' => 'HD2023-003',
                'Motor' => 'K24Z3',
                'Placas' => 'DEF-789-C',
                'Color' => 'Negro',
                'Uso' => 'Ejecutivo',
            ],
            [
                'VIN' => '5XYKT3A69CG123456',
                'TipoUnidad' => 'SUV',
                'Marca' => 'Hyundai',
                'Submarca' => 'Santa Fe',
                'Anio' => 2020,
                'NoSerie' => 'HY2020-004',
                'Motor' => 'G4KE',
                'Placas' => 'GHI-012-D',
                'Color' => 'Rojo',
                'Uso' => 'Familiar',
            ],
            [
                'VIN' => '3MYDLBYV8KY123456',
                'TipoUnidad' => 'Automóvil',
                'Marca' => 'Mazda',
                'Submarca' => 'Mazda3',
                'Anio' => 2021,
                'NoSerie' => 'MZ2021-005',
                'Motor' => 'SKYACTIV-G',
                'Placas' => 'JKL-345-E',
                'Color' => 'Azul',
                'Uso' => 'Particular',
            ],
        ];

        foreach ($unidades as $unidad) {
            Unidad::create($unidad);
        }

        // Crear Pólizas
        $formasPago = ['Anual', 'Semestral', 'Mensual'];
        $estatuses = ['Activa', 'Activa', 'Activa', 'Vencida'];

        for ($i = 1; $i <= 20; $i++) {
            $fechaInicio = now()->subMonths(rand(0, 24));
            $fechaVencimiento = (clone $fechaInicio)->addYear();
            
            // Algunas pólizas próximas a vencer
            if ($i <= 5) {
                $fechaVencimiento = now()->addDays(rand(1, 30));
                $estatus = 'Activa';
            } else {
                $estatus = $estatuses[array_rand($estatuses)];
            }

            Poliza::create([
                'NumPoliza' => 'POL-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'FormaPago' => $formasPago[array_rand($formasPago)],
                'FechaInicio' => $fechaInicio,
                'FechaVencimiento' => $fechaVencimiento,
                'Prima' => rand(5000, 15000) + (rand(0, 99) / 100),
                'Estatus' => $estatus,
                'IdCompania' => rand(1, 7),
                'IdUnidad' => rand(1, 5),
                'IdAsegurado' => rand(1, 5),
            ]);
        }

        $this->command->info('Base de datos poblada exitosamente!');
        $this->command->info('Usuario Admin: admin@seguros.com');
        $this->command->info('Usuario Agente: agente@seguros.com');
        $this->command->info('Contraseña: password');
    }
}