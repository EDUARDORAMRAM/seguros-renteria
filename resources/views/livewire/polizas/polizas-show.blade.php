<div>
    <div class="max-w-7xl mx-auto">
        {{-- Flash Messages --}}
        @if (session()->has('message'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Detalles de la Póliza</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Información completa de la póliza
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('polizas.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition">
                        ← Volver
                    </a>
                    <a href="{{ route('polizas.edit', $poliza->IdPoliza) }}"
                        class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Editar
                    </a>
                    @if ($poliza->Estatus === 'Activa')
                        <button onclick="confirmarRenovacion()"
                            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Renovar
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Columna Principal --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Datos Principales --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">{{ $poliza->NumPoliza }}</h3>
                        @php
                            $badgeClass = match ($poliza->Estatus) {
                                'Activa' => 'bg-green-100 text-green-800 border-green-200',
                                'Vencida' => 'bg-red-100 text-red-800 border-red-200',
                                'Cancelada' => 'bg-gray-100 text-gray-800 border-gray-200',
                                default => 'bg-blue-100 text-blue-800 border-blue-200',
                            };
                        @endphp
                        <span class="px-4 py-2 text-sm font-bold rounded-full border {{ $badgeClass }}">
                            {{ $poliza->Estatus }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Forma de Pago</label>
                            <p class="text-lg font-medium text-gray-900 mt-1">{{ $poliza->FormaPago }}</p>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Prima</label>
                            <p class="text-2xl font-bold text-green-600 mt-1">${{ number_format($poliza->Prima, 2) }}</p>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Fecha de Inicio</label>
                            <p class="text-lg font-medium text-gray-900 mt-1">
                                {{ $poliza->FechaInicio->format('d/m/Y') }}</p>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Fecha de Vencimiento</label>
                            <p class="text-lg font-medium text-gray-900 mt-1">
                                {{ $poliza->FechaVencimiento->format('d/m/Y') }}</p>
                            @if ($poliza->Estatus === 'Activa')
                                @php
                                    $dias = $poliza->dias_para_vencer;
                                    $urgenciaClass = $dias <= 7 ? 'text-red-600' : ($dias <= 30 ? 'text-yellow-600' : 'text-gray-600');
                                @endphp
                                <p class="text-sm {{ $urgenciaClass }} mt-1">
                                    @if ($dias < 0)
                                        ¡Vencida hace {{ abs($dias) }} días!
                                    @elseif($dias === 0)
                                        ¡Vence hoy!
                                    @elseif($dias === 1)
                                        ¡Vence mañana!
                                    @else
                                        Vence en {{ $dias }} días
                                    @endif
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════════════ --}}
                {{-- SECCIÓN: FECHAS DE COBRANZA --}}
                {{-- ═══════════════════════════════════════════════════════════ --}}
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            📅 Calendario de Cobranzas
                        </h2>
                        <p class="text-blue-100 text-sm mt-1">
                            Historial completo de pagos programados
                        </p>
                    </div>

                    <div class="p-6">
                        @if($poliza->fechasCobranza->count() > 0)
                            <div class="space-y-3">
                                @foreach($poliza->fechasCobranza as $index => $fechaCobro)
                                    @php
                                        $diasRestantes = $fechaCobro->dias_para_cobrar;
                                        $esCritico = $fechaCobro->Estatus === 'Pendiente' && $diasRestantes !== null && $diasRestantes <= 1;
                                        $esUrgente = $fechaCobro->Estatus === 'Pendiente' && $diasRestantes !== null && $diasRestantes <= 3 && $diasRestantes > 1;
                                        $esProximo = $fechaCobro->Estatus === 'Pendiente' && $diasRestantes !== null && $diasRestantes <= 7 && $diasRestantes > 3;
                                    @endphp

                                    <div class="flex items-center justify-between p-4 rounded-lg border-2 transition-all duration-200
                                        {{ $fechaCobro->Estatus === 'Pagado' ? 'bg-green-50 border-green-300' : 
                                           ($esCritico ? 'bg-red-50 border-red-300 shadow-lg' : 
                                           ($esUrgente ? 'bg-orange-50 border-orange-300' : 
                                           ($esProximo ? 'bg-yellow-50 border-yellow-300' : 
                                           'bg-white border-gray-300'))) }}">
                                        
                                        <div class="flex items-center space-x-4 flex-1">
                                            {{-- Número de pago --}}
                                            <div class="flex-shrink-0">
                                                <div class="w-14 h-14 rounded-full flex items-center justify-center font-bold text-xl shadow-md
                                                    {{ $fechaCobro->Estatus === 'Pagado' ? 'bg-green-500 text-white' : 
                                                       ($esCritico ? 'bg-red-500 text-white animate-pulse' : 
                                                       ($esUrgente ? 'bg-orange-500 text-white' : 
                                                       ($esProximo ? 'bg-yellow-500 text-white' : 
                                                       'bg-blue-500 text-white'))) }}">
                                                    {{ $index + 1 }}
                                                </div>
                                            </div>

                                            {{-- Información --}}
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-3 mb-1">
                                                    <span class="text-lg font-bold text-gray-900">
                                                        {{ $fechaCobro->FechaCobranza->format('d/m/Y') }}
                                                    </span>
                                                    
                                                    @if($fechaCobro->Estatus === 'Pagado')
                                                        <span class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                            </svg>
                                                            PAGADO
                                                        </span>
                                                    @elseif($esCritico)
                                                        <span class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full animate-pulse">
                                                            🔴 {{ $diasRestantes === 0 ? '¡HOY!' : '¡MAÑANA!' }}
                                                        </span>
                                                    @elseif($esUrgente)
                                                        <span class="px-3 py-1 bg-orange-500 text-white text-xs font-bold rounded-full">
                                                            🟠 En {{ $diasRestantes }} días
                                                        </span>
                                                    @elseif($esProximo)
                                                        <span class="px-3 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full">
                                                            🟡 En {{ $diasRestantes }} días
                                                        </span>
                                                    @elseif($fechaCobro->esta_vencida)
                                                        <span class="px-3 py-1 bg-red-600 text-white text-xs font-bold rounded-full">
                                                            ⚠️ VENCIDO ({{ abs($diasRestantes) }} días)
                                                        </span>
                                                    @else
                                                        <span class="px-3 py-1 bg-blue-500 text-white text-xs font-bold rounded-full">
                                                            Pendiente
                                                        </span>
                                                    @endif
                                                </div>

                                                @if($fechaCobro->Estatus === 'Pagado' && $fechaCobro->FechaPago)
                                                    <p class="text-sm text-green-700 font-medium">
                                                        ✓ Pagado el: {{ $fechaCobro->FechaPago->format('d/m/Y H:i') }}
                                                    </p>
                                                @endif

                                                @if($fechaCobro->Observaciones)
                                                    <p class="text-sm text-gray-600 mt-1 italic">
                                                        💬 {{ $fechaCobro->Observaciones }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Monto y Acciones --}}
                                        <div class="flex items-center space-x-4">
                                            <div class="text-right">
                                                <p class="text-2xl font-bold text-green-600">
                                                    ${{ number_format($fechaCobro->MontoCobro, 2) }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    MXN
                                                </p>
                                            </div>

                                            {{-- Botones de Acción --}}
                                            <div class="flex flex-col space-y-2">
                                                @if($fechaCobro->Estatus === 'Pendiente')
                                                    <button 
                                                        wire:click="marcarComoPagado({{ $fechaCobro->IdFechaCobranza }})"
                                                        wire:confirm="¿Confirmar que este pago de ${{ number_format($fechaCobro->MontoCobro, 2) }} fue recibido?"
                                                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition flex items-center shadow-md">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                        Marcar Pagado
                                                    </button>
                                                @else
                                                    <button 
                                                        wire:click="desmarcarPago({{ $fechaCobro->IdFechaCobranza }})"
                                                        wire:confirm="¿Desmarcar este pago como pagado?"
                                                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-xs rounded-lg transition">
                                                        Desmarcar
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Resumen de Cobranzas --}}
                            <div class="mt-8 pt-6 border-t-2 border-gray-200">
                                <h3 class="text-lg font-bold text-gray-900 mb-4">
                                    📊 Resumen de Pagos
                                </h3>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="bg-blue-50 rounded-lg p-4 text-center border-2 border-blue-200">
                                        <p class="text-sm text-gray-600 mb-1">Total Pagos</p>
                                        <p class="text-3xl font-bold text-blue-600">
                                            {{ $poliza->fechasCobranza->count() }}
                                        </p>
                                    </div>
                                    <div class="bg-green-50 rounded-lg p-4 text-center border-2 border-green-200">
                                        <p class="text-sm text-gray-600 mb-1">Pagados</p>
                                        <p class="text-3xl font-bold text-green-600">
                                            {{ $poliza->fechasCobranza->where('Estatus', 'Pagado')->count() }}
                                        </p>
                                    </div>
                                    <div class="bg-orange-50 rounded-lg p-4 text-center border-2 border-orange-200">
                                        <p class="text-sm text-gray-600 mb-1">Pendientes</p>
                                        <p class="text-3xl font-bold text-orange-600">
                                            {{ $poliza->fechasCobranza->where('Estatus', 'Pendiente')->count() }}
                                        </p>
                                    </div>
                                    <div class="bg-purple-50 rounded-lg p-4 text-center border-2 border-purple-200">
                                        <p class="text-sm text-gray-600 mb-1">Cobrado</p>
                                        <p class="text-2xl font-bold text-purple-600">
                                            ${{ number_format($poliza->fechasCobranza->where('Estatus', 'Pagado')->sum('MontoCobro'), 2) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="mt-4 text-gray-500 font-semibold">
                                    No hay fechas de cobranza generadas para esta póliza
                                </p>
                                <p class="text-sm text-gray-400 mt-2">
                                    Las fechas de cobranza se generan automáticamente al crear o editar la póliza
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Documento PDF --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                clip-rule="evenodd" />
                        </svg>
                        Documento de Póliza
                    </h3>

                    @if ($poliza->tiene_pdf)
                        <div class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-10 h-10 text-green-600 mr-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $poliza->ArchivoPDF }}</p>
                                    <p class="text-sm text-gray-600">Documento PDF de la póliza</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ $poliza->url_pdf }}" target="_blank"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-sm font-medium">
                                    Ver PDF
                                </a>
                                <a href="{{ $poliza->url_pdf }}" download
                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition text-sm font-medium">
                                    Descargar
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg text-center">
                            <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-600 text-sm">No hay PDF adjunto para esta póliza</p>
                            <a href="{{ route('polizas.edit', $poliza->IdPoliza) }}"
                                class="mt-3 inline-flex items-center text-sm text-green-600 hover:text-green-800 font-medium">
                                Agregar PDF
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Endosos --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Endosos ({{ $poliza->endosos->count() }})
                        </h3>
                        <a href="{{ route('polizas.edit', $poliza->IdPoliza) }}"
                            class="text-sm text-green-600 hover:text-green-800 font-medium">
                            + Agregar Endoso
                        </a>
                    </div>

                    @if ($poliza->endosos->count() > 0)
                        <div class="space-y-3">
                            @foreach ($poliza->endosos->take(5) as $endoso)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <span class="text-sm font-bold text-gray-900">{{ $endoso->NumEndoso }}</span>
                                                @php
                                                    $badgeClass = match ($endoso->TipoEndoso) {
                                                        'Modificacion' => 'bg-blue-100 text-blue-800',
                                                        'Renovacion' => 'bg-green-100 text-green-800',
                                                        'Cancelacion' => 'bg-red-100 text-red-800',
                                                        'Cambio Suma Asegurada' => 'bg-yellow-100 text-yellow-800',
                                                        'Cambio Beneficiario' => 'bg-purple-100 text-purple-800',
                                                        'Cambio Unidad' => 'bg-indigo-100 text-indigo-800',
                                                        default => 'bg-gray-100 text-gray-800',
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
                                                    {{ $endoso->TipoEndoso }}
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    {{ $endoso->FechaEndoso->format('d/m/Y') }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-700 line-clamp-2">{{ $endoso->Descripcion }}</p>
                                        </div>
                                        <a href="{{ route('endosos.show', $endoso->IdEndoso) }}"
                                            class="ml-4 text-blue-600 hover:text-blue-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach

                            @if ($poliza->endosos->count() > 5)
                                <div class="text-center pt-2">
                                    <a href="{{ route('polizas.edit', $poliza->IdPoliza) }}#endosos"
                                        class="text-sm text-green-600 hover:text-green-800 font-medium">
                                        Ver todos los {{ $poliza->endosos->count() }} endosos
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-600 text-sm">No hay endosos registrados</p>
                            <a href="{{ route('polizas.edit', $poliza->IdPoliza) }}"
                                class="mt-3 inline-flex items-center text-sm text-green-600 hover:text-green-800 font-medium">
                                Crear primer endoso
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Compañía Aseguradora --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Compañía Aseguradora
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Nombre</label>
                            <p class="text-base font-medium text-gray-900 mt-1">
                                {{ $poliza->compania->Nombre ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Cobertura</label>
                            <p class="text-base font-medium text-gray-900 mt-1">
                                {{ $poliza->compania->Cobertura ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Unidad Asegurada --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-4-1a1 1 0 001 1h4M8 17a5 5 0 10-8 0h8z" />
                        </svg>
                        Unidad Asegurada
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Vehículo</label>
                            <p class="text-base font-medium text-gray-900 mt-1">
                                {{ $poliza->unidad->descripcion_completa ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Placas</label>
                            <p class="text-base font-medium text-gray-900 mt-1">{{ $poliza->unidad->Placas ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">VIN</label>
                            <p class="text-base font-medium text-gray-900 mt-1">{{ $poliza->unidad->VIN ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Color</label>
                            <p class="text-base font-medium text-gray-900 mt-1">{{ $poliza->unidad->Color ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Columna Lateral: Asegurado --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Asegurado
                    </h3>

                    <div class="flex flex-col items-center mb-6">
                        <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mb-3">
                            <span class="text-green-600 font-bold text-2xl">
                                {{ $poliza->asegurado->iniciales ?? 'N/A' }}
                            </span>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 text-center">
                            {{ $poliza->asegurado->nombre_completo ?? 'N/A' }}
                        </h4>
                    </div>

                    <div class="space-y-4 border-t pt-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">RFC</label>
                            <p class="text-sm font-medium text-gray-900 mt-1">{{ $poliza->asegurado->RFC ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Teléfono</label>
                            <a href="tel:{{ $poliza->asegurado->Telefono }}"
                                class="text-sm text-blue-600 hover:text-blue-800 mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $poliza->asegurado->Telefono ?? 'N/A' }}
                            </a>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Email</label>
                            <a href="mailto:{{ $poliza->asegurado->Email }}"
                                class="text-sm text-blue-600 hover:text-blue-800 mt-1 flex items-center break-all">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $poliza->asegurado->Email ?? 'N/A' }}
                            </a>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t">
                        <a href="{{ route('asegurados.show', $poliza->IdAsegurado) }}"
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                            Ver Perfil Completo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmarRenovacion() {
        if (confirm('¿Deseas renovar esta póliza por un año más?')) {
            Livewire.dispatch('renovar-poliza');
        }
    }
</script>