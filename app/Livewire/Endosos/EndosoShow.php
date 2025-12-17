<?php

namespace App\Livewire\Endosos;

use Livewire\Component;
use App\Models\Endoso;

class EndosoShow extends Component
{
    public $endosoId;
    public $endoso;

    public function mount($id)
    {
        $this->endosoId = $id;
        $this->endoso = Endoso::with(['poliza.compania', 'poliza.asegurado', 'poliza.unidad', 'usuario'])
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.endosos.endoso-show');
    }
}