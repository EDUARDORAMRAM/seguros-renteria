<?php

namespace App\Console\Commands;

use App\Models\Poliza;
use Illuminate\Console\Command;

class CorregirCobranzasPasadas extends Command
{
    protected $signature = 'polizas:corregir-cobranzas';

    protected $description = 'Marca como Pagadas las fechas de cobranza que ya pasaron';

    public function handle()
    {
        $this->info('Corrigiendo fechas de cobranza pasadas...');

        $actualizados = Poliza::corregirCobranzasPasadas();

        $this->info("Se actualizaron {$actualizados} registros de cobranza.");

        return Command::SUCCESS;
    }
}
