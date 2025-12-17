<div>
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Editar Póliza</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Modifica la información de la póliza {{ $NumPoliza }}
                    </p>
                </div>
                <a href="{{ route('polizas.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition">
                    ← Volver
                </a>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('message') }}
            </div>
        @endif

        {{-- Formulario --}}
        <form wire:submit.prevent="actualizar">
            <div class="bg-white rounded-lg shadow-lg p-6 space-y-6">
                
                {{-- Información de la Póliza --}}
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
                                <option value="Anual">Anual</option>
                                <option value="Semestral">Semestral</option>
                                <option value="Trimestral">Trimestral</option>
                                <option value="Mensual">Mensual</option>
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
                                   wire:model="FechaVencimiento" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 bg-gray-50"
                                   readonly>
                            @error('FechaVencimiento') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">
                                💡 Se calcula automáticamente según la forma de pago
                            </p>
                        </div>

                        {{-- NUEVO: Fecha de Cobranza --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Fecha de Cobranza
                            </label>
                            <input type="date" 
                                   wire:model="FechaCobranza" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 bg-gray-50"
                                   readonly>
                            @error('FechaCobranza') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">
                                💰 Recordatorio de cobro automático
                            </p>
                        </div>

                        {{-- Prima --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Prima <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                                <input type="number" 
                                       wire:model="Prima" 
                                       step="0.01"
                                       min="0"
                                       class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                                       placeholder="0.00">
                            </div>
                            @error('Prima') 
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

                {{-- Compañía Aseguradora --}}
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

                {{-- Asegurado --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                        👤 Asegurado
                    </h3>
                    
                    <div>
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
                </div>

                {{-- Unidad --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                        🚗 Unidad Asegurada
                    </h3>
                    
                    <div>
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
                </div>

                {{-- Documento PDF --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                        📎 Documento de Póliza
                    </h3>
                    
                    {{-- PDF Actual --}}
                    @if($pdfActual)
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-green-800">
                                    <svg class="w-6 h-6 mr-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                    </svg>
                                    <div>
                                        <p class="font-medium">PDF de la póliza actual</p>
                                        <p class="text-xs text-gray-600">{{ $pdfActual }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ asset('storage/polizas/' . $pdfActual) }}" 
                                       target="_blank"
                                       class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition">
                                        Ver PDF
                                    </a>
                                    <a href="{{ asset('storage/polizas/' . $pdfActual) }}" 
                                       download
                                       class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg transition">
                                        Descargar
                                    </a>
                                    <button type="button"
                                            wire:click="eliminarPdf"
                                            wire:confirm="¿Estás seguro de eliminar el PDF? Esta acción no se puede deshacer."
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg transition">
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mb-4 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                            <p class="text-sm text-gray-600">
                                <svg class="w-5 h-5 inline mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                No hay PDF adjunto para esta póliza
                            </p>
                        </div>
                    @endif
                    
                    {{-- Subir nuevo PDF --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $pdfActual ? 'Reemplazar PDF' : 'Adjuntar PDF de la Póliza' }}
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
                            Formato PDF, máximo 10MB. {{ $pdfActual ? 'El nuevo archivo reemplazará al actual.' : '' }}
                        </p>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="flex items-center justify-end gap-4 pt-6 border-t">
                    <a href="{{ route('polizas.show', $poliza->IdPoliza) }}" 
                       class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Actualizar Póliza
                    </button>
                </div>
            </div>
        </form>

        {{-- Sección de Endosos (Abajo del formulario) --}}
        <div class="mt-8">
            @livewire('endosos.endoso-create', ['polizaId' => $poliza->IdPoliza])
        </div>

        {{-- Loading Indicator --}}
        <div wire:loading wire:target="actualizar" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 flex items-center gap-3">
                <svg class="animate-spin h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-900 font-medium">Actualizando...</span>
            </div>
        </div>
    </div>
</div>