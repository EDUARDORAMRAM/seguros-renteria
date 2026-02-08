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

            // Letra según forma de pago: M=Mensual, T=Trimestral, S=Semestral, A=Anual
            $letraFormaPago = match($poliza->FormaPago) {
                'Mensual' => 'M',
                'Trimestral' => 'T',
                'Semestral' => 'S',
                'Anual' => 'A',
                default => 'A',
            };

            // Marcar meses de pago con la letra de la forma de pago
            foreach ($poliza->fechasCobranza as $pago) {
                $mes = $pago->FechaCobranza->month;
                $letra = $mesMap[$mes] ?? '';

                if ($letra) {
                    $meses[$letra] = $letraFormaPago;
                }
            }

            // Marcar el mes de inicio de la póliza con V (vencimiento)
            if ($poliza->FechaInicio) {
                $mesInicio = $poliza->FechaInicio->month;
                $letraInicio = $mesMap[$mesInicio] ?? '';
                if ($letraInicio) {
                    $meses[$letraInicio] = 'V';
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