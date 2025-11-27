<div>
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Detalles del Asegurado</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Información completa del cliente y sus pólizas
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('asegurados.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition">
                        ← Volver
                    </a>
                    <a href="{{ route('asegurados.edit', $asegurado->IdAsegurado) }}" 
                       class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Información del Cliente --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    {{-- Avatar --}}
                    <div class="flex flex-col items-center mb-6">
                        <div class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center mb-3">
                            <span class="text-green-600 font-bold text-3xl">
                                {{ $asegurado->iniciales }}
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 text-center">
                            {{ $asegurado->nombre_completo }}
                        </h3>
                        @if($asegurado->Referencia)
                            <p class="text-sm text-gray-500 text-center mt-1">
                                {{ $asegurado->Referencia }}
                            </p>
                        @endif
                    </div>

                    {{-- Información de Contacto --}}
                    <div class="space-y-4 border-t pt-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">RFC</label>
                            <p class="text-sm font-medium text-gray-900 mt-1">{{ $asegurado->RFC }}</p>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Teléfono</label>
                            <a href="tel:{{ $asegurado->Telefono }}" class="text-sm text-blue-600 hover:text-blue-800 mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $asegurado->Telefono }}
                            </a>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Email</label>
                            <a href="mailto:{{ $asegurado->Email }}" class="text-sm text-blue-600 hover:text-blue-800 mt-1 flex items-center break-all">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $asegurado->Email }}
                            </a>
                        </div>
                    </div>

                    {{-- Estadísticas --}}
                    <div class="grid grid-cols-2 gap-4 mt-6 pt-6 border-t">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $asegurado->polizas_activas_count }}</div>
                            <div class="text-xs text-gray-500 uppercase">Activas</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-600">{{ $asegurado->polizas_count }}</div>
                            <div class="text-xs text-gray-500 uppercase">Total Pólizas</div>
                        </div>
                    </div>

                    {{-- Botón Nueva Póliza --}}
                    <div class="mt-6">
                        <a href="{{ route('polizas.create') }}?asegurado={{ $asegurado->IdAsegurado }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Nueva Póliza
                        </a>
                    </div>
                </div>
            </div>

            {{-- Pólizas del Cliente --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Historial de Pólizas
                    </h3>

                    @if($asegurado->polizas->count() > 0)
                        <div class="space-y-4">
                            @foreach($asegurado->polizas as $poliza)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <h4 class="text-sm font-bold text-gray-900">{{ $poliza->NumPoliza }}</h4>
                                                @php
                                                    $badgeClass = match($poliza->Estatus) {
                                                        'Activa' => 'bg-green-100 text-green-800 border-green-200',
                                                        'Vencida' => 'bg-red-100 text-red-800 border-red-200',
                                                        'Cancelada' => 'bg-gray-100 text-gray-800 border-gray-200',
                                                        default => 'bg-blue-100 text-blue-800 border-blue-200'
                                                    };
                                                @endphp
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full border {{ $badgeClass }}">
                                                    {{ $poliza->Estatus }}
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-2 gap-4 text-sm">
                                                <div>
                                                    <span class="text-gray-500">Compañía:</span>
                                                    <span class="font-medium text-gray-900 ml-1">{{ $poliza->compania->Nombre ?? 'N/A' }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Prima:</span>
                                                    <span class="font-bold text-green-600 ml-1">${{ number_format($poliza->Prima, 2) }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Vencimiento:</span>
                                                    <span class="font-medium text-gray-900 ml-1">{{ $poliza->FechaVencimiento->format('d/m/Y') }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Vehículo:</span>
                                                    <span class="font-medium text-gray-900 ml-1">{{ $poliza->unidad->descripcion_completa ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <a href="{{ route('polizas.show', $poliza->IdPoliza) }}" 
                                           class="ml-4 text-blue-600 hover:text-blue-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No tiene pólizas</h3>
                            <p class="mt-1 text-sm text-gray-500">Este cliente aún no tiene pólizas registradas.</p>
                            <div class="mt-6">
                                <a href="{{ route('polizas.create') }}?asegurado={{ $asegurado->IdAsegurado }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Crear Primera Póliza
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>