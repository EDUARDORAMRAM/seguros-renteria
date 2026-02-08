<?php

namespace App\Livewire\Polizas;

use App\Models\Poliza;
use App\Models\Asegurado;
use App\Models\Compania;
use App\Models\Unidad;
use Livewire\Component;
use Livewire\WithFileUploads;

class PolizasEdit extends Component
{
    use WithFileUploads;

    public Poliza $poliza;
    public $NumPoliza;
    public $FormaPago;
    public $FechaInicio;
    public $FechaVencimiento;
    public $FechaCobranza;
    public $Prima;
    public $Estatus;
    public $IdCompania;
    public $IdAsegurado;
    public $IdUnidad;

    // Para montos de cobranza
    public $montoPrimerPago = 0;
    public $montoSegundoPago = 0;
    public $mostrarSeccionMontos = false;

    // Para control de cambio de forma de pago
    public $formaPagoAnterior;
    public $mostrarAlertaCambioFormaPago = false;
    public $nuevaFormaPago;

    // Para PDF
    public $archivoPdf;
    public $pdfActual;

    public $companias;
    public $asegurados;
    public $unidades;

    // Listeners
    protected $listeners = [
        'endosoCreado' => '$refresh',
        'aseguradoCreado' => 'actualizarAsegurados',
        'unidadCreada' => 'actualizarUnidades',
    ];

    public function actualizarAsegurados($idAsegurado = null)
    {
        $this->asegurados = Asegurado::orderBy('Nombre')->get();
        if ($idAsegurado) {
            $this->IdAsegurado = $idAsegurado;
        }
    }

    public function actualizarUnidades($idUnidad = null)
    {
        $this->unidades = Unidad::orderBy('Marca')->get();
        if ($idUnidad) {
            $this->IdUnidad = $idUnidad;
        }
    }

    protected $rules = [
        'NumPoliza' => 'required|unique:polizas,NumPoliza',
        'FormaPago' => 'required|in:Anual,Semestral,Trimestral,Mensual',
        'FechaInicio' => 'required|date',
        'FechaVencimiento' => 'required|date|after:FechaInicio',
        'FechaCobranza' => 'nullable|date|after_or_equal:FechaInicio',
        'Prima' => 'nullable|numeric|min:0', // Se calcula desde los montos de cobranza
        'Estatus' => 'required|in:Activa,Vencida,Cancelada',
        'IdCompania' => 'required|exists:companias,IdCompania',
        'IdAsegurado' => 'required|exists:asegurados,IdAsegurado',
        'IdUnidad' => 'required|exists:unidads,IdUnidad',
        'archivoPdf' => 'nullable|file|mimes:pdf|max:10240',
    ];

    public function mount(Poliza $poliza)
    {
        $this->poliza = $poliza;
        $this->cargarPoliza();
        $this->cargarDatos();

        // Guardar forma de pago original para detectar cambios
        $this->formaPagoAnterior = $this->FormaPago;
    }

    public function cargarDatos()
    {
        $this->companias = Compania::orderBy('Nombre')->get();
        $this->asegurados = Asegurado::orderBy('Nombre')->get();
        $this->unidades = Unidad::orderBy('Marca')->get();
    }

    public function cargarPoliza()
    {
        $this->NumPoliza = $this->poliza->NumPoliza;
        $this->FormaPago = $this->poliza->FormaPago;
        $this->FechaInicio = $this->poliza->FechaInicio->format('Y-m-d');
        $this->FechaVencimiento = $this->poliza->FechaVencimiento->format('Y-m-d');
        $this->FechaCobranza = $this->poliza->FechaCobranza ? $this->poliza->FechaCobranza->format('Y-m-d') : null;
        $this->Prima = $this->poliza->Prima;
        $this->Estatus = $this->poliza->Estatus;
        $this->IdCompania = $this->poliza->IdCompania;
        $this->IdAsegurado = $this->poliza->IdAsegurado;
        $this->IdUnidad = $this->poliza->IdUnidad;
        $this->pdfActual = $this->poliza->ArchivoPDF;

        // Cargar montos de cobranza existentes
        $this->cargarMontosCobranza();
    }

    public function cargarMontosCobranza()
    {
        $fechas = $this->poliza->fechasCobranza()->orderBy('FechaCobranza', 'asc')->get();

        if ($fechas->count() > 0) {
            $this->montoPrimerPago = $fechas->first()->MontoCobro ?? 0;

            if ($fechas->count() > 1) {
                $this->montoSegundoPago = $fechas->skip(1)->first()->MontoCobro ?? 0;
            }

            // Mostrar sección de montos si hay fechas de cobranza
            $this->mostrarSeccionMontos = true;
        }
    }

    // ═══════════════════════════════════════════════════════════
    // Detectar cambio de forma de pago y mostrar alerta
    // ═══════════════════════════════════════════════════════════
    public function updatedFormaPago($value)
    {
        // Si hay fechas de cobranza existentes, mostrar alerta de confirmación
        if ($this->poliza->fechasCobranza()->count() > 0 && $value !== $this->formaPagoAnterior) {
            $this->nuevaFormaPago = $value;
            $this->mostrarAlertaCambioFormaPago = true;
            // Revertir temporalmente al valor anterior
            $this->FormaPago = $this->formaPagoAnterior;
        } else {
            // No hay fechas existentes, aplicar cambio directamente
            $this->aplicarCambioFormaPago($value);
        }
    }

    // ═══════════════════════════════════════════════════════════
    // Confirmar cambio de forma de pago (elimina fechas y regenera)
    // ═══════════════════════════════════════════════════════════
    public function confirmarCambioFormaPago()
    {
        $this->FormaPago = $this->nuevaFormaPago;
        $this->formaPagoAnterior = $this->nuevaFormaPago;
        $this->mostrarAlertaCambioFormaPago = false;

        // Aplicar el cambio
        $this->aplicarCambioFormaPago($this->FormaPago);

        // Actualizar la póliza con la nueva forma de pago
        $this->poliza->FormaPago = $this->FormaPago;
        $this->poliza->FechaCobranza = $this->FechaCobranza;
        $this->poliza->save();

        // Regenerar fechas de cobranza con la nueva forma de pago
        $this->poliza->generarFechasCobranza();
        $this->poliza->refresh();

        // Recargar montos (serán 0 porque se regeneraron)
        $this->cargarMontosCobranza();
        $this->Prima = 0;

        session()->flash('message', 'Forma de pago actualizada. Se han regenerado las fechas de cobranza. Por favor, configure los nuevos montos.');
    }

    // ═══════════════════════════════════════════════════════════
    // Cancelar cambio de forma de pago
    // ═══════════════════════════════════════════════════════════
    public function cancelarCambioFormaPago()
    {
        $this->mostrarAlertaCambioFormaPago = false;
        $this->nuevaFormaPago = null;
        // FormaPago ya está en el valor anterior
    }

    // ═══════════════════════════════════════════════════════════
    // Aplicar cambio de forma de pago (recalcular fechas)
    // ═══════════════════════════════════════════════════════════
    private function aplicarCambioFormaPago($value)
    {
        if ($this->FechaInicio) {
            $fechaInicio = \Carbon\Carbon::parse($this->FechaInicio);
            // La fecha de vencimiento siempre es 1 año
            $this->FechaVencimiento = $fechaInicio->copy()->addYear()->format('Y-m-d');

            // Primera fecha de cobranza: mismo día del inicio de la póliza
            $this->FechaCobranza = $fechaInicio->copy()->format('Y-m-d');
        }
    }

    // ═══════════════════════════════════════════════════════════
    // Cuando cambie FechaInicio, recalcular fechas
    // ═══════════════════════════════════════════════════════════
    public function updatedFechaInicio($value)
    {
        $this->aplicarCambioFormaPago($this->FormaPago);
    }

    // ═══════════════════════════════════════════════════════════
    // Cuando cambie FechaCobranza, regenerar fechas de pago
    // ═══════════════════════════════════════════════════════════
    public function updatedFechaCobranza($value)
    {
        // Solo regenerar si hay valor válido
        if ($value && $this->FechaInicio) {
            // Actualizar en la póliza
            $this->poliza->FechaCobranza = $value;
            $this->poliza->save();

            // Regenerar las fechas de cobranza basándose en la nueva fecha
            $this->regenerarFechasDesdeCobranza();

            session()->flash('message', 'Fechas de cobranza actualizadas según la nueva fecha. Por favor, revise los montos.');
        }
    }

    // ═══════════════════════════════════════════════════════════
    // Regenerar fechas de cobranza desde la fecha de cobranza editada
    // ═══════════════════════════════════════════════════════════
    public function regenerarFechasDesdeCobranza()
    {
        // Eliminar fechas anteriores
        $this->poliza->fechasCobranza()->delete();

        $fechaCobranza = \Carbon\Carbon::parse($this->FechaCobranza);
        $fechaVencimiento = \Carbon\Carbon::parse($this->FechaVencimiento);

        // Calcular intervalo según forma de pago
        $mesesIntervalo = match($this->FormaPago) {
            'Mensual' => 1,
            'Trimestral' => 3,
            'Semestral' => 6,
            'Anual' => 12,
            default => 12,
        };

        // Calcular número de pagos
        $numPagos = match($this->FormaPago) {
            'Mensual' => 12,
            'Trimestral' => 4,
            'Semestral' => 2,
            'Anual' => 1,
            default => 1,
        };

        // Generar fechas comenzando desde la fecha de cobranza
        $fechaActual = $fechaCobranza->copy();

        for ($i = 0; $i < $numPagos; $i++) {
            $this->poliza->fechasCobranza()->create([
                'FechaCobranza' => $fechaActual->format('Y-m-d'),
                'MontoCobro' => 0,
                'Estatus' => 'Pendiente',
            ]);

            $fechaActual->addMonths($mesesIntervalo);
        }

        // Recargar la póliza y los montos
        $this->poliza->refresh();
        $this->cargarMontosCobranza();
    }

    // ═══════════════════════════════════════════════════════════
    // ACTUALIZAR MONTOS DE COBRANZA
    // ═══════════════════════════════════════════════════════════
    public function actualizarMontos()
    {
        $this->validate([
            'montoPrimerPago' => 'required|numeric|min:0',
            'montoSegundoPago' => 'required|numeric|min:0',
        ], [
            'montoPrimerPago.required' => 'El monto del primer pago es obligatorio',
            'montoPrimerPago.min' => 'El monto no puede ser negativo',
            'montoSegundoPago.required' => 'El monto del segundo pago es obligatorio',
            'montoSegundoPago.min' => 'El monto no puede ser negativo',
        ]);

        // Actualizar montos en la base de datos
        $nuevaPrima = $this->poliza->actualizarMontosCobranza(
            $this->montoPrimerPago,
            $this->montoSegundoPago
        );

        // Recargar la póliza para obtener datos actualizados
        $this->poliza->refresh();

        // Actualizar la prima en el formulario
        $this->Prima = $nuevaPrima;

        session()->flash('message', 'Montos de cobranza actualizados. Prima total: $' . number_format($nuevaPrima, 2));
    }

    // ═══════════════════════════════════════════════════════════
    // GENERAR/REGENERAR FECHAS DE COBRANZA
    // ═══════════════════════════════════════════════════════════
    public function regenerarFechasCobranza()
    {
        $this->poliza->generarFechasCobranza();
        $this->cargarMontosCobranza();

        session()->flash('message', 'Fechas de cobranza regeneradas. Por favor, configure los montos.');
    }

    public function actualizar()
    {
        $rules = $this->rules;
        $rules['NumPoliza'] = 'required|unique:polizas,NumPoliza,' . $this->poliza->IdPoliza . ',IdPoliza';

        try {
            // Convertir NumPoliza a mayúsculas
            $this->NumPoliza = strtoupper($this->NumPoliza);

            $validated = $this->validate($rules);

            // Guardar PDF si se subió uno nuevo
            if ($this->archivoPdf) {
                // Eliminar PDF anterior si existe
                $this->poliza->eliminarPdfAnterior();

                // Guardar nuevo PDF
                $nombreArchivo = 'poliza_' . str_replace(['/', '-', ' '], '_', $this->NumPoliza) . '_' . time() . '.pdf';
                $this->archivoPdf->storeAs('polizas', $nombreArchivo, 'public');

                $validated['ArchivoPDF'] = $nombreArchivo;
            }

            $this->poliza->update($validated);

            session()->flash('message', 'Póliza actualizada exitosamente.');

            return redirect()->route('polizas.show', $this->poliza);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar la póliza: ' . $e->getMessage());
        }
    }

    // Método para eliminar PDF
    public function eliminarPdf()
    {
        $this->poliza->eliminarPdfAnterior();
        $this->poliza->ArchivoPDF = null;
        $this->poliza->save();
        
        $this->pdfActual = null;
        session()->flash('message', 'PDF eliminado exitosamente');
    }

    public function render()
    {
        return view('livewire.polizas.polizas-edit');
    }
}