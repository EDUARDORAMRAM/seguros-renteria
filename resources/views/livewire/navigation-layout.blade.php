<div>
    {{-- Botón para abrir sidebar (mobile) --}}
    <button data-drawer-target="drawer-navigation"
            data-drawer-show="drawer-navigation"
            aria-controls="drawer-navigation"
            class="fixed top-4 left-4 z-50 sm:hidden inline-flex items-center p-2 text-gray-500 rounded-lg bg-white border border-gray-200 hover:bg-gray-100 shadow-sm">
        <span class="sr-only">Abrir menú</span>
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h12"/>
        </svg>
    </button>

    {{-- Sidebar --}}
    <aside id="drawer-navigation" class="fixed top-0 left-0 z-40 w-64 h-full overflow-y-auto transition-transform -translate-x-full sm:translate-x-0 bg-white border-r border-gray-100" tabindex="-1">

        {{-- Logo --}}
        <div class="p-5 border-b border-gray-100">
            <a href="{{ route('dashboard') }}" class="block">
                <img src="{{ asset('images/logoColor.png') }}" alt="Logo" class="h-10 w-auto">
            </a>
            <button type="button"
                    data-drawer-hide="drawer-navigation"
                    aria-controls="drawer-navigation"
                    class="absolute top-4 right-4 p-1 text-gray-400 hover:text-gray-600 rounded sm:hidden">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Usuario --}}
        <div class="px-5 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-medium">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>

        {{-- Navegación --}}
        <nav class="p-4">
            <ul class="space-y-1">
                {{-- Dashboard --}}
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>
                </li>

                {{-- Pólizas --}}
                <li>
                    <a href="{{ route('polizas.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('polizas.*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Pólizas
                    </a>
                </li>

                {{-- Asegurados --}}
                <li>
                    <a href="{{ route('asegurados.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('asegurados.*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Asegurados
                    </a>
                </li>

                {{-- Compañías --}}
                <li>
                    <a href="{{ route('companias.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('companias.*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Compañías
                    </a>
                </li>

                {{-- Unidades --}}
                <li>
                    <a href="{{ route('unidades.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('unidades.*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 17h8M8 17v-4m8 4v-4m-8 0h8m-8 0V9a1 1 0 011-1h6a1 1 0 011 1v4M5 17h14a2 2 0 002-2v-3a2 2 0 00-2-2h-1V7a2 2 0 00-2-2H8a2 2 0 00-2 2v3H5a2 2 0 00-2 2v3a2 2 0 002 2z"/>
                        </svg>
                        Unidades
                    </a>
                </li>
            </ul>

            {{-- Herramientas --}}
            <div class="mt-8">
                <p class="px-3 mb-2 text-xs font-medium text-gray-400 uppercase tracking-wider">Herramientas</p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('importar.excel') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('importar.*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Importar Excel
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reportes.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('reportes.*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Reportes
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Cuenta --}}
            <div class="mt-8">
                <p class="px-3 mb-2 text-xs font-medium text-gray-400 uppercase tracking-wider">Cuenta</p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('profile.show') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Mi Perfil
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('configuracion') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('configuracion') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Configuración
                        </a>
                    </li>
                    <li>
                        <button wire:click="logout"
                                class="flex items-center gap-3 w-full px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Cerrar Sesión
                        </button>
                    </li>
                </ul>
            </div>
        </nav>
    </aside>
</div>
