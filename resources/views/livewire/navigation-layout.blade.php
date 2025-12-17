<div>
    {{-- Botón para abrir sidebar (mobile) --}}
    <button data-drawer-target="drawer-navigation" 
            data-drawer-show="drawer-navigation" 
            aria-controls="drawer-navigation"
            class="fixed top-4 left-4 z-50 sm:hidden inline-flex items-center p-2 text-sm text-gray-500 rounded-lg bg-white border border-gray-200 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
        <span class="sr-only">Abrir menú</span>
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10"/>
        </svg>
    </button>

    {{-- Sidebar Drawer --}}
    <aside id="drawer-navigation" class="fixed top-0 left-0 z-40 w-64 h-full min-h-screen overflow-y-auto transition-transform -translate-x-full sm:translate-x-0 bg-white border-r border-gray-200" tabindex="-1" aria-labelledby="drawer-navigation-label">
        
        {{-- Header del Sidebar con Logo --}}
        <div class="border-b border-gray-200 p-4 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                 <img src="{{ asset('images/logoColor.png') }}" 
             alt="Logo Sistema de Seguros" 
             class="h-15 w-auto"> <!-- h-8 w-auto mantiene la proporción -->
                
            </a>
            <button type="button" 
                    data-drawer-hide="drawer-navigation" 
                    aria-controls="drawer-navigation" 
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg w-8 h-8 sm:hidden inline-flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="sr-only">Cerrar menú</span>
            </button>
        </div>

        {{-- Perfil de Usuario --}}
        <div class="p-4 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">
                        {{ Auth::user()->name }}
                    </p>
                    <p class="text-xs text-gray-500 truncate">
                        {{ Auth::user()->email }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Navegación --}}
        <div class="py-4 overflow-y-auto">
            <ul class="space-y-2 font-medium px-3">
                
                {{-- Dashboard --}}
                <li>
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center px-2 py-2 rounded-lg group {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                
                {{-- Pólizas --}}
                <li>
                    <a href="{{ route('polizas.index') }}" 
                       class="flex items-center px-2 py-2 rounded-lg group {{ request()->routeIs('polizas.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }}">
                        <svg class="shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('polizas.*') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Pólizas</span>
                    </a>
                </li>
                
                {{-- Asegurados --}}
                <li>
                    <a href="{{ route('asegurados.index') }}" 
                       class="flex items-center px-2 py-2 rounded-lg group {{ request()->routeIs('asegurados.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }}">
                        <svg class="shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('asegurados.*') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-width="2" d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Asegurados</span>
                    </a>
                </li>
                
                {{-- Compañías --}}
                <li>
                    <a href="{{ route('companias.index') }}" 
                       class="flex items-center px-2 py-2 rounded-lg group {{ request()->routeIs('companias.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }}">
                        <svg class="shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('companias.*') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Compañías</span>
                    </a>
                </li>
                
                {{-- Unidades --}}
                <li>
                    <a href="{{ route('unidades.index') }}" 
                       class="flex items-center px-2 py-2 rounded-lg group {{ request()->routeIs('unidades.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }}">
                        <svg class="shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('unidades.*') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-4-1a1 1 0 001 1h4M8 17a5 5 0 10-8 0h8z"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Unidades</span>
                    </a>
                </li>

                {{-- Divider Reportes --}}
                <li class="pt-4 mt-4 space-y-2 border-t border-gray-200">
                    <span class="px-2 text-xs font-semibold text-gray-400 uppercase">Reportes</span>
                </li>

                {{-- Ventas --}}
                <li>
    <a href="#" 
       class="flex items-center px-2 py-2 rounded-lg group opacity-60 cursor-not-allowed"
       onclick="return false;">
        <svg class="shrink-0 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
        </svg>
        <span class="flex-1 ms-3 whitespace-nowrap text-gray-900">Pólizas</span>
        <span class="inline-flex items-center px-2 py-0.5 ms-3 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
            Próximamente
        </span>
    </a>
</li>

                {{-- Divider Herramientas --}}
                <li class="pt-4 mt-4 space-y-2 border-t border-gray-200">
                    <span class="px-2 text-xs font-semibold text-gray-400 uppercase">Herramientas</span>
                </li>

                {{-- Importar Excel --}}
                <li>
                    <a href="{{ route('importar.excel') }}" 
                       class="flex items-center px-2 py-2 rounded-lg group {{ request()->routeIs('importar.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }}">
                        <svg class="shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('importar.*') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Importar Excel</span>
                    </a>
                </li>

                {{-- Divider Cuenta --}}
                <li class="pt-4 mt-4 space-y-2 border-t border-gray-200">
                    <span class="px-2 text-xs font-semibold text-gray-400 uppercase">Cuenta</span>
                </li>

                {{-- Mi Perfil --}}
                <li>
                    <a href="{{ route('profile.show') }}" 
                       class="flex items-center px-2 py-2 rounded-lg group {{ request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }}">
                        <svg class="shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('profile.*') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Mi Perfil</span>
                    </a>
                </li>

                {{-- Configuración --}}
                <li>
                    <a href="{{ route('configuracion') }}" 
                       class="flex items-center px-2 py-2 rounded-lg group {{ request()->routeIs('configuracion') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }}">
                        <svg class="shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('configuracion') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Configuración</span>
                    </a>
                </li>

                {{-- Cerrar Sesión --}}
                <li>
                    <button wire:click="logout" 
                            class="flex items-center w-full px-2 py-2 rounded-lg text-red-600 hover:bg-red-50 group">
                        <svg class="shrink-0 w-5 h-5 transition duration-75 text-red-500 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Cerrar Sesión</span>
                    </button>
                </li>
            </ul>
        </div>
    </aside>
</div>