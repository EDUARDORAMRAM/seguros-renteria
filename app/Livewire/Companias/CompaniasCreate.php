<?php

namespace App\Livewire\Companias;

use App\Models\Compania;
use Livewire\Component;

class CompaniasCreate extends Component
{
    // Propiedades del formulario
    public $nombre = '';
    public $cobertura = '';

    // ═══════════════════════════════════════════════════════════
    // NUEVO: Mostrar sugerencias de nombres existentes
    // ═══════════════════════════════════════════════════════════
    public $nombresExistentes = [];
    public $coberturasExistentes = [];
    public $mostrarSugerencias = false;

    // Reglas de validación
    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'cobertura' => 'required|string|max:255',
        ];
    }

    // Mensajes de validación personalizados
    protected $messages = [
        'nombre.required' => 'El nombre de la compañía es obligatorio.',
        'nombre.max' => 'El nombre no debe exceder 255 caracteres.',
        'cobertura.required' => 'La cobertura es obligatoria.',
        'cobertura.max' => 'La cobertura no debe exceder 255 caracteres.',
    ];

    // ═══════════════════════════════════════════════════════════
    // NUEVO: Cargar datos al montar el componente
    // ═══════════════════════════════════════════════════════════
    public function mount()
    {
        $this->cargarNombresExistentes();
    }

    // ═══════════════════════════════════════════════════════════
    // NUEVO: Cargar nombres de compañías existentes
    // ═══════════════════════════════════════════════════════════
    private function cargarNombresExistentes()
    {
        $this->nombresExistentes = Compania::nombresUnicos()->toArray();
    }

    // ═══════════════════════════════════════════════════════════
    // NUEVO: Cuando el usuario escribe el nombre, mostrar coberturas existentes
    // ═══════════════════════════════════════════════════════════
    public function updatedNombre($value)
    {
        $this->validateOnly('nombre');
        
        // Si el nombre ya existe, cargar sus coberturas
        if ($value && in_array($value, $this->nombresExistentes)) {
            $this->coberturasExistentes = Compania::coberturasDisponiblesPorNombre($value)->toArray();
            $this->mostrarSugerencias = true;
        } else {
            $this->coberturasExistentes = [];
            $this->mostrarSugerencias = false;
        }
    }

    // Validación en tiempo real
    public function updatedCobertura($value)
    {
        $this->validateOnly('cobertura');
    }

    // ═══════════════════════════════════════════════════════════
    // MÉTODO PRINCIPAL: Guardar con validación profesional
    // ═══════════════════════════════════════════════════════════
    public function guardar()
    {
        $this->validate();

        // ═══════════════════════════════════════════════════════════
        // VALIDACIÓN CRÍTICA: Verificar que no exista Nombre + Cobertura
        // ═══════════════════════════════════════════════════════════
        if (Compania::existeCombinacion($this->nombre, $this->cobertura)) {
            $this->addError('cobertura', 'Ya existe una compañía con el nombre "' . $this->nombre . '" y la cobertura "' . $this->cobertura . '". Puedes usar el mismo nombre con una cobertura diferente.');
            return;
        }

        try {
            $compania = Compania::create([
                'Nombre' => $this->nombre,
                'Cobertura' => $this->cobertura,
            ]);

            // Mensaje de éxito diferenciado
            if (in_array($this->nombre, $this->nombresExistentes)) {
                session()->flash('message', 'Nueva cobertura "' . $this->cobertura . '" agregada exitosamente a ' . $this->nombre . '.');
            } else {
                session()->flash('message', 'Compañía "' . $compania->nombre_completo . '" creada exitosamente.');
            }
            
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