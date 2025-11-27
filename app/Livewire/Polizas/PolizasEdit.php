<?php

namespace App\Livewire\Polizas;

use App\Models\Poliza;
use App\Models\Asegurado;
use App\Models\Compania;
use App\Models\Unidad;
use Livewire\Component;

class PolizasEdit extends Component
{
    public Poliza $poliza;
    public $NumPoliza;
    public $FormaPago;
    public $FechaInicio;
    public $FechaVencimiento;
    public $Prima;
    public $Estatus;
    public $IdCompania;
    public $IdAsegurado;
    public $IdUnidad;

    public $companias;
    public $asegurados;
    public $unidades;

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

    public function mount(Poliza $poliza)
    {
        $this->poliza = $poliza;
        $this->cargarPoliza();
        $this->cargarDatos();
        
    }

    public function cargarDatos()
    {
        $this->companias = Compania::orderBy('Nombre')->get();
        $this->asegurados = Asegurado::orderBy('Nombre')->get();
        $this->unidades = Unidad::orderBy('Marca')->get();
    }

    public function cargarPoliza()
    {
        $this->NumPoliza = $this->poliza->NumPoliza;
        $this->FormaPago = $this->poliza->FormaPago;
        $this->FechaInicio = $this->poliza->FechaInicio->format('Y-m-d');
        $this->FechaVencimiento = $this->poliza->FechaVencimiento->format('Y-m-d');
        $this->Prima = $this->poliza->Prima;
        $this->Estatus = $this->poliza->Estatus;
        $this->IdCompania = $this->poliza->IdCompania;
        $this->IdAsegurado = $this->poliza->IdAsegurado;
        $this->IdUnidad = $this->poliza->IdUnidad;
    }

    public function updatedFormaPago($value)
    {
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

    public function actualizar()
    {
        $rules = $this->rules;
        $rules['NumPoliza'] = 'required|unique:polizas,NumPoliza,' . $this->poliza->IdPoliza . ',IdPoliza';

        $validated = $this->validate($rules);

        $this->poliza->update($validated);

        session()->flash('message', 'Póliza actualizada exitosamente.');
        
        
        return redirect()->route('polizas.show', $this->poliza);
    }

    public function render()
    {
        return view('livewire.polizas.polizas-edit');
    }
}