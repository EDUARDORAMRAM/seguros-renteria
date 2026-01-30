<?php

namespace App\Console\Commands;

use App\Models\Asegurado;
use Illuminate\Console\Command;

class CorregirRfcMayusculas extends Command
{
    protected $signature = 'asegurados:rfc-mayusculas';
    protected $description = 'Convierte todos los RFC de asegurados a mayúsculas';

    public function handle()
    {
        $this->info('Corrigiendo RFC a mayúsculas...');

        $asegurados = Asegurado::all();
        $corregidos = 0;

        foreach ($asegurados as $asegurado) {
            $rfcOriginal = $asegurado->RFC;
            $rfcMayusculas = strtoupper(trim($rfcOriginal));

            if ($rfcOriginal !== $rfcMayusculas) {
                $asegurado->RFC = $rfcMayusculas;
                $asegurado->save();
                $corregidos++;
                $this->line("  - {$asegurado->nombre_completo}: '{$rfcOriginal}' -> '{$rfcMayusculas}'");
            }
        }

        $this->info("Corrección completada. {$corregidos} RFC corregidos de {$asegurados->count()} asegurados.");

        return Command::SUCCESS;
    }
}
