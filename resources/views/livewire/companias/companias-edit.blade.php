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
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Compañía</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Actualiza la información de la compañía aseguradora
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Formulario Principal --}}
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                <form wire:submit.prevent="actualizar">
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

                        {{-- Información de registro --}}
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Información del Registro</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Fecha de registro:</span>
                                    <p class="text-gray-900 dark:text-white font-medium">
                                        {{ $compania->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Última actualización:</span>
                                    <p class="text-gray-900 dark:text-white font-medium">
                                        {{ $compania->updated_at->format('d/m/Y H:i') }}
                                    </p>
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
                            Actualizar Compañía
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Panel de Estadísticas --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Estadísticas --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Estadísticas</h3>
                <div class="space-y-4">
                    {{-- Total Pólizas --}}
                    <div class="flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Pólizas</p>
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $totalPolizas }}</p>
                        </div>
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>

                    {{-- Pólizas Activas --}}
                    <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Pólizas Activas</p>
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $polizasActivas }}</p>
                        </div>
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>

                    {{-- Primas Totales --}}
                    <div class="flex items-center justify-between p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Primas Totales</p>
                            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                                ${{ number_format($primasTotales, 2) }}
                            </p>
                        </div>
                        <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Advertencia --}}
            @if($totalPolizas > 0)
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                            Advertencia
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                            <p>Esta compañía tiene {{ $totalPolizas }} póliza(s) asociada(s). Los cambios afectarán la información relacionada.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Ayuda --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ayuda</h3>
                <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <p>El nombre debe ser único en el sistema.</p>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <p>Los cambios se aplicarán inmediatamente a todas las pólizas asociadas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>