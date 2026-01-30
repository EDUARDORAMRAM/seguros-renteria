<?php

namespace App\Livewire\Polizas;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Poliza;
use App\Models\Compania;
use App\Models\Asegurado;
use App\Models\Unidad;

class PolizasCreate extends Component
{
    use WithFileUploads;

    public $NumPoliza;
    public $FormaPago = 'Anual';
    public $FechaInicio;
    public $FechaVencimiento;
    public $Prima;
    public $Estatus = 'Activa';
    public $IdCompania;
    public $IdAsegurado;
    public $IdUnidad;
    public $archivoPdf;

    // NUEVOS
    public $validacionFechas = null;
    public $fechasCobranzaPreview = [];

    public $companias;
    public $asegurados;
    public $unidades;

    public $mostrarModalAsegurado = false;
    public $mostrarModalUnidad = false;

    // Listeners para actualizar datos cuando se crean nuevos registros
    protected $listeners = [
        'aseguradoCreado' => 'actualizarAsegurados',
        'unidadCreada' => 'actualizarUnidades',
    ];

    public function actualizarAsegurados($idAsegurado = null)
    {
        $this->asegurados = Asegurado::orderBy('Nombre')->get();
        if ($idAsegurado) {
            $this->IdAsegurado = $idAsegurado;
        }
        $this->mostrarModalAsegurado = false;
    }

    public function actualizarUnidades($idUnidad = null)
    {
        $this->unidades = Unidad::orderBy('Marca')->get();
        if ($idUnidad) {
            $this->IdUnidad = $idUnidad;
        }
        $this->mostrarModalUnidad = false;
    }

    protected $rules = [
        'NumPoliza' => 'required|unique:polizas,NumPoliza',
        'FormaPago' => 'required|in:Anual,Semestral,Trimestral,Mensual',
        'FechaInicio' => 'required|date',
        'FechaVencimiento' => 'required|date|after:FechaInicio',
        'Prima' => 'required|numeric|min:0',
        'Estatus' => 'required|in:Activa,Vencida,Cancelada',
        'IdCompania' => 'required|exists:companias,IdCompania',
        'IdAsegurado' => 'required|exists:asegurados,IdAsegurado',
        'IdUnidad' => 'required|exists:unidads,IdUnidad',
        'archivoPdf' => 'nullable|file|mimes:pdf|max:10240',
    ];

    protected $messages = [
        'NumPoliza.required' => 'El número de póliza es obligatorio',
        'NumPoliza.unique' => 'Este número de póliza ya existe',
        'FechaVencimiento.after' => 'La fecha de vencimiento debe ser posterior a la fecha de inicio',
        'Prima.required' => 'La prima es obligatoria',
        'Prima.min' => 'La prima debe ser mayor a 0',
    ];

    public function mount()
    {
        $this->FechaInicio = now()->format('Y-m-d');
        $this->FechaVencimiento = now()->addYear()->format('Y-m-d');
        $this->generarNumeroPoliza();
        $this->cargarDatos();
        $this->validarYCalcularFechas();
    }

    public function cargarDatos()
    {
        $this->companias = Compania::orderBy('Nombre')->get();
        $this->asegurados = Asegurado::orderBy('Nombre')->get();
        $this->unidades = Unidad::orderBy('Marca')->get();
    }

    public function generarNumeroPoliza()
    {
        $ultimaPoliza = Poliza::latest('IdPoliza')->first();
        $numero = $ultimaPoliza ? intval(substr($ultimaPoliza->NumPoliza, 4)) + 1 : 1;
        $this->NumPoliza = 'POL-' . str_pad($numero, 6, '0', STR_PAD_LEFT);
    }

    // ═══════════════════════════════════════════════════════════
    // NUEVO: Validar y calcular fechas en tiempo real
    // ═══════════════════════════════════════════════════════════
    public function updatedFormaPago($value)
    {
        $this->validarYCalcularFechas();
    }

    public function updatedFechaInicio($value)
    {
        $this->validarYCalcularFechas();
    }

    public function updatedFechaVencimiento($value)
    {
        $this->validarYCalcularFechas();
    }

    private function validarYCalcularFechas()
    {
        if ($this->FechaInicio && $this->FechaVencimiento && $this->FormaPago) {
            // Validar coherencia
            $this->validacionFechas = Poliza::validarCoherenciaFechas(
                $this->FechaInicio,
                $this->FechaVencimiento,
                $this->FormaPago
            );

            // Calcular preview de fechas
            if ($this->validacionFechas['valido']) {
                $this->fechasCobranzaPreview = Poliza::calcularFechasCobranza(
                    $this->FechaInicio,
                    $this->FechaVencimiento,
                    $this->FormaPago
                );
            } else {
                $this->fechasCobranzaPreview = [];
            }
        }
    }

    public function guardar()
    {
        // Validar coherencia antes de guardar
        if (!$this->validacionFechas || !$this->validacionFechas['valido']) {
            $this->addError('FechaVencimiento', $this->validacionFechas['mensaje'] ?? 'Las fechas no son coherentes con la forma de pago');
            return;
        }

        $this->validate();

        $poliza = Poliza::create([
            'NumPoliza' => strtoupper($this->NumPoliza),
            'FormaPago' => $this->FormaPago,
            'FechaInicio' => $this->FechaInicio,
            'FechaVencimiento' => $this->FechaVencimiento,
            'FechaCobranza' => null, // Ya no se usa
            'Prima' => $this->Prima,
            'Estatus' => $this->Estatus,
            'IdCompania' => $this->IdCompania,
            'IdAsegurado' => $this->IdAsegurado,
            'IdUnidad' => $this->IdUnidad,
        ]);

        // Guardar PDF si existe
        if ($this->archivoPdf) {
            $nombreArchivo = 'poliza_' . str_replace(['/', '-', ' '], '_', $this->NumPoliza) . '_' . time() . '.pdf';
            $this->archivoPdf->storeAs('polizas', $nombreArchivo, 'public');
            $poliza->ArchivoPDF = $nombreArchivo;
            $poliza->save();
        }

        // ═══════════════════════════════════════════════════════════
        // GENERAR FECHAS DE COBRANZA
        // ═══════════════════════════════════════════════════════════
        $poliza->generarFechasCobranza();

        session()->flash('message', 'Póliza creada exitosamente con ' . count($this->fechasCobranzaPreview) . ' fechas de cobranza.');
        
        return redirect()->route('polizas.index');
    }

    public function render()
    {
        return view('livewire.polizas.polizas-create');
    }
}