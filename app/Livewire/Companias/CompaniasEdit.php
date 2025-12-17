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

    // ═══════════════════════════════════════════════════════════
    // NUEVO: Para mostrar sugerencias y validaciones
    // ═══════════════════════════════════════════════════════════
    public $nombreOriginal = '';
    public $coberturaOriginal = '';
    public $coberturasExistentes = [];
    public $mostrarSugerencias = false;

    // Montar el componente con los datos existentes
    public function mount(Compania $compania)
    {
        $this->compania = $compania;
        $this->nombre = $compania->Nombre;
        $this->cobertura = $compania->Cobertura;
        
        // ═══════════════════════════════════════════════════════════
        // NUEVO: Guardar valores originales
        // ═══════════════════════════════════════════════════════════
        $this->nombreOriginal = $compania->Nombre;
        $this->coberturaOriginal = $compania->Cobertura;
    }

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
    // NUEVO: Cuando cambia el nombre, mostrar coberturas existentes
    // ═══════════════════════════════════════════════════════════
    public function updatedNombre($value)
    {
        $this->validateOnly('nombre');
        
        // Si el nombre cambió y ya existe, mostrar sus coberturas
        if ($value && $value !== $this->nombreOriginal) {
            $this->coberturasExistentes = Compania::coberturasDisponiblesPorNombre($value)->toArray();
            $this->mostrarSugerencias = count($this->coberturasExistentes) > 0;
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
    // MÉTODO PRINCIPAL: Actualizar con validación profesional
    // ═══════════════════════════════════════════════════════════
    public function actualizar()
    {
        $this->validate();

        // ═══════════════════════════════════════════════════════════
        // VALIDACIÓN CRÍTICA: Verificar que no exista Nombre + Cobertura
        // (excluyendo la compañía actual)
        // ═══════════════════════════════════════════════════════════
        if (Compania::existeCombinacion($this->nombre, $this->cobertura, $this->compania->IdCompania)) {
            $this->addError('cobertura', 'Ya existe otra compañía con el nombre "' . $this->nombre . '" y la cobertura "' . $this->cobertura . '".');
            return;
        }

        try {
            // Detectar si cambió el nombre o cobertura
            $cambioNombre = $this->nombre !== $this->nombreOriginal;
            $cambioCobertura = $this->cobertura !== $this->coberturaOriginal;

            $this->compania->update([
                'Nombre' => $this->nombre,
                'Cobertura' => $this->cobertura,
            ]);

            // Mensaje de éxito personalizado
            if ($cambioNombre && $cambioCobertura) {
                session()->flash('message', 'Compañía actualizada: "' . $this->compania->nombre_completo . '"');
            } elseif ($cambioNombre) {
                session()->flash('message', 'Nombre actualizado a "' . $this->nombre . '" para la cobertura "' . $this->cobertura . '"');
            } elseif ($cambioCobertura) {
                session()->flash('message', 'Cobertura actualizada a "' . $this->cobertura . '" para ' . $this->nombre);
            } else {
                session()->flash('message', 'Compañía actualizada exitosamente.');
            }
            
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
        $totalPolizas = $this->compania->total_polizas;
        $polizasActivas = $this->compania->total_polizas_activas;
        $primasTotales = $this->compania->primas_totales;

        return view('livewire.companias.companias-edit', [
            'totalPolizas' => $totalPolizas,
            'polizasActivas' => $polizasActivas,
            'primasTotales' => $primasTotales,
        ]);
    }
}