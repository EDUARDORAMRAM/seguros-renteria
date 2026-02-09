<?php

namespace App\Livewire\Asegurados;

use App\Models\Asegurado;
use Livewire\Component;

class AseguradosCreate extends Component
{
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
        'RFC' => 'required|string|max:13|unique:asegurados,RFC',
        'Referencia' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'Nombre.required' => 'El nombre o razón social es obligatorio',
        'Email.email' => 'Ingresa un email válido',
        'RFC.required' => 'El RFC es obligatorio',
        'RFC.unique' => 'Este RFC ya está registrado',
    ];

    public function guardar()
    {
        $validated = $this->validate();

        Asegurado::create($validated);

        session()->flash('message', 'Asegurado creado exitosamente.');
        
        return redirect()->route('asegurados.index');
    }

    public function render()
    {
        return view('livewire.asegurados.asegurados-create');
    }
}