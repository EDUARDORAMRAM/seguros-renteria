<?php

namespace App\Livewire\Polizas;

use App\Models\Poliza;
use Livewire\Component;

class PolizasShow extends Component
{
    public Poliza $poliza;

    protected $listeners = [
        'renovar-poliza' => 'renovar'
    ];

    public function mount(Poliza $poliza)
    {
        $this->poliza = $poliza->load(['asegurado', 'compania', 'unidad']);
    }

    public function cargarPoliza()
    {
        $this->poliza->refresh();
        $this->poliza->load(['asegurado', 'compania', 'unidad']);
    }

    public function renovar()
    {
        $nuevaFechaVencimiento = $this->poliza->FechaVencimiento->addYear();
        $this->poliza->renovar($nuevaFechaVencimiento);
        
        $this->cargarPoliza();
        session()->flash('message', 'Póliza renovada exitosamente.');
    }

    public function cancelar()
    {
        $this->poliza->cancelar();
        $this->cargarPoliza();
        session()->flash('message', 'Póliza cancelada exitosamente.');
    }

    public function render()
    {
        return view('livewire.polizas.polizas-show');
    }
}