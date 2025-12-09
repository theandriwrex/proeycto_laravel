<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte General de Reservas</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #555;
            margin-bottom: 20px;
        }
        .logo {
            font-weight: bold;
            font-size: 20px;
        }
        h2 {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            table-layout: fixed;
            word-wrap: break-word;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #f0f0f0;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 25px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="logo">HOTEL SPYCE </div>
    <small>Reporte General de Reservas</small>
</div>

<h2>Listado de Reservas</h2>

@foreach ($reservas as $r)
    <table>
        <tr>
            <th>ID</th>
            <td>{{ $r->id }}</td>
            <th>Cliente</th>
            <td>{{ $r->usuario->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $r->usuario->email }}</td>
            <th>Habitación</th>
            <td>{{ $r->habitacion->tipo->nombre }}</td>
        </tr>
        <tr>
            <th>Ingreso</th>
            <td>{{ $r->fecha_ingreso }}</td>
            <th>Salida</th>
            <td>{{ $r->fecha_salida }}</td>
        </tr>
        <tr>
            <th>Noches</th>
            <td>{{ $r->noches }}</td>
            <th>Adultos / Niños</th>
            <td>{{ $r->adultos }} / {{ $r->ninos ?? 0 }}</td>
        </tr>
        <tr>
            <th>Servicios</th>
            <td colspan="3">
                @if($r->servicios)
                    {{ implode(', ', json_decode($r->servicios)) }}
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <th>Peticiones</th>
            <td colspan="3">{{ $r->peticiones ?? '-' }}</td>
        </tr>
        <tr>
            <th>Total</th>
            <td>COP ${{ number_format($r->precio_total, 0, ',', '.') }}</td>
            <th>Estado</th>
            <td>{{ strtoupper($r->estado) }}</td>
        </tr>
    </table>
@endforeach

<div class="footer">
    Documento generado automáticamente por el sistema de reservas del Hotel Paraíso Real.
</div>

</body>
</html>
