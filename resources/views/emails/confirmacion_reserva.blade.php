@component('mail::message')
# Confirmación de Reserva

Hola **{{ $reserva->usuario->name }}**,

Tu reserva **#{{ $reserva->id }}** ha sido confirmada.  
Detalles:

- **Habitación:** {{ $reserva->habitacion->tipo->nombre }} ({{ $reserva->habitacion->numero }})
- **Ingreso:** {{ $reserva->fecha_ingreso }}
- **Salida:** {{ $reserva->fecha_salida }}
- **Adultos:** {{ $reserva->adultos }}
- **Niños:** {{ $reserva->ninos }}
- **Servicios:** {{ $reserva->servicios ? implode(', ', json_decode($reserva->servicios)) : 'Ninguno' }}
- **Peticiones:** {{ $reserva->peticiones ?? '-' }}
- **Total:** COP ${{ number_format($reserva->precio_total, 0, ',', '.') }}

Gracias por confiar en **Hotel Paraíso Real**.

@endcomponent
