<?php

namespace App\Livewire\Asegurados;

use App\Models\Asegurado;
use Livewire\Component;

class AseguradosShow extends Component
{
    public Asegurado $asegurado;
    

     public function mount(Asegurado $asegurado)
    {
        $this->asegurado = $asegurado;
        $this->cargarAsegurado();
    }

    public function cargarAsegurado()
    {
        $this->Nombre = $this->asegurado->Nombre;
        $this->ApellidoPaterno = $this->asegurado->ApellidoPaterno;
        $this->ApellidoMaterno = $this->asegurado->ApellidoMaterno;
        $this->Telefono = $this->asegurado->Telefono;
        $this->Email = $this->asegurado->Email;
        $this->RFC = $this->asegurado->RFC;
        $this->Referencia = $this->asegurado->Referencia;
    }

    public function render()
    {
        return view('livewire.asegurados.asegurados-show');
    }
}