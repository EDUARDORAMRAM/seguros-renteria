<div>
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Nueva Compañía</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Registra una nueva compañía aseguradora
                    </p>
                </div>
                <a href="{{ route('companias.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition">
                    ← Volver
                </a>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session()->has('error'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Formulario --}}
        <form wire:submit.prevent="guardar">
            <div class="bg-white rounded-lg shadow-lg p-6 space-y-6">
                
                {{-- Información de la Compañía --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                        🏢 Información de la Compañía
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nombre --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre de la Compañía <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   wire:model.live.debounce.500ms="nombre"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="Ej: AXA Seguros, GNP, Qualitas, etc.">
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">
                                Ingresa el nombre oficial de la compañía aseguradora
                            </p>

                            {{-- NUEVO: Sugerencias de nombres existentes --}}
                            @if(count($nombresExistentes) > 0)
                                <div class="mt-2">
                                    <p class="text-xs font-semibold text-gray-600 mb-1">Nombres registrados:</p>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($nombresExistentes as $nombreExistente)
                                            <button type="button"
                                                    wire:click="$set('nombre', '{{ $nombreExistente }}')"
                                                    class="px-2 py-1 text-xs bg-blue-50 hover:bg-blue-100 text-blue-700 rounded border border-blue-200 transition">
                                                {{ $nombreExistente }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Cobertura --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Cobertura <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   wire:model.live.debounce.500ms="cobertura"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="Ej: Amplia, Limitada, Responsabilidad Civil">
                            @error('cobertura')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">
                                Tipo de cobertura que ofrece esta compañía
                            </p>

                            {{-- NUEVO: Mostrar coberturas existentes si el nombre ya está registrado --}}
                            @if($mostrarSugerencias && count($coberturasExistentes) > 0)
                                <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <p class="text-xs font-semibold text-yellow-800 mb-2">
                                        ⚠️ "{{ $nombre }}" ya tiene estas coberturas registradas:
                                    </p>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($coberturasExistentes as $coberturaExistente)
                                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded border border-yellow-300">
                                                {{ $coberturaExistente }}
                                            </span>
                                        @endforeach
                                    </div>
                                    <p class="text-xs text-yellow-700 mt-2">
                                        💡 Puedes agregar una nueva cobertura diferente para esta compañía
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Información adicional --}}
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800">
                                Información Importante
                            </h3>
                            <div class="mt-2 text-sm text-green-700 space-y-1">
                                <p>✅ <strong>Puedes usar el mismo nombre</strong> con diferentes coberturas</p>
                                <p>✅ Ejemplo: "AXA Seguros - Premium" y "AXA Seguros - Limitada"</p>
                                <p>❌ <strong>No puedes duplicar</strong> el mismo nombre y cobertura</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="flex items-center justify-end gap-4 pt-6 border-t">
                    <a href="{{ route('companias.index') }}" 
                       class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Guardar Compañía
                    </button>
                </div>
            </div>
        </form>

        {{-- Ayuda rápida --}}
        <div class="mt-6 bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ayuda Rápida</h3>
            <div class="space-y-3 text-sm text-gray-600">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p><strong>Nombre:</strong> Puede repetirse con diferentes coberturas. Usa el nombre oficial de la aseguradora.</p>
                </div>
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p><strong>Cobertura:</strong> Define el tipo de protección (Amplia Plus, Limitada, RC Profesional, etc.).</p>
                </div>
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p><strong>Validación:</strong> No se puede repetir la combinación exacta de Nombre + Cobertura.</p>
                </div>
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p>Los campos marcados con <span class="text-red-500">*</span> son obligatorios.</p>
                </div>
            </div>
        </div>

        {{-- Loading Indicator --}}
        <div wire:loading wire:target="guardar" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
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