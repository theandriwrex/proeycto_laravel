@php
    $tarifas = [
        'desayuno'   => 20000,
        'spa'        => 45000,
        'parqueadero'=> 10000,
        'mascotas'   => 35000,
        'transporte' => 50000,
    ];

    $servicios = $reserva->servicios ? json_decode($reserva->servicios, true) : [];
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva Nº {{ $reserva->id }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        h1, h2, h3 {
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #555;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .logo {
            font-weight: bold;
            font-size: 22px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table td, table th {
            padding: 8px;
            border: 1px solid #aaa;
        }

        .section-title {
            background: #f0f0f0;
            padding: 8px;
            font-weight: bold;
            border-left: 4px solid #555;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            margin-top: 25px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">HOTEL SPYCE</div>
        <small>Reporte de Reserva</small>
    </div>

    <h2>Detalle de Reserva Nº {{ $reserva->id }}</h2>

    <div class="section-title">Información del Cliente</div>
    <table>
        <tr>
            <th>Nombre</th>
            <td>{{ $reserva->usuario->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $reserva->usuario->email }}</td>
        </tr>
    </table>

    <div class="section-title">Información de la Habitación</div>
    <table>
        <tr>
            <th>Tipo</th>
            <td>{{ $reserva->habitacion->tipo->nombre }}</td>
        </tr>
        <tr>
            <th>Descripción</th>
            <td>{{ $reserva->habitacion->tipo->descripcion }}</td>
        </tr>
        <tr>
            <th>Capacidad</th>
            <td>{{ $reserva->habitacion->tipo->capacidad }} personas</td>
        </tr>
        <tr>
            <th>Precio por noche</th>
            <td>COP ${{ number_format($reserva->habitacion->tipo->precio_noche, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="section-title">Fechas de la Reserva</div>
    <table>
        <tr>
            <th>Fecha de ingreso</th>
            <td>{{ $reserva->fecha_ingreso }}</td>
        </tr>
        <tr>
            <th>Fecha de salida</th>
            <td>{{ $reserva->fecha_salida }}</td>
        </tr>
        <tr>
            <th>Noches</th>
            <td>{{ $reserva->noches }}</td>
        </tr>
    </table>


    <div class="section-title">Servicios Adicionales</div>
    <table>
        @if (count($servicios) > 0)
            <tr>
                <th>Servicio</th>
                <th>Precio</th>
            </tr>

            @foreach ($servicios as $s)
                <tr>
                    <td>{{ ucfirst($s) }}</td>
                    <td>COP ${{ number_format($tarifas[$s], 0, ',', '.') }}</td>
                </tr>
            @endforeach

        @else
            <tr>
                <td colspan="2" style="text-align:center;">No se solicitaron servicios adicionales.</td>
            </tr>
        @endif
    </table>



    <div class="section-title">Resumen de Pago</div>
    <table>
        <tr>
            <th>Precio total</th>
            <td><strong>COP ${{ number_format($reserva->precio_total, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <th>Estado</th>
            <td>{{ strtoupper($reserva->estado) }}</td>
        </tr>
    </table>

    <div class="footer">
        Documento generado automáticamente por el sistema de reservas del Hotel Paraíso Real.
    </div>

</body>
</html>
