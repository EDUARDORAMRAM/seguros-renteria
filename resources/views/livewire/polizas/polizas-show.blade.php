<div>
    <div class="max-w-7xl mx-auto">
        {{-- Flash Messages --}}
        @if (session()->has('message'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('message') }}
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                    @if($poliza->Estatus === 'Activa')
                        <button onclick="confirmarRenovacion()" 
        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
    </svg>
    Renovar
</button>

                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Información de la Póliza --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Datos Principales --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">{{ $poliza->NumPoliza }}</h3>
                        @php
                            $badgeClass = match($poliza->Estatus) {
                                'Activa' => 'bg-green-100 text-green-800 border-green-200',
                                'Vencida' => 'bg-red-100 text-red-800 border-red-200',
                                'Cancelada' => 'bg-gray-100 text-gray-800 border-gray-200',
                                default => 'bg-blue-100 text-blue-800 border-blue-200'
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
                            <p class="text-lg font-medium text-gray-900 mt-1">{{ $poliza->FechaInicio->format('d/m/Y') }}</p>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Fecha de Vencimiento</label>
                            <p class="text-lg font-medium text-gray-900 mt-1">{{ $poliza->FechaVencimiento->format('d/m/Y') }}</p>
                            @if($poliza->Estatus === 'Activa')
                                @php
                                    $dias = $poliza->dias_para_vencer;
                                    $urgenciaClass = $dias <= 7 ? 'text-red-600' : ($dias <= 30 ? 'text-yellow-600' : 'text-gray-600');
                                @endphp
                                <p class="text-sm {{ $urgenciaClass }} mt-1">
                                    @if($dias < 0)
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

                {{-- Compañía Aseguradora --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Compañía Aseguradora
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Nombre</label>
                            <p class="text-base font-medium text-gray-900 mt-1">{{ $poliza->compania->Nombre ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Cobertura</label>
                            <p class="text-base font-medium text-gray-900 mt-1">{{ $poliza->compania->Cobertura ?? 'N/A' }}</p>
                        </div>
                    </div>  
                </div>

                {{-- Unidad Asegurada --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-4-1a1 1 0 001 1h4M8 17a5 5 0 10-8 0h8z"/>
                        </svg>
                        Unidad Asegurada
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Vehículo</label>
                            <p class="text-base font-medium text-gray-900 mt-1">{{ $poliza->unidad->descripcion_completa ?? 'N/A' }}</p>
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

            {{-- Información del Asegurado --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
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
                            <a href="tel:{{ $poliza->asegurado->Telefono }}" class="text-sm text-blue-600 hover:text-blue-800 mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $poliza->asegurado->Telefono ?? 'N/A' }}
                            </a>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Email</label>
                            <a href="mailto:{{ $poliza->asegurado->Email }}" class="text-sm text-blue-600 hover:text-blue-800 mt-1 flex items-center break-all">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
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
