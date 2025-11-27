<?php

namespace App\Livewire\Companias;

use App\Models\Compania;
use Livewire\Component;

class CompaniasEdit extends Component
{
    public Compania $compania;
    
    // Propiedades del formulario
    public $nombre = '';
    public $cobertura = '';

    // Montar el componente con los datos existentes
    public function mount(Compania $compania)
    {
        $this->compania = $compania;
        $this->nombre = $compania->Nombre;
        $this->cobertura = $compania->Cobertura;
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255|unique:companias,Nombre,' . $this->compania->IdCompania . ',IdCompania',
            'cobertura' => 'required|string|max:255',
        ];
    }

    // Mensajes de validación personalizados
    protected $messages = [
        'nombre.required' => 'El nombre de la compañía es obligatorio.',
        'nombre.unique' => 'Ya existe otra compañía con este nombre.',
        'nombre.max' => 'El nombre no debe exceder 255 caracteres.',
        'cobertura.required' => 'La cobertura es obligatoria.',
        'cobertura.max' => 'La cobertura no debe exceder 255 caracteres.',
    ];

    // Validación en tiempo real
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // Método para actualizar
    public function actualizar()
    {
        $this->validate();

        try {
            $this->compania->update([
                'Nombre' => $this->nombre,
                'Cobertura' => $this->cobertura,
            ]);

            session()->flash('message', 'Compañía actualizada exitosamente.');
            
            return redirect()->route('companias.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar la compañía: ' . $e->getMessage());
        }
    }

    // Método para cancelar
    public function cancelar()
    {
        return redirect()->route('companias.index');
    }

    public function render()
    {
        // Obtener estadísticas de la compañía
        $totalPolizas = $this->compania->polizas()->count();
        $polizasActivas = $this->compania->polizasActivas()->count();
        $primasTotales = $this->compania->primasTotales;

        return view('livewire.companias.companias-edit', [
            'totalPolizas' => $totalPolizas,
            'polizasActivas' => $polizasActivas,
            'primasTotales' => $primasTotales,
        ]);
    }
}