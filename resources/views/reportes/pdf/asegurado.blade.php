<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte - {{ $asegurado->nombre_completo }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.4;
        }
        .page {
            padding: 20px 30px;
        }
        /* Header */
        .header {
            display: table;
            width: 100%;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header-left {
            display: table-cell;
            vertical-align: middle;
            width: 70%;
        }
        .header-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            width: 30%;
        }
        .logo {
            max-height: 50px;
            max-width: 150px;
        }
        .report-title {
            font-size: 18px;
            font-weight: bold;
            color: #1e3a5f;
            margin-bottom: 3px;
        }
        .report-subtitle {
            font-size: 11px;
            color: #666;
        }
        .fecha-reporte {
            font-size: 9px;
            color: #888;
            margin-top: 5px;
        }
        /* Info Asegurado */
        .asegurado-info {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px 15px;
            margin-bottom: 20px;
        }
        .asegurado-nombre {
            font-size: 14px;
            font-weight: bold;
            color: #1e3a5f;
            margin-bottom: 5px;
        }
        .asegurado-detalle {
            font-size: 10px;
            color: #64748b;
        }
        /* Resumen */
        .resumen {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .resumen-item {
            display: table-cell;
            text-align: center;
            padding: 10px;
            background: #f1f5f9;
            border-right: 1px solid #e2e8f0;
        }
        .resumen-item:last-child {
            border-right: none;
        }
        .resumen-valor {
            font-size: 16px;
            font-weight: bold;
            color: #1e3a5f;
        }
        .resumen-label {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            margin-top: 3px;
        }
        .resumen-valor.verde { color: #16a34a; }
        .resumen-valor.amarillo { color: #d97706; }
        /* Póliza */
        .poliza {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        .poliza-header {
            background: #f8fafc;
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
            display: table;
            width: 100%;
        }
        .poliza-header-left {
            display: table-cell;
            width: 70%;
        }
        .poliza-header-right {
            display: table-cell;
            width: 30%;
            text-align: right;
        }
        .poliza-numero {
            font-size: 12px;
            font-weight: bold;
            color: #1e3a5f;
        }
        .poliza-compania {
            font-size: 10px;
            color: #64748b;
        }
        .poliza-prima {
            font-size: 14px;
            font-weight: bold;
            color: #1e3a5f;
        }
        .poliza-forma-pago {
            font-size: 9px;
            color: #64748b;
        }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-activa { background: #dcfce7; color: #166534; }
        .badge-vencida { background: #fee2e2; color: #991b1b; }
        .badge-cancelada { background: #f3f4f6; color: #374151; }
        .poliza-body {
            padding: 10px 12px;
        }
        .poliza-unidad {
            background: #f1f5f9;
            padding: 6px 10px;
            border-radius: 4px;
            margin-bottom: 8px;
            font-size: 10px;
        }
        .poliza-fechas {
            font-size: 9px;
            color: #64748b;
            margin-bottom: 10px;
        }
        /* Tabla de Pagos */
        .pagos-titulo {
            font-size: 9px;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 6px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
        }
        .pagos-tabla {
            width: 100%;
            border-collapse: collapse;
        }
        .pagos-tabla th {
            text-align: left;
            font-size: 8px;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            padding: 4px 6px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        .pagos-tabla td {
            padding: 5px 6px;
            font-size: 9px;
            border-bottom: 1px solid #f1f5f9;
        }
        .pago-pagado {
            color: #16a34a;
        }
        .pago-pendiente {
            color: #d97706;
        }
        .check-icon {
            color: #16a34a;
            font-weight: bold;
        }
        .pending-icon {
            color: #d97706;
            font-weight: bold;
        }
        /* Footer */
        .footer {
            position: fixed;
            bottom: 20px;
            left: 30px;
            right: 30px;
            font-size: 8px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
            text-align: center;
        }
        .page-number:after {
            content: counter(page);
        }
    </style>
</head>
<body>
    <div class="page">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <div class="report-title">Reporte de Pólizas</div>
                <div class="report-subtitle">
                    @if($estatus === 'todas')
                        Todas las pólizas
                    @elseif($estatus === 'activas')
                        Pólizas Activas
                    @elseif($estatus === 'vencidas')
                        Pólizas Vencidas
                    @else
                        Pólizas Canceladas
                    @endif
                </div>
                <div class="fecha-reporte">Generado el {{ $fechaReporte }}</div>
            </div>
            <div class="header-right">
                <div style="font-size: 14px; font-weight: bold; color: #2563eb;">Rentería Seguros</div>
            </div>
        </div>

        <!-- Info Asegurado -->
        <div class="asegurado-info">
            <div class="asegurado-nombre">{{ $asegurado->nombre_completo }}</div>
            <div class="asegurado-detalle">
                @if($asegurado->RFC)
                    RFC: {{ $asegurado->RFC }} |
                @endif
                @if($asegurado->Telefono)
                    Tel: {{ $asegurado->Telefono }} |
                @endif
                @if($asegurado->Email)
                    {{ $asegurado->Email }}
                @endif
            </div>
        </div>

        <!-- Resumen -->
        <div class="resumen">
            <div class="resumen-item">
                <div class="resumen-valor">{{ $totalPolizas }}</div>
                <div class="resumen-label">Pólizas</div>
            </div>
            <div class="resumen-item">
                <div class="resumen-valor">${{ number_format($totalPrima, 2) }}</div>
                <div class="resumen-label">Prima Total</div>
            </div>
            <div class="resumen-item">
                <div class="resumen-valor verde">${{ number_format($totalPagado, 2) }}</div>
                <div class="resumen-label">Pagado</div>
            </div>
            <div class="resumen-item">
                <div class="resumen-valor amarillo">${{ number_format($totalPendiente, 2) }}</div>
                <div class="resumen-label">Pendiente</div>
            </div>
        </div>

        <!-- Pólizas -->
        @foreach($polizas as $poliza)
            <div class="poliza">
                <div class="poliza-header">
                    <div class="poliza-header-left">
                        <span class="poliza-numero">{{ $poliza->NumPoliza }}</span>
                        <span class="badge badge-{{ strtolower($poliza->Estatus) }}">{{ $poliza->Estatus }}</span>
                        <div class="poliza-compania">{{ $poliza->compania->Nombre ?? 'N/A' }} - {{ $poliza->compania->Cobertura ?? '' }}</div>
                    </div>
                    <div class="poliza-header-right">
                        <div class="poliza-prima">${{ number_format($poliza->Prima, 2) }}</div>
                        <div class="poliza-forma-pago">{{ $poliza->FormaPago }}</div>
                    </div>
                </div>
                <div class="poliza-body">
                    @if($poliza->unidad)
                        <div class="poliza-unidad">
                            <strong>Unidad:</strong> {{ $poliza->unidad->Marca }} {{ $poliza->unidad->Submarca }} {{ $poliza->unidad->Modelo }}
                            @if($poliza->unidad->Placas)
                                | Placas: {{ $poliza->unidad->Placas }}
                            @endif
                        </div>
                    @endif

                    <div class="poliza-fechas">
                        <strong>Vigencia:</strong> {{ $poliza->FechaInicio?->format('d/m/Y') }} al {{ $poliza->FechaVencimiento?->format('d/m/Y') }}
                    </div>

                    @if($poliza->fechasCobranza->count() > 0)
                        <div class="pagos-titulo">Calendario de Pagos</div>
                        <table class="pagos-tabla">
                            <thead>
                                <tr>
                                    <th style="width: 15%;">#</th>
                                    <th style="width: 30%;">Fecha</th>
                                    <th style="width: 25%;">Monto</th>
                                    <th style="width: 30%;">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($poliza->fechasCobranza as $index => $pago)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $pago->FechaCobranza?->format('d/m/Y') }}</td>
                                        <td>${{ number_format($pago->MontoCobro, 2) }}</td>
                                        <td>
                                            @if($pago->Estatus === 'Pagado')
                                                <span class="pago-pagado">
                                                    <span class="check-icon">&#10003;</span> Pagado
                                                    @if($pago->FechaPago)
                                                        ({{ $pago->FechaPago->format('d/m/Y') }})
                                                    @endif
                                                </span>
                                            @else
                                                <span class="pago-pendiente">
                                                    <span class="pending-icon">&#9711;</span> Pendiente
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Footer -->
    <div class="footer">
        Documento generado automáticamente por Sistema de Seguros | {{ $fechaReporte }} | Página <span class="page-number"></span>
    </div>
</body>
</html>
