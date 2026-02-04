<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // Dashboard - Livewire Component
    Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');

    // Pólizas - Livewire Components
    Route::prefix('polizas')->name('polizas.')->group(function () {
        Route::get('/', \App\Livewire\Polizas\PolizasList::class)->name('index');
        Route::get('/create', \App\Livewire\Polizas\PolizasCreate::class)->name('create');
        Route::get('/{poliza}', \App\Livewire\Polizas\PolizasShow::class)->name('show');
        Route::get('/{poliza}/edit', \App\Livewire\Polizas\PolizasEdit::class)->name('edit');
    });

    // Asegurados (Clientes) - Livewire Components
    Route::prefix('asegurados')->name('asegurados.')->group(function () {
        Route::get('/', \App\Livewire\Asegurados\AseguradosList::class)->name('index');
        Route::get('/create', \App\Livewire\Asegurados\AseguradosCreate::class)->name('create');
        Route::get('/{asegurado}', \App\Livewire\Asegurados\AseguradosShow::class)->name('show');
        Route::get('/{asegurado}/edit', \App\Livewire\Asegurados\AseguradosEdit::class)->name('edit');
    });

    // Compañías Aseguradoras - Livewire Components
    Route::prefix('companias')->name('companias.')->group(function () {
        Route::get('/', \App\Livewire\Companias\CompaniasList::class)->name('index');
        Route::get('/create', \App\Livewire\Companias\CompaniasCreate::class)->name('create');
        Route::get('/{compania}/edit', \App\Livewire\Companias\CompaniasEdit::class)->name('edit');
    });

    // Unidades (Vehículos) - Livewire Components
    Route::prefix('unidades')->name('unidades.')->group(function () {
        Route::get('/', \App\Livewire\Unidades\UnidadesList::class)->name('index');
        Route::get('/create', \App\Livewire\Unidades\UnidadesCreate::class)->name('create');
        Route::get('/{unidad}', \App\Livewire\Unidades\UnidadesShow::class)->name('show');
        Route::get('/{unidad}/edit', \App\Livewire\Unidades\UnidadesEdit::class)->name('edit');
    });

    // Reportes - Livewire Components
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/', \App\Livewire\Reportes\ReportesIndex::class)->name('index');
        Route::get('/asegurado', \App\Livewire\Reportes\ReporteAsegurado::class)->name('asegurado');
        Route::get('/asegurado/pdf/{asegurado}/{estatus}', [\App\Http\Controllers\ReportePdfController::class, 'asegurado'])->name('asegurado.pdf');
    });

    Route::get('/endosos/{id}', \App\Livewire\Endosos\EndosoShow::class)
        ->name('endosos.show');
    // Configuración / Ajustes - Livewire Component
    Route::get('/configuracion', \App\Livewire\Configuracion\ConfiguracionIndex::class)->name('configuracion');
    
    // Importar desde Excel - Livewire Component
    Route::get('/importar-excel', \App\Livewire\Importar\ImportarExcel::class)->name('importar.excel');
});