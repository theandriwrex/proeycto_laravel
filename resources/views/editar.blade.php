@extends('layouts.auth')

@section('title', 'Editar Reserva')

@push('styles')
    @vite(['resources/css/editar.css'])
@endpush

@section('content')
<div class="reserva-bg">
    <div class="reserva-card">
        <h2 class="title">Editar Reserva</h2>
        <p class="subtitle">Modifica tu reserva existente</p>

        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reservas.update', $reserva->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Fechas --}}
            <div class="field">
                <label>Fecha de Ingreso</label>
                <input type="date" name="fecha_ingreso" value="{{ old('fecha_ingreso', $reserva->fecha_ingreso) }}" required>
            </div>

            <div class="field">
                <label>Fecha de Salida</label>
                <input type="date" name="fecha_salida" value="{{ old('fecha_salida', $reserva->fecha_salida) }}" required>
            </div>

            {{-- Hora llegada --}}
            <div class="field">
                <label>Hora Estimada de Llegada</label>
                <input type="time" name="hora_llegada" value="{{ old('hora_llegada', $reserva->hora_llegada) }}">
            </div>

            {{-- Adultos y niños --}}
           <div class="col-md-6">
                <label>Adultos</label>
                <input type="number" name="adultos" min="1" max="6" 
                    value="{{ old('adultos', $reserva->adultos) }}" required>
            </div>

            <div class="col-md-6">
                <label>Niños</label>
                <input type="number" name="ninos" min="0" max="6" 
                    value="{{ old('ninos', $reserva->ninos) }}">
            </div>

            {{-- Tipo y habitación (solo lectura) --}}
            <div class="field">
                <label>Tipo de Habitación</label>
                <input type="text" value="{{ $reserva->habitacion->tipo->nombre }}" readonly>
            </div>

            <div class="field">
                <label>Habitación Asignada</label>
                <input type="text" value="Habitación {{ $reserva->habitacion->numero }}" readonly>
            </div>

            {{-- Peticiones --}}
            <div class="field-full">
                <label>Peticiones especiales</label>
                <textarea name="peticiones" rows="2">{{ old('peticiones', $reserva->peticiones) }}</textarea>
            </div>

            {{-- Servicios adicionales --}}
            <div class="field-full">
                <label>Servicios adicionales</label>
                @php
                    $serviciosDisponibles = [
                        'desayuno' => 'Desayuno buffet',
                        'spa' => 'Acceso al Spa',
                        'parqueadero' => 'Parqueadero',
                        'mascotas' => 'Alojamiento para mascotas',
                        'transporte' => 'Transporte aeropuerto',
                    ];
                    $serviciosGuardados = $reserva->servicios ? json_decode($reserva->servicios) : [];
                @endphp
                <div class="services-box">
                    @foreach ($serviciosDisponibles as $key => $label)
                        <label>
                            <input type="checkbox" name="servicios[]" value="{{ $key }}"
                                @if(in_array($key, $serviciosGuardados)) checked @endif>
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Botón --}}
            <div class="field-full">
                <button type="submit" class="btn-reservar">Guardar cambios</button>
            </div>

        </form>
    </div>
</div>
@endsection
