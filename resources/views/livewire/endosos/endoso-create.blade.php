<div>
    {{-- Header --}}
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Endosos de la Póliza</h3>
                <p class="text-sm text-gray-600 mt-1">
                    Historial de modificaciones y cambios en la póliza
                </p>
            </div>
            <button wire:click="abrirModal" 
                    type="button"
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Endoso
            </button>
        </div>

        {{-- Flash Messages --}}
        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('message') }}
            </div>
        @endif

        {{-- Lista de Endosos --}}
        @if($endosos->count() > 0)
            <div class="space-y-4">
                @foreach($endosos as $endoso)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-sm font-bold text-gray-900">{{ $endoso->NumEndoso }}</span>
                                    @php
                                        $badgeClass = match($endoso->TipoEndoso) {
                                            'Modificacion' => 'bg-blue-100 text-blue-800',
                                            'Renovacion' => 'bg-green-100 text-green-800',
                                            'Cancelacion' => 'bg-red-100 text-red-800',
                                            'Cambio Suma Asegurada' => 'bg-yellow-100 text-yellow-800',
                                            'Cambio Beneficiario' => 'bg-purple-100 text-purple-800',
                                            'Cambio Unidad' => 'bg-indigo-100 text-indigo-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
                                        {{ $endoso->TipoEndoso }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $endoso->FechaEndoso->format('d/m/Y') }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        por {{ $endoso->nombre_usuario }}
                                    </span>
                                </div>
                                
                                <p class="text-sm text-gray-700 mb-2">{{ $endoso->Descripcion }}</p>
                                
                                <div class="flex items-center gap-4 text-xs text-gray-500">
                                    @if($endoso->MontoAfectado)
                                        <span class="font-medium">
                                            Monto: ${{ number_format($endoso->MontoAfectado, 2) }}
                                        </span>
                                    @endif
                                    
                                    @if($endoso->tiene_archivo)
                                        <a href="{{ $endoso->url_archivo }}" 
                                           target="_blank"
                                           class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Ver PDF
                                        </a>
                                    @endif
                                </div>
                            </div>
                            
                            <button wire:click="eliminar({{ $endoso->IdEndoso }})" 
                                    wire:confirm="¿Estás seguro de eliminar este endoso? Esta acción no se puede deshacer."
                                    type="button"
                                    class="text-red-600 hover:text-red-900 ml-4"
                                    title="Eliminar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay endosos</h3>
                <p class="mt-1 text-sm text-gray-500">Comienza creando un nuevo endoso para esta póliza.</p>
                <div class="mt-6">
                    <button wire:click="abrirModal" 
                            type="button"
                            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Crear Primer Endoso
                    </button>
                </div>
            </div>
        @endif
    </div>

    {{-- MODAL CREAR ENDOSO --}}
    @if($mostrarModal)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                {{-- Header Modal --}}
                <div class="flex items-center justify-between p-6 border-b sticky top-0 bg-white">
                    <h3 class="text-lg font-semibold text-gray-900">Nuevo Endoso</h3>
                    <button wire:click="cerrarModal" type="button" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Body Modal --}}
                <form wire:submit.prevent="guardar" class="p-6 space-y-6">
                    {{-- Tipo de Endoso --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tipo de Endoso <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="tipo_endoso" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                            <option value="Modificacion">Modificación</option>
                            <option value="Renovacion">Renovación</option>
                            <option value="Cancelacion">Cancelación</option>
                            <option value="Cambio Suma Asegurada">Cambio Suma Asegurada</option>
                            <option value="Cambio Beneficiario">Cambio Beneficiario</option>
                            <option value="Cambio Unidad">Cambio Unidad</option>
                            <option value="Otro">Otro</option>
                        </select>
                        @error('tipo_endoso') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción <span class="text-red-500">*</span>
                        </label>
                        <textarea wire:model="descripcion" 
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                                  placeholder="Describe los cambios realizados en este endoso..."></textarea>
                        @error('descripcion') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Mínimo 10 caracteres</p>
                    </div>

                    {{-- Monto Afectado --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Monto Afectado (Opcional)
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                            <input type="number" 
                                   wire:model="monto_afectado"
                                   step="0.01"
                                   min="0"
                                   class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                                   placeholder="0.00">
                        </div>
                        @error('monto_afectado') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Si aplica, indica el monto relacionado con el endoso</p>
                    </div>

                    {{-- Archivo Adjunto --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Adjuntar Documento PDF (Opcional)
                        </label>
                        <input type="file" 
                               wire:model="archivo_adjunto"
                               accept=".pdf"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        @error('archivo_adjunto') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        {{-- Indicador de carga --}}
                        <div wire:loading wire:target="archivo_adjunto" class="mt-2">
                            <div class="flex items-center text-green-600 text-sm">
                                <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Cargando archivo...
                            </div>
                        </div>
                        
                        {{-- Preview --}}
                        @if ($archivo_adjunto)
                            <div class="mt-2 p-3 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-sm text-green-800">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="font-medium">{{ $archivo_adjunto->getClientOriginalName() }}</span>
                                    </div>
                                    <button type="button" 
                                            wire:click="$set('archivo_adjunto', null)"
                                            class="text-red-600 hover:text-red-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif
                        
                        <p class="mt-1 text-xs text-gray-500">Formato PDF, máximo 5MB</p>
                    </div>

                    {{-- Footer Modal --}}
                    <div class="flex items-center justify-end gap-4 pt-4 border-t">
                        <button type="button"
                                wire:click="cerrarModal"
                                class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Guardar Endoso
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Loading Overlay --}}
    <div wire:loading wire:target="guardar" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <svg class="animate-spin h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-900 font-medium">Guardando endoso...</span>
        </div>
    </div>
</div>