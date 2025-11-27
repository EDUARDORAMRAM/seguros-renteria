<?php

namespace App\Livewire\Asegurados;

use App\Models\Asegurado;
use Livewire\Component;

class AseguradosCreate extends Component
{
    public $Nombre;
    public $ApellidoPaterno;
    public $ApellidoMaterno;
    public $Telefono;
    public $Email;
    public $RFC;
    public $Referencia;

    protected $rules = [
        'Nombre' => 'required|string|max:255',
        'ApellidoPaterno' => 'required|string|max:255',
        'ApellidoMaterno' => 'nullable|string|max:255',
        'Telefono' => 'required|string|max:20',
        'Email' => 'required|email|max:255|unique:asegurados,Email',
        'RFC' => 'required|string|max:13|unique:asegurados,RFC',
        'Referencia' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'Nombre.required' => 'El nombre es obligatorio',
        'ApellidoPaterno.required' => 'El apellido paterno es obligatorio',
        'Telefono.required' => 'El teléfono es obligatorio',
        'Email.required' => 'El email es obligatorio',
        'Email.email' => 'Ingresa un email válido',
        'Email.unique' => 'Este email ya está registrado',
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