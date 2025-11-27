<div>
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Editar Asegurado</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Modifica la información del cliente
                    </p>
                </div>
                <a href="{{ route('asegurados.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition">
                    ← Volver
                </a>
            </div>
        </div>

        {{-- Formulario --}}
        <form wire:submit.prevent="actualizar">
            <div class="bg-white rounded-lg shadow-lg p-6 space-y-6">
                
                {{-- Información Personal --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                        👤 Información Personal
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Nombre --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre(s) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="Nombre" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="Juan">
                            @error('Nombre') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Apellido Paterno --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Apellido Paterno <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="ApellidoPaterno" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="Pérez">
                            @error('ApellidoPaterno') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Apellido Materno --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Apellido Materno
                            </label>
                            <input type="text" 
                                   wire:model="ApellidoMaterno" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="García">
                            @error('ApellidoMaterno') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Datos de Contacto --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                        📞 Datos de Contacto
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Teléfono --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Teléfono <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   wire:model="Telefono" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="4421234567">
                            @error('Telefono') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   wire:model="Email" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="correo@ejemplo.com">
                            @error('Email') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Datos Fiscales --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                        📄 Datos Fiscales
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- RFC --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                RFC <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="RFC" 
                                   maxlength="13"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent uppercase"
                                   placeholder="XAXX010101000">
                            @error('RFC') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Referencia --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Referencia / Notas
                            </label>
                            <input type="text" 
                                   wire:model="Referencia" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="Cliente recomendado por...">
                            @error('Referencia') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="flex items-center justify-between pt-6 border-t">
                    <a href="{{ route('asegurados.show', $asegurado->IdAsegurado) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Ver Detalles
                    </a>

                    <div class="flex gap-4">
                        <a href="{{ route('asegurados.index') }}" 
                           class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Guardar Cambios
                        </button>
                    </div>
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
                <span class="text-gray-900 font-medium">Actualizando...</span>
            </div>
        </div>
    </div>
</div>