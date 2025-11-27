<?php

namespace App\Livewire;

use App\Models\Poliza;
use App\Models\Asegurado;
use App\Models\Compania;
use App\Models\Unidad;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    // Refrescar automáticamente cada 60 segundos
    protected $listeners = ['polizaCreada' => '$refresh', 'polizaActualizada' => '$refresh'];

    public function mount()
    {
        // Puedes agregar lógica inicial aquí si es necesario
    }

    public function getStatsProperty()
    {
        return [
            'total_polizas' => Poliza::count(),
            'polizas_activas' => Poliza::activas()->count(),
            'polizas_vencidas' => Poliza::vencidas()->count(),
            'proximas_vencer' => Poliza::proximasAVencer(30)->count(),
            'total_asegurados' => Asegurado::count(),
            'total_companias' => Compania::count(),
            'total_unidades' => Unidad::count(),
            'prima_total_mes' => Poliza::activas()
                ->whereMonth('FechaInicio', now()->month)
                ->whereYear('FechaInicio', now()->year)
                ->sum('Prima'),
        ];
    }

    public function getPolizasProximasVencerProperty()
    {
        return Poliza::with(['asegurado', 'compania', 'unidad'])
            ->proximasAVencer(30)
            ->orderBy('FechaVencimiento', 'asc')
            ->get();
    }

    public function getPolizasRecientesProperty()
    {
        return Poliza::with(['asegurado', 'compania'])
            ->latest('created_at')
            ->limit(5)
            ->get();
    }

    public function getPolizasPorMesProperty()
    {
        return Poliza::select(
                DB::raw('MONTH(FechaInicio) as mes'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(Prima) as prima_total')
            )
            ->whereYear('FechaInicio', now()->year)
            ->groupBy('mes')
            ->get();
    }

    public function getPolizasPorCompaniaProperty()
    {
        return Compania::withCount('polizasActivas')
            ->having('polizas_activas_count', '>', 0)
            ->orderBy('polizas_activas_count', 'desc')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard');
        
    }
}