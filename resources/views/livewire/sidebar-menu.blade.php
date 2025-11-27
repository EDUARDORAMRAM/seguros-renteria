<button data-drawer-target="top-bar-sidebar" data-drawer-toggle="top-bar-sidebar" aria-controls="top-bar-sidebar" type="button" 
    class="text-heading bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-base ms-3 mt-3 text-sm p-2 focus:outline-none inline-flex sm:hidden">
   <span class="sr-only">Open sidebar</span>
   <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10"/>
   </svg>
</button>

<aside id="top-bar-sidebar" class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
   <div class="h-full px-3 py-4 overflow-y-auto bg-neutral-primary-soft border-e border-default pt-20">

      <a href="{{ route('dashboard') }}" class="flex items-center ps-2.5 mb-5">
         <span class="self-center text-lg text-heading font-semibold whitespace-nowrap">Sistema Seguros</span>
      </a>

      <ul class="space-y-2 font-medium">

         {{-- Dashboard --}}
         <li>
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group 
                  {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">
               
               <svg class="w-5 h-5 transition duration-75 
                  {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'group-hover:text-fg-brand' }}" 
                  fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                     d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
               </svg>

               <span class="ms-3">Dashboard</span>
            </a>
         </li>

         {{-- Pólizas --}}
         <li>
            <a href="{{ route('polizas.index') }}" 
               class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group
                  {{ request()->routeIs('polizas.*') ? 'bg-blue-50 text-blue-600' : '' }}">
               
               <svg class="w-5 h-5 transition duration-75 
                  {{ request()->routeIs('polizas.*') ? 'text-blue-600' : 'group-hover:text-fg-brand' }}" 
                  fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                     d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
               </svg>

               <span class="ms-3">Pólizas</span>
            </a>
         </li>

         {{-- Asegurados --}}
         <li>
            <a href="{{ route('asegurados.index') }}" 
               class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group
                  {{ request()->routeIs('asegurados.*') ? 'bg-blue-50 text-blue-600' : '' }}">
               
               <svg class="w-5 h-5 transition duration-75 
                  {{ request()->routeIs('asegurados.*') ? 'text-blue-600' : 'group-hover:text-fg-brand' }}" 
                  fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-width="2"
                     d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
               </svg>

               <span class="ms-3">Asegurados</span>
            </a>
         </li>

         {{-- Compañías --}}
         <li>
            <a href="{{ route('companias.index') }}" 
               class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group
                  {{ request()->routeIs('companias.*') ? 'bg-blue-50 text-blue-600' : '' }}">
               
               <svg class="w-5 h-5 transition duration-75 
                  {{ request()->routeIs('companias.*') ? 'text-blue-600' : 'group-hover:text-fg-brand' }}" 
                  fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
               </svg>

               <span class="ms-3">Compañías</span>
            </a>
         </li>

         {{-- Unidades --}}
         <li>
            <a href="{{ route('unidades.index') }}" 
               class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group
                  {{ request()->routeIs('unidades.*') ? 'bg-blue-50 text-blue-600' : '' }}">
               
               <svg class="w-5 h-5 transition duration-75 
                  {{ request()->routeIs('unidades.*') ? 'text-blue-600' : 'group-hover:text-fg-brand' }}" 
                  fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-4-1a1 1 0 001 1h4M8 17a5 5 0 10-8 0h8z"/>
               </svg>

               <span class="ms-3">Unidades</span>
            </a>
         </li>

         {{-- Reportes --}}
         <li class="pt-4 mt-4 space-y-2 border-t border-default">
            <span class="px-2 text-xs font-semibold text-gray-400 uppercase">Reportes</span>
         </li>

         {{-- Ventas --}}
         <li>
            <a href="{{ route('reportes.ventas') }}" 
               class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group
                  {{ request()->routeIs('reportes.*') ? 'bg-blue-50 text-blue-600' : '' }}">
               
               <svg class="w-5 h-5 transition duration-75 
                  {{ request()->routeIs('reportes.*') ? 'text-blue-600' : 'group-hover:text-fg-brand' }}" 
                  fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                     d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
               </svg>

               <span class="ms-3">Ventas</span>
            </a>
         </li>

         {{-- Herramientas --}}
         <li class="pt-4 mt-4 space-y-2 border-t border-default">
            <span class="px-2 text-xs font-semibold text-gray-400 uppercase">Herramientas</span>
         </li>

         {{-- Importar Excel --}}
         <li>
            <a href="{{ route('importar.excel') }}" 
               class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group
                  {{ request()->routeIs('importar.*') ? 'bg-blue-50 text-blue-600' : '' }}">
               
               <svg class="w-5 h-5 transition duration-75 
                  {{ request()->routeIs('importar.*') ? 'text-blue-600' : 'group-hover:text-fg-brand' }}" 
                  fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                     d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
               </svg>

               <span class="ms-3">Importar Excel</span>
            </a>
         </li>
      </ul>
   </div>
</aside>
