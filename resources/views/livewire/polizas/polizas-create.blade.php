<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Nueva Póliza</h2>
                <p class="mt-1 text-sm text-gray-600">
                    Complete el formulario para crear una nueva póliza
                </p>
            </div>
            <a href="{{ route('polizas.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition">
                ← Volver
            </a>
        </div>
    </div>

    {{-- Formulario --}}
    <form wire:submit.prevent="guardar">
        <div class="bg-white rounded-lg shadow-lg p-6 space-y-6">
            
            {{-- Sección: Información de la Póliza --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                    📋 Información de la Póliza
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Número de Póliza --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Número de Póliza <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               wire:model="NumPoliza" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="POL-000001">
                        @error('NumPoliza') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Forma de Pago --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Forma de Pago <span class="text-red-500">*</span>
                        </label>
                        <select wire:model.live="FormaPago" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                            <option value="Mensual">Mensual</option>
                            <option value="Trimestral">Trimestral</option>
                            <option value="Semestral">Semestral</option>
                            <option value="Anual">Anual</option>
                        </select>
                        @error('FormaPago') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Fecha de Inicio --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Fecha de Inicio <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               wire:model.live="FechaInicio" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        @error('FechaInicio') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Fecha de Vencimiento --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Fecha de Vencimiento <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               wire:model.live="FechaVencimiento" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        @error('FechaVencimiento') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Estatus --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Estatus <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="Estatus" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                            <option value="Activa">Activa</option>
                            <option value="Vencida">Vencida</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                        @error('Estatus') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- NUEVO: Validación y Preview de Fechas de Cobranza --}}
            @if($validacionFechas)
                <div class="p-4 rounded-lg border-2 {{ $validacionFechas['valido'] ? 'bg-green-50 border-green-300' : 'bg-red-50 border-red-300' }}">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            @if($validacionFechas['valido'])
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @else
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-sm font-bold {{ $validacionFechas['valido'] ? 'text-green-800' : 'text-red-800' }}">
                                {{ $validacionFechas['mensaje'] }}
                            </h3>

                            @if($validacionFechas['valido'] && count($fechasCobranzaPreview) > 0)
                                <div class="mt-3">
                                    <p class="text-xs font-semibold text-gray-700 mb-2">
                                        📅 Fechas de cobranza que se generarán ({{ count($fechasCobranzaPreview) }} pagos):
                                    </p>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                        @foreach($fechasCobranzaPreview as $index => $fecha)
                                            <div class="bg-white px-3 py-2 rounded-lg border border-green-200 text-center">
                                                <span class="text-xs font-bold text-green-700">Pago {{ $index + 1 }}</span>
                                                <p class="text-sm font-semibold text-gray-900">
                                                    {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    Monto pendiente
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                    <p class="mt-2 text-xs text-blue-600 bg-blue-50 p-2 rounded">
                                        Los montos de cada pago se configurarán al editar la póliza después de crearla.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- Sección: Compañía Aseguradora --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                    🏢 Compañía Aseguradora
                </h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Seleccionar Compañía <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="IdCompania" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        <option value="">Seleccione una compañía...</option>
                        @foreach($companias as $compania)
                            <option value="{{ $compania->IdCompania }}">
                                {{ $compania->Nombre }} - {{ $compania->Cobertura }}
                            </option>
                        @endforeach
                    </select>
                    @error('IdCompania') 
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Sección: Asegurado --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                    👤 Asegurado
                </h3>
                
                <div class="flex gap-2">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Seleccionar Asegurado <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="IdAsegurado" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                            <option value="">Seleccione un asegurado...</option>
                            @foreach($asegurados as $asegurado)
                                <option value="{{ $asegurado->IdAsegurado }}">
                                    {{ $asegurado->nombre_completo }} - {{ $asegurado->RFC }}
                                </option>
                            @endforeach
                        </select>
                        @error('IdAsegurado') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-end gap-2">
                        <a href="{{ route('asegurados.create') }}"
                           target="_blank"
                           class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition whitespace-nowrap">
                            + Nuevo
                        </a>
                        <button type="button"
                                wire:click="actualizarAsegurados"
                                class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition"
                                title="Refrescar lista de asegurados">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Sección: Unidad --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                    🚗 Unidad Asegurada
                </h3>
                
                <div class="flex gap-2">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Seleccionar Unidad <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="IdUnidad" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                            <option value="">Seleccione una unidad...</option>
                            @foreach($unidades as $unidad)
                                <option value="{{ $unidad->IdUnidad }}">
                                    {{ $unidad->descripcion_completa }} - {{ $unidad->VIN }}
                                </option>
                            @endforeach
                        </select>
                        @error('IdUnidad') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-end gap-2">
                        <a href="{{ route('unidades.create') }}"
                           target="_blank"
                           class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition whitespace-nowrap">
                            + Nuevo
                        </a>
                        <button type="button"
                                wire:click="actualizarUnidades"
                                class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition"
                                title="Refrescar lista de unidades">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Documento PDF (Opcional) --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                    📎 Documento de Póliza (Opcional)
                </h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Adjuntar PDF de la Póliza
                    </label>
                    <input type="file" 
                           wire:model="archivoPdf"
                           accept=".pdf"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    @error('archivoPdf') 
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    
                    {{-- Indicador de carga --}}
                    <div wire:loading wire:target="archivoPdf" class="mt-2">
                        <div class="flex items-center text-green-600 text-sm">
                            <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Cargando archivo...
                        </div>
                    </div>
                    
                    {{-- Preview --}}
                    @if ($archivoPdf)
                        <div class="mt-2 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-green-800">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="font-medium">{{ $archivoPdf->getClientOriginalName() }}</span>
                                    <span class="ml-2 text-gray-600">({{ number_format($archivoPdf->getSize() / 1024, 2) }} KB)</span>
                                </div>
                                <button type="button" 
                                        wire:click="$set('archivoPdf', null)"
                                        class="text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                    
                    <p class="mt-2 text-xs text-gray-500">
                        Formato PDF, máximo 10MB. Puede agregarlo después si lo prefiere.
                    </p>
                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="flex items-center justify-end gap-4 pt-6 border-t">
                <a href="{{ route('polizas.index') }}" 
                   class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition flex items-center gap-2"
                        @if($validacionFechas && !$validacionFechas['valido']) disabled @endif>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar Póliza
                </button>
            </div>
        </div>
    </form>

    {{-- Loading Indicator --}}
    <div wire:loading wire:target="guardar" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <svg class="animate-spin h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-900 font-medium">Guardando póliza y generando fechas de cobranza...</span>
        </div>
    </div>
</div>