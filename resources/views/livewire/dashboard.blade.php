<div x-data="{ showNotifications: false, activeTab: 'cobranzas' }">

    {{-- Header --}}
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900 flex items-center gap-3">
                Panel de Control
            </h1>
            <p class="text-slate-500 mt-1 flex items-center gap-2 text-sm">
                <span class="material-icons-round text-sm">calendar_today</span>
                {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
            </p>
        </div>

        <div class="flex items-center gap-4">
            {{-- Notificaciones --}}
            @php
                $totalAlertas = $this->stats['proximas_cobrar'] + $this->stats['proximas_vencer'];
            @endphp
            <div class="relative">
                <button @click="showNotifications = !showNotifications"
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition-all relative shadow-sm">
                    <span class="material-icons-round">notifications</span>
                    @if($totalAlertas > 0)
                        <span class="absolute -top-1 -right-1 w-5 h-5 flex items-center justify-center text-[10px] font-bold text-white bg-red-500 rounded-full border-2 border-white">
                            {{ $totalAlertas > 99 ? '99+' : $totalAlertas }}
                        </span>
                    @endif
                </button>

                {{-- Dropdown Notificaciones --}}
                <div x-show="showNotifications"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     @click.away="showNotifications = false"
                     class="absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-2xl border border-slate-200 z-50 overflow-hidden">
                    <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                        <h4 class="text-sm font-bold text-slate-900">Notificaciones</h4>
                        @if($totalAlertas > 0)
                            <span class="text-[10px] font-bold text-blue-600 uppercase bg-blue-50 px-2 py-0.5 rounded">{{ $totalAlertas }} Alertas</span>
                        @endif
                    </div>
                    <div class="max-h-80 overflow-y-auto">
                        @if($this->stats['proximas_cobrar'] > 0)
                            <a href="#seccion-alertas" @click="activeTab = 'cobranzas'; showNotifications = false"
                               class="block p-4 hover:bg-amber-50 border-b border-slate-50 transition-colors">
                                <div class="flex gap-3">
                                    <div class="w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center shrink-0">
                                        <span class="material-icons-round text-amber-600 text-lg">account_balance_wallet</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-slate-900">Cobranzas próximas</p>
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $this->stats['proximas_cobrar'] }} en los próximos 7 días</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-bold text-amber-700 bg-amber-100 rounded-full">
                                        {{ $this->stats['proximas_cobrar'] }}
                                    </span>
                                </div>
                            </a>
                        @endif

                        @if($this->stats['proximas_vencer'] > 0)
                            <a href="#seccion-alertas" @click="activeTab = 'vencer'; showNotifications = false"
                               class="block p-4 hover:bg-red-50 border-b border-slate-50 transition-colors">
                                <div class="flex gap-3">
                                    <div class="w-9 h-9 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                                        <span class="material-icons-round text-red-600 text-lg">running_with_errors</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-slate-900">Pólizas por vencer</p>
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $this->stats['proximas_vencer'] }} en los próximos 30 días</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-bold text-red-700 bg-red-100 rounded-full">
                                        {{ $this->stats['proximas_vencer'] }}
                                    </span>
                                </div>
                            </a>
                        @endif

                        @if($totalAlertas == 0)
                            <div class="p-8 text-center">
                                <span class="material-icons-round text-4xl text-emerald-400 mb-2">check_circle</span>
                                <p class="text-sm text-slate-500">Todo al día</p>
                            </div>
                        @endif
                    </div>
                    @if($totalAlertas > 0)
                        <a href="#seccion-alertas" @click="showNotifications = false"
                           class="block p-3 text-center text-xs font-bold text-blue-600 hover:bg-slate-50 transition-colors border-t border-slate-100">
                            Ver todas las alertas
                        </a>
                    @endif
                </div>
            </div>

            <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>

            {{-- Botones de acción rápida --}}
            <div class="hidden sm:flex items-center bg-white rounded-lg border border-slate-200 p-1 shadow-sm">
                <a href="{{ route('polizas.create') }}" class="px-4 py-1.5 bg-blue-600 text-white rounded-md text-sm font-medium flex items-center gap-2 hover:bg-blue-700 transition-all">
                    <span class="material-icons-round text-base">add</span>
                    Póliza
                </a>
                <a href="{{ route('asegurados.create') }}" class="px-3 py-1.5 text-slate-600 hover:bg-slate-100 rounded-md text-sm font-medium transition-all">
                    Cliente
                </a>
                <a href="{{ route('unidades.create') }}" class="px-3 py-1.5 text-slate-600 hover:bg-slate-100 rounded-md text-sm font-medium transition-all">
                    Unidad
                </a>
            </div>
        </div>
    </header>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Pólizas Activas --}}
        <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Pólizas Activas</p>
                    <h3 class="text-3xl font-bold mt-2 text-slate-900">
                        {{ number_format($this->stats['polizas_activas']) }}
                        <span class="text-lg font-normal text-slate-400">/ {{ number_format($this->stats['total_polizas']) }}</span>
                    </h3>
                    <a href="{{ route('polizas.index') }}" class="text-xs text-blue-600 hover:underline mt-2 inline-block font-medium">Ver todas</a>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                    <span class="material-icons-round">verified_user</span>
                </div>
            </div>
        </div>

        {{-- Próximos Cobros --}}
        <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Próximos Cobros</p>
                    <h3 class="text-3xl font-bold mt-2 {{ $this->stats['proximas_cobrar'] > 0 ? 'text-amber-600' : 'text-slate-900' }}">
                        {{ number_format($this->stats['proximas_cobrar']) }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-2">En los siguientes 7 días</p>
                </div>
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500">
                    <span class="material-icons-round">account_balance_wallet</span>
                </div>
            </div>
        </div>

        {{-- Por Vencer --}}
        <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Por Vencer</p>
                    <h3 class="text-3xl font-bold mt-2 {{ $this->stats['proximas_vencer'] > 0 ? 'text-red-500' : 'text-slate-900' }}">
                        {{ number_format($this->stats['proximas_vencer']) }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-2">Próximos 30 días</p>
                </div>
                <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center text-red-500">
                    <span class="material-icons-round">running_with_errors</span>
                </div>
            </div>
        </div>

        {{-- Primas del Mes --}}
        <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Primas del Mes</p>
                    <h3 class="text-3xl font-bold mt-2 text-slate-900">${{ number_format($this->stats['prima_total_mes'], 0) }}</h3>
                    <p class="text-xs text-slate-400 mt-2">{{ now()->locale('es')->isoFormat('MMMM YYYY') }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500">
                    <span class="material-icons-round">payments</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        {{-- Seguimiento Operativo (2 columnas) --}}
        <div id="seccion-alertas" class="xl:col-span-2 bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            {{-- Header con tabs --}}
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <span class="material-icons-round text-blue-600">view_list</span>
                        Seguimiento Operativo
                    </h2>
                    <p class="text-sm text-slate-500">Gestión de cartera prioritaria</p>
                </div>
                <div class="inline-flex p-1 bg-slate-100 rounded-lg border border-slate-200">
                    <button @click="activeTab = 'cobranzas'"
                            :class="activeTab === 'cobranzas' ? 'bg-white text-slate-900 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-700'"
                            class="px-4 py-1.5 text-xs font-bold rounded-md transition-all flex items-center gap-2">
                        Cobranzas
                        <span class="text-[10px] text-slate-400 font-normal">(7d)</span>
                        @if($this->stats['proximas_cobrar'] > 0)
                            <span class="w-5 h-5 flex items-center justify-center text-[10px] font-bold bg-amber-100 text-amber-700 rounded-full">{{ $this->stats['proximas_cobrar'] }}</span>
                        @endif
                    </button>
                    <button @click="activeTab = 'vencer'"
                            :class="activeTab === 'vencer' ? 'bg-white text-slate-900 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-700'"
                            class="px-4 py-1.5 text-xs font-bold rounded-md transition-all flex items-center gap-2">
                        Por Vencer
                        <span class="text-[10px] text-slate-400 font-normal">(30d)</span>
                        @if($this->stats['proximas_vencer'] > 0)
                            <span class="w-5 h-5 flex items-center justify-center text-[10px] font-bold bg-red-100 text-red-700 rounded-full">{{ $this->stats['proximas_vencer'] }}</span>
                        @endif
                    </button>
                </div>
            </div>

            {{-- Tab Cobranzas --}}
            <div x-show="activeTab === 'cobranzas'" class="flex-1 flex flex-col">
                @if($this->stats['proximas_cobrar'] > 0)
                    <div class="overflow-x-auto flex-1">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 text-[11px] uppercase tracking-wider font-bold text-slate-500 border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-4">Prioridad</th>
                                    <th class="px-6 py-4">Cliente</th>
                                    <th class="px-6 py-4 hidden md:table-cell">Contacto</th>
                                    <th class="px-6 py-4 hidden lg:table-cell">Compañía</th>
                                    <th class="px-6 py-4">Fecha</th>
                                    <th class="px-6 py-4">Monto</th>
                                    <th class="px-6 py-4 text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm">
                                @foreach($this->polizasProximasCobrar as $poliza)
                                    @php
                                        $dias = $poliza->dias_para_cobrar_real;
                                        if ($dias <= 0) {
                                            $badgeClass = 'bg-red-100 text-red-600';
                                            $badgeText = '¡HOY!';
                                        } elseif ($dias == 1) {
                                            $badgeClass = 'bg-red-100 text-red-600';
                                            $badgeText = '¡MAÑANA!';
                                        } elseif ($dias <= 3) {
                                            $badgeClass = 'bg-amber-100 text-amber-600';
                                            $badgeText = $dias . ' DÍAS';
                                        } else {
                                            $badgeClass = 'bg-slate-100 text-slate-600';
                                            $badgeText = $dias . ' DÍAS';
                                        }
                                    @endphp
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <span class="px-2.5 py-1 rounded text-[10px] font-bold {{ $badgeClass }}">{{ $badgeText }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="font-semibold text-slate-900">{{ Str::limit($poliza->nombre_completo_asegurado, 25) }}</p>
                                            <p class="text-xs text-slate-400">{{ $poliza->NumPoliza }}</p>
                                        </td>
                                        <td class="px-6 py-4 hidden md:table-cell">
                                            @if($poliza->asegurado?->Telefono)
                                                <a href="tel:{{ $poliza->asegurado->Telefono }}" class="text-blue-600 hover:underline text-sm flex items-center gap-1">
                                                    <span class="material-icons-round text-xs">phone</span>
                                                    {{ $poliza->asegurado->Telefono }}
                                                </a>
                                            @elseif($poliza->asegurado?->Email)
                                                <a href="mailto:{{ $poliza->asegurado->Email }}" class="text-blue-600 hover:underline text-sm flex items-center gap-1">
                                                    <span class="material-icons-round text-xs">email</span>
                                                    {{ Str::limit($poliza->asegurado->Email, 20) }}
                                                </a>
                                            @else
                                                <span class="text-slate-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 hidden lg:table-cell">
                                            <span class="font-medium text-slate-600">{{ Str::limit($poliza->compania->Nombre ?? 'N/A', 15) }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-slate-600">{{ \Carbon\Carbon::parse($poliza->proxima_fecha_cobranza)->format('d/m/Y') }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($poliza->proximo_monto_cobro > 0)
                                                <span class="font-bold text-slate-900">${{ number_format($poliza->proximo_monto_cobro, 2) }}</span>
                                            @else
                                                <a href="{{ route('polizas.edit', $poliza->IdPoliza) }}" class="text-xs text-orange-500 hover:underline font-medium">Configurar</a>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('polizas.show', $poliza->IdPoliza) }}" class="p-2 hover:bg-slate-100 rounded-lg transition-colors inline-flex">
                                                <span class="material-icons-round text-slate-400 hover:text-blue-600">visibility</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginador Cobranzas --}}
                    @if($this->polizasProximasCobrar->hasPages())
                        <div class="p-4 bg-slate-50/50 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
                            <p class="text-xs text-slate-500 font-medium">
                                Mostrando {{ $this->polizasProximasCobrar->firstItem() }}-{{ $this->polizasProximasCobrar->lastItem() }} de {{ $this->polizasProximasCobrar->total() }} registros
                            </p>

                            <div class="flex items-center gap-1">
                                {{-- Ir al inicio --}}
                                @if($this->polizasProximasCobrar->currentPage() > 1)
                                    <button wire:click="gotoPage(1, 'cobrarPage')"
                                            class="p-1.5 border border-slate-200 rounded-lg hover:bg-white text-slate-500 transition-colors"
                                            title="Primera página">
                                        <span class="material-icons-round text-lg">first_page</span>
                                    </button>
                                @else
                                    <span class="p-1.5 border border-slate-100 rounded-lg text-slate-300 cursor-not-allowed">
                                        <span class="material-icons-round text-lg">first_page</span>
                                    </span>
                                @endif

                                {{-- Anterior --}}
                                @if(!$this->polizasProximasCobrar->onFirstPage())
                                    <button wire:click="previousPage('cobrarPage')"
                                            class="p-1.5 border border-slate-200 rounded-lg hover:bg-white text-slate-500 transition-colors"
                                            title="Anterior">
                                        <span class="material-icons-round text-lg">chevron_left</span>
                                    </button>
                                @else
                                    <span class="p-1.5 border border-slate-100 rounded-lg text-slate-300 cursor-not-allowed">
                                        <span class="material-icons-round text-lg">chevron_left</span>
                                    </span>
                                @endif

                                {{-- Números de página --}}
                                @php
                                    $currentPageCobrar = $this->polizasProximasCobrar->currentPage();
                                    $lastPageCobrar = $this->polizasProximasCobrar->lastPage();
                                    $startCobrar = max(1, $currentPageCobrar - 2);
                                    $endCobrar = min($lastPageCobrar, $currentPageCobrar + 2);

                                    if ($endCobrar - $startCobrar < 4) {
                                        if ($startCobrar == 1) {
                                            $endCobrar = min($lastPageCobrar, $startCobrar + 4);
                                        } else {
                                            $startCobrar = max(1, $endCobrar - 4);
                                        }
                                    }
                                @endphp

                                @if($startCobrar > 1)
                                    <button wire:click="gotoPage(1, 'cobrarPage')"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-semibold text-slate-600 hover:bg-white border border-slate-200 transition-colors">
                                        1
                                    </button>
                                    @if($startCobrar > 2)
                                        <span class="px-1 text-slate-400 text-xs">...</span>
                                    @endif
                                @endif

                                @for($i = $startCobrar; $i <= $endCobrar; $i++)
                                    @if($i == $currentPageCobrar)
                                        <span class="w-8 h-8 flex items-center justify-center bg-amber-600 text-white rounded-lg text-xs font-bold">
                                            {{ $i }}
                                        </span>
                                    @else
                                        <button wire:click="gotoPage({{ $i }}, 'cobrarPage')"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-semibold text-slate-600 hover:bg-white border border-slate-200 transition-colors">
                                            {{ $i }}
                                        </button>
                                    @endif
                                @endfor

                                @if($endCobrar < $lastPageCobrar)
                                    @if($endCobrar < $lastPageCobrar - 1)
                                        <span class="px-1 text-slate-400 text-xs">...</span>
                                    @endif
                                    <button wire:click="gotoPage({{ $lastPageCobrar }}, 'cobrarPage')"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-semibold text-slate-600 hover:bg-white border border-slate-200 transition-colors">
                                        {{ $lastPageCobrar }}
                                    </button>
                                @endif

                                {{-- Siguiente --}}
                                @if($this->polizasProximasCobrar->hasMorePages())
                                    <button wire:click="nextPage('cobrarPage')"
                                            class="p-1.5 border border-slate-200 rounded-lg hover:bg-white text-slate-500 transition-colors"
                                            title="Siguiente">
                                        <span class="material-icons-round text-lg">chevron_right</span>
                                    </button>
                                @else
                                    <span class="p-1.5 border border-slate-100 rounded-lg text-slate-300 cursor-not-allowed">
                                        <span class="material-icons-round text-lg">chevron_right</span>
                                    </span>
                                @endif

                                {{-- Ir al final --}}
                                @if($currentPageCobrar < $lastPageCobrar)
                                    <button wire:click="gotoPage({{ $lastPageCobrar }}, 'cobrarPage')"
                                            class="p-1.5 border border-slate-200 rounded-lg hover:bg-white text-slate-500 transition-colors"
                                            title="Última página">
                                        <span class="material-icons-round text-lg">last_page</span>
                                    </button>
                                @else
                                    <span class="p-1.5 border border-slate-100 rounded-lg text-slate-300 cursor-not-allowed">
                                        <span class="material-icons-round text-lg">last_page</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                @else
                    <div class="flex-1 flex items-center justify-center p-12">
                        <div class="text-center">
                            <span class="material-icons-round text-5xl text-emerald-400 mb-3">check_circle</span>
                            <p class="text-slate-500 font-medium">No hay cobranzas próximas</p>
                            <p class="text-xs text-slate-400 mt-1">Todo al día en los próximos 7 días</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Tab Por Vencer --}}
            <div x-show="activeTab === 'vencer'" class="flex-1 flex flex-col">
                @if($this->stats['proximas_vencer'] > 0)
                    <div class="overflow-x-auto flex-1">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 text-[11px] uppercase tracking-wider font-bold text-slate-500 border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-4">Prioridad</th>
                                    <th class="px-6 py-4">Cliente</th>
                                    <th class="px-6 py-4 hidden md:table-cell">Contacto</th>
                                    <th class="px-6 py-4 hidden lg:table-cell">Vehículo</th>
                                    <th class="px-6 py-4">Vence</th>
                                    <th class="px-6 py-4">Prima</th>
                                    <th class="px-6 py-4 text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm">
                                @foreach($this->polizasProximasVencer as $poliza)
                                    @php
                                        $dias = (int)$poliza->dias_para_vencer;
                                        if ($dias <= 0) {
                                            $badgeClass = 'bg-red-100 text-red-600';
                                            $badgeText = '¡HOY!';
                                        } elseif ($dias <= 7) {
                                            $badgeClass = 'bg-red-100 text-red-600';
                                            $badgeText = $dias . ' DÍAS';
                                        } elseif ($dias <= 15) {
                                            $badgeClass = 'bg-amber-100 text-amber-600';
                                            $badgeText = $dias . ' DÍAS';
                                        } else {
                                            $badgeClass = 'bg-slate-100 text-slate-600';
                                            $badgeText = $dias . ' DÍAS';
                                        }
                                    @endphp
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <span class="px-2.5 py-1 rounded text-[10px] font-bold {{ $badgeClass }}">{{ $badgeText }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="font-semibold text-slate-900">{{ Str::limit($poliza->nombre_completo_asegurado, 25) }}</p>
                                            <p class="text-xs text-slate-400">{{ $poliza->NumPoliza }}</p>
                                        </td>
                                        <td class="px-6 py-4 hidden md:table-cell">
                                            @if($poliza->asegurado?->Telefono)
                                                <a href="tel:{{ $poliza->asegurado->Telefono }}" class="text-blue-600 hover:underline text-sm flex items-center gap-1">
                                                    <span class="material-icons-round text-xs">phone</span>
                                                    {{ $poliza->asegurado->Telefono }}
                                                </a>
                                            @elseif($poliza->asegurado?->Email)
                                                <a href="mailto:{{ $poliza->asegurado->Email }}" class="text-blue-600 hover:underline text-sm flex items-center gap-1">
                                                    <span class="material-icons-round text-xs">email</span>
                                                    {{ Str::limit($poliza->asegurado->Email, 20) }}
                                                </a>
                                            @else
                                                <span class="text-slate-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 hidden lg:table-cell">
                                            <span class="text-slate-600">{{ Str::limit($poliza->unidad->descripcion_completa ?? 'N/A', 20) }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-slate-600">{{ $poliza->FechaVencimiento->format('d/m/Y') }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($poliza->Prima > 0)
                                                <span class="font-bold text-slate-900">${{ number_format($poliza->Prima, 0) }}</span>
                                            @else
                                                <span class="text-slate-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('polizas.show', $poliza->IdPoliza) }}" class="p-2 hover:bg-slate-100 rounded-lg transition-colors inline-flex">
                                                <span class="material-icons-round text-slate-400 hover:text-blue-600">visibility</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginador Rediseñado --}}
                    @if($this->polizasProximasVencer->hasPages())
                        <div class="p-4 bg-slate-50/50 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
                            <p class="text-xs text-slate-500 font-medium">
                                Mostrando {{ $this->polizasProximasVencer->firstItem() }}-{{ $this->polizasProximasVencer->lastItem() }} de {{ $this->polizasProximasVencer->total() }} registros
                            </p>

                            <div class="flex items-center gap-1">
                                {{-- Ir al inicio --}}
                                @if($this->polizasProximasVencer->currentPage() > 1)
                                    <button wire:click="gotoPage(1, 'vencerPage')"
                                            class="p-1.5 border border-slate-200 rounded-lg hover:bg-white text-slate-500 transition-colors"
                                            title="Primera página">
                                        <span class="material-icons-round text-lg">first_page</span>
                                    </button>
                                @else
                                    <span class="p-1.5 border border-slate-100 rounded-lg text-slate-300 cursor-not-allowed">
                                        <span class="material-icons-round text-lg">first_page</span>
                                    </span>
                                @endif

                                {{-- Anterior --}}
                                @if(!$this->polizasProximasVencer->onFirstPage())
                                    <button wire:click="previousPage('vencerPage')"
                                            class="p-1.5 border border-slate-200 rounded-lg hover:bg-white text-slate-500 transition-colors"
                                            title="Anterior">
                                        <span class="material-icons-round text-lg">chevron_left</span>
                                    </button>
                                @else
                                    <span class="p-1.5 border border-slate-100 rounded-lg text-slate-300 cursor-not-allowed">
                                        <span class="material-icons-round text-lg">chevron_left</span>
                                    </span>
                                @endif

                                {{-- Números de página --}}
                                @php
                                    $currentPage = $this->polizasProximasVencer->currentPage();
                                    $lastPage = $this->polizasProximasVencer->lastPage();
                                    $start = max(1, $currentPage - 2);
                                    $end = min($lastPage, $currentPage + 2);

                                    // Ajustar para mostrar siempre 5 páginas si es posible
                                    if ($end - $start < 4) {
                                        if ($start == 1) {
                                            $end = min($lastPage, $start + 4);
                                        } else {
                                            $start = max(1, $end - 4);
                                        }
                                    }
                                @endphp

                                @if($start > 1)
                                    <button wire:click="gotoPage(1, 'vencerPage')"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-semibold text-slate-600 hover:bg-white border border-slate-200 transition-colors">
                                        1
                                    </button>
                                    @if($start > 2)
                                        <span class="px-1 text-slate-400 text-xs">...</span>
                                    @endif
                                @endif

                                @for($i = $start; $i <= $end; $i++)
                                    @if($i == $currentPage)
                                        <span class="w-8 h-8 flex items-center justify-center bg-blue-600 text-white rounded-lg text-xs font-bold">
                                            {{ $i }}
                                        </span>
                                    @else
                                        <button wire:click="gotoPage({{ $i }}, 'vencerPage')"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-semibold text-slate-600 hover:bg-white border border-slate-200 transition-colors">
                                            {{ $i }}
                                        </button>
                                    @endif
                                @endfor

                                @if($end < $lastPage)
                                    @if($end < $lastPage - 1)
                                        <span class="px-1 text-slate-400 text-xs">...</span>
                                    @endif
                                    <button wire:click="gotoPage({{ $lastPage }}, 'vencerPage')"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-semibold text-slate-600 hover:bg-white border border-slate-200 transition-colors">
                                        {{ $lastPage }}
                                    </button>
                                @endif

                                {{-- Siguiente --}}
                                @if($this->polizasProximasVencer->hasMorePages())
                                    <button wire:click="nextPage('vencerPage')"
                                            class="p-1.5 border border-slate-200 rounded-lg hover:bg-white text-slate-500 transition-colors"
                                            title="Siguiente">
                                        <span class="material-icons-round text-lg">chevron_right</span>
                                    </button>
                                @else
                                    <span class="p-1.5 border border-slate-100 rounded-lg text-slate-300 cursor-not-allowed">
                                        <span class="material-icons-round text-lg">chevron_right</span>
                                    </span>
                                @endif

                                {{-- Ir al final --}}
                                @if($currentPage < $lastPage)
                                    <button wire:click="gotoPage({{ $lastPage }}, 'vencerPage')"
                                            class="p-1.5 border border-slate-200 rounded-lg hover:bg-white text-slate-500 transition-colors"
                                            title="Última página">
                                        <span class="material-icons-round text-lg">last_page</span>
                                    </button>
                                @else
                                    <span class="p-1.5 border border-slate-100 rounded-lg text-slate-300 cursor-not-allowed">
                                        <span class="material-icons-round text-lg">last_page</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                @else
                    <div class="flex-1 flex items-center justify-center p-12">
                        <div class="text-center">
                            <span class="material-icons-round text-5xl text-emerald-400 mb-3">check_circle</span>
                            <p class="text-slate-500 font-medium">No hay pólizas por vencer</p>
                            <p class="text-xs text-slate-400 mt-1">Todo al día en los próximos 30 días</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Panel Derecho --}}
        <div class="flex flex-col gap-6">
            {{-- Top Aseguradoras --}}
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-6">
                <h3 class="text-lg font-bold mb-6 flex items-center gap-2 text-slate-900">
                    <span class="material-icons-round text-blue-500">donut_small</span>
                    Top Aseguradoras
                </h3>
                <div class="space-y-5">
                    @forelse($this->polizasPorCompania as $compania)
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between text-sm font-medium">
                                <div>
                                    <span class="text-slate-700">{{ $compania->Nombre }}</span>
                                    <span class="text-xs text-slate-400 ml-1">{{ $compania->Cobertura }}</span>
                                </div>
                                <span class="text-slate-500">{{ $compania->polizas_activas_count }} pólizas</span>
                            </div>
                            @php
                                $maxPolizas = $this->polizasPorCompania->max('polizas_activas_count');
                                $percentage = $maxPolizas > 0 ? ($compania->polizas_activas_count / $maxPolizas) * 100 : 0;
                            @endphp
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-blue-600 h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400 text-center py-4">Sin datos disponibles</p>
                    @endforelse
                </div>
            </div>

            {{-- Gráfico Pólizas por Mes --}}
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-6">
                <h3 class="text-lg font-bold mb-6 flex items-center gap-2 text-slate-900">
                    <span class="material-icons-round text-emerald-500">trending_up</span>
                    Pólizas Emitidas ({{ now()->year }})
                </h3>
                <div style="height: 180px;">
                    <canvas id="polizasChart"></canvas>
                </div>
            </div>

            {{-- Resumen rápido --}}
            <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl shadow-sm p-6 text-white">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <span class="material-icons-round">insights</span>
                    Resumen
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-blue-100">Total Clientes</span>
                        <span class="font-bold">{{ number_format($this->stats['total_asegurados']) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-blue-100">Compañías</span>
                        <span class="font-bold">{{ number_format($this->stats['total_companias']) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-blue-100">Unidades</span>
                        <span class="font-bold">{{ number_format($this->stats['total_unidades']) }}</span>
                    </div>
                </div>
                <a href="{{ route('asegurados.index') }}" class="mt-4 block text-center text-sm font-medium bg-white/20 hover:bg-white/30 rounded-lg py-2 transition-colors">
                    Ver Clientes
                </a>
            </div>
        </div>
    </div>

    {{-- FAB Móvil --}}
    <a href="{{ route('polizas.create') }}" class="fixed bottom-6 right-6 sm:hidden w-14 h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg flex items-center justify-center z-40 transition-transform hover:scale-110">
        <span class="material-icons-round">add</span>
    </a>

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
                        backgroundColor: 'rgba(37, 99, 235, 0.8)',
                        borderRadius: 6,
                        barThickness: 20,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                color: '#94a3b8',
                                font: { size: 10 }
                            },
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: '#94a3b8',
                                font: { size: 10, weight: 'bold' }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
