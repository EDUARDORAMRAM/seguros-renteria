<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">
                📊 Importar Datos desde CSV
            </h2>
            <p class="text-sm text-gray-600 mt-1">
                Importa tus 4 archivos CSV (Compañías, Asegurados, Unidades, Pólizas)
            </p>
        </div>

        {{-- Mensajes --}}
        @if (session()->has('message'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                ✅ {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
                ❌ {{ session('error') }}
            </div>
        @endif

        {{-- Instrucciones --}}
        <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-6 rounded-lg">
            <h3 class="text-lg font-bold text-blue-800 mb-2">📋 Formato de los CSV</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                
                {{-- CSV 1: Companias --}}
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <h4 class="font-bold text-purple-700 mb-2">1️⃣ companias.csv</h4>
                    <div class="text-xs space-y-1">
                        <code class="bg-gray-100 px-2 py-1 rounded block">IdCompania,Nombre,Cobertura</code>
                        <code class="bg-gray-100 px-2 py-1 rounded block">1,CHUBB,AMPLIA</code>
                    </div>
                </div>

                {{-- CSV 2: Asegurados --}}
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <h4 class="font-bold text-green-700 mb-2">2️⃣ asegurados.csv</h4>
                    <div class="text-xs space-y-1">
                        <code class="bg-gray-100 px-2 py-1 rounded block">AseguradoID,Nombre,RFC,Telefono,Email</code>
                        <code class="bg-gray-100 px-2 py-1 rounded block">1,GARCIA LOPEZ JUAN,GALJ...</code>
                    </div>
                </div>

                {{-- CSV 3: Unidades --}}
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <h4 class="font-bold text-orange-700 mb-2">3️⃣ unidades.csv</h4>
                    <div class="text-xs space-y-1">
                        <code class="bg-gray-100 px-2 py-1 rounded block">IdUnidad,Marca,Submarca,Modelo,VIN,Año,Motor</code>
                        <code class="bg-gray-100 px-2 py-1 rounded block">1,KIA,SELTOS,EX,MZBE...</code>
                    </div>
                </div>

                {{-- CSV 4: Polizas --}}
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <h4 class="font-bold text-red-700 mb-2">4️⃣ polizas.csv</h4>
                    <div class="text-xs space-y-1">
                        <code class="bg-gray-100 px-2 py-1 rounded block">IdPoliza,NumPoliza,FormaPago,FechaInicio...</code>
                        <code class="bg-gray-100 px-2 py-1 rounded block">1,M645721062,ANUAL,2025-09-25...</code>
                    </div>
                </div>

            </div>
            <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded">
                <p class="text-xs text-yellow-800">
                    <strong>💡 Cómo crear los CSV:</strong> Abre tu Excel → Selecciona cada hoja → Guardar Como → CSV (delimitado por comas)
                </p>
            </div>
        </div>

        {{-- Sección de carga --}}
        <div class="bg-white shadow-xl rounded-xl p-8 border border-gray-100">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">
                📤 Cargar Archivos CSV
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- CSV 1: Compañías --}}
                <div class="border-2 border-purple-200 rounded-lg p-4 bg-purple-50">
                    <label class="block">
                        <span class="text-sm font-bold text-purple-800 mb-2 block">
                            1️⃣ Compañías (companias.csv)
                        </span>
                        <input type="file" 
                               wire:model="csvCompanias" 
                               accept=".csv"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200 cursor-pointer">
                        @error('csvCompanias') 
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if($csvCompanias)
                            <p class="mt-2 text-xs text-green-600">✅ {{ $csvCompanias->getClientOriginalName() }}</p>
                        @endif
                    </label>
                </div>

                {{-- CSV 2: Asegurados --}}
                <div class="border-2 border-green-200 rounded-lg p-4 bg-green-50">
                    <label class="block">
                        <span class="text-sm font-bold text-green-800 mb-2 block">
                            2️⃣ Asegurados (asegurados.csv)
                        </span>
                        <input type="file" 
                               wire:model="csvAsegurados" 
                               accept=".csv"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-100 file:text-green-700 hover:file:bg-green-200 cursor-pointer">
                        @error('csvAsegurados') 
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if($csvAsegurados)
                            <p class="mt-2 text-xs text-green-600">✅ {{ $csvAsegurados->getClientOriginalName() }}</p>
                        @endif
                    </label>
                </div>

                {{-- CSV 3: Unidades --}}
                <div class="border-2 border-orange-200 rounded-lg p-4 bg-orange-50">
                    <label class="block">
                        <span class="text-sm font-bold text-orange-800 mb-2 block">
                            3️⃣ Unidades (unidades.csv)
                        </span>
                        <input type="file" 
                               wire:model="csvUnidades" 
                               accept=".csv"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200 cursor-pointer">
                        @error('csvUnidades') 
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if($csvUnidades)
                            <p class="mt-2 text-xs text-green-600">✅ {{ $csvUnidades->getClientOriginalName() }}</p>
                        @endif
                    </label>
                </div>

                {{-- CSV 4: Pólizas --}}
                <div class="border-2 border-red-200 rounded-lg p-4 bg-red-50">
                    <label class="block">
                        <span class="text-sm font-bold text-red-800 mb-2 block">
                            4️⃣ Pólizas (polizas.csv)
                        </span>
                        <input type="file" 
                               wire:model="csvPolizas" 
                               accept=".csv"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-100 file:text-red-700 hover:file:bg-red-200 cursor-pointer">
                        @error('csvPolizas') 
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if($csvPolizas)
                            <p class="mt-2 text-xs text-green-600">✅ {{ $csvPolizas->getClientOriginalName() }}</p>
                        @endif
                    </label>
                </div>

            </div>

            @if($csvCompanias && $csvAsegurados && $csvUnidades && $csvPolizas)
                <div class="mt-6">
                    <button wire:click="importarCsvs" 
                            wire:loading.attr="disabled"
                            class="w-full px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Iniciar Importación
                    </button>
                </div>
            @endif

            @if($progreso > 0)
                <div class="mt-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Progreso</span>
                        <span class="text-sm font-bold text-blue-600">{{ $progreso }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500" 
                             style="width: {{ $progreso }}%"></div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Resultados --}}
        @if(count($resultados) > 0)
            <div class="mt-6 bg-white shadow-xl rounded-xl p-6 border border-gray-100">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">📊 Resultados</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($resultados as $tipo => $resultado)
                        @php
                            $colores = [
                                'companias' => ['bg' => 'bg-purple-50', 'border' => 'border-purple-200', 'text' => 'text-purple-800'],
                                'asegurados' => ['bg' => 'bg-green-50', 'border' => 'border-green-200', 'text' => 'text-green-800'],
                                'unidades' => ['bg' => 'bg-orange-50', 'border' => 'border-orange-200', 'text' => 'text-orange-800'],
                                'polizas' => ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'text' => 'text-red-800'],
                            ];
                            $color = $colores[$tipo] ?? ['bg' => 'bg-gray-50', 'border' => 'border-gray-200', 'text' => 'text-gray-800'];
                        @endphp
                        
                        <div class="border-2 {{ $color['border'] }} {{ $color['bg'] }} rounded-lg p-5">
                            <h4 class="font-bold {{ $color['text'] }} capitalize mb-3">{{ ucfirst($tipo) }}</h4>
                            
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm">Total:</span>
                                    <span class="font-bold">{{ $resultado['total'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm">Importados:</span>
                                    <span class="font-bold text-green-600">{{ $resultado['importados'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm">Errores:</span>
                                    <span class="font-bold text-red-600">{{ count($resultado['errores']) }}</span>
                                </div>
                            </div>
                            
                            @if(count($resultado['errores']) > 0)
                                <details class="mt-4">
                                    <summary class="text-sm text-red-600 cursor-pointer">⚠️ Ver errores</summary>
                                    <ul class="mt-2 text-xs text-red-600 max-h-40 overflow-y-auto">
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

    {{-- Loading --}}
    <div wire:loading wire:target="importarCsvs" 
         class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 flex flex-col items-center gap-4">
            <svg class="animate-spin h-16 w-16 text-blue-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-xl font-bold">Importando... {{ $progreso }}%</span>
        </div>
    </div>
</div>