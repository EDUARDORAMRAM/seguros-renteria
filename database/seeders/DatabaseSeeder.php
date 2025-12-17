<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Compania;
use App\Models\Asegurado;
use App\Models\Unidad;
use App\Models\Poliza;
use App\Models\Endoso;
use App\Models\FechaCobranza;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('════════════════════════════════════════════════════════════');
        $this->command->info('🚀 SISTEMA DE GESTIÓN DE SEGUROS - SEEDER PROFESIONAL');
        $this->command->info('════════════════════════════════════════════════════════════');
        $this->command->info('');

        // ═══════════════════════════════════════════════════════════
        // 1. USUARIOS
        // ═══════════════════════════════════════════════════════════
        $this->command->info('👤 Creando usuarios del sistema...');
        
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@seguros.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $agente1 = User::create([
            'name' => 'Juan Pérez Martínez',
            'email' => 'juan.perez@seguros.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $agente2 = User::create([
            'name' => 'María García López',
            'email' => 'maria.garcia@seguros.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $this->command->info('   ✓ 3 usuarios creados');

        // ═══════════════════════════════════════════════════════════
        // 2. COMPAÑÍAS ASEGURADORAS (CON MÚLTIPLES COBERTURAS)
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
        $this->command->info('   ✓ ' . Compania::distinct('Nombre')->count() . ' compañías únicas');

        // ═══════════════════════════════════════════════════════════
        // 3. ASEGURADOS
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
        // 4. UNIDADES (VEHÍCULOS)
        // ═══════════════════════════════════════════════════════════
        $this->command->info('🚗 Creando unidades...');
        
        $unidades = [
            // Nissan
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
            [
                'VIN' => '3N1AB8CV9LY234567',
                'TipoUnidad' => 'Automóvil',
                'Marca' => 'Nissan',
                'Submarca' => 'Sentra',
                'Anio' => 2024,
                'NoSerie' => 'NS2024-002',
                'Motor' => 'MR20DD',
                'Placas' => 'DEF-456-B',
                'Color' => 'Gris Oscuro',
                'Uso' => 'Particular',
            ],
            // Volkswagen
            [
                'VIN' => '3VWFB7AT9GM123789',
                'TipoUnidad' => 'Automóvil',
                'Marca' => 'Volkswagen',
                'Submarca' => 'Jetta',
                'Anio' => 2023,
                'NoSerie' => 'VW2023-003',
                'Motor' => 'EA211',
                'Placas' => 'XYZ-789-C',
                'Color' => 'Gris Platino',
                'Uso' => 'Ejecutivo',
            ],
            [
                'VIN' => '3VW5T7AJ8LM345678',
                'TipoUnidad' => 'SUV',
                'Marca' => 'Volkswagen',
                'Submarca' => 'Tiguan',
                'Anio' => 2024,
                'NoSerie' => 'VT2024-004',
                'Motor' => 'EA888',
                'Placas' => 'GHI-012-D',
                'Color' => 'Azul Metalizado',
                'Uso' => 'Familiar',
            ],
            // Honda
            [
                'VIN' => '1HGCR2F3XFA123456',
                'TipoUnidad' => 'Automóvil',
                'Marca' => 'Honda',
                'Submarca' => 'Accord',
                'Anio' => 2023,
                'NoSerie' => 'HD2023-005',
                'Motor' => 'K24Z3',
                'Placas' => 'JKL-345-E',
                'Color' => 'Negro',
                'Uso' => 'Ejecutivo',
            ],
            [
                'VIN' => '2HKRM4H78MH456789',
                'TipoUnidad' => 'SUV',
                'Marca' => 'Honda',
                'Submarca' => 'CR-V',
                'Anio' => 2024,
                'NoSerie' => 'HC2024-006',
                'Motor' => 'L15B7',
                'Placas' => 'MNO-678-F',
                'Color' => 'Rojo Intenso',
                'Uso' => 'Familiar',
            ],
            // Hyundai
            [
                'VIN' => '5XYKT3A69CG123456',
                'TipoUnidad' => 'SUV',
                'Marca' => 'Hyundai',
                'Submarca' => 'Santa Fe',
                'Anio' => 2023,
                'NoSerie' => 'HY2023-007',
                'Motor' => 'G4KE',
                'Placas' => 'PQR-901-G',
                'Color' => 'Blanco Perla',
                'Uso' => 'Familiar',
            ],
            // Mazda
            [
                'VIN' => '3MYDLBYV8KY123456',
                'TipoUnidad' => 'Automóvil',
                'Marca' => 'Mazda',
                'Submarca' => 'Mazda3',
                'Anio' => 2023,
                'NoSerie' => 'MZ2023-008',
                'Motor' => 'SKYACTIV-G',
                'Placas' => 'STU-234-H',
                'Color' => 'Azul Marino',
                'Uso' => 'Particular',
            ],
            [
                'VIN' => 'JM3KFBDM8L0567890',
                'TipoUnidad' => 'SUV',
                'Marca' => 'Mazda',
                'Submarca' => 'CX-5',
                'Anio' => 2024,
                'NoSerie' => 'MC2024-009',
                'Motor' => 'SKYACTIV-G 2.5',
                'Placas' => 'VWX-567-I',
                'Color' => 'Rojo Soul',
                'Uso' => 'Ejecutivo',
            ],
            // Ford
            [
                'VIN' => '1FMCU0GD9KUA12345',
                'TipoUnidad' => 'SUV',
                'Marca' => 'Ford',
                'Submarca' => 'Escape',
                'Anio' => 2023,
                'NoSerie' => 'FD2023-010',
                'Motor' => 'EcoBoost',
                'Placas' => 'YZA-890-J',
                'Color' => 'Plata',
                'Uso' => 'Familiar',
            ],
            // Toyota
            [
                'VIN' => '5TDDKRFH0HS123456',
                'TipoUnidad' => 'SUV',
                'Marca' => 'Toyota',
                'Submarca' => 'Highlander',
                'Anio' => 2024,
                'NoSerie' => 'TY2024-011',
                'Motor' => '2GR-FKS',
                'Placas' => 'BCD-123-K',
                'Color' => 'Blanco Perla',
                'Uso' => 'Ejecutivo',
            ],
            [
                'VIN' => '4T1B11HK8KU678901',
                'TipoUnidad' => 'Automóvil',
                'Marca' => 'Toyota',
                'Submarca' => 'Camry',
                'Anio' => 2023,
                'NoSerie' => 'TC2023-012',
                'Motor' => '2AR-FE',
                'Placas' => 'EFG-456-L',
                'Color' => 'Gris Metalizado',
                'Uso' => 'Ejecutivo',
            ],
            // Chevrolet
            [
                'VIN' => '3GNAXKEV9LL234567',
                'TipoUnidad' => 'SUV',
                'Marca' => 'Chevrolet',
                'Submarca' => 'Equinox',
                'Anio' => 2024,
                'NoSerie' => 'CE2024-013',
                'Motor' => 'Turbo 1.5L',
                'Placas' => 'HIJ-789-M',
                'Color' => 'Negro',
                'Uso' => 'Familiar',
            ],
            // KIA
            [
                'VIN' => '5XYP5DHC5KG345678',
                'TipoUnidad' => 'SUV',
                'Marca' => 'KIA',
                'Submarca' => 'Sportage',
                'Anio' => 2023,
                'NoSerie' => 'KS2023-014',
                'Motor' => 'Smartstream',
                'Placas' => 'KLM-012-N',
                'Color' => 'Azul Profundo',
                'Uso' => 'Particular',
            ],
            // Mercedes-Benz
            [
                'VIN' => 'WDDSJ4EB5JN456789',
                'TipoUnidad' => 'Automóvil',
                'Marca' => 'Mercedes-Benz',
                'Submarca' => 'Clase C',
                'Anio' => 2023,
                'NoSerie' => 'MB2023-015',
                'Motor' => 'M264',
                'Placas' => 'NOP-345-O',
                'Color' => 'Negro Obsidiana',
                'Uso' => 'Ejecutivo',
            ],
        ];

        foreach ($unidades as $unidad) {
            Unidad::create($unidad);
        }

        $this->command->info('   ✓ ' . count($unidades) . ' unidades creadas');

        // ═══════════════════════════════════════════════════════════
        // 5. PÓLIZAS CON ESCENARIOS REALISTAS
        // ═══════════════════════════════════════════════════════════
        $this->command->info('📋 Creando pólizas con diferentes escenarios...');
        
        $formasPago = ['Anual', 'Semestral', 'Trimestral', 'Mensual'];
        $polizasCreadas = [];
        $numeroPoliza = 1;

        // ─────────────────────────────────────────────────────────
        // ESCENARIO 1: COBRANZAS CRÍTICAS (HOY y MAÑANA) - 3 pólizas
        // ─────────────────────────────────────────────────────────
        $this->command->info('   💰 Cobranzas críticas (0-1 días)...');
        
        for ($i = 0; $i < 3; $i++) {
            $formaPago = $formasPago[array_rand($formasPago)];
            $fechaInicio = now()->subMonths(rand(2, 6));
            
            // Calcular vencimiento coherente
            $mesesVencimiento = match($formaPago) {
                'Mensual' => 12,
                'Trimestral' => 12,
                'Semestral' => 12,
                'Anual' => 12,
            };
            $fechaVencimiento = (clone $fechaInicio)->addMonths($mesesVencimiento);

            $poliza = Poliza::create([
                'NumPoliza' => 'POL-' . str_pad($numeroPoliza++, 6, '0', STR_PAD_LEFT),
                'FormaPago' => $formaPago,
                'FechaInicio' => $fechaInicio,
                'FechaVencimiento' => $fechaVencimiento,
                'FechaCobranza' => null, // Se calculará con fechas_cobranza
                'Prima' => rand(8000, 20000) + (rand(0, 99) / 100),
                'Estatus' => 'Activa',
                'IdCompania' => rand(1, Compania::count()),
                'IdUnidad' => rand(1, Unidad::count()),
                'IdAsegurado' => rand(1, Asegurado::count()),
            ]);
            
            // Generar fechas de cobranza
            $poliza->generarFechasCobranza();
            
            // Modificar una fecha para que sea HOY o MAÑANA
            $primeraCobranza = $poliza->fechasCobranza()->pendientes()->first();
            if ($primeraCobranza) {
                $primeraCobranza->update(['FechaCobranza' => now()->addDays($i === 0 ? 0 : 1)]);
            }
            
            $polizasCreadas[] = $poliza;
        }

        // ─────────────────────────────────────────────────────────
        // ESCENARIO 2: COBRANZAS PRÓXIMAS (2-7 días) - 5 pólizas
        // ─────────────────────────────────────────────────────────
        $this->command->info('   ⏰ Cobranzas próximas (2-7 días)...');
        
        for ($i = 0; $i < 5; $i++) {
            $formaPago = $formasPago[array_rand($formasPago)];
            $fechaInicio = now()->subMonths(rand(2, 6));
            
            $mesesVencimiento = match($formaPago) {
                'Mensual' => 12,
                'Trimestral' => 12,
                'Semestral' => 12,
                'Anual' => 12,
            };
            $fechaVencimiento = (clone $fechaInicio)->addMonths($mesesVencimiento);

            $poliza = Poliza::create([
                'NumPoliza' => 'POL-' . str_pad($numeroPoliza++, 6, '0', STR_PAD_LEFT),
                'FormaPago' => $formaPago,
                'FechaInicio' => $fechaInicio,
                'FechaVencimiento' => $fechaVencimiento,
                'FechaCobranza' => null,
                'Prima' => rand(8000, 20000) + (rand(0, 99) / 100),
                'Estatus' => 'Activa',
                'IdCompania' => rand(1, Compania::count()),
                'IdUnidad' => rand(1, Unidad::count()),
                'IdAsegurado' => rand(1, Asegurado::count()),
            ]);
            
            $poliza->generarFechasCobranza();
            
            // Modificar primera fecha de cobranza pendiente
            $primeraCobranza = $poliza->fechasCobranza()->pendientes()->first();
            if ($primeraCobranza) {
                $primeraCobranza->update(['FechaCobranza' => now()->addDays(rand(2, 7))]);
            }
            
            $polizasCreadas[] = $poliza;
        }

        // ─────────────────────────────────────────────────────────
        // ESCENARIO 3: PÓLIZAS PRÓXIMAS A VENCER (1-30 días) - 5 pólizas
        // ─────────────────────────────────────────────────────────
        $this->command->info('   ⚠️  Pólizas próximas a vencer (1-30 días)...');
        
        for ($i = 0; $i < 5; $i++) {
            $formaPago = $formasPago[array_rand($formasPago)];
            $diasParaVencer = rand(1, 30);
            $fechaVencimiento = now()->addDays($diasParaVencer);
            $fechaInicio = (clone $fechaVencimiento)->subYear();

            $poliza = Poliza::create([
                'NumPoliza' => 'POL-' . str_pad($numeroPoliza++, 6, '0', STR_PAD_LEFT),
                'FormaPago' => $formaPago,
                'FechaInicio' => $fechaInicio,
                'FechaVencimiento' => $fechaVencimiento,
                'FechaCobranza' => null,
                'Prima' => rand(8000, 20000) + (rand(0, 99) / 100),
                'Estatus' => 'Activa',
                'IdCompania' => rand(1, Compania::count()),
                'IdUnidad' => rand(1, Unidad::count()),
                'IdAsegurado' => rand(1, Asegurado::count()),
            ]);
            
            $poliza->generarFechasCobranza();
            $polizasCreadas[] = $poliza;
        }

        // ─────────────────────────────────────────────────────────
        // ESCENARIO 4: PÓLIZAS ACTIVAS NORMALES - 15 pólizas
        // ─────────────────────────────────────────────────────────
        $this->command->info('   ✅ Pólizas activas normales...');
        
        for ($i = 0; $i < 15; $i++) {
            $formaPago = $formasPago[array_rand($formasPago)];
            $fechaInicio = now()->subMonths(rand(1, 6));
            
            $mesesVencimiento = match($formaPago) {
                'Mensual' => 12,
                'Trimestral' => 12,
                'Semestral' => 12,
                'Anual' => 12,
            };
            $fechaVencimiento = (clone $fechaInicio)->addMonths($mesesVencimiento);

            $poliza = Poliza::create([
                'NumPoliza' => 'POL-' . str_pad($numeroPoliza++, 6, '0', STR_PAD_LEFT),
                'FormaPago' => $formaPago,
                'FechaInicio' => $fechaInicio,
                'FechaVencimiento' => $fechaVencimiento,
                'FechaCobranza' => null,
                'Prima' => rand(8000, 20000) + (rand(0, 99) / 100),
                'Estatus' => 'Activa',
                'IdCompania' => rand(1, Compania::count()),
                'IdUnidad' => rand(1, Unidad::count()),
                'IdAsegurado' => rand(1, Asegurado::count()),
            ]);
            
            $poliza->generarFechasCobranza();
            $polizasCreadas[] = $poliza;
        }

        // ─────────────────────────────────────────────────────────
        // ESCENARIO 5: PÓLIZAS TRIMESTRALES - 8 pólizas
        // ─────────────────────────────────────────────────────────
        $this->command->info('   📅 Pólizas trimestrales...');
        
        for ($i = 0; $i < 8; $i++) {
            $fechaInicio = now()->subMonths(rand(1, 3));
            $fechaVencimiento = (clone $fechaInicio)->addYear();

            $poliza = Poliza::create([
                'NumPoliza' => 'POL-' . str_pad($numeroPoliza++, 6, '0', STR_PAD_LEFT),
                'FormaPago' => 'Trimestral',
                'FechaInicio' => $fechaInicio,
                'FechaVencimiento' => $fechaVencimiento,
                'FechaCobranza' => null,
                'Prima' => rand(8000, 15000) + (rand(0, 99) / 100),
                'Estatus' => 'Activa',
                'IdCompania' => rand(1, Compania::count()),
                'IdUnidad' => rand(1, Unidad::count()),
                'IdAsegurado' => rand(1, Asegurado::count()),
            ]);
            
            $poliza->generarFechasCobranza();
            $polizasCreadas[] = $poliza;
        }

        // ─────────────────────────────────────────────────────────
        // ESCENARIO 6: PÓLIZAS MENSUALES (12 pagos) - 5 pólizas
        // ─────────────────────────────────────────────────────────
        $this->command->info('   📆 Pólizas mensuales (12 pagos)...');
        
        for ($i = 0; $i < 5; $i++) {
            $fechaInicio = now()->subMonths(rand(2, 5));
            $fechaVencimiento = (clone $fechaInicio)->addYear();

            $poliza = Poliza::create([
                'NumPoliza' => 'POL-' . str_pad($numeroPoliza++, 6, '0', STR_PAD_LEFT),
                'FormaPago' => 'Mensual',
                'FechaInicio' => $fechaInicio,
                'FechaVencimiento' => $fechaVencimiento,
                'FechaCobranza' => null,
                'Prima' => rand(12000, 24000) + (rand(0, 99) / 100),
                'Estatus' => 'Activa',
                'IdCompania' => rand(1, Compania::count()),
                'IdUnidad' => rand(1, Unidad::count()),
                'IdAsegurado' => rand(1, Asegurado::count()),
            ]);
            
            $poliza->generarFechasCobranza();
            
            // Marcar algunas cobranzas como pagadas
            $cobranzasPagadas = $poliza->fechasCobranza()
                ->where('FechaCobranza', '<', now())
                ->take(rand(2, 4))
                ->get();
                
            foreach ($cobranzasPagadas as $cobranza) {
                $cobranza->marcarComoPagado($cobranza->FechaCobranza->addDays(rand(0, 5)));
            }
            
            $polizasCreadas[] = $poliza;
        }

        // ─────────────────────────────────────────────────────────
        // ESCENARIO 7: PÓLIZAS VENCIDAS - 6 pólizas
        // ─────────────────────────────────────────────────────────
        $this->command->info('   ❌ Pólizas vencidas...');
        
        for ($i = 0; $i < 6; $i++) {
            $formaPago = $formasPago[array_rand($formasPago)];
            $fechaVencimiento = now()->subDays(rand(1, 90));
            $fechaInicio = (clone $fechaVencimiento)->subYear();

            $poliza = Poliza::create([
                'NumPoliza' => 'POL-' . str_pad($numeroPoliza++, 6, '0', STR_PAD_LEFT),
                'FormaPago' => $formaPago,
                'FechaInicio' => $fechaInicio,
                'FechaVencimiento' => $fechaVencimiento,
                'FechaCobranza' => null,
                'Prima' => rand(8000, 20000) + (rand(0, 99) / 100),
                'Estatus' => 'Vencida',
                'IdCompania' => rand(1, Compania::count()),
                'IdUnidad' => rand(1, Unidad::count()),
                'IdAsegurado' => rand(1, Asegurado::count()),
            ]);
            
            $poliza->generarFechasCobranza();
            $polizasCreadas[] = $poliza;
        }

        // ─────────────────────────────────────────────────────────
        // ESCENARIO 8: PÓLIZAS CANCELADAS - 3 pólizas
        // ─────────────────────────────────────────────────────────
        $this->command->info('   🚫 Pólizas canceladas...');
        
        for ($i = 0; $i < 3; $i++) {
            $formaPago = $formasPago[array_rand($formasPago)];
            $fechaInicio = now()->subMonths(rand(3, 8));
            $fechaVencimiento = (clone $fechaInicio)->addYear();

            $poliza = Poliza::create([
                'NumPoliza' => 'POL-' . str_pad($numeroPoliza++, 6, '0', STR_PAD_LEFT),
                'FormaPago' => $formaPago,
                'FechaInicio' => $fechaInicio,
                'FechaVencimiento' => $fechaVencimiento,
                'FechaCobranza' => null,
                'Prima' => rand(8000, 20000) + (rand(0, 99) / 100),
                'Estatus' => 'Cancelada',
                'IdCompania' => rand(1, Compania::count()),
                'IdUnidad' => rand(1, Unidad::count()),
                'IdAsegurado' => rand(1, Asegurado::count()),
            ]);
            
            $poliza->generarFechasCobranza();
            $polizasCreadas[] = $poliza;
        }

        $this->command->info('   ✓ ' . count($polizasCreadas) . ' pólizas creadas');

        // ═══════════════════════════════════════════════════════════
        // 6. ENDOSOS (para pólizas activas)
        // ═══════════════════════════════════════════════════════════
        $this->command->info('📝 Creando endosos...');
        
        $tiposEndoso = [
            'Modificacion',
            'Renovacion',
            'Cancelacion',
            'Cambio Suma Asegurada',
            'Cambio Beneficiario',
            'Cambio Unidad',
            'Otro'
        ];

        $endososCreados = 0;
        $polizasConEndosos = array_slice($polizasCreadas, 0, 15); // Primeras 15 pólizas

        foreach ($polizasConEndosos as $poliza) {
            if ($poliza->Estatus === 'Activa') {
                $numEndosos = rand(1, 3);
                
                for ($j = 1; $j <= $numEndosos; $j++) {
                    Endoso::create([
                        'IdPoliza' => $poliza->IdPoliza,
                        'NumEndoso' => Endoso::generarNumero(),
                        'FechaEndoso' => now()->subDays(rand(1, 180)),
                        'TipoEndoso' => $tiposEndoso[array_rand($tiposEndoso)],
                        'Descripcion' => 'Endoso de ' . $tiposEndoso[array_rand($tiposEndoso)] . ' aplicado a la póliza ' . $poliza->NumPoliza . '. Cambio solicitado por el cliente.',
                        'MontoAfectado' => rand(-2000, 5000) + (rand(0, 99) / 100),
                        'user_id' => rand(1, 3),
                    ]);
                    $endososCreados++;
                }
            }
        }

        $this->command->info('   ✓ ' . $endososCreados . ' endosos creados');

        // ═══════════════════════════════════════════════════════════
        // RESUMEN FINAL
        // ═══════════════════════════════════════════════════════════
        $this->command->info('');
        $this->command->info('════════════════════════════════════════════════════════════');
        $this->command->info('✅ ¡BASE DE DATOS POBLADA EXITOSAMENTE!');
        $this->command->info('════════════════════════════════════════════════════════════');
        $this->command->info('');
        
        // Credenciales
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
        
        // Estadísticas
        $this->command->info('📊 ESTADÍSTICAS DEL SISTEMA:');
        $this->command->info('   👤 Usuarios: ' . User::count());
        $this->command->info('   🏢 Compañías: ' . Compania::count() . ' combinaciones (' . Compania::distinct('Nombre')->count() . ' únicas)');
        $this->command->info('   👥 Asegurados: ' . Asegurado::count());
        $this->command->info('   🚗 Unidades: ' . Unidad::count());
        $this->command->info('   📋 Pólizas: ' . Poliza::count());
        $this->command->info('   📝 Endosos: ' . Endoso::count());
        $this->command->info('   💰 Fechas de Cobranza: ' . FechaCobranza::count());
        $this->command->info('');
        
        // Escenarios de prueba
        $this->command->info('🎯 ESCENARIOS DE PRUEBA CREADOS:');
        $this->command->info('   💰 Cobranzas críticas (0-1 días): ' . 
            FechaCobranza::proximas(1)->count() . ' pagos');
        $this->command->info('   ⏰ Cobranzas próximas (2-7 días): ' . 
            FechaCobranza::proximas(7)->count() . ' pagos');
        $this->command->info('   ⚠️  Pólizas próximas a vencer (30 días): ' .
            Poliza::proximasAVencer(30)->count());
        $this->command->info('   ✅ Pólizas activas: ' . 
            Poliza::where('Estatus', 'Activa')->count());
        $this->command->info('   📅 Pólizas trimestrales: ' . 
            Poliza::where('FormaPago', 'Trimestral')->count());
        $this->command->info('   📆 Pólizas mensuales: ' . 
            Poliza::where('FormaPago', 'Mensual')->count());
        $this->command->info('   ❌ Pólizas vencidas: ' . 
            Poliza::where('Estatus', 'Vencida')->count());
        $this->command->info('   🚫 Pólizas canceladas: ' . 
            Poliza::where('Estatus', 'Cancelada')->count());
        $this->command->info('');
        
        // Compañías con múltiples coberturas
        $this->command->info('🏢 COMPAÑÍAS CON MÚLTIPLES COBERTURAS:');
        $companiasPorNombre = Compania::select('Nombre')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('Nombre')
            ->having('total', '>', 1)
            ->get();
            
        foreach ($companiasPorNombre as $comp) {
            $coberturas = Compania::where('Nombre', $comp->Nombre)->pluck('Cobertura')->toArray();
            $this->command->info('   • ' . $comp->Nombre . ': ' . implode(', ', $coberturas));
        }
        
        $this->command->info('');
        $this->command->info('════════════════════════════════════════════════════════════');
        $this->command->info('🚀 ¡SISTEMA LISTO PARA USAR!');
        $this->command->info('════════════════════════════════════════════════════════════');
        $this->command->info('');
    }
}