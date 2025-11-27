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
                    // Buscar o crear compañía
                    $compania = Compania::firstOrCreate(
                        ['Nombre' => $row[6] ?? ''],
                        ['Cobertura' => $row[7] ?? 'Amplia']
                    );

                    // Buscar o crear asegurado
                    $asegurado = Asegurado::firstOrCreate(
                        ['RFC' => $row[1] ?? ''],
                        [
                            'Nombre' => $row[2] ?? '',
                            'ApellidoPaterno' => $row[3] ?? '',
                            'ApellidoMaterno' => $row[4] ?? '',
                            'Telefono' => $row[5] ?? '',
                        ]
                    );

                    // Buscar o crear unidad
                    $unidad = Unidad::firstOrCreate(
                        ['Placas' => $row[8] ?? ''],
                        [
                            'Marca' => $row[9] ?? '',
                            'Submarca' => $row[10] ?? '',
                            'Anio' => $row[11] ?? now()->year,
                            'TipoUnidad' => 'Automóvil',
                            'VIN' => $row[12] ?? '',
                        ]
                    );

                    // Crear póliza
                    Poliza::create([
                        'NumPoliza' => $row[0] ?? '',
                        'FormaPago' => $row[13] ?? 'Anual',
                        'FechaInicio' => $row[14] ?? now(),
                        'FechaVencimiento' => $row[15] ?? now()->addYear(),
                        'Prima' => $row[16] ?? 0,
                        'Estatus' => $row[17] ?? 'Activa',
                        'IdCompania' => $compania->IdCompania,
                        'IdAsegurado' => $asegurado->IdAsegurado,
                        'IdUnidad' => $unidad->IdUnidad,
                    ]);
                    
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

            session()->flash('message', "Pólizas importadas: {$importados} de {$total}");
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al importar: ' . $e->getMessage());
        }

        $this->importando = false;
        $this->archivoPolizas = null;
    }

    public function descargarPlantilla($tipo)
    {
        $plantillas = [
            'companias' => [
                ['Nombre', 'Cobertura'],
                ['GNP Seguros', 'Amplia Plus'],
                ['Qualitas', 'Amplia'],
            ],
            'clientes' => [
                ['Nombre', 'ApellidoPaterno', 'ApellidoMaterno', 'Telefono', 'Email', 'RFC', 'Referencia'],
                ['Juan', 'Pérez', 'García', '4421234567', 'juan@email.com', 'PEGJ850101ABC', 'Referido'],
            ],
            'unidades' => [
                ['VIN', 'TipoUnidad', 'Marca', 'Submarca', 'Año', 'NoSerie', 'Motor', 'Placas', 'Color', 'Uso'],
                ['3N1AB7AP5HY123456', 'Automóvil', 'Nissan', 'Versa', '2022', 'NV001', 'HR16DE', 'ABC123', 'Blanco', 'Particular'],
            ],
            'polizas' => [
                ['NumPoliza', 'RFC', 'Nombre', 'ApellidoP', 'ApellidoM', 'Telefono', 'Compania', 'Cobertura', 'Placas', 'Marca', 'Submarca', 'Año', 'VIN', 'FormaPago', 'FechaInicio', 'FechaVencimiento', 'Prima', 'Estatus'],
            ]
        ];

        // Aquí implementarías la descarga del Excel
        // Por ahora retornamos un mensaje
        session()->flash('info', 'Descargando plantilla de ' . $tipo);
    }

    public function render()
    {
        return view('livewire.importar.importar-excel');
    }
}