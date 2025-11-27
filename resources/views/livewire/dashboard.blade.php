<div>
    <div class="max-w-7xl mx-auto">
            
            {{-- Header con fecha --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Dashboard - Panel de Control</h1>
                <p class="text-sm text-gray-600 mt-1">
                    📅 {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                </p>
            </div>

            {{-- Botones de Acción Rápida --}}
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('polizas.create') }}" 
                   class="flex items-center justify-center gap-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-5 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <div class="text-left">
                        <div class="font-bold text-lg">Nueva Póliza</div>
                        <div class="text-xs opacity-90">Registrar póliza</div>
                    </div>
                </a>

                <a href="{{ route('asegurados.create') }}" 
                   class="flex items-center justify-center gap-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-5 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <div class="text-left">
                        <div class="font-bold text-lg">Nuevo Cliente</div>
                        <div class="text-xs opacity-90">Agregar asegurado</div>
                    </div>
                </a>

                <a href="{{ route('unidades.create') }}" 
                   class="flex items-center justify-center gap-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white p-5 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                    </svg>
                    <div class="text-left">
                        <div class="font-bold text-lg">Nueva Unidad</div>
                        <div class="text-xs opacity-90">Registrar vehículo</div>
                    </div>
                </a>
            </div>

            {{-- Alerta de Pólizas por Vencer --}}
            @if($this->stats['proximas_vencer'] > 0)
                <div class="mb-6 bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-500 p-5 rounded-xl shadow-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-10 w-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-xl font-bold text-yellow-900">
                                ⚠️ ¡ATENCIÓN! Tienes {{ $this->stats['proximas_vencer'] }} póliza(s) por vencer
                            </h3>
                            <p class="text-sm text-yellow-800 mt-1">
                                Es importante contactar a tus clientes para renovar sus pólizas en los próximos 30 días
                            </p>
                        </div>
                        <div class="ml-auto">
                            <a href="#polizas-vencer" 
                               class="inline-flex items-center px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition shadow-md">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Estadísticas Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                {{-- Pólizas Activas --}}
                <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-100 hover:shadow-2xl transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-xl p-4">
                                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Pólizas Activas
                                </dt>
                                <dd class="flex items-baseline mt-1">
                                    <div class="text-4xl font-bold text-gray-900">
                                        {{ number_format($this->stats['polizas_activas']) }}
                                    </div>
                                    <div class="ml-2 text-sm font-medium text-gray-500">
                                        / {{ $this->stats['total_polizas'] }}
                                    </div>
                                </dd>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
                        <a href="{{ route('polizas.index') }}" 
                           class="text-sm text-blue-600 hover:text-blue-800 font-semibold">
                            Ver todas →
                        </a>
                    </div>
                </div>

                {{-- Por Vencer --}}
                <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-100 hover:shadow-2xl transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-xl p-4">
                                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Por Vencer
                                </dt>
                                <dd class="flex items-baseline mt-1">
                                    <div class="text-4xl font-bold text-yellow-600">
                                        {{ number_format($this->stats['proximas_vencer']) }}
                                    </div>
                                    <div class="ml-2 text-sm font-medium text-gray-500">
                                        30 días
                                    </div>
                                </dd>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
                        <a href="#polizas-vencer" 
                           class="text-sm text-blue-600 hover:text-blue-800 font-semibold">
                            Ver detalles →
                        </a>
                    </div>
                </div>

                {{-- Clientes --}}
                <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-100 hover:shadow-2xl transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-xl p-4">
                                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Clientes
                                </dt>
                                <dd class="mt-1">
                                    <div class="text-4xl font-bold text-gray-900">
                                        {{ number_format($this->stats['total_asegurados']) }}
                                    </div>
                                </dd>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
                        <a href="{{ route('asegurados.index') }}" 
                           class="text-sm text-blue-600 hover:text-blue-800 font-semibold">
                            Ver todos →
                        </a>
                    </div>
                </div>

                {{-- Primas del Mes --}}
                <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-100 hover:shadow-2xl transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-xl p-4">
                                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Primas del Mes
                                </dt>
                                <dd class="mt-1">
                                    <div class="text-3xl font-bold text-gray-900">
                                        ${{ number_format($this->stats['prima_total_mes'], 2) }}
                                    </div>
                                </dd>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
                        <span class="text-sm text-gray-500 font-medium">
                            {{ now()->locale('es')->format('F Y') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Pólizas Próximas a Vencer --}}
            <div id="polizas-vencer" class="bg-white shadow-xl rounded-xl p-6 mb-6 border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                            <span class="text-3xl">⏰</span>
                            Pólizas Próximas a Vencer (30 días)
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">
                            ¡Contacta a estos clientes para renovar sus pólizas!
                        </p>
                    </div>
                </div>
                
                @if($this->polizasProximasVencer->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b-2 border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Urgencia</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Cliente</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Teléfono</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Vehículo</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Vencimiento</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Prima</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($this->polizasProximasVencer as $poliza)
                                    @php
                                        $dias = $poliza->dias_para_vencer;
                                        $urgencia = $dias <= 7 ? 'critico' : ($dias <= 15 ? 'urgente' : 'proximo');
                                        $badgeClass = [
                                            'critico' => 'bg-red-100 text-red-800 border-2 border-red-300 animate-pulse',
                                            'urgente' => 'bg-orange-100 text-orange-800 border-2 border-orange-300',
                                            'proximo' => 'bg-yellow-100 text-yellow-800 border-2 border-yellow-300'
                                        ][$urgencia];
                                    @endphp
                                    <tr class="hover:bg-blue-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-4 py-2 text-sm font-bold rounded-lg {{ $badgeClass }}">
                                                @if($dias <= 0)
                                                    ¡VENCIDA!
                                                @elseif($dias == 1)
                                                    ¡MAÑANA!
                                                @else
                                                    {{ $dias }} días
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-gray-900">
                                                {{ $poliza->nombre_completo_asegurado }}
                                            </div>
                                            <div class="text-xs text-gray-500 font-medium">
                                                {{ $poliza->NumPoliza }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="tel:{{ $poliza->asegurado->Telefono }}" 
                                               class="text-sm text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                </svg>
                                                {{ $poliza->asegurado->Telefono }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700 font-medium">
                                            {{ $poliza->unidad->descripcion_completa ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            {{ $poliza->FechaVencimiento->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                                            ${{ number_format($poliza->Prima, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                            <a href="{{ route('polizas.show', $poliza->IdPoliza) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-md">
                                                Ver
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-16">
                        <svg class="mx-auto h-20 w-20 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="mt-4 text-2xl font-bold text-gray-900">¡Todo al día!</h3>
                        <p class="mt-2 text-base text-gray-600">
                            No hay pólizas próximas a vencer en los próximos 30 días
                        </p>
                    </div>
                @endif
            </div>

            {{-- Gráficos --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                
                {{-- Gráfico de Pólizas --}}
                <div class="bg-white shadow-xl rounded-xl p-6 border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">
                        📊 Pólizas Emitidas ({{ now()->year }})
                    </h3>
                    <div style="height: 300px;">
                        <canvas id="polizasChart"></canvas>
                    </div>
                </div>

                {{-- Top Aseguradoras --}}
                <div class="bg-white shadow-xl rounded-xl p-6 border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">
                        🏢 Top 5 Aseguradoras
                    </h3>
                    <div class="space-y-5">
                        @foreach($this->polizasPorCompania as $compania)
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm font-bold text-gray-700">
                                        {{ $compania->Nombre }}
                                    </span>
                                    <span class="text-sm font-bold text-blue-600">
                                        {{ $compania->polizas_activas_count }} pólizas
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-4">
                                    @php
                                        $maxPolizas = $this->polizasPorCompania->max('polizas_activas_count');
                                        $percentage = $maxPolizas > 0 ? ($compania->polizas_activas_count / $maxPolizas) * 100 : 0;
                                    @endphp
                                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-4 rounded-full transition-all duration-500 shadow-inner" 
                                         style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('polizasChart');
        if (ctx) {
            const mesesData = @json($this->polizasPorMes);
            
            const mesesNombres = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
            const labels = mesesData.map(item => mesesNombres[item.mes - 1]);
            const data = mesesData.map(item => item.total);
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pólizas',
                        data: data,
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 2,
                        borderRadius: 10,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 2
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush