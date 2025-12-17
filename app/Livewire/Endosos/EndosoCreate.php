<?php

namespace App\Livewire\Endosos;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Endoso;
use App\Models\Poliza;

class EndosoCreate extends Component
{
    use WithFileUploads;

    public $polizaId;
    public $poliza;
    
    // Control del modal
    public $mostrarModal = false;
    
    // Campos del formulario
    public $tipo_endoso = 'Modificacion';
    public $descripcion;
    public $monto_afectado;
    public $archivo_adjunto;

    public function mount($polizaId)
    {
        $this->polizaId = $polizaId;
        $this->poliza = Poliza::with('compania', 'asegurado', 'unidad')->findOrFail($polizaId);
    }

    public function rules()
    {
        return [
            'tipo_endoso' => 'required|in:Modificacion,Renovacion,Cancelacion,Cambio Suma Asegurada,Cambio Beneficiario,Cambio Unidad,Otro',
            'descripcion' => 'required|min:10|max:1000',
            'monto_afectado' => 'nullable|numeric|min:0',
            'archivo_adjunto' => 'nullable|file|mimes:pdf|max:5120', // 5MB
        ];
    }

    protected $messages = [
        'tipo_endoso.required' => 'El tipo de endoso es obligatorio',
        'descripcion.required' => 'La descripción es obligatoria',
        'descripcion.min' => 'La descripción debe tener al menos 10 caracteres',
        'archivo_adjunto.mimes' => 'El archivo debe ser un PDF',
        'archivo_adjunto.max' => 'El archivo no debe superar 5MB',
    ];

    public function abrirModal()
    {
        $this->resetValidation();
        $this->reset(['tipo_endoso', 'descripcion', 'monto_afectado', 'archivo_adjunto']);
        $this->tipo_endoso = 'Modificacion';
        $this->mostrarModal = true;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->reset(['tipo_endoso', 'descripcion', 'monto_afectado', 'archivo_adjunto']);
        $this->resetValidation();
    }

    public function guardar()
    {
        $this->validate();

        $endoso = new Endoso();
        $endoso->IdPoliza = $this->polizaId;
        $endoso->NumEndoso = Endoso::generarNumero();
        $endoso->FechaEndoso = now();
        $endoso->TipoEndoso = $this->tipo_endoso;
        $endoso->Descripcion = $this->descripcion;
        $endoso->MontoAfectado = $this->monto_afectado;
        $endoso->user_id = auth()->id();

        // Guardar archivo si existe
        if ($this->archivo_adjunto) {
            $numeroLimpio = str_replace(['END-', '-'], ['', '_'], $endoso->NumEndoso);
            $nombreArchivo = 'endoso_' . $numeroLimpio . '_' . time() . '.pdf';
            $this->archivo_adjunto->storeAs('endosos', $nombreArchivo, 'public');
            $endoso->ArchivoAdjunto = $nombreArchivo;
        }

        $endoso->save();

        $this->cerrarModal();
        
        // Emitir evento para refrescar el padre
        $this->dispatch('endosoCreado');
        
        session()->flash('message', 'Endoso registrado exitosamente con número: ' . $endoso->NumEndoso);
    }

    public function eliminar($endosoId)
    {
        $endoso = Endoso::findOrFail($endosoId);
        
        // Verificar que pertenece a esta póliza
        if ($endoso->IdPoliza != $this->polizaId) {
            session()->flash('error', 'No tienes permiso para eliminar este endoso');
            return;
        }

        // Eliminar archivo si existe
        $endoso->eliminarArchivoAnterior();
        
        $endoso->delete();

        $this->dispatch('endosoCreado');
        session()->flash('message', 'Endoso eliminado exitosamente');
    }

    public function render()
    {
        $endosos = Endoso::where('IdPoliza', $this->polizaId)
            ->with('usuario')
            ->orderBy('FechaEndoso', 'desc')
            ->get();

        return view('livewire.endosos.endoso-create', [
            'endosos' => $endosos
        ]);
    }
}