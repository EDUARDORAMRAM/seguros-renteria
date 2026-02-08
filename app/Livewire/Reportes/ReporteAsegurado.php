<?php

namespace App\Livewire\Reportes;

use App\Models\Asegurado;
use App\Models\Poliza;
use Livewire\Component;

class ReporteAsegurado extends Component
{
    public $busqueda = '';
    public $aseguradoId = '';
    public $estatus = 'todas';
    public $aseguradoSeleccionado = null;
    public $polizasPreview = [];

    protected $rules = [
        'aseguradoId' => 'required',
        'estatus' => 'required|in:todas,activas,vencidas,canceladas',
    ];

    protected $messages = [
        'aseguradoId.required' => 'Debes seleccionar un asegurado.',
    ];

    public function updatedAseguradoId($value)
    {
        if ($value) {
            $this->aseguradoSeleccionado = Asegurado::find($value);
            $this->cargarPreview();
        } else {
            $this->aseguradoSeleccionado = null;
            $this->polizasPreview = [];
        }
    }

    public function updatedEstatus()
    {
        $this->cargarPreview();
    }

    public function cargarPreview()
    {
        if (!$this->aseguradoId) {
            $this->polizasPreview = [];
            return;
        }

        $query = Poliza::where('IdAsegurado', $this->aseguradoId)
            ->with(['compania', 'unidad', 'fechasCobranza']);

        if ($this->estatus === 'activas') {
            $query->where('Estatus', 'Activa');
        } elseif ($this->estatus === 'vencidas') {
            $query->where('Estatus', 'Vencida');
        } elseif ($this->estatus === 'canceladas') {
            $query->where('Estatus', 'Cancelada');
        }

        $this->polizasPreview = $query->orderByRaw("SUBSTRING_INDEX(NumPoliza, '-', 1) ASC, CAST(SUBSTRING_INDEX(NumPoliza, '-', -1) AS UNSIGNED) ASC")->get();
    }

    public function getAseguradosProperty()
    {
        if (strlen($this->busqueda) >= 2) {
            return Asegurado::where('Nombre', 'like', "%{$this->busqueda}%")
                ->orWhere('ApellidoPaterno', 'like', "%{$this->busqueda}%")
                ->orWhere('ApellidoMaterno', 'like', "%{$this->busqueda}%")
                ->orWhere('RFC', 'like', "%{$this->busqueda}%")
                ->orderBy('Nombre')
                ->limit(50)
                ->get();
        }

        return Asegurado::orderBy('Nombre')->limit(50)->get();
    }

    public function getResumenProperty()
    {
        if (!$this->polizasPreview || count($this->polizasPreview) === 0) {
            return null;
        }

        $totalPolizas = count($this->polizasPreview);
        $totalPrima = $this->polizasPreview->sum('Prima');
        $totalPagado = 0;
        $totalPendiente = 0;

        foreach ($this->polizasPreview as $poliza) {
            foreach ($poliza->fechasCobranza as $fecha) {
                if ($fecha->Estatus === 'Pagado') {
                    $totalPagado += $fecha->MontoCobro;
                } else {
                    $totalPendiente += $fecha->MontoCobro;
                }
            }
        }

        return [
            'totalPolizas' => $totalPolizas,
            'totalPrima' => $totalPrima,
            'totalPagado' => $totalPagado,
            'totalPendiente' => $totalPendiente,
        ];
    }

    public function generarPdf()
    {
        $this->validate();

        return redirect()->route('reportes.asegurado.pdf', [
            'asegurado' => $this->aseguradoId,
            'estatus' => $this->estatus,
        ]);
    }

    public function render()
    {
        return view('livewire.reportes.reporte-asegurado');
    }
}
