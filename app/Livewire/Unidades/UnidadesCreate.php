<?php

namespace App\Livewire\Unidades;

use App\Models\Unidad;
use Livewire\Component;

class UnidadesCreate extends Component
{
    public $VIN = '';
    public $Marca = '';
    public $Submarca = '';
    public $Anio = '';
    public $NoSerie = '';
    public $Motor = '';
    public $Placas = '';
    public $Color = '';
    public $Uso = '';

    protected function rules()
    {
        return [
            'VIN' => 'required|string|max:50|unique:unidads,VIN',
            'Marca' => 'required|string|max:100',
            'Submarca' => 'required|string|max:100',
            'Anio' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'NoSerie' => 'required|string|max:50|unique:unidads,NoSerie',
            'Motor' => 'nullable|string|max:50',
            'Placas' => 'nullable|string|max:20|unique:unidads,Placas',
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
        'NoSerie.required' => 'El número de serie es obligatorio.',
        'NoSerie.unique' => 'Este número de serie ya está registrado.',
        'Placas.unique' => 'Estas placas ya están registradas.',
        'Uso.required' => 'El uso es obligatorio.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function guardar()
    {
        $this->validate();

        try {
            Unidad::create([
                'VIN' => strtoupper($this->VIN),
                'Marca' => $this->Marca,
                'Submarca' => $this->Submarca,
                'Anio' => $this->Anio,
                'NoSerie' => strtoupper($this->NoSerie),
                'Motor' => strtoupper($this->Motor),
                'Placas' => $this->Placas ? strtoupper($this->Placas) : null,
                'Color' => $this->Color,
                'Uso' => $this->Uso,
            ]);

            session()->flash('message', 'Unidad registrada exitosamente.');
            
            return redirect()->route('unidades.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al registrar la unidad: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.unidades.unidades-create');
    }
}