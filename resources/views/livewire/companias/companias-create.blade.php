<div>
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('companias.index') }}" 
               class="mr-4 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Nueva Compañía</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Registra una nueva compañía aseguradora
                </p>
            </div>
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
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <form wire:submit.prevent="guardar">
            <div class="p-6 space-y-6">
                {{-- Nombre --}}
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nombre de la Compañía <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nombre"
                           wire:model.blur="nombre"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nombre') border-red-500 @enderror"
                           placeholder="Ej: AXA Seguros, GNP, Qualitas, etc.">
                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Ingresa el nombre oficial de la compañía aseguradora
                    </p>
                </div>

                {{-- Cobertura --}}
                <div>
                    <label for="cobertura" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Cobertura <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="cobertura"
                           wire:model.blur="cobertura"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('cobertura') border-red-500 @enderror"
                           placeholder="Ej: Amplia, Limitada, Responsabilidad Civil">
                    @error('cobertura')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Tipo de cobertura que ofrece esta compañía
                    </p>
                </div>

                {{-- Información adicional --}}
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                Información
                            </h3>
                            <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                <p>Una vez creada la compañía, podrás asociarle pólizas en el módulo correspondiente.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 rounded-b-lg flex justify-end space-x-3">
                <button type="button"
                        wire:click="cancelar"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                    Cancelar
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar Compañía
                </button>
            </div>
        </form>
    </div>

    {{-- Ayuda rápida --}}
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ayuda Rápida</h3>
        <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p><strong>Nombre:</strong> Debe ser único en el sistema. Usa el nombre oficial de la aseguradora.</p>
            </div>
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p><strong>Cobertura:</strong> Indica el tipo principal de cobertura (Amplia, Limitada, RC, etc.).</p>
            </div>
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p>Los campos marcados con <span class="text-red-500">*</span> son obligatorios.</p>
            </div>
        </div>
    </div>
</div>