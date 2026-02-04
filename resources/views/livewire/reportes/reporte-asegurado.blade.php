<div>
    {{-- Header --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3">
                <a href="{{ route('reportes.index') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Reporte por Asegurado</h1>
            </div>
            <p class="text-gray-500 mt-1 ml-8">Selecciona un cliente y genera el reporte de sus pólizas</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Formulario --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-gray-100 p-6 sticky top-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Configuración</h2>

                {{-- Buscar Asegurado --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Asegurado</label>
                    <input type="text"
                           wire:model.live.debounce.300ms="busqueda"
                           placeholder="Nombre, apellido o RFC..."
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                {{-- Seleccionar Asegurado --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Asegurado</label>
                    <select wire:model.live="aseguradoId"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccionar...</option>
                        @foreach($this->asegurados as $asegurado)
                            <option value="{{ $asegurado->IdAsegurado }}">
                                {{ $asegurado->nombre_completo }}
                            </option>
                        @endforeach
                    </select>
                    @error('aseguradoId')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Filtrar por Estatus --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mostrar Pólizas</label>
                    <div class="space-y-2">
                        <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="radio" wire:model.live="estatus" value="todas" class="text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Todas las pólizas</span>
                        </label>
                        <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="radio" wire:model.live="estatus" value="activas" class="text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Solo activas</span>
                            <span class="ml-auto px-2 py-0.5 text-xs bg-green-100 text-green-700 rounded">Activa</span>
                        </label>
                        <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="radio" wire:model.live="estatus" value="vencidas" class="text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Solo vencidas</span>
                            <span class="ml-auto px-2 py-0.5 text-xs bg-red-100 text-red-700 rounded">Vencida</span>
                        </label>
                        <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="radio" wire:model.live="estatus" value="canceladas" class="text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Solo canceladas</span>
                            <span class="ml-auto px-2 py-0.5 text-xs bg-gray-100 text-gray-700 rounded">Cancelada</span>
                        </label>
                    </div>
                </div>

                {{-- Resumen --}}
                @if($this->resumen)
                    <div class="border-t border-gray-100 pt-4 mb-6">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Resumen del Reporte</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Total Pólizas:</span>
                                <span class="font-medium">{{ $this->resumen['totalPolizas'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Prima Total:</span>
                                <span class="font-medium">${{ number_format($this->resumen['totalPrima'], 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Total Pagado:</span>
                                <span class="font-medium text-green-600">${{ number_format($this->resumen['totalPagado'], 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Total Pendiente:</span>
                                <span class="font-medium text-amber-600">${{ number_format($this->resumen['totalPendiente'], 2) }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Botón Generar --}}
                <button wire:click="generarPdf"
                        @if(!$aseguradoId) disabled @endif
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Descargar PDF
                </button>
            </div>
        </div>

        {{-- Preview --}}
        <div class="lg:col-span-2">
            @if($aseguradoSeleccionado)
                <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                    {{-- Header del Preview --}}
                    <div class="p-6 border-b border-gray-100 bg-gray-50">
                        <div class="flex items-start justify-between">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">{{ $aseguradoSeleccionado->nombre_completo }}</h2>
                                <p class="text-sm text-gray-500 mt-1">RFC: {{ $aseguradoSeleccionado->RFC ?? 'No registrado' }}</p>
                                @if($aseguradoSeleccionado->Telefono)
                                    <p class="text-sm text-gray-500">Tel: {{ $aseguradoSeleccionado->Telefono }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <span class="px-3 py-1 text-sm font-medium rounded-full
                                    {{ $estatus === 'todas' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $estatus === 'activas' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $estatus === 'vencidas' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $estatus === 'canceladas' ? 'bg-gray-100 text-gray-700' : '' }}">
                                    {{ ucfirst($estatus) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Lista de Pólizas --}}
                    @if(count($polizasPreview) > 0)
                        <div class="divide-y divide-gray-100">
                            @foreach($polizasPreview as $poliza)
                                <div class="p-4">
                                    {{-- Encabezado de Póliza --}}
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-semibold text-gray-900">{{ $poliza->NumPoliza }}</span>
                                                <span class="px-2 py-0.5 text-xs rounded
                                                    {{ $poliza->Estatus === 'Activa' ? 'bg-green-100 text-green-700' : '' }}
                                                    {{ $poliza->Estatus === 'Vencida' ? 'bg-red-100 text-red-700' : '' }}
                                                    {{ $poliza->Estatus === 'Cancelada' ? 'bg-gray-100 text-gray-700' : '' }}">
                                                    {{ $poliza->Estatus }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-500">{{ $poliza->compania->Nombre ?? 'N/A' }} - {{ $poliza->compania->Cobertura ?? '' }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-gray-900">${{ number_format($poliza->Prima, 2) }}</p>
                                            <p class="text-xs text-gray-500">{{ $poliza->FormaPago }}</p>
                                        </div>
                                    </div>

                                    {{-- Info de Unidad --}}
                                    @if($poliza->unidad)
                                        <div class="bg-gray-50 rounded-lg p-2 mb-3 text-sm">
                                            <span class="text-gray-600">{{ $poliza->unidad->Marca }} {{ $poliza->unidad->Submarca }} {{ $poliza->unidad->Modelo }}</span>
                                            @if($poliza->unidad->Placas)
                                                <span class="text-gray-400 ml-2">Placas: {{ $poliza->unidad->Placas }}</span>
                                            @endif
                                        </div>
                                    @endif

                                    {{-- Fechas --}}
                                    <div class="flex gap-4 text-xs text-gray-500 mb-3">
                                        <span>Inicio: {{ $poliza->FechaInicio?->format('d/m/Y') }}</span>
                                        <span>Vence: {{ $poliza->FechaVencimiento?->format('d/m/Y') }}</span>
                                    </div>

                                    {{-- Calendario de Pagos --}}
                                    @if($poliza->fechasCobranza->count() > 0)
                                        <div class="border-t border-gray-100 pt-3">
                                            <p class="text-xs font-medium text-gray-500 mb-2">CALENDARIO DE PAGOS</p>
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                @foreach($poliza->fechasCobranza as $pago)
                                                    <div class="text-xs p-2 rounded
                                                        {{ $pago->Estatus === 'Pagado' ? 'bg-green-50 border border-green-100' : 'bg-amber-50 border border-amber-100' }}">
                                                        <div class="flex items-center justify-between">
                                                            <span class="{{ $pago->Estatus === 'Pagado' ? 'text-green-700' : 'text-amber-700' }}">
                                                                {{ $pago->FechaCobranza?->format('d/m/Y') }}
                                                            </span>
                                                            @if($pago->Estatus === 'Pagado')
                                                                <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                                </svg>
                                                            @else
                                                                <svg class="w-3 h-3 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                                </svg>
                                                            @endif
                                                        </div>
                                                        <div class="font-medium {{ $pago->Estatus === 'Pagado' ? 'text-green-800' : 'text-amber-800' }}">
                                                            ${{ number_format($pago->MontoCobro, 2) }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-12 text-center">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500">No hay pólizas con el filtro seleccionado</p>
                        </div>
                    @endif
                </div>
            @else
                {{-- Estado vacío --}}
                <div class="bg-white rounded-xl border border-gray-100 p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Selecciona un asegurado</h3>
                    <p class="text-gray-500 text-sm">Busca y selecciona un cliente para ver la vista previa del reporte</p>
                </div>
            @endif
        </div>
    </div>
</div>
