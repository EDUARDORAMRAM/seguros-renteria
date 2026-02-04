<?php

namespace App\Http\Controllers;

use App\Models\Asegurado;
use App\Models\Poliza;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportePdfController extends Controller
{
    public function asegurado($aseguradoId, $estatus)
    {
        $asegurado = Asegurado::findOrFail($aseguradoId);

        $query = Poliza::where('IdAsegurado', $aseguradoId)
            ->with(['compania', 'unidad', 'fechasCobranza']);

        if ($estatus === 'activas') {
            $query->where('Estatus', 'Activa');
        } elseif ($estatus === 'vencidas') {
            $query->where('Estatus', 'Vencida');
        } elseif ($estatus === 'canceladas') {
            $query->where('Estatus', 'Cancelada');
        }

        $polizas = $query->orderBy('FechaVencimiento', 'desc')->get();

        // Calcular totales
        $totalPrima = $polizas->sum('Prima');
        $totalPagado = 0;
        $totalPendiente = 0;

        foreach ($polizas as $poliza) {
            foreach ($poliza->fechasCobranza as $fecha) {
                if ($fecha->Estatus === 'Pagado') {
                    $totalPagado += $fecha->MontoCobro;
                } else {
                    $totalPendiente += $fecha->MontoCobro;
                }
            }
        }

        $data = [
            'asegurado' => $asegurado,
            'polizas' => $polizas,
            'estatus' => $estatus,
            'totalPolizas' => $polizas->count(),
            'totalPrima' => $totalPrima,
            'totalPagado' => $totalPagado,
            'totalPendiente' => $totalPendiente,
            'fechaReporte' => now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY'),
        ];

        $pdf = Pdf::loadView('reportes.pdf.asegurado', $data);
        $pdf->setPaper('letter', 'portrait');

        $nombreArchivo = 'Reporte_' . str_replace(' ', '_', $asegurado->nombre_completo) . '_' . now()->format('Ymd') . '.pdf';

        return $pdf->download($nombreArchivo);
    }
}
