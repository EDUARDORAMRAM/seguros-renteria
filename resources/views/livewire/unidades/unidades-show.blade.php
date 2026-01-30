<div>
    <div class="max-w-6xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Detalle de Unidad</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Información completa del vehículo
                    </p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('unidades.edit', $unidad->IdUnidad) }}" 
                       class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                    <a href="{{ route('unidades.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition">
                        ← Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Información Principal --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Datos del Vehículo --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                        </svg>
                        Información del Vehículo
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">Marca</p>
                            <p class="text-base font-medium text-gray-900">{{ $unidad->Marca }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Submarca</p>
                            <p class="text-base font-medium text-gray-900">{{ $unidad->Submarca }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Año</p>
                            <p class="text-base font-medium text-gray-900">{{ $unidad->Anio }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Color</p>
                            <p class="text-base font-medium text-gray-900">{{ $unidad->Color ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Uso</p>
                            <p class="text-base font-medium text-gray-900">{{ $unidad->Uso }}</p>
                        </div>
                    </div>
                </div>

                {{-- Identificación --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Identificación
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500">VIN (Número de Serie)</p>
                            <p class="text-base font-medium text-gray-900 font-mono">{{ $unidad->VIN }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Placas</p>
                            <p class="text-base font-medium text-gray-900 font-mono">{{ $unidad->Placas ?? 'N/A' }}</p>
                        </div>
                        <div class="md:col-span-3">
                            <p class="text-sm text-gray-500">Motor</p>
                            <p class="text-base font-medium text-gray-900 font-mono">{{ $unidad->Motor ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Pólizas Asociadas --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Pólizas Asociadas ({{ $unidad->polizas->count() }})
                    </h3>
                    
                    @if($unidad->polizas->count() > 0)
                        <div class="space-y-3">
                            @foreach($unidad->polizas as $poliza)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2">
                                                <p class="font-medium text-gray-900">{{ $poliza->NumPoliza }}</p>
                                                @php
                                                    $badgeClass = match($poliza->Estatus) {
                                                        'Activa' => 'bg-green-100 text-green-800',
                                                        'Vencida' => 'bg-red-100 text-red-800',
                                                        'Cancelada' => 'bg-gray-100 text-gray-800',
                                                        default => 'bg-blue-100 text-blue-800'
                                                    };
                                                @endphp
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $badgeClass }}">
                                                    {{ $poliza->Estatus }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1">
                                                {{ $poliza->compania->Nombre ?? 'N/A' }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                Asegurado: {{ $poliza->asegurado->nombre_completo ?? 'N/A' }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                Vigencia: {{ $poliza->FechaInicio ? $poliza->FechaInicio->format('d/m/Y') : 'N/A' }} - 
                                                {{ $poliza->FechaVencimiento ? $poliza->FechaVencimiento->format('d/m/Y') : 'N/A' }}
                                            </p>
                                        </div>
                                        <a href="{{ route('polizas.show', $poliza->IdPoliza) }}" 
                                           class="ml-4 text-green-600 hover:text-green-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500">No hay pólizas asociadas a esta unidad</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Panel Lateral --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Resumen --}}
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                    <h3 class="text-lg font-semibold mb-4">Resumen</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-green-100 text-sm">Descripción</p>
                            <p class="text-xl font-bold">{{ $unidad->descripcion_completa }}</p>
                        </div>
                        <div class="border-t border-green-400 pt-3">
                            <p class="text-green-100 text-sm">Estado</p>
                            <p class="text-lg font-semibold">
                                {{ $unidad->tiene_poliza_vigente ? 'Con póliza vigente' : 'Sin póliza vigente' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Información del Sistema --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Sistema</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-500">Fecha de registro</p>
                            <p class="text-gray-900 font-medium">{{ $unidad->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Última actualización</p>
                            <p class="text-gray-900 font-medium">{{ $unidad->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">ID de Unidad</p>
                            <p class="text-gray-900 font-medium font-mono">#{{ $unidad->IdUnidad }}</p>
                        </div>
                    </div>
                </div>

                {{-- Acciones Rápidas --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones Rápidas</h3>
                    <div class="space-y-2">
                        <a href="{{ route('unidades.edit', $unidad->IdUnidad) }}" 
                           class="block w-full px-4 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-800 font-medium rounded-lg transition text-center">
                            Editar Unidad
                        </a>
                        <a href="{{ route('polizas.create') }}?unidad={{ $unidad->IdUnidad }}" 
                           class="block w-full px-4 py-2 bg-green-100 hover:bg-green-200 text-green-800 font-medium rounded-lg transition text-center">
                            Nueva Póliza
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>