<?php

namespace App\Livewire\Polizas;

use App\Models\Poliza;
use App\Models\Asegurado;
use App\Models\Compania;
use App\Models\Unidad;
use Livewire\Component;

class PolizasCreate extends Component
{
    // Campos del formulario
    public $NumPoliza;
    public $FormaPago = 'Anual';
    public $FechaInicio;
    public $FechaVencimiento;
    public $Prima;
    public $Estatus = 'Activa';
    public $IdCompania;
    public $IdAsegurado;
    public $IdUnidad;

    // Datos para los selects
    public $companias;
    public $asegurados;
    public $unidades;

    // Modales
    public $mostrarModalAsegurado = false;
    public $mostrarModalUnidad = false;

    // Reglas de validación
    protected $rules = [
        'NumPoliza' => 'required|unique:polizas,NumPoliza',
        'FormaPago' => 'required|in:Anual,Semestral,Mensual',
        'FechaInicio' => 'required|date',
        'FechaVencimiento' => 'required|date|after:FechaInicio',
        'Prima' => 'required|numeric|min:0',
        'Estatus' => 'required|in:Activa,Vencida,Cancelada',
        'IdCompania' => 'required|exists:companias,IdCompania',
        'IdAsegurado' => 'required|exists:asegurados,IdAsegurado',
        'IdUnidad' => 'required|exists:unidads,IdUnidad',
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

    public function updatedFormaPago($value)
    {
        // Calcular fecha de vencimiento según forma de pago
        if ($this->FechaInicio) {
            $fechaInicio = \Carbon\Carbon::parse($this->FechaInicio);
            $this->FechaVencimiento = match($value) {
                'Anual' => $fechaInicio->copy()->addYear()->format('Y-m-d'),
                'Semestral' => $fechaInicio->copy()->addMonths(6)->format('Y-m-d'),
                'Mensual' => $fechaInicio->copy()->addMonth()->format('Y-m-d'),
                default => $fechaInicio->copy()->addYear()->format('Y-m-d'),
            };
        }
    }

    public function guardar()
    {
        $this->validate();

        Poliza::create([
            'NumPoliza' => $this->NumPoliza,
            'FormaPago' => $this->FormaPago,
            'FechaInicio' => $this->FechaInicio,
            'FechaVencimiento' => $this->FechaVencimiento,
            'Prima' => $this->Prima,
            'Estatus' => $this->Estatus,
            'IdCompania' => $this->IdCompania,
            'IdAsegurado' => $this->IdAsegurado,
            'IdUnidad' => $this->IdUnidad,
        ]);

        session()->flash('message', 'Póliza creada exitosamente.');
        
        return redirect()->route('polizas.index');
    }

    public function render()
    {
        return view('livewire.polizas.polizas-create');
    }
}