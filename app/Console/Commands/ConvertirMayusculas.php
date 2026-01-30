<?php

namespace App\Console\Commands;

use App\Models\Asegurado;
use App\Models\Poliza;
use Illuminate\Console\Command;

class ConvertirMayusculas extends Command
{
    protected $signature = 'datos:mayusculas';
    protected $description = 'Convierte nombres de asegurados y números de póliza a mayúsculas';

    public function handle()
    {
        $this->info('Convirtiendo datos a mayúsculas...');

        // Convertir asegurados
        $asegurados = Asegurado::all();
        $aseguradosConvertidos = 0;

        foreach ($asegurados as $asegurado) {
            $cambios = false;

            $nombreUpper = mb_strtoupper($asegurado->Nombre);
            $paternoUpper = mb_strtoupper($asegurado->ApellidoPaterno);
            $maternoUpper = mb_strtoupper($asegurado->ApellidoMaterno ?? '');

            if ($asegurado->Nombre !== $nombreUpper ||
                $asegurado->ApellidoPaterno !== $paternoUpper ||
                $asegurado->ApellidoMaterno !== $maternoUpper) {

                $asegurado->Nombre = $nombreUpper;
                $asegurado->ApellidoPaterno = $paternoUpper;
                $asegurado->ApellidoMaterno = $maternoUpper;
                $asegurado->save();
                $aseguradosConvertidos++;
                $this->line("  - Asegurado: {$asegurado->nombre_completo}");
            }
        }

        $this->info("Asegurados convertidos: {$aseguradosConvertidos}");

        // Convertir pólizas
        $polizas = Poliza::all();
        $polizasConvertidas = 0;

        foreach ($polizas as $poliza) {
            $numPolizaUpper = strtoupper($poliza->NumPoliza);

            if ($poliza->NumPoliza !== $numPolizaUpper) {
                $poliza->NumPoliza = $numPolizaUpper;
                $poliza->save();
                $polizasConvertidas++;
                $this->line("  - Póliza: {$poliza->NumPoliza}");
            }
        }

        $this->info("Pólizas convertidas: {$polizasConvertidas}");
        $this->info('Conversión completada.');

        return Command::SUCCESS;
    }
}
