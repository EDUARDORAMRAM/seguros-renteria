<?php

namespace App\Livewire\Unidades;

use App\Models\Unidad;
use Livewire\Component;

class UnidadesShow extends Component
{
    public Unidad $unidad;

    public function mount(Unidad $unidad)
    {
        $this->unidad = $unidad->load(['polizas.compania', 'polizas.asegurado']);
    }

    public function render()
    {
        return view('livewire.unidades.unidades-show');
    }
}