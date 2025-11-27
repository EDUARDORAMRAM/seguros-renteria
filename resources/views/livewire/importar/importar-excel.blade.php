<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                📊 Importar Datos desde Excel
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                Carga tus archivos de Excel para migrar tu información al sistema
            </p>
        </div>

        {{-- Mensajes --}}
        @if (session()->has('message'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        {{-- Instrucciones --}}
        <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
            <div class="flex items-start">
                <svg class="h-6 w-6 text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="text-lg font-bold text-blue-800">Instrucciones de Importación</h3>
                    <ul class="mt-2 text-sm text-blue-700 list-disc list-inside space-y-1">
                        <li>Descarga las plantillas de Excel haciendo clic en los botones correspondientes</li>
                        <li>Llena las plantillas con tus datos siguiendo el formato indicado</li>
                        <li>Sube los archivos en el orden sugerido: 1) Compañías, 2) Clientes, 3) Unidades, 4) Pólizas</li>
                        <li>Los archivos deben estar en formato .xlsx, .xls o .csv</li>
                        <li>Tamaño máximo por archivo: 10 MB</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Grid de Secciones --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- 1. Importar Compañías Aseguradoras --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="text-2xl">🏢</span>
                            Compañías Aseguradoras
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Paso 1: Importar primero las compañías
                        </p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        Paso 1
                    </span>
                </div>

                <div class="space-y-4">
                    <button wire:click="descargarPlantilla('companias')" 
                            class="w-full px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Descargar Plantilla
                    </button>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Seleccionar archivo Excel
                        </label>
                        <input type="file" 
                               wire:model="archivoCompanias" 
                               accept=".xlsx,.xls,.csv"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @error('archivoCompanias') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    @if($archivoCompanias)
                        <button wire:click="importarCompanias" 
                                wire:loading.attr="disabled"
                                class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Importar Compañías
                        </button>
                    @endif

                    @if($progresoCompanias > 0)
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" 
                                 style="width: {{ $progresoCompanias }}%"></div>
                        </div>
                        <p class="text-sm text-center text-gray-600">{{ $progresoCompanias }}%</p>
                    @endif
                </div>
            </div>

            {{-- 2. Importar Clientes --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="text-2xl">👥</span>
                            Clientes (Asegurados)
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Paso 2: Importar tu base de clientes
                        </p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Paso 2
                    </span>
                </div>

                <div class="space-y-4">
                    <button wire:click="descargarPlantilla('clientes')" 
                            class="w-full px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Descargar Plantilla
                    </button>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Seleccionar archivo Excel
                        </label>
                        <input type="file" 
                               wire:model="archivoClientes" 
                               accept=".xlsx,.xls,.csv"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        @error('archivoClientes') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    @if($archivoClientes)
                        <button wire:click="importarClientes" 
                                wire:loading.attr="disabled"
                                class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Importar Clientes
                        </button>
                    @endif

                    @if($progresoClientes > 0)
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-green-600 h-2.5 rounded-full transition-all duration-300" 
                                 style="width: {{ $progresoClientes }}%"></div>
                        </div>
                        <p class="text-sm text-center text-gray-600">{{ $progresoClientes }}%</p>
                    @endif
                </div>
            </div>

            {{-- 3. Importar Unidades --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="text-2xl">🚗</span>
                            Unidades (Vehículos)
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Paso 3: Importar los vehículos
                        </p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                        Paso 3
                    </span>
                </div>

                <div class="space-y-4">
                    <button wire:click="descargarPlantilla('unidades')" 
                            class="w-full px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Descargar Plantilla
                    </button>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Seleccionar archivo Excel
                        </label>
                        <input type="file" 
                               wire:model="archivoUnidades" 
                               accept=".xlsx,.xls,.csv"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                        @error('archivoUnidades') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    @if($archivoUnidades)
                        <button wire:click="importarUnidades" 
                                wire:loading.attr="disabled"
                                class="w-full px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Importar Unidades
                        </button>
                    @endif

                    @if($progresoUnidades > 0)
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-orange-600 h-2.5 rounded-full transition-all duration-300" 
                                 style="width: {{ $progresoUnidades }}%"></div>
                        </div>
                        <p class="text-sm text-center text-gray-600">{{ $progresoUnidades }}%</p>
                    @endif
                </div>
            </div>

            {{-- 4. Importar Pólizas --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="text-2xl">📋</span>
                            Pólizas
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Paso 4: Finalmente, importar las pólizas
                        </p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        Paso 4
                    </span>
                </div>

                <div class="space-y-4">
                    <button wire:click="descargarPlantilla('polizas')" 
                            class="w-full px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Descargar Plantilla
                    </button>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Seleccionar archivo Excel
                        </label>
                        <input type="file" 
                               wire:model="archivoPolizas" 
                               accept=".xlsx,.xls,.csv"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                        @error('archivoPolizas') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    @if($archivoPolizas)
                        <button wire:click="importarPolizas" 
                                wire:loading.attr="disabled"
                                class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Importar Pólizas
                        </button>
                    @endif

                    @if($progresoPolizas > 0)
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-red-600 h-2.5 rounded-full transition-all duration-300" 
                                 style="width: {{ $progresoPolizas }}%"></div>
                        </div>
                        <p class="text-sm text-center text-gray-600">{{ $progresoPolizas }}%</p>
                    @endif
                </div>
            </div>

        </div>

        {{-- Resultados de Importación --}}
        @if(count($resultados) > 0)
            <div class="mt-6 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                    📊 Resultados de Importación
                </h3>
                
                <div class="space-y-4">
                    @foreach($resultados as $tipo => $resultado)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white capitalize mb-2">
                                {{ ucfirst($tipo) }}
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Importados: <span class="font-bold text-green-600">{{ $resultado['importados'] }}</span> de {{ $resultado['total'] }}
                            </p>
                            
                            @if(count($resultado['errores']) > 0)
                                <details class="mt-2">
                                    <summary class="text-sm text-red-600 cursor-pointer">
                                        Ver errores ({{ count($resultado['errores']) }})
                                    </summary>
                                    <ul class="mt-2 text-xs text-red-600 list-disc list-inside space-y-1">
                                        @foreach($resultado['errores'] as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </details>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    {{-- Loading Overlay --}}
    <div wire:loading wire:target="importarCompanias,importarClientes,importarUnidades,importarPolizas" 
         class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-8 flex flex-col items-center gap-4">
            <svg class="animate-spin h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-lg font-semibold text-gray-900 dark:text-white">Importando datos...</span>
            <span class="text-sm text-gray-600 dark:text-gray-400">Por favor espera</span>
        </div>
    </div>
</div>