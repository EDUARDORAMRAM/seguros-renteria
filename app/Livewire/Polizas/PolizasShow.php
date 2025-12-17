<?php

namespace App\Livewire\Polizas;

use App\Models\Poliza;
use App\Models\FechaCobranza;
use Livewire\Component;

class PolizasShow extends Component
{
    public Poliza $poliza;

    protected $listeners = [
        'renovar-poliza' => 'renovar'
    ];

    public function mount(Poliza $poliza)
    {
        // ═══════════════════════════════════════════════════════════
        // CARGAR TODAS LAS RELACIONES NECESARIAS
        // ═══════════════════════════════════════════════════════════
        $this->poliza = $poliza->load([
            'asegurado', 
            'compania', 
            'unidad',
            'endosos',
            'fechasCobranza' // ← AGREGAR ESTA RELACIÓN
        ]);
    }

    public function cargarPoliza()
    {
        $this->poliza->refresh();
        $this->poliza->load([
            'asegurado', 
            'compania', 
            'unidad',
            'endosos',
            'fechasCobranza' // ← AGREGAR AQUÍ TAMBIÉN
        ]);
    }

    // ═══════════════════════════════════════════════════════════
    // NUEVO: Marcar fecha de cobranza como pagada
    // ═══════════════════════════════════════════════════════════
    public function marcarComoPagado($idFechaCobranza)
    {
        try {
            $fechaCobro = FechaCobranza::find($idFechaCobranza);
            
            if (!$fechaCobro) {
                session()->flash('error', 'Fecha de cobranza no encontrada.');
                return;
            }

            // Verificar que pertenece a esta póliza
            if ($fechaCobro->IdPoliza !== $this->poliza->IdPoliza) {
                session()->flash('error', 'Esta fecha de cobranza no pertenece a esta póliza.');
                return;
            }

            // Verificar que está pendiente
            if ($fechaCobro->Estatus !== 'Pendiente') {
                session()->flash('error', 'Esta fecha de cobranza ya fue procesada.');
                return;
            }

            // Marcar como pagado
            $fechaCobro->marcarComoPagado(
                now(),
                'Pago registrado desde el sistema'
            );

            // Recargar la póliza con sus relaciones
            $this->cargarPoliza();

            session()->flash('message', '✅ Pago registrado exitosamente el ' . now()->format('d/m/Y') . '.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al registrar el pago: ' . $e->getMessage());
        }
    }

    // ═══════════════════════════════════════════════════════════
    // NUEVO: Desmarcar pago (opcional, por si se equivocaron)
    // ═══════════════════════════════════════════════════════════
    public function desmarcarPago($idFechaCobranza)
    {
        try {
            $fechaCobro = FechaCobranza::find($idFechaCobranza);
            
            if (!$fechaCobro) {
                session()->flash('error', 'Fecha de cobranza no encontrada.');
                return;
            }

            if ($fechaCobro->Estatus !== 'Pagado') {
                session()->flash('error', 'Esta fecha de cobranza no está marcada como pagada.');
                return;
            }

            // Volver a pendiente
            $fechaCobro->update([
                'Estatus' => 'Pendiente',
                'FechaPago' => null,
                'Observaciones' => 'Pago desmarcado desde el sistema'
            ]);

            $this->cargarPoliza();

            session()->flash('message', 'Pago desmarcado exitosamente.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al desmarcar el pago: ' . $e->getMessage());
        }
    }

    public function renovar()
    {
        $nuevaFechaVencimiento = $this->poliza->FechaVencimiento->addYear();
        $this->poliza->renovar($nuevaFechaVencimiento);
        
        $this->cargarPoliza();
        session()->flash('message', 'Póliza renovada exitosamente.');
    }

    public function cancelar()
    {
        $this->poliza->cancelar();
        $this->cargarPoliza();
        session()->flash('message', 'Póliza cancelada exitosamente.');
    }

    public function render()
    {
        return view('livewire.polizas.polizas-show');
    }
}