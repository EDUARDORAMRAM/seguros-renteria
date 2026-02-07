<?php

namespace App\Livewire\Polizas;

use App\Models\Poliza;
use App\Models\FechaCobranza;
use Livewire\Component;

class PolizasShow extends Component
{
    public Poliza $poliza;

    protected $listeners = [];

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

    // ═══════════════════════════════════════════════════════════
    // Verificar si todos los pagos están completados
    // ═══════════════════════════════════════════════════════════
    public function tienePagosPendientes()
    {
        return $this->poliza->fechasCobranza()
            ->where('Estatus', 'Pendiente')
            ->count() > 0;
    }

    public function contarPagosPendientes()
    {
        return $this->poliza->fechasCobranza()
            ->where('Estatus', 'Pendiente')
            ->count();
    }

    // ═══════════════════════════════════════════════════════════
    // Renovar póliza (solo si todos los pagos están completados)
    // ═══════════════════════════════════════════════════════════
    public function renovar()
    {
        // Verificar que todos los pagos estén completados
        $pagosPendientes = $this->contarPagosPendientes();

        if ($pagosPendientes > 0) {
            session()->flash('error', "No se puede renovar la póliza. Hay {$pagosPendientes} pago(s) pendiente(s). Todos los pagos deben estar completados antes de renovar.");
            return;
        }

        try {
            // Calcular nuevas fechas (un año más desde la fecha de vencimiento actual)
            $nuevaFechaInicio = $this->poliza->FechaVencimiento->copy();
            $nuevaFechaVencimiento = $nuevaFechaInicio->copy()->addYear();

            // Primera fecha de cobranza: 1 mes después del inicio
            $nuevaFechaCobranza = $nuevaFechaInicio->copy()->addMonth();

            // Actualizar la póliza
            $this->poliza->FechaInicio = $nuevaFechaInicio;
            $this->poliza->FechaVencimiento = $nuevaFechaVencimiento;
            $this->poliza->FechaCobranza = $nuevaFechaCobranza;
            $this->poliza->Estatus = 'Activa';
            $this->poliza->Prima = 0; // Se recalculará con los nuevos montos
            $this->poliza->save();

            // Eliminar las fechas de cobranza anteriores (ya pagadas)
            $this->poliza->fechasCobranza()->delete();

            // Generar nuevas fechas de cobranza para el nuevo período
            $this->poliza->generarFechasCobranza();

            // Recargar la póliza
            $this->cargarPoliza();

            session()->flash('message', '✅ Póliza renovada exitosamente. Nuevo período: ' .
                $nuevaFechaInicio->format('d/m/Y') . ' - ' . $nuevaFechaVencimiento->format('d/m/Y') .
                '. Por favor, configure los montos de las nuevas cobranzas.');

        } catch (\Exception $e) {
            session()->flash('error', 'Error al renovar la póliza: ' . $e->getMessage());
        }
    }

    public function cancelar()
    {
        $this->poliza->cancelar();
        $this->cargarPoliza();
        session()->flash('message', 'Póliza cancelada exitosamente.');
    }

    public function eliminarPoliza()
    {
        // Solo permitir eliminar pólizas canceladas
        if ($this->poliza->Estatus !== 'Cancelada') {
            session()->flash('error', 'Solo se pueden eliminar pólizas canceladas.');
            return;
        }

        try {
            // Eliminar PDF si existe
            $this->poliza->eliminarPdfAnterior();

            // Eliminar fechas de cobranza asociadas
            $this->poliza->fechasCobranza()->delete();

            // Eliminar endosos asociados
            $this->poliza->endosos()->delete();

            // Eliminar la póliza
            $this->poliza->delete();

            session()->flash('message', 'Póliza eliminada exitosamente.');

            return redirect()->route('polizas.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar la póliza: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.polizas.polizas-show');
    }
}