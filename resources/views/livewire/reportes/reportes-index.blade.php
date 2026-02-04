<div>
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Reportes</h1>
        <p class="text-gray-500 mt-1">Genera reportes personalizados de tu cartera</p>
    </div>

    {{-- Grid de Reportes --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Reporte por Asegurado --}}
        <a href="{{ route('reportes.asegurado') }}"
           class="bg-white rounded-xl border border-gray-100 p-6 hover:shadow-lg hover:border-blue-200 transition-all group">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 mb-4 group-hover:bg-blue-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Reporte por Asegurado</h3>
            <p class="text-sm text-gray-500">Genera un reporte detallado de las pólizas de un cliente específico, incluyendo historial de pagos.</p>
            <div class="mt-4 flex items-center text-blue-600 text-sm font-medium">
                Generar reporte
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </a>

        {{-- Reporte de Cobranzas (Próximamente) --}}
        <div class="bg-white rounded-xl border border-gray-100 p-6 opacity-60">
            <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500 mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Reporte de Cobranzas</h3>
            <p class="text-sm text-gray-500">Resumen de cobranzas pendientes y realizadas por período.</p>
            <div class="mt-4">
                <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded">Próximamente</span>
            </div>
        </div>

        {{-- Reporte de Vencimientos (Próximamente) --}}
        <div class="bg-white rounded-xl border border-gray-100 p-6 opacity-60">
            <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center text-red-500 mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Reporte de Vencimientos</h3>
            <p class="text-sm text-gray-500">Listado de pólizas próximas a vencer por rango de fechas.</p>
            <div class="mt-4">
                <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded">Próximamente</span>
            </div>
        </div>

        {{-- Reporte por Compañía (Próximamente) --}}
        <div class="bg-white rounded-xl border border-gray-100 p-6 opacity-60">
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-500 mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Reporte por Compañía</h3>
            <p class="text-sm text-gray-500">Análisis de pólizas agrupadas por aseguradora.</p>
            <div class="mt-4">
                <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded">Próximamente</span>
            </div>
        </div>

    </div>
</div>
