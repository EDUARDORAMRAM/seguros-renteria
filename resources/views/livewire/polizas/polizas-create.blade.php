<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Nueva Póliza</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
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
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 space-y-6">
            
            {{-- Sección: Información de la Póliza --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b pb-2">
                    📋 Información de la Póliza
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Número de Póliza --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Número de Póliza <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               wire:model="NumPoliza" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="POL-000001">
                        @error('NumPoliza') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Forma de Pago --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Forma de Pago <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="FormaPago" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="Anual">Anual</option>
                            <option value="Semestral">Semestral</option>
                            <option value="Mensual">Mensual</option>
                        </select>
                        @error('FormaPago') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Fecha de Inicio --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Fecha de Inicio <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               wire:model="FechaInicio" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('FechaInicio') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Fecha de Vencimiento --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Fecha de Vencimiento <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               wire:model="FechaVencimiento" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('FechaVencimiento') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Prima --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Prima <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                            <input type="number" 
                                   wire:model="Prima" 
                                   step="0.01"
                                   min="0"
                                   class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="0.00">
                        </div>
                        @error('Prima') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Estatus --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Estatus <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="Estatus" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
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

            {{-- Sección: Compañía Aseguradora --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b pb-2">
                    🏢 Compañía Aseguradora
                </h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Seleccionar Compañía <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="IdCompania" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
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
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b pb-2">
                    👤 Asegurado
                </h3>
                
                <div class="flex gap-2">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Seleccionar Asegurado <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="IdAsegurado" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
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
                    <div class="flex items-end">
                        <a href="{{ route('asegurados.create') }}" 
                           target="_blank"
                           class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition whitespace-nowrap">
                            + Nuevo
                        </a>
                    </div>
                </div>
            </div>

            {{-- Sección: Unidad --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b pb-2">
                    🚗 Unidad Asegurada
                </h3>
                
                <div class="flex gap-2">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Seleccionar Unidad <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="IdUnidad" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Seleccione una unidad...</option>
                            @foreach($unidades as $unidad)
                                <option value="{{ $unidad->IdUnidad }}">
                                    {{ $unidad->descripcion_completa }} - {{ $unidad->Placas }}
                                </option>
                            @endforeach
                        </select>
                        @error('IdUnidad') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-end">
                        <a href="{{ route('unidades.create') }}" 
                           target="_blank"
                           class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition whitespace-nowrap">
                            + Nuevo
                        </a>
                    </div>
                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="flex items-center justify-end gap-4 pt-6 border-t">
                <a href="{{ route('polizas.index') }}" 
                   class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar Póliza
                </button>
            </div>
        </div>
    </form>

    {{-- Loading Indicator --}}
    <div wire:loading class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 flex items-center gap-3">
            <svg class="animate-spin h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-900 dark:text-white font-medium">Guardando...</span>
        </div>
    </div>
</div>