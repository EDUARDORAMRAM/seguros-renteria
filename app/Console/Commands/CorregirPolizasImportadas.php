<?php

namespace App\Console\Commands;

use App\Models\Poliza;
use Illuminate\Console\Command;

class CorregirPolizasImportadas extends Command
{
    protected $signature = 'polizas:corregir-importadas';
    protected $description = 'Corrige las pólizas importadas: normaliza FormaPago y calcula FechaInicio';

    public function handle()
    {
        $this->info('Iniciando corrección de pólizas importadas...');

        $polizas = Poliza::all();
        $corregidas = 0;

        foreach ($polizas as $poliza) {
            $cambios = false;

            // Corregir FormaPago si está en mayúsculas
            $formaPagoOriginal = $poliza->FormaPago;
            $formaPagoCorregida = match(strtoupper($formaPagoOriginal)) {
                'ANUAL' => 'Anual',
                'SEMESTRAL' => 'Semestral',
                'TRIMESTRAL' => 'Trimestral',
                'MENSUAL' => 'Mensual',
                default => $formaPagoOriginal,
            };

            if ($formaPagoOriginal !== $formaPagoCorregida) {
                $poliza->FormaPago = $formaPagoCorregida;
                $cambios = true;
                $this->line("  - Póliza {$poliza->NumPoliza}: FormaPago '{$formaPagoOriginal}' -> '{$formaPagoCorregida}'");
            }

            // Corregir FechaInicio si es igual a FechaVencimiento o si está mal
            if ($poliza->FechaInicio && $poliza->FechaVencimiento) {
                // Si las fechas son iguales o muy cercanas (menos de 30 días de diferencia)
                $diferenciaDias = $poliza->FechaInicio->diffInDays($poliza->FechaVencimiento);

                if ($diferenciaDias < 30) {
                    // Calcular fecha de inicio 1 año antes del vencimiento
                    $nuevaFechaInicio = $poliza->FechaVencimiento->copy()->subYear();
                    $this->line("  - Póliza {$poliza->NumPoliza}: FechaInicio '{$poliza->FechaInicio->format('Y-m-d')}' -> '{$nuevaFechaInicio->format('Y-m-d')}'");
                    $poliza->FechaInicio = $nuevaFechaInicio;
                    $cambios = true;
                }
            }

            if ($cambios) {
                $poliza->save();
                $corregidas++;
            }
        }

        $this->info("Corrección completada. {$corregidas} pólizas corregidas de {$polizas->count()} totales.");

        return Command::SUCCESS;
    }
}
