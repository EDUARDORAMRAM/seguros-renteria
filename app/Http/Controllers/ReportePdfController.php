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

        $polizas = $query->orderByRaw("SUBSTRING_INDEX(NumPoliza, '-', 1) ASC, CAST(SUBSTRING_INDEX(NumPoliza, '-', -1) AS UNSIGNED) ASC")->get();

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

        // Procesar pagos por mes para cada póliza
        $polizasConMeses = $polizas->map(function ($poliza) {
            $meses = [
                'E' => '', 'F' => '', 'M' => '', 'A' => '', 'MY' => '', 'J' => '',
                'JL' => '', 'AG' => '', 'S' => '', 'O' => '', 'N' => '', 'D' => ''
            ];

            $mesMap = [
                1 => 'E', 2 => 'F', 3 => 'M', 4 => 'A', 5 => 'MY', 6 => 'J',
                7 => 'JL', 8 => 'AG', 9 => 'S', 10 => 'O', 11 => 'N', 12 => 'D'
            ];

            // Para Anual: solo V en el mes de vencimiento, sin letra de pago
            // Para los demás: letras de pago (M, T, S) + V en mes de vencimiento
            if ($poliza->FormaPago !== 'Anual') {
                $letraFormaPago = match($poliza->FormaPago) {
                    'Mensual' => 'M',
                    'Trimestral' => 'T',
                    'Semestral' => 'S',
                    default => 'M',
                };

                foreach ($poliza->fechasCobranza as $pago) {
                    $mes = $pago->FechaCobranza->month;
                    $letra = $mesMap[$mes] ?? '';
                    if ($letra) {
                        $meses[$letra] = $letraFormaPago;
                    }
                }
            }

            // V en el mes de vencimiento (siempre, para todas las formas de pago)
            if ($poliza->FechaVencimiento) {
                $mesVenc = $poliza->FechaVencimiento->month;
                $letraVenc = $mesMap[$mesVenc] ?? '';
                if ($letraVenc) {
                    $meses[$letraVenc] = 'V';
                }
            }

            $poliza->mesesPago = $meses;
            return $poliza;
        });

        $data = [
            'asegurado' => $asegurado,
            'polizas' => $polizasConMeses,
            'estatus' => $estatus,
            'totalPolizas' => $polizas->count(),
            'totalPrima' => $totalPrima,
            'totalPagado' => $totalPagado,
            'totalPendiente' => $totalPendiente,
            'fechaReporte' => now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY'),
            'logoPath' => public_path('images/logoColor.png'),
        ];

        $pdf = Pdf::loadView('reportes.pdf.asegurado', $data);
        $pdf->setPaper('letter', 'landscape'); // Horizontal

        $nombreArchivo = 'REPORTE_' . str_replace(' ', '_', strtoupper($asegurado->nombre_completo)) . '.pdf';

        return $pdf->download($nombreArchivo);
    }
}