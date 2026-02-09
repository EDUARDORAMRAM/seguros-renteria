<?php

namespace App\Livewire\Asegurados;

use App\Models\Asegurado;
use Livewire\Component;

class AseguradosEdit extends Component
{
    public Asegurado $asegurado;
    public $TipoPersona = 'Física';
    public $Nombre;
    public $ApellidoPaterno;
    public $ApellidoMaterno;
    public $Telefono;
    public $Email;
    public $RFC;
    public $Referencia;

    protected $rules = [
        'TipoPersona' => 'required|in:Física,Moral',
        'Nombre' => 'required|string|max:255',
        'ApellidoPaterno' => 'nullable|string|max:255',
        'ApellidoMaterno' => 'nullable|string|max:255',
        'Telefono' => 'nullable|string|max:20',
        'Email' => 'nullable|email|max:255',
        'RFC' => 'required|string|max:13',
        'Referencia' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'Nombre.required' => 'El nombre o razón social es obligatorio',
        'Email.email' => 'Ingresa un email válido',
        'RFC.required' => 'El RFC es obligatorio',
    ];

    public function mount(Asegurado $asegurado)
    {
        $this->asegurado = $asegurado;
        $this->cargarAsegurado();
    }

    public function cargarAsegurado()
    {
        $this->TipoPersona = $this->asegurado->TipoPersona ?? 'Física';
        $this->Nombre = $this->asegurado->Nombre;
        $this->ApellidoPaterno = $this->asegurado->ApellidoPaterno;
        $this->ApellidoMaterno = $this->asegurado->ApellidoMaterno;
        $this->Telefono = $this->asegurado->Telefono;
        $this->Email = $this->asegurado->Email;
        $this->RFC = $this->asegurado->RFC;
        $this->Referencia = $this->asegurado->Referencia;
    }

    public function actualizar()
    {
        $rules = $this->rules;
        $rules['RFC'] = 'required|string|max:13|unique:asegurados,RFC,' . $this->asegurado->IdAsegurado . ',IdAsegurado';

        $validated = $this->validate($rules);

        $this->asegurado->update($validated);

        session()->flash('message', 'Asegurado actualizado exitosamente.');

        return redirect()->route('asegurados.index');
    }

    public function render()
    {
        return view('livewire.asegurados.asegurados-edit');
    }
}
