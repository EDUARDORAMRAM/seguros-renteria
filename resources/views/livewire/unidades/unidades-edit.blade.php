<div>
    <div class="max-w-6xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Editar Unidad</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Actualiza la información del vehículo
                    </p>
                </div>
                <a href="{{ route('unidades.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition">
                    ← Volver
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Formulario Principal --}}
            <div class="lg:col-span-2">
                <form wire:submit.prevent="actualizar">
                    <div class="bg-white rounded-lg shadow-lg p-6 space-y-6">
                        
                        {{-- Información del Vehículo --}}
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                                🚗 Información del Vehículo
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                {{-- Marca --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Marca <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           wire:model="Marca" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                           placeholder="Ej: Toyota, Honda, Ford">
                                    @error('Marca') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Submarca --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Submarca <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           wire:model="Submarca" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                           placeholder="Ej: Corolla, Civic, F-150">
                                    @error('Submarca') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Año --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Año <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           wire:model="Anio" 
                                           min="1900"
                                           max="{{ date('Y') + 1 }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                           placeholder="{{ date('Y') }}">
                                    @error('Anio') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                {{-- Color --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Color
                                    </label>
                                    <input type="text"
                                           wire:model="Color"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                           placeholder="Ej: Blanco, Negro, Gris">
                                    @error('Color')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Uso --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Uso <span class="text-red-500">*</span>
                                    </label>
                                    <select wire:model="Uso" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        <option value="">Seleccione el uso</option>
                                        <option value="Particular">Particular</option>
                                        <option value="Comercial">Comercial</option>
                                        <option value="Público">Público</option>
                                    </select>
                                    @error('Uso') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Identificación --}}
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                                🔖 Identificación
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- VIN --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        VIN <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           wire:model="VIN" 
                                           maxlength="50"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent uppercase"
                                           placeholder="Ej: 1HGBH41JXMN109186">
                                    @error('VIN') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Número de Serie --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Número de Serie <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           wire:model="NoSerie" 
                                           maxlength="50"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent uppercase"
                                           placeholder="Número de serie">
                                    @error('NoSerie') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Motor --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Motor
                                    </label>
                                    <input type="text" 
                                           wire:model="Motor" 
                                           maxlength="50"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent uppercase"
                                           placeholder="Número de motor">
                                    @error('Motor') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Placas --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Placas
                                    </label>
                                    <input type="text"
                                           wire:model="Placas"
                                           maxlength="20"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent uppercase"
                                           placeholder="Ej: ABC-123-D">
                                    @error('Placas')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Información de registro --}}
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Información del Registro</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Fecha de registro:</span>
                                    <p class="text-gray-900 font-medium">
                                        {{ $unidad->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Última actualización:</span>
                                    <p class="text-gray-900 font-medium">
                                        {{ $unidad->updated_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="flex items-center justify-end gap-4 pt-6 border-t">
                            <a href="{{ route('unidades.index') }}" 
                               class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Actualizar Unidad
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Panel de Estadísticas --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Estadísticas --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Estadísticas</h3>
                    <div class="space-y-4">
                        {{-- Total Pólizas --}}
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                            <div>
                                <p class="text-sm text-gray-600">Total Pólizas</p>
                                <p class="text-2xl font-bold text-green-600">{{ $totalPolizas }}</p>
                            </div>
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>

                        {{-- Póliza Activa --}}
                        @if($polizaActiva)
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-700">Póliza Activa</p>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Vigente
                                </span>
                            </div>
                            <p class="text-sm text-gray-600">
                                N°: {{ $polizaActiva->NumPoliza }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                Vence: {{ $polizaActiva->FechaVencimiento->format('d/m/Y') }}
                            </p>
                        </div>
                        @else
                        <div class="p-3 bg-yellow-50 rounded-lg">
                            <p class="text-sm font-medium text-yellow-800">Sin póliza activa</p>
                            <p class="text-xs text-yellow-700 mt-1">Esta unidad no tiene póliza vigente</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Advertencia --}}
                @if($totalPolizas > 0)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">
                                Advertencia
                            </h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>Esta unidad tiene {{ $totalPolizas }} póliza(s) asociada(s). Los cambios afectarán la información relacionada.</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Ayuda --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ayuda</h3>
                    <div class="space-y-3 text-sm text-gray-600">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <p>El VIN, número de serie y placas deben ser únicos.</p>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <p>Los cambios se aplicarán a todas las pólizas asociadas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Loading Indicator --}}
        <div wire:loading class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
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