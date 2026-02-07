<?php

namespace App\Livewire;

use App\Models\Poliza;
use App\Models\Asegurado;
use App\Models\Compania;
use App\Models\Unidad;
use App\Models\FechaCobranza;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    use WithPagination;

    // Refrescar automáticamente cada 60 segundos
    protected $listeners = ['polizaCreada' => '$refresh', 'polizaActualizada' => '$refresh'];

    protected $paginationTheme = 'tailwind';

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
            
            // ═══════════════════════════════════════════════════════════
            // CORREGIDO: Ahora cuenta FechasCobranza en lugar de Polizas
            // ═══════════════════════════════════════════════════════════
            'proximas_cobrar' => FechaCobranza::proximas(7)->count(),
            
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
            ->paginate(10, ['*'], 'vencerPage');
    }

    // ═══════════════════════════════════════════════════════════
    // CORREGIDO: Obtener FECHAS DE COBRANZA próximas con paginación
    // Ordenadas por fecha de cobranza (más urgentes primero)
    // ═══════════════════════════════════════════════════════════
    public function getPolizasProximasCobrarProperty()
    {
        // Obtener IDs únicos de pólizas con su fecha de cobranza más próxima
        $subquery = FechaCobranza::proximas(7)
            ->select('IdPoliza', DB::raw('MIN(FechaCobranza) as fecha_minima'))
            ->groupBy('IdPoliza');

        // Paginar las pólizas ordenadas por la fecha de cobranza más próxima
        $polizasPaginadas = Poliza::with(['asegurado', 'compania', 'unidad'])
            ->joinSub($subquery, 'cobranzas', function ($join) {
                $join->on('polizas.IdPoliza', '=', 'cobranzas.IdPoliza');
            })
            ->orderBy('cobranzas.fecha_minima', 'asc')
            ->select('polizas.*')
            ->paginate(10, ['*'], 'cobrarPage');

        // Agregar datos de cobranza a cada póliza
        $polizasPaginadas->getCollection()->transform(function ($poliza) {
            $fechaMasProxima = FechaCobranza::where('IdPoliza', $poliza->IdPoliza)
                ->proximas(7)
                ->orderBy('FechaCobranza', 'asc')
                ->first();

            if ($fechaMasProxima) {
                $diasRestantes = (int) now()->diffInDays($fechaMasProxima->FechaCobranza, false);
                $poliza->proxima_fecha_cobranza = $fechaMasProxima->FechaCobranza;
                $poliza->proximo_monto_cobro = $fechaMasProxima->MontoCobro;
                $poliza->dias_para_cobrar_real = $diasRestantes;
            }

            return $poliza;
        });

        return $polizasPaginadas;
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