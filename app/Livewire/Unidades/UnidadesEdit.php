<?php

namespace App\Livewire\Unidades;

use App\Models\Unidad;
use Livewire\Component;

class UnidadesEdit extends Component
{
    public Unidad $unidad;
    
    public $VIN = '';
    public $Marca = '';
    public $Submarca = '';
    public $Anio = '';
    public $Motor = '';
    public $Placas = '';
    public $Color = '';
    public $Uso = '';

    public function mount(Unidad $unidad)
    {
        $this->unidad = $unidad;
        $this->VIN = $unidad->VIN;
        $this->Marca = $unidad->Marca;
        $this->Submarca = $unidad->Submarca;
        $this->Anio = $unidad->Anio;
        $this->Motor = $unidad->Motor;
        $this->Placas = $unidad->Placas;
        $this->Color = $unidad->Color;
        $this->Uso = $unidad->Uso;
    }

    protected function rules()
    {
        return [
            'VIN' => 'required|string|max:50|unique:unidads,VIN,' . $this->unidad->IdUnidad . ',IdUnidad',
            'Marca' => 'required|string|max:100',
            'Submarca' => 'required|string|max:100',
            'Anio' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'Motor' => 'nullable|string|max:50',
            'Placas' => 'nullable|string|max:20|unique:unidads,Placas,' . $this->unidad->IdUnidad . ',IdUnidad',
            'Color' => 'nullable|string|max:50',
            'Uso' => 'required|string|in:Particular,Comercial,Público',
        ];
    }

    protected $messages = [
        'VIN.required' => 'El VIN es obligatorio.',
        'VIN.unique' => 'Este VIN ya está registrado.',
        'Marca.required' => 'La marca es obligatoria.',
        'Submarca.required' => 'La submarca es obligatoria.',
        'Anio.required' => 'El año es obligatorio.',
        'Anio.integer' => 'El año debe ser un número.',
        'Anio.min' => 'El año no puede ser menor a 1900.',
        'Anio.max' => 'El año no puede ser mayor al año próximo.',
        'Placas.unique' => 'Estas placas ya están registradas.',
        'Uso.required' => 'El uso es obligatorio.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function actualizar()
    {
        $this->validate();

        try {
            $this->unidad->update([
                'VIN' => strtoupper($this->VIN),
                'Marca' => $this->Marca,
                'Submarca' => $this->Submarca,
                'Anio' => $this->Anio,
                'Motor' => $this->Motor ? strtoupper($this->Motor) : null,
                'Placas' => $this->Placas ? strtoupper($this->Placas) : null,
                'Color' => $this->Color,
                'Uso' => $this->Uso,
            ]);

            session()->flash('message', 'Unidad actualizada exitosamente.');
            
            return redirect()->route('unidades.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar la unidad: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $totalPolizas = $this->unidad->polizas()->count();
        $polizaActiva = $this->unidad->polizaActiva;

        return view('livewire.unidades.unidades-edit', [
            'totalPolizas' => $totalPolizas,
            'polizaActiva' => $polizaActiva,
        ]);
    }
}