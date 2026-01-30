<?php

namespace App\Livewire\Importar;

use App\Models\Poliza;
use App\Models\Asegurado;
use App\Models\Compania;
use App\Models\Unidad;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportarExcel extends Component
{
    use WithFileUploads;

    public $csvCompanias;
    public $csvAsegurados;
    public $csvUnidades;
    public $csvPolizas;
    
    public $importando = false;
    public $progreso = 0;
    public $resultados = [];

    protected $rules = [
        'csvCompanias' => 'required|file|mimes:csv,txt|max:10240',
        'csvAsegurados' => 'required|file|mimes:csv,txt|max:10240',
        'csvUnidades' => 'required|file|mimes:csv,txt|max:10240',
        'csvPolizas' => 'required|file|mimes:csv,txt|max:10240',
    ];

    public function importarCsvs()
    {
        $this->validate();

        $this->importando = true;
        $this->progreso = 0;
        $this->resultados = [];

        try {
            DB::beginTransaction();

            $this->progreso = 10;
            $resultadoCompanias = $this->importarCompaniasData($this->csvCompanias->getRealPath());
            $this->resultados['companias'] = $resultadoCompanias;

            $this->progreso = 30;
            $resultadoAsegurados = $this->importarAseguradosData($this->csvAsegurados->getRealPath());
            $this->resultados['asegurados'] = $resultadoAsegurados;

            $this->progreso = 50;
            $resultadoUnidades = $this->importarUnidadesData($this->csvUnidades->getRealPath());
            $this->resultados['unidades'] = $resultadoUnidades;

            $this->progreso = 70;
            $resultadoPolizas = $this->importarPolizasData(
                $this->csvPolizas->getRealPath(),
                $resultadoAsegurados['mapa_ids'],
                $resultadoUnidades['mapa_ids'],
                $resultadoCompanias['mapa_ids']
            );
            $this->resultados['polizas'] = $resultadoPolizas;

            DB::commit();

            $this->progreso = 100;
            
            $totalImportados = 
                $resultadoCompanias['importados'] + 
                $resultadoAsegurados['importados'] + 
                $resultadoUnidades['importados'] + 
                $resultadoPolizas['importados'];

            session()->flash('message', "✅ Importación completada: {$totalImportados} registros importados");
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error en importación: ' . $e->getMessage());
            \Log::error('Error en importación CSV: ' . $e->getMessage());
        }

        $this->importando = false;
        $this->reset(['csvCompanias', 'csvAsegurados', 'csvUnidades', 'csvPolizas']);
    }

    private function importarCompaniasData($filePath)
    {
        $importados = 0;
        $errores = [];
        $mapa_ids = [];

        $file = fopen($filePath, 'r');
        fgetcsv($file); // Skip header
        
        $lineNumber = 1;
        while (($row = fgetcsv($file)) !== false) {
            $lineNumber++;
            
            try {
                if (empty($row[1]) || empty($row[2])) {
                    continue;
                }

                $idExcel = (int) ($row[0] ?? 0);
                $nombre = trim($row[1]);
                $cobertura = trim($row[2]);

                $compania = Compania::firstOrCreate(
                    ['Nombre' => $nombre, 'Cobertura' => $cobertura]
                );

                $mapa_ids[$idExcel] = $compania->IdCompania;
                $importados++;
                
            } catch (\Exception $e) {
                $errores[] = "Línea {$lineNumber}: " . $e->getMessage();
            }
        }
        
        fclose($file);

        return [
            'total' => $lineNumber - 1,
            'importados' => $importados,
            'errores' => $errores,
            'mapa_ids' => $mapa_ids
        ];
    }

    private function importarAseguradosData($filePath)
    {
        $importados = 0;
        $errores = [];
        $mapa_ids = [];

        $file = fopen($filePath, 'r');
        fgetcsv($file);
        
        $lineNumber = 1;
        while (($row = fgetcsv($file)) !== false) {
            $lineNumber++;
            
            try {
                if (empty($row[1]) || empty($row[2])) {
                    continue;
                }

                $idExcel = (int) ($row[0] ?? 0);
                $nombreCompleto = trim($row[1]);
                $rfc = strtoupper(trim($row[2]));
                $telefono = $this->limpiarTelefono($row[3] ?? '');
                $email = trim($row[4] ?? '');

                $partes = $this->dividirNombreCompleto($nombreCompleto);

                if (Asegurado::where('RFC', $rfc)->exists()) {
                    throw new \Exception("RFC duplicado: {$rfc}");
                }

                if (!empty($email) && Asegurado::where('Email', $email)->exists()) {
                    throw new \Exception("Email duplicado: {$email}");
                }

                $asegurado = Asegurado::create([
                    'Nombre' => $partes['nombre'],
                    'ApellidoPaterno' => $partes['apellido_paterno'],
                    'ApellidoMaterno' => $partes['apellido_materno'],
                    'RFC' => $rfc,
                    'Telefono' => $telefono ?: null,
                    'Email' => $email ?: null,
                    'Referencia' => null,
                ]);

                $mapa_ids[$idExcel] = $asegurado->IdAsegurado;
                $importados++;
                
            } catch (\Exception $e) {
                $errores[] = "Línea {$lineNumber}: " . $e->getMessage();
            }
        }
        
        fclose($file);

        return [
            'total' => $lineNumber - 1,
            'importados' => $importados,
            'errores' => $errores,
            'mapa_ids' => $mapa_ids
        ];
    }

    private function importarUnidadesData($filePath)
    {
        $importados = 0;
        $errores = [];
        $mapa_ids = [];

        $file = fopen($filePath, 'r');
        fgetcsv($file);
        
        $lineNumber = 1;
        while (($row = fgetcsv($file)) !== false) {
            $lineNumber++;
            
            try {
                if (empty($row[1]) || empty($row[4])) {
                    continue;
                }

                $idExcel = (int) ($row[0] ?? 0);
                $marca = trim($row[1]);
                $submarca = trim($row[2] ?? 'SIN SUBMARCA');
                $modelo = trim($row[3] ?? '');
                $vin = trim($row[4]);
                $anio = (int) ($row[5] ?? now()->year);
                $motor = trim($row[6] ?? 'SIN MOTOR');

                $placas = $this->generarPlacas();

                if (Unidad::where('VIN', $vin)->exists()) {
                    throw new \Exception("VIN duplicado: {$vin}");
                }

                $unidad = Unidad::create([
                    'VIN' => $vin,
                    'Marca' => $marca,
                    'Submarca' => $submarca,
                    'Anio' => $anio,
                    'Motor' => $motor,
                    'Placas' => $placas,
                    'Color' => 'POR DEFINIR',
                    'Uso' => 'Particular',
                ]);

                $mapa_ids[$idExcel] = $unidad->IdUnidad;
                $importados++;
                
            } catch (\Exception $e) {
                $errores[] = "Línea {$lineNumber}: " . $e->getMessage();
            }
        }
        
        fclose($file);

        return [
            'total' => $lineNumber - 1,
            'importados' => $importados,
            'errores' => $errores,
            'mapa_ids' => $mapa_ids
        ];
    }

    private function importarPolizasData($filePath, $mapaAsegurados, $mapaUnidades, $mapaCompanias)
    {
        $importados = 0;
        $errores = [];

        $file = fopen($filePath, 'r');
        fgetcsv($file);
        
        $lineNumber = 1;
        while (($row = fgetcsv($file)) !== false) {
            $lineNumber++;
            
            try {
                if (empty($row[1])) {
                    continue;
                }

                $numPoliza = trim($row[1]);
                $formaPago = $this->normalizarFormaPago($row[2] ?? 'ANUAL');
                $fechaVencimiento = $this->parsearFecha($row[4] ?? '');

                // Calcular fecha de inicio: si está vacía o inválida, restar 1 año al vencimiento
                $fechaInicioRaw = trim($row[3] ?? '');
                if (!empty($fechaInicioRaw)) {
                    $fechaInicio = $this->parsearFecha($fechaInicioRaw);
                } else {
                    // Si no hay fecha de inicio, calcular 1 año antes del vencimiento
                    $fechaInicio = $fechaVencimiento->copy()->subYear();
                }

                $prima = floatval($row[6] ?? 0);
                $estatus = ucfirst(strtolower(trim($row[7] ?? 'Activa')));
                
                $idCompaniaExcel = (int) ($row[8] ?? 0);
                $idAseguradoExcel = (int) ($row[9] ?? 0);
                $idUnidadExcel = (int) ($row[10] ?? 0);

                $idCompania = $mapaCompanias[$idCompaniaExcel] ?? null;
                $idAsegurado = $mapaAsegurados[$idAseguradoExcel] ?? null;
                $idUnidad = $mapaUnidades[$idUnidadExcel] ?? null;

                if (!$idCompania || !$idAsegurado || !$idUnidad) {
                    throw new \Exception("Referencias inválidas");
                }

                if ($prima <= 0) {
                    $prima = 0;
                }

                if (Poliza::where('NumPoliza', $numPoliza)->exists()) {
                    throw new \Exception("NumPoliza duplicada: {$numPoliza}");
                }

                $poliza = Poliza::create([
                    'NumPoliza' => $numPoliza,
                    'FormaPago' => $formaPago,
                    'FechaInicio' => $fechaInicio,
                    'FechaVencimiento' => $fechaVencimiento,
                    'Prima' => $prima,
                    'Estatus' => $estatus,
                    'IdCompania' => $idCompania,
                    'IdAsegurado' => $idAsegurado,
                    'IdUnidad' => $idUnidad,
                ]);

                if ($prima > 0) {
                    $poliza->generarFechasCobranza();
                }

                $importados++;
                
            } catch (\Exception $e) {
                $errores[] = "Línea {$lineNumber}: " . $e->getMessage();
            }
        }
        
        fclose($file);

        return [
            'total' => $lineNumber - 1,
            'importados' => $importados,
            'errores' => $errores
        ];
    }

    private function dividirNombreCompleto($nombreCompleto)
    {
        $partes = array_filter(explode(' ', $nombreCompleto));
        $count = count($partes);

        if ($count >= 3) {
            return [
                'apellido_paterno' => $partes[0],
                'apellido_materno' => $partes[1],
                'nombre' => implode(' ', array_slice($partes, 2))
            ];
        } elseif ($count == 2) {
            return [
                'apellido_paterno' => $partes[0],
                'apellido_materno' => '',
                'nombre' => $partes[1]
            ];
        } else {
            return [
                'apellido_paterno' => $nombreCompleto,
                'apellido_materno' => '',
                'nombre' => 'SIN NOMBRE'
            ];
        }
    }

    private function limpiarTelefono($telefono)
    {
        if (empty($telefono)) {
            return '';
        }
        
        if (is_numeric($telefono)) {
            return (string) intval($telefono);
        }
        
        return preg_replace('/[^0-9]/', '', $telefono);
    }

    private function inferirTipoUnidad($modelo, $marca)
    {
        $modelo = strtoupper($modelo);

        if (Str::contains($modelo, ['CHASIS', 'CAMION', 'GRUA'])) {
            return 'Camión';
        }
        if (Str::contains($modelo, ['PICK', 'LOBO', 'RANGER'])) {
            return 'Pickup';
        }
        if (Str::contains($modelo, ['SUV', 'SELTOS', 'SPORTAGE', 'TUCSON'])) {
            return 'SUV';
        }
        
        return 'Sedán';
    }

    private function generarPlacas()
    {
        static $contador = 1000;
        $contador++;
        return 'IMP-' . str_pad($contador, 4, '0', STR_PAD_LEFT);
    }

    private function parsearFecha($fecha)
    {
        if (empty($fecha)) {
            return now();
        }

        try {
            // Intentar formato d/m/Y (ej: 25/9/2025)
            if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', trim($fecha))) {
                return \Carbon\Carbon::createFromFormat('d/m/Y', trim($fecha));
            }

            // Intentar formato d-m-Y (ej: 25-09-2025)
            if (preg_match('/^\d{1,2}-\d{1,2}-\d{4}$/', trim($fecha))) {
                return \Carbon\Carbon::createFromFormat('d-m-Y', trim($fecha));
            }

            // Intentar formato Y-m-d (ej: 2025-09-25)
            if (preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', trim($fecha))) {
                return \Carbon\Carbon::createFromFormat('Y-m-d', trim($fecha));
            }

            // Fallback a Carbon::parse
            return \Carbon\Carbon::parse($fecha);
        } catch (\Exception $e) {
            return now();
        }
    }

    private function normalizarFormaPago($formaPago)
    {
        $formaPago = strtoupper(trim($formaPago));

        return match($formaPago) {
            'ANUAL' => 'Anual',
            'SEMESTRAL' => 'Semestral',
            'TRIMESTRAL' => 'Trimestral',
            'MENSUAL' => 'Mensual',
            default => 'Anual',
        };
    }

    public function render()
    {
        return view('livewire.importar.importar-excel');
    }
}