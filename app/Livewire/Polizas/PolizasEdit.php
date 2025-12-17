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
    public $FechaCobranza; // ← NUEVO
    public $Prima;
    public $Estatus;
    public $IdCompania;
    public $IdAsegurado;
    public $IdUnidad;

    // Para PDF
    public $archivoPdf;
    public $pdfActual;

    public $companias;
    public $asegurados;
    public $unidades;

    // Listener para refrescar cuando se cree un endoso
    protected $listeners = ['endosoCreado' => '$refresh'];

    protected $rules = [
        'NumPoliza' => 'required|unique:polizas,NumPoliza',
        'FormaPago' => 'required|in:Anual,Semestral,Trimestral,Mensual', // ← AGREGADO Trimestral
        'FechaInicio' => 'required|date',
        'FechaVencimiento' => 'required|date|after:FechaInicio',
        'FechaCobranza' => 'nullable|date|after_or_equal:FechaInicio', // ← NUEVO
        'Prima' => 'required|numeric|min:0',
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
        $this->FechaCobranza = $this->poliza->FechaCobranza ? $this->poliza->FechaCobranza->format('Y-m-d') : null; // ← NUEVO
        $this->Prima = $this->poliza->Prima;
        $this->Estatus = $this->poliza->Estatus;
        $this->IdCompania = $this->poliza->IdCompania;
        $this->IdAsegurado = $this->poliza->IdAsegurado;
        $this->IdUnidad = $this->poliza->IdUnidad;
        $this->pdfActual = $this->poliza->ArchivoPDF;
    }

    // ═══════════════════════════════════════════════════════════
    // ACTUALIZADO: Calcular fechas con Trimestral
    // ═══════════════════════════════════════════════════════════
    public function updatedFormaPago($value)
    {
        if ($this->FechaInicio) {
            $fechaInicio = \Carbon\Carbon::parse($this->FechaInicio);
            $this->FechaVencimiento = match($value) {
                'Anual' => $fechaInicio->copy()->addYear()->format('Y-m-d'),
                'Semestral' => $fechaInicio->copy()->addMonths(6)->format('Y-m-d'),
                'Trimestral' => $fechaInicio->copy()->addMonths(3)->format('Y-m-d'), // ← NUEVO
                'Mensual' => $fechaInicio->copy()->addMonth()->format('Y-m-d'),
                default => $fechaInicio->copy()->addYear()->format('Y-m-d'),
            };
            
            // ← NUEVO: Calcular Fecha de Cobranza igual al vencimiento
            $this->FechaCobranza = $this->FechaVencimiento;
        }
    }

    // ═══════════════════════════════════════════════════════════
    // NUEVO: Cuando cambie FechaInicio, recalcular ambas fechas
    // ═══════════════════════════════════════════════════════════
    public function updatedFechaInicio($value)
    {
        $this->updatedFormaPago($this->FormaPago);
    }

    public function actualizar()
    {
        $rules = $this->rules;
        $rules['NumPoliza'] = 'required|unique:polizas,NumPoliza,' . $this->poliza->IdPoliza . ',IdPoliza';

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