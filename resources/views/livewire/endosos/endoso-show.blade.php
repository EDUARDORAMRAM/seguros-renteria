<div>
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Detalle del Endoso</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ $endoso->NumEndoso }}
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('polizas.show', $endoso->IdPoliza) }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition">
                        Ver Póliza
                    </a>
                    <a href="{{ route('polizas.edit', $endoso->IdPoliza) }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                        ← Volver
                    </a>
                </div>
            </div>
        </div>

        {{-- Información del Endoso --}}
        <div class="bg-white rounded-lg shadow-lg p-6 space-y-6">
            
            {{-- Sección: Información General --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                    📋 Información General
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Número de Endoso --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">
                            Número de Endoso
                        </label>
                        <p class="text-base font-semibold text-gray-900">{{ $endoso->NumEndoso }}</p>
                    </div>

                    {{-- Fecha --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">
                            Fecha del Endoso
                        </label>
                        <p class="text-base text-gray-900">
                            {{ $endoso->FechaEndoso->format('d/m/Y') }}
                            <span class="text-sm text-gray-500 ml-2">
                                ({{ $endoso->FechaEndoso->diffForHumans() }})
                            </span>
                        </p>
                    </div>

                    {{-- Tipo de Endoso --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">
                            Tipo de Endoso
                        </label>
                        @php
                            $badgeClass = match($endoso->TipoEndoso) {
                                'Modificacion' => 'bg-blue-100 text-blue-800',
                                'Renovacion' => 'bg-green-100 text-green-800',
                                'Cancelacion' => 'bg-red-100 text-red-800',
                                'Cambio Suma Asegurada' => 'bg-yellow-100 text-yellow-800',
                                'Cambio Beneficiario' => 'bg-purple-100 text-purple-800',
                                'Cambio Unidad' => 'bg-indigo-100 text-indigo-800',
                                default => 'bg-gray-100 text-gray-800'
                            };
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $badgeClass }}">
                            {{ $endoso->TipoEndoso }}
                        </span>
                    </div>

                    {{-- Monto Afectado --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">
                            Monto Afectado
                        </label>
                        <p class="text-base font-semibold text-gray-900">
                            @if($endoso->MontoAfectado)
                                ${{ number_format($endoso->MontoAfectado, 2) }}
                            @else
                                <span class="text-gray-400 font-normal">No aplica</span>
                            @endif
                        </p>
                    </div>

                    {{-- Creado por --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">
                            Registrado por
                        </label>
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                <span class="text-green-600 font-semibold text-sm">
                                    {{ strtoupper(substr($endoso->nombre_usuario, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $endoso->nombre_usuario }}</p>
                                <p class="text-xs text-gray-500">{{ $endoso->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección: Descripción --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                    📝 Descripción
                </h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $endoso->Descripcion }}</p>
                </div>
            </div>

            {{-- Sección: Información de la Póliza --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                    📄 Información de la Póliza
                </h3>
                
                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Número de Póliza:</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $endoso->poliza->NumPoliza }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Asegurado:</span>
                        <span class="text-sm text-gray-900">{{ $endoso->poliza->nombre_completo_asegurado }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Compañía:</span>
                        <span class="text-sm text-gray-900">{{ $endoso->poliza->compania->Nombre }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Unidad:</span>
                        <span class="text-sm text-gray-900">{{ $endoso->poliza->unidad->descripcion_completa }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Prima:</span>
                        <span class="text-sm font-semibold text-gray-900">${{ number_format($endoso->poliza->Prima, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Sección: Documento Adjunto --}}
            @if($endoso->tiene_archivo)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                        📎 Documento Adjunto
                    </h3>
                    
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-10 h-10 text-green-600 mr-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $endoso->ArchivoAdjunto }}</p>
                                    <p class="text-sm text-gray-600">Documento PDF del endoso</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ $endoso->url_archivo }}" 
                                   target="_blank"
                                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                                    Ver PDF
                                </a>
                                <a href="{{ $endoso->url_archivo }}" 
                                   download
                                   class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                                    Descargar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                        📎 Documento Adjunto
                    </h3>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-600">No hay documento adjunto para este endoso</p>
                    </div>
                </div>
            @endif

            {{-- Botones de Acción --}}
            <div class="flex items-center justify-between pt-6 border-t">
                <a href="{{ route('polizas.edit', $endoso->IdPoliza) }}" 
                   class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                    ← Volver a Póliza
                </a>
                <a href="{{ route('polizas.show', $endoso->IdPoliza) }}" 
                   class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                    Ver Póliza Completa
                </a>
            </div>
        </div>
    </div>
</div>