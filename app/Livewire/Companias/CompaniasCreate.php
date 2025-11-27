<?php

namespace App\Livewire\Companias;

use App\Models\Compania;
use Livewire\Component;

class CompaniasCreate extends Component
{
    // Propiedades del formulario
    public $nombre = '';
    public $cobertura = '';

    // Reglas de validación
    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255|unique:companias,Nombre',
            'cobertura' => 'required|string|max:255',
        ];
    }

    // Mensajes de validación personalizados
    protected $messages = [
        'nombre.required' => 'El nombre de la compañía es obligatorio.',
        'nombre.unique' => 'Ya existe una compañía con este nombre.',
        'nombre.max' => 'El nombre no debe exceder 255 caracteres.',
        'cobertura.required' => 'La cobertura es obligatoria.',
        'cobertura.max' => 'La cobertura no debe exceder 255 caracteres.',
    ];

    // Validación en tiempo real
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // Método para guardar
    public function guardar()
    {
        $this->validate();

        try {
            Compania::create([
                'Nombre' => $this->nombre,
                'Cobertura' => $this->cobertura,
            ]);

            session()->flash('message', 'Compañía creada exitosamente.');
            
            return redirect()->route('companias.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al crear la compañía: ' . $e->getMessage());
        }
    }

    // Método para cancelar
    public function cancelar()
    {
        return redirect()->route('companias.index');
    }

    public function render()
    {
        return view('livewire.companias.companias-create');
    }
}