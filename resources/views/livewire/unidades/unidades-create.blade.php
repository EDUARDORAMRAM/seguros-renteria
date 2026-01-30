<div>
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Nueva Unidad</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Complete el formulario para registrar un nuevo vehículo
                    </p>
                </div>
                <a href="{{ route('unidades.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition">
                    ← Volver
                </a>
            </div>
        </div>

        {{-- Formulario --}}
        <form wire:submit.prevent="guardar">
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
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- VIN --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                VIN (Número de Serie) <span class="text-red-500">*</span>
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

                        {{-- Motor --}}
                        <div class="md:col-span-3">
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
                        Guardar Unidad
                    </button>
                </div>
            </div>
        </form>

        {{-- Loading Indicator --}}
        <div wire:loading class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 flex items-center gap-3">
                <svg class="animate-spin h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-900 font-medium">Guardando...</span>
            </div>
        </div>
    </div>
</div>