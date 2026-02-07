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
            font-size: 7px;
            color: #000;
            line-height: 1.2;
        }
        
        .page {
            padding: 15px;
        }
        
        /* Header con Logo */
        .header {
            margin-bottom: 10px;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }
        
        .header-content {
            display: table;
            width: 100%;
        }
        
        .header-left {
            display: table-cell;
            width: 70%;
            vertical-align: top;
        }
        
        .header-right {
            display: table-cell;
            width: 30%;
            text-align: right;
            vertical-align: top;
        }
        
        .cliente-info {
            font-size: 8px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        
        .representante {
            font-size: 7px;
            margin-bottom: 2px;
        }
        
        .total-unidades {
            font-size: 7px;
            font-weight: bold;
        }
        
        .logo {
            max-height: 45px;
            max-width: 120px;
        }
        
        .report-title {
            text-align: center;
            font-size: 10px;
            font-weight: bold;
            margin: 5px 0;
            text-transform: uppercase;
        }
        
        /* Tabla Principal */
        .tabla-reporte {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            font-size: 6px;
        }
        
        .tabla-reporte th {
            background-color: #000;
            color: #fff;
            font-weight: bold;
            padding: 3px 2px;
            border: 1px solid #000;
            text-align: center;
            font-size: 6px;
            line-height: 1.1;
        }
        
        .tabla-reporte td {
            border: 1px solid #000;
            padding: 2px 2px;
            vertical-align: middle;
            font-size: 6px;
            line-height: 1.1;
        }
        
        .tabla-reporte tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        /* Columnas específicas */
        .col-v {
            width: 2%;
            text-align: center;
            font-weight: bold;
        }
        
        .col-asegurado {
            width: 12%;
            font-size: 6px;
        }
        
        .col-fpago {
            width: 7%;
            text-align: center;
        }
        
        .col-poliza {
            width: 9%;
            text-align: center;
        }
        
        .col-vigencia {
            width: 6%;
            text-align: center;
        }
        
        .col-unidad {
            width: 16%;
            font-size: 6px;
        }
        
        .col-serie {
            width: 11%;
            font-size: 5px;
        }
        
        .col-placas {
            width: 6%;
            text-align: center;
        }
        
        .col-mod {
            width: 4%;
            text-align: center;
        }
        
        .col-cob {
            width: 5%;
            text-align: center;
        }
        
        .col-mes {
            width: 2%;
            text-align: center;
            font-weight: bold;
        }
        
        /* Estados */
        .vigente {
            color: #16a34a;
            font-weight: bold;
        }
        
        .vencida {
            color: #dc2626;
            font-weight: bold;
        }
        
        .pago-v {
            color: #dc2626;
            font-weight: bold;
        }

        .pago-m {
            color: #16a34a;
            font-weight: bold;
        }

        .pago-t {
            color: #d97706;
            font-weight: bold;
        }

        .pago-s {
            color: #2563eb;
            font-weight: bold;
        }

        .pago-a {
            color: #7c3aed;
            font-weight: bold;
        }
        
        /* Footer */
        .footer {
            position: fixed;
            bottom: 10px;
            left: 15px;
            width: 100%;
        }
        
        .footer-content {
            display: table;
            width: 100%;
        }
        
        .footer-left {
            display: table-cell;
            width: 20%;
            vertical-align: middle;
        }
        
        .footer-center {
            display: table-cell;
            width: 60%;
            text-align: center;
            vertical-align: middle;
        }
        
        .footer-logo {
            max-height: 40px;
            max-width: 80px;
        }
        
        .footer-info {
            font-size: 7px;
            line-height: 1.3;
        }
        
        .footer-contacto {
            font-size: 6px;
            margin-top: 2px;
        }
    </style>
</head>
<body>
    <div class="page">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div class="header-left">
                    <div class="cliente-info">CLIENTE: {{ strtoupper($asegurado->nombre_completo) }}</div>
                    <div class="representante">REPRESENTANTE: </div>
                    <div class="total-unidades">TOTAL DE UNIDADES: {{ $totalPolizas }} UNIDADES</div>
                </div>
                <div class="header-right">
                    @if(file_exists($logoPath))
                        <img src="{{ $logoPath }}" alt="Logo" class="logo">
                    @endif
                </div>
            </div>
        </div>

        <!-- Título -->
        <div class="report-title">Reporte de Unidades Aseguradas</div>

        <!-- Tabla Principal -->
        <table class="tabla-reporte">
            <thead>
                <tr>
                    <th class="col-v">V</th>
                    <th class="col-asegurado">ASEGURADO</th>
                    <th class="col-fpago">F.PAGO</th>
                    <th class="col-poliza">No.POLIZA</th>
                    <th class="col-vigencia">VIGENCIA</th>
                    <th class="col-unidad">UNIDAD</th>
                    <th class="col-serie">SERIE</th>
                    <th class="col-placas">PLACAS DEL<br>VEHICULO</th>
                    <th class="col-mod">MOD.</th>
                    <th class="col-cob">COB.</th>
                    <th class="col-mes">E</th>
                    <th class="col-mes">F</th>
                    <th class="col-mes">M</th>
                    <th class="col-mes">A</th>
                    <th class="col-mes">M</th>
                    <th class="col-mes">J</th>
                    <th class="col-mes">JL</th>
                    <th class="col-mes">A</th>
                    <th class="col-mes">S</th>
                    <th class="col-mes">O</th>
                    <th class="col-mes">N</th>
                    <th class="col-mes">D</th>
                </tr>
            </thead>
            <tbody>
                @foreach($polizas as $poliza)
                <tr>
                    <!-- V (Vigencia) -->
                    <td class="col-v">
                        @if($poliza->Estatus === 'Activa')
                            <span class="vigente">V</span>
                        @elseif($poliza->Estatus === 'Vencida')
                            <span class="vencida">X</span>
                        @else
                            -
                        @endif
                    </td>
                    
                    <!-- Asegurado -->
                    <td class="col-asegurado">{{ strtoupper($asegurado->nombre_completo) }}</td>
                    
                    <!-- Forma de Pago -->
                    <td class="col-fpago">{{ strtoupper($poliza->FormaPago) }}</td>
                    
                    <!-- Número de Póliza -->
                    <td class="col-poliza">{{ $poliza->NumPoliza }}</td>
                    
                    <!-- Vigencia -->
                    <td class="col-vigencia">
                        {{ $poliza->FechaVencimiento?->format('d-M-y') }}
                    </td>
                    
                    <!-- Unidad -->
                    <td class="col-unidad">
                        @if($poliza->unidad)
                            {{ strtoupper($poliza->unidad->Marca) }} 
                            {{ strtoupper($poliza->unidad->Submarca) }}
                            @if($poliza->unidad->Modelo)
                                {{ strtoupper(substr($poliza->unidad->Modelo, 0, 20)) }}
                            @endif
                        @else
                            N/A
                        @endif
                    </td>
                    
                    <!-- Serie (VIN) -->
                    <td class="col-serie">
                        {{ $poliza->unidad->VIN ?? 'N/A' }}
                    </td>
                    
                    <!-- Placas -->
                    <td class="col-placas">
                        {{ $poliza->unidad->Placas ?? 'N/A' }}
                    </td>
                    
                    <!-- Modelo (Año) -->
                    <td class="col-mod">
                        {{ $poliza->unidad->Anio ?? '' }}
                    </td>
                    
                    <!-- Cobertura -->
                    <td class="col-cob">
                        {{ strtoupper(substr($poliza->compania->Cobertura ?? 'N/A', 0, 6)) }}
                    </td>
                    
                    <!-- Meses (E F M A M J JL A S O N D) -->
                    @foreach(['E', 'F', 'M', 'A', 'MY', 'J', 'JL', 'AG', 'S', 'O', 'N', 'D'] as $mes)
                        <td class="col-mes">
                            @if($poliza->mesesPago[$mes] === 'V')
                                <span class="pago-v">V</span>
                            @elseif($poliza->mesesPago[$mes] === 'M')
                                <span class="pago-m">M</span>
                            @elseif($poliza->mesesPago[$mes] === 'T')
                                <span class="pago-t">T</span>
                            @elseif($poliza->mesesPago[$mes] === 'S')
                                <span class="pago-s">S</span>
                            @elseif($poliza->mesesPago[$mes] === 'A')
                                <span class="pago-a">A</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-content">
            <div class="footer-left">
                @if(file_exists($logoPath))
                    <img src="{{ $logoPath }}" alt="Logo" class="footer-logo">
                @endif
            </div>
            <div class="footer-center">
                <div class="footer-info">
                    <strong>Rubén Rentería Méndez</strong><br>
                    T: (442) 183 22 50 | C: (442) 438 12 88
                </div>
                <div class="footer-contacto">
                    WhatsApp: (442) 773 78 75
                </div>
            </div>
        </div>
    </div>
</body>
</html>