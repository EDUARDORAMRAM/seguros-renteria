<?php

namespace App\Livewire\Asegurados;

use App\Models\Asegurado;
use Livewire\Component;

class AseguradosShow extends Component
{
    public Asegurado $asegurado;
    

    public function mount(Asegurado $asegurado)
    {
        $this->asegurado = $asegurado->load(['polizas.compania', 'polizas.unidad']);
    }

    public function render()
    {
        return view('livewire.asegurados.asegurados-show');
    }
}