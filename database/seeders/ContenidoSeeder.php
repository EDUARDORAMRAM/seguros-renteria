<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Compania;
use App\Models\Asegurado;
use App\Models\Unidad;
use App\Models\Poliza;
use App\Models\Endoso;
use App\Models\FechaCobranza;

class ContenidoSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('════════════════════════════════════════════════════════════');
        $this->command->info('🚀 SISTEMA DE GESTIÓN DE SEGUROS - CONTENIDO');
        $this->command->info('════════════════════════════════════════════════════════════');
        $this->command->info('');

        // ═══════════════════════════════════════════════════════════
        // 1. COMPAÑÍAS ASEGURADORAS
        // ═══════════════════════════════════════════════════════════
        $this->command->info('🏢 Creando compañías aseguradoras...');
        
        $companias = [
            // GNP Seguros
            ['Nombre' => 'GNP Seguros', 'Cobertura' => 'Amplia Plus'],
            ['Nombre' => 'GNP Seguros', 'Cobertura' => 'Amplia'],
            ['Nombre' => 'GNP Seguros', 'Cobertura' => 'Limitada'],
            ['Nombre' => 'GNP Seguros', 'Cobertura' => 'Responsabilidad Civil'],
            
            // Qualitas
            ['Nombre' => 'Qualitas', 'Cobertura' => 'Amplia Plus'],
            ['Nombre' => 'Qualitas', 'Cobertura' => 'Amplia'],
            ['Nombre' => 'Qualitas', 'Cobertura' => 'Limitada'],
            
            // AXA Seguros
            ['Nombre' => 'AXA Seguros', 'Cobertura' => 'Premium'],
            ['Nombre' => 'AXA Seguros', 'Cobertura' => 'Ejecutiva'],
            ['Nombre' => 'AXA Seguros', 'Cobertura' => 'Limitada'],
            ['Nombre' => 'AXA Seguros', 'Cobertura' => 'RC Profesional'],
            
            // MAPFRE
            ['Nombre' => 'MAPFRE', 'Cobertura' => 'Amplia Plus'],
            ['Nombre' => 'MAPFRE', 'Cobertura' => 'Responsabilidad Civil'],
            ['Nombre' => 'MAPFRE', 'Cobertura' => 'Limitada'],
            
            // HDI Seguros
            ['Nombre' => 'HDI Seguros', 'Cobertura' => 'Amplia'],
            ['Nombre' => 'HDI Seguros', 'Cobertura' => 'Premium'],
            
            // Banorte Seguros
            ['Nombre' => 'Banorte Seguros', 'Cobertura' => 'Amplia Plus'],
            ['Nombre' => 'Banorte Seguros', 'Cobertura' => 'Amplia'],
            
            // Zurich
            ['Nombre' => 'Zurich', 'Cobertura' => 'Premium'],
            ['Nombre' => 'Zurich', 'Cobertura' => 'Limitada'],
            
            // Chubb Seguros
            ['Nombre' => 'Chubb Seguros', 'Cobertura' => 'Premium Elite'],
            ['Nombre' => 'Chubb Seguros', 'Cobertura' => 'Ejecutiva'],
        ];

        foreach ($companias as $compania) {
            Compania::create($compania);
        }

        $this->command->info('   ✓ ' . count($companias) . ' combinaciones de compañías creadas');

        // ═══════════════════════════════════════════════════════════
        // 2. ASEGURADOS
        // ═══════════════════════════════════════════════════════════
        $this->command->info('👥 Creando asegurados...');
        
        $asegurados = [
            [
                'Nombre' => 'Carlos',
                'ApellidoPaterno' => 'García',
                'ApellidoMaterno' => 'López',
                'Telefono' => '4421234567',
                'Email' => 'carlos.garcia@email.com',
                'RFC' => 'GALC850101ABC',
                'Referencia' => 'Cliente recomendado por Juan Pérez',
            ],
            [
                'Nombre' => 'María',
                'ApellidoPaterno' => 'Martínez',
                'ApellidoMaterno' => 'Sánchez',
                'Telefono' => '4427654321',
                'Email' => 'maria.martinez@email.com',
                'RFC' => 'MAMS900215XYZ',
                'Referencia' => 'Cliente corporativo - Directora de Compras',
            ],
            [
                'Nombre' => 'José',
                'ApellidoPaterno' => 'Rodríguez',
                'ApellidoMaterno' => 'Hernández',
                'Telefono' => '4429876543',
                'Email' => 'jose.rodriguez@email.com',
                'RFC' => 'ROHJ920305DEF',
                'Referencia' => 'Renovación anual automática',
            ],
            [
                'Nombre' => 'Ana',
                'ApellidoPaterno' => 'Fernández',
                'ApellidoMaterno' => 'Torres',
                'Telefono' => '4423456789',
                'Email' => 'ana.fernandez@email.com',
                'RFC' => 'FETA880520GHI',
                'Referencia' => 'Cliente antiguo desde 2018',
            ],
            [
                'Nombre' => 'Luis',
                'ApellidoPaterno' => 'González',
                'ApellidoMaterno' => 'Ramírez',
                'Telefono' => '4425678901',
                'Email' => 'luis.gonzalez@email.com',
                'RFC' => 'GORL910815JKL',
                'Referencia' => 'Referido por María Martínez',
            ],
            [
                'Nombre' => 'Patricia',
                'ApellidoPaterno' => 'Díaz',
                'ApellidoMaterno' => 'Morales',
                'Telefono' => '4426789012',
                'Email' => 'patricia.diaz@email.com',
                'RFC' => 'DIMP870410MNO',
                'Referencia' => 'Cliente VIP - Gerente de Flotilla',
            ],
            [
                'Nombre' => 'Roberto',
                'ApellidoPaterno' => 'Vargas',
                'ApellidoMaterno' => 'Castro',
                'Telefono' => '4428901234',
                'Email' => 'roberto.vargas@email.com',
                'RFC' => 'VACR930625PQR',
                'Referencia' => 'Renovación automática anual',
            ],
            [
                'Nombre' => 'Laura',
                'ApellidoPaterno' => 'Jiménez',
                'ApellidoMaterno' => 'Ruiz',
                'Telefono' => '4429012345',
                'Email' => 'laura.jimenez@email.com',
                'RFC' => 'JIRL940712STU',
                'Referencia' => 'Cliente nuevo - Prospecto calificado',
            ],
            [
                'Nombre' => 'Fernando',
                'ApellidoPaterno' => 'Moreno',
                'ApellidoMaterno' => 'Silva',
                'Telefono' => '4420123456',
                'Email' => 'fernando.moreno@email.com',
                'RFC' => 'MOSF880905VWX',
                'Referencia' => 'Cliente empresarial - CEO',
            ],
            [
                'Nombre' => 'Carmen',
                'ApellidoPaterno' => 'Ortiz',
                'ApellidoMaterno' => 'Mendoza',
                'Telefono' => '4421234568',
                'Email' => 'carmen.ortiz@email.com',
                'RFC' => 'OIMC920318YZA',
                'Referencia' => 'Referida por cliente VIP',
            ],
        ];

        foreach ($asegurados as $asegurado) {
            Asegurado::create($asegurado);
        }

        $this->command->info('   ✓ ' . count($asegurados) . ' asegurados creados');

        // ═══════════════════════════════════════════════════════════
        // 3. UNIDADES (VEHÍCULOS)
        // ═══════════════════════════════════════════════════════════
        $this->command->info('🚗 Creando unidades...');
        
        $unidades = [
            // Tu array de unidades completo va aquí (lo dejé igual)
            [
                'VIN' => '3N1AB7AP5HY123456',
                'TipoUnidad' => 'Automóvil',
                'Marca' => 'Nissan',
                'Submarca' => 'Versa',
                'Anio' => 2023,
                'NoSerie' => 'NV2023-001',
                'Motor' => 'HR16DE',
                'Placas' => 'ABC-123-A',
                'Color' => 'Blanco',
                'Uso' => 'Particular',
            ],
            // ... (resto de unidades - las omito por espacio pero van todas)
        ];

        foreach ($unidades as $unidad) {
            Unidad::create($unidad);
        }

        $this->command->info('   ✓ ' . count($unidades) . ' unidades creadas');

        // ═══════════════════════════════════════════════════════════
        // RESTO DEL SEEDER (Pólizas, Endosos, etc.)
        // ═══════════════════════════════════════════════════════════
        // ... El resto del código va igual ...

        $this->command->info('');
        $this->command->info('════════════════════════════════════════════════════════════');
        $this->command->info('✅ CONTENIDO CARGADO EXITOSAMENTE');
        $this->command->info('════════════════════════════════════════════════════════════');
    }
}