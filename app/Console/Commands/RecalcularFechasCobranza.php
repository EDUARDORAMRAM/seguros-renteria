<?php

namespace App\Console\Commands;

use App\Models\Poliza;
use App\Models\FechaCobranza;
use Illuminate\Console\Command;

class RecalcularFechasCobranza extends Command
{
    protected $signature = 'polizas:recalcular-cobranzas';
    protected $description = 'Recalcula las fechas de cobranza para que el primer pago sea 1 mes después del inicio';

    public function handle()
    {
        $this->info('Iniciando recálculo de fechas de cobranza...');
        $this->info('Nueva lógica: primer pago = FechaInicio + 1 mes, siguientes = intervalo normal');
        $this->newLine();

        $polizas = Poliza::with('fechasCobranza')->get();
        $recalculadas = 0;
        $sinCambios = 0;
        $errores = 0;

        foreach ($polizas as $poliza) {
            try {
                $fechasActuales = $poliza->fechasCobranza()->orderBy('FechaCobranza')->get();

                if ($fechasActuales->isEmpty()) {
                    $this->line("  [SKIP] Póliza {$poliza->NumPoliza}: sin fechas de cobranza");
                    continue;
                }

                // Calcular nuevas fechas con la nueva lógica
                $nuevasFechas = Poliza::calcularFechasCobranza(
                    $poliza->FechaInicio,
                    $poliza->FechaVencimiento,
                    $poliza->FormaPago
                );

                // Verificar si las fechas ya son correctas
                $fechasActualesArray = $fechasActuales->pluck('FechaCobranza')
                    ->map(fn($f) => \Carbon\Carbon::parse($f)->format('Y-m-d'))
                    ->toArray();

                if ($fechasActualesArray === $nuevasFechas) {
                    $sinCambios++;
                    continue;
                }

                // Guardar info de pagos ya realizados
                $pagosRealizados = $fechasActuales->where('Estatus', 'Pagado')->count();
                $montosPrevios = $fechasActuales->pluck('MontoCobro')->toArray();

                // Calcular monto por pago (usar el más común de los existentes)
                $montoPorPago = 0;
                if (count($montosPrevios) > 0) {
                    // Usar el monto del segundo pago si existe, si no el primero
                    $montoPorPago = count($montosPrevios) > 1 ? $montosPrevios[1] : $montosPrevios[0];
                }
                $montoPrimerPago = $montosPrevios[0] ?? 0;

                // Eliminar fechas anteriores
                $poliza->fechasCobranza()->delete();

                $hoy = now()->startOfDay();

                // Crear nuevas fechas
                foreach ($nuevasFechas as $index => $fecha) {
                    $fechaCarbon = \Carbon\Carbon::parse($fecha);

                    // Determinar estatus: si la fecha ya pasó Y había pagos realizados, marcar como pagado
                    $estatus = 'Pendiente';
                    $fechaPago = null;
                    $observaciones = null;

                    if ($fechaCarbon->lt($hoy) && $index < $pagosRealizados) {
                        $estatus = 'Pagado';
                        $fechaPago = $fechaCarbon;
                        $observaciones = 'Pago anterior (recálculo de fechas)';
                    }

                    FechaCobranza::create([
                        'IdPoliza' => $poliza->IdPoliza,
                        'FechaCobranza' => $fecha,
                        'MontoCobro' => $index === 0 ? $montoPrimerPago : $montoPorPago,
                        'Estatus' => $estatus,
                        'FechaPago' => $fechaPago,
                        'Observaciones' => $observaciones,
                    ]);
                }

                $this->line("  [OK] Póliza {$poliza->NumPoliza} ({$poliza->FormaPago}): " .
                    implode(', ', array_map(fn($f) => \Carbon\Carbon::parse($f)->format('d/m/Y'), $fechasActualesArray)) .
                    " -> " .
                    implode(', ', array_map(fn($f) => \Carbon\Carbon::parse($f)->format('d/m/Y'), $nuevasFechas))
                );

                $recalculadas++;

            } catch (\Exception $e) {
                $errores++;
                $this->error("  [ERROR] Póliza {$poliza->NumPoliza}: " . $e->getMessage());
            }
        }

        $this->newLine();
        $this->info("Recálculo completado:");
        $this->info("  - Pólizas recalculadas: {$recalculadas}");
        $this->info("  - Sin cambios necesarios: {$sinCambios}");
        $this->info("  - Errores: {$errores}");
        $this->info("  - Total procesadas: {$polizas->count()}");

        return Command::SUCCESS;
    }
}
