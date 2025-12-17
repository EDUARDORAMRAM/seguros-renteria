<?php

namespace App\Livewire\Importar;

use App\Models\Poliza;
use App\Models\Asegurado;
use App\Models\Compania;
use App\Models\Unidad;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImportarExcel extends Component
{
    use WithFileUploads;

    public $archivoPolizas;
    public $archivoClientes;
    public $archivoUnidades;
    public $archivoCompanias;
    
    public $importando = false;
    public $progresoPolizas = 0;
    public $progresoClientes = 0;
    public $progresoUnidades = 0;
    public $progresoCompanias = 0;
    
    public $resultados = [];

    protected $rules = [
        'archivoPolizas' => 'nullable|file|mimes:xlsx,xls,csv|max:10240',
        'archivoClientes' => 'nullable|file|mimes:xlsx,xls,csv|max:10240',
        'archivoUnidades' => 'nullable|file|mimes:xlsx,xls,csv|max:10240',
        'archivoCompanias' => 'nullable|file|mimes:xlsx,xls,csv|max:10240',
    ];

    public function importarCompanias()
    {
        $this->validate([
            'archivoCompanias' => 'required|file|mimes:xlsx,xls,csv|max:10240'
        ]);

        $this->importando = true;
        $this->progresoCompanias = 0;

        try {
            $data = Excel::toArray([], $this->archivoCompanias)[0];
            $total = count($data) - 1; // Menos el header
            $importados = 0;
            $errores = [];

            foreach (array_slice($data, 1) as $index => $row) {
                try {
                    Compania::create([
                        'Nombre' => $row[0] ?? '',
                        'Cobertura' => $row[1] ?? '',
                    ]);
                    $importados++;
                } catch (\Exception $e) {
                    $errores[] = "Fila " . ($index + 2) . ": " . $e->getMessage();
                }
                
                $this->progresoCompanias = round((($index + 1) / $total) * 100);
            }

            $this->resultados['companias'] = [
                'total' => $total,
                'importados' => $importados,
                'errores' => $errores
            ];

            session()->flash('message', "Compañías importadas: {$importados} de {$total}");
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al importar: ' . $e->getMessage());
        }

        $this->importando = false;
        $this->archivoCompanias = null;
    }

    public function importarClientes()
    {
        $this->validate([
            'archivoClientes' => 'required|file|mimes:xlsx,xls,csv|max:10240'
        ]);

        $this->importando = true;
        $this->progresoClientes = 0;

        try {
            $data = Excel::toArray([], $this->archivoClientes)[0];
            $total = count($data) - 1;
            $importados = 0;
            $errores = [];

            foreach (array_slice($data, 1) as $index => $row) {
                try {
                    Asegurado::create([
                        'Nombre' => $row[0] ?? '',
                        'ApellidoPaterno' => $row[1] ?? '',
                        'ApellidoMaterno' => $row[2] ?? '',
                        'Telefono' => $row[3] ?? '',
                        'Email' => $row[4] ?? '',
                        'RFC' => $row[5] ?? '',
                        'Referencia' => $row[6] ?? null,
                    ]);
                    $importados++;
                } catch (\Exception $e) {
                    $errores[] = "Fila " . ($index + 2) . ": " . $e->getMessage();
                }
                
                $this->progresoClientes = round((($index + 1) / $total) * 100);
            }

            $this->resultados['clientes'] = [
                'total' => $total,
                'importados' => $importados,
                'errores' => $errores
            ];

            session()->flash('message', "Clientes importados: {$importados} de {$total}");
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al importar: ' . $e->getMessage());
        }

        $this->importando = false;
        $this->archivoClientes = null;
    }

    public function importarUnidades()
    {
        $this->validate([
            'archivoUnidades' => 'required|file|mimes:xlsx,xls,csv|max:10240'
        ]);

        $this->importando = true;
        $this->progresoUnidades = 0;

        try {
            $data = Excel::toArray([], $this->archivoUnidades)[0];
            $total = count($data) - 1;
            $importados = 0;
            $errores = [];

            foreach (array_slice($data, 1) as $index => $row) {
                try {
                    Unidad::create([
                        'VIN' => $row[0] ?? '',
                        'TipoUnidad' => $row[1] ?? 'Automóvil',
                        'Marca' => $row[2] ?? '',
                        'Submarca' => $row[3] ?? '',
                        'Anio' => $row[4] ?? now()->year,
                        'NoSerie' => $row[5] ?? '',
                        'Motor' => $row[6] ?? '',
                        'Placas' => $row[7] ?? '',
                        'Color' => $row[8] ?? '',
                        'Uso' => $row[9] ?? 'Particular',
                    ]);
                    $importados++;
                } catch (\Exception $e) {
                    $errores[] = "Fila " . ($index + 2) . ": " . $e->getMessage();
                }
                
                $this->progresoUnidades = round((($index + 1) / $total) * 100);
            }

            $this->resultados['unidades'] = [
                'total' => $total,
                'importados' => $importados,
                'errores' => $errores
            ];

            session()->flash('message', "Unidades importadas: {$importados} de {$total}");
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al importar: ' . $e->getMessage());
        }

        $this->importando = false;
        $this->archivoUnidades = null;
    }

    public function importarPolizas()
{
    $this->validate([
        'archivoPolizas' => 'required|file|mimes:xlsx,xls,csv|max:10240'
    ]);

    $this->importando = true;
    $this->progresoPolizas = 0;

    try {
        $data = Excel::toArray([], $this->archivoPolizas)[0];
        $total = count($data) - 1;
        $importados = 0;
        $errores = [];

        foreach (array_slice($data, 1) as $index => $row) {
            try {
                // ═══════════════════════════════════════════════════════════
                // PASO 1: Buscar Compañía (Nombre + Cobertura)
                // ═══════════════════════════════════════════════════════════
                $compania = Compania::where('Nombre', $row[6] ?? '')
                    ->where('Cobertura', $row[7] ?? '')
                    ->first();
                
                if (!$compania) {
                    throw new \Exception("Compañía no encontrada: {$row[6]} - {$row[7]}");
                }

                // ═══════════════════════════════════════════════════════════
                // PASO 2: Buscar Asegurado por RFC
                // ═══════════════════════════════════════════════════════════
                $asegurado = Asegurado::where('RFC', $row[1] ?? '')->first();
                
                if (!$asegurado) {
                    throw new \Exception("Asegurado con RFC '{$row[1]}' no encontrado. Importa clientes primero.");
                }

                // ═══════════════════════════════════════════════════════════
                // PASO 3: Buscar Unidad por VIN o Placas
                // ═══════════════════════════════════════════════════════════
                $unidad = Unidad::where('VIN', $row[12] ?? '')
                    ->orWhere('Placas', $row[8] ?? '')
                    ->first();
                
                if (!$unidad) {
                    throw new \Exception("Unidad con VIN '{$row[12]}' o Placas '{$row[8]}' no encontrada. Importa unidades primero.");
                }

                // ═══════════════════════════════════════════════════════════
                // PASO 4: Parsear fechas (soporte múltiples formatos)
                // ═══════════════════════════════════════════════════════════
                $fechaInicio = $this->parsearFecha($row[14] ?? null);
                $fechaVencimiento = $this->parsearFecha($row[15] ?? null);
                
                if (!$fechaInicio || !$fechaVencimiento) {
                    throw new \Exception("Fechas inválidas. Formato esperado: DD/MM/YYYY o YYYY-MM-DD");
                }

                $formaPago = $row[13] ?? 'Anual';

                // ═══════════════════════════════════════════════════════════
                // PASO 5: VALIDAR COHERENCIA DE FECHAS
                // ═══════════════════════════════════════════════════════════
                $validacion = Poliza::validarCoherenciaFechas(
                    $fechaInicio,
                    $fechaVencimiento,
                    $formaPago
                );

                if (!$validacion['valido']) {
                    throw new \Exception($validacion['mensaje']);
                }

                // ═══════════════════════════════════════════════════════════
                // PASO 6: Crear Póliza
                // ═══════════════════════════════════════════════════════════
                $poliza = Poliza::create([
                    'NumPoliza' => $row[0] ?? '',
                    'FormaPago' => $formaPago,
                    'FechaInicio' => $fechaInicio,
                    'FechaVencimiento' => $fechaVencimiento,
                    'Prima' => floatval($row[16] ?? 0),
                    'Estatus' => $row[17] ?? 'Activa',
                    'IdCompania' => $compania->IdCompania,
                    'IdAsegurado' => $asegurado->IdAsegurado,
                    'IdUnidad' => $unidad->IdUnidad,
                ]);

                // ═══════════════════════════════════════════════════════════
                // PASO 7: ⭐ GENERAR FECHAS DE COBRANZA (CRÍTICO)
                // ═══════════════════════════════════════════════════════════
                $poliza->generarFechasCobranza();
                
                $importados++;
            } catch (\Exception $e) {
                $errores[] = "Fila " . ($index + 2) . ": " . $e->getMessage();
            }
            
            $this->progresoPolizas = round((($index + 1) / $total) * 100);
        }

        $this->resultados['polizas'] = [
            'total' => $total,
            'importados' => $importados,
            'errores' => $errores
        ];

        session()->flash('message', "Pólizas importadas: {$importados} de {$total} (con {$validacion['numeroPagos']} fechas de cobranza cada una)");
        
    } catch (\Exception $e) {
        session()->flash('error', 'Error al importar: ' . $e->getMessage());
    }

    $this->importando = false;
    $this->archivoPolizas = null;
}

// ═══════════════════════════════════════════════════════════
// MÉTODO AUXILIAR: Parsear fechas de Excel
// ═══════════════════════════════════════════════════════════
private function parsearFecha($fecha)
{
    if (!$fecha) {
        return null;
    }

    try {
        // Si es número (formato Excel serial date)
        if (is_numeric($fecha)) {
            // Excel fecha serial: días desde 1900-01-01
            // Convertir a timestamp Unix y luego a Carbon
            $unixTimestamp = ($fecha - 25569) * 86400; // 25569 = días entre 1900 y 1970
            return Carbon::createFromTimestamp($unixTimestamp)->startOfDay();
        }

        // Si es string, intentar múltiples formatos
        $formatos = ['d/m/Y', 'Y-m-d', 'd-m-Y', 'm/d/Y'];

        foreach ($formatos as $formato) {
            try {
                return Carbon::createFromFormat($formato, $fecha);
            } catch (\Exception $e) {
                continue;
            }
        }

        return null;
    } catch (\Exception $e) {
        return null;
    }
}

    public function descargarPlantilla($tipo)
{
    $plantillas = [
        'companias' => [
            'nombre' => 'Plantilla_Companias.xlsx',
            'headers' => ['Nombre', 'Cobertura'],
            'ejemplos' => [
                ['GNP Seguros', 'Amplia Plus'],
                ['GNP Seguros', 'Limitada'],
                ['AXA Seguros', 'Premium'],
                ['Qualitas', 'Amplia'],
                ['MAPFRE', 'Básica'],
            ]
        ],
        'clientes' => [
            'nombre' => 'Plantilla_Clientes.xlsx',
            'headers' => ['Nombre', 'ApellidoPaterno', 'ApellidoMaterno', 'Telefono', 'Email', 'RFC', 'Referencia'],
            'ejemplos' => [
                ['Juan', 'Pérez', 'García', '4421234567', 'juan@email.com', 'PEGJ850101HDF', 'Cliente frecuente'],
                ['María', 'López', 'Hernández', '4429876543', 'maria@email.com', 'LOHM900215MDF', 'Referido'],
            ]
        ],
        'unidades' => [
            'nombre' => 'Plantilla_Unidades.xlsx',
            'headers' => ['VIN', 'TipoUnidad', 'Marca', 'Submarca', 'Año', 'NoSerie', 'Motor', 'Placas', 'Color', 'Uso'],
            'ejemplos' => [
                ['3N1AB7AP5HY123456', 'Sedán', 'Nissan', 'Versa', '2022', 'NV001', 'HR16DE', 'ABC123', 'Blanco', 'Particular'],
                ['WVWZZZ3CZHE456789', 'Sedán', 'VW', 'Jetta', '2021', 'VW002', 'EA211', 'XYZ456', 'Negro', 'Uber'],
            ]
        ],
        'polizas' => [
            'nombre' => 'Plantilla_Polizas.xlsx',
            'headers' => ['NumPoliza', 'RFC', 'Nombre', 'ApellidoP', 'ApellidoM', 'Telefono', 'Compania', 'Cobertura', 'Placas', 'Marca', 'Submarca', 'Año', 'VIN', 'FormaPago', 'FechaInicio', 'FechaVencimiento', 'Prima', 'Estatus'],
            'ejemplos' => [
                ['POL-00001', 'PEGJ850101HDF', 'Juan', 'Pérez', 'García', '4421234567', 'GNP Seguros', 'Amplia Plus', 'ABC123', 'Nissan', 'Versa', '2022', '3N1AB7AP5HY123456', 'Anual', '01/01/2025', '01/01/2026', '15000.00', 'Activa'],
                ['POL-00002', 'LOHM900215MDF', 'María', 'López', 'Hernández', '4429876543', 'AXA Seguros', 'Premium', 'XYZ456', 'VW', 'Jetta', '2021', 'WVWZZZ3CZHE456789', 'Trimestral', '01/01/2025', '01/01/2026', '12000.00', 'Activa'],
            ]
        ],
    ];

    if (!isset($plantillas[$tipo])) {
        session()->flash('error', 'Plantilla no encontrada');
        return;
    }

    $plantilla = $plantillas[$tipo];
    
    // Crear array para exportar (API Laravel-Excel v1)
    $data = array_merge(
        [$plantilla['headers']],
        $plantilla['ejemplos']
    );

    // Usar la API antigua de Laravel-Excel v1
    Excel::create($plantilla['nombre'], function($excel) use ($data) {
        $excel->sheet('Plantilla', function($sheet) use ($data) {
            $sheet->fromArray($data, null, 'A1', false, false);
        });
    })->download('xlsx');

    return response()->noContent();
}
    public function render()
    {
        return view('livewire.importar.importar-excel');
    }
}