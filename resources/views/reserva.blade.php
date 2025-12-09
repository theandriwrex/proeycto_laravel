@extends('layouts.auth')

@section('title', 'Reservar')

@push('styles')
    @vite(['resources/css/formulario.css'])
@endpush

@push('scripts')
    @vite(['resources/js/reserva.js'])
@endpush

@section('content')

<div class="reserva-bg">

    <div class="reserva-card">

        <h2 class="title">Reserva tu estancia</h2>
        <p class="subtitle">
            Bienvenido <span class="fw-bold">{{ Auth::user()->name }}</span>
        </p>

        {{-- Errores --}}
        @if ($errors->any())
            <div class="error-message">
                <ul style="margin: 0; padding-left: 15px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reservas.store') }}" method="POST" id="formReserva">
            @csrf

            <div class="form-grid">

                {{-- Fecha ingreso --}}
                <div class="field">
                    <label>Fecha de Ingreso</label>
                    <input type="date" name="fecha_ingreso" id="fecha_ingreso"
                        value="{{ old('fecha_ingreso') }}" required>
                </div>

                {{-- Fecha salida --}}
                <div class="field">
                    <label>Fecha de Salida</label>
                    <input type="date" name="fecha_salida" id="fecha_salida"
                        value="{{ old('fecha_salida') }}" required>
                </div>

                {{-- Hora llegada --}}
                <div class="field-full">
                    <label>Hora Estimada de Llegada</label>
                    <input type="time" name="hora_llegada"
                        value="{{ old('hora_llegada') }}">
                </div>

                {{-- Adultos --}}
                <div class="field">
                    <label>Adultos</label>
                    <input type="number" name="adultos" min="1" max="6"
                        value="{{ old('adultos', 1) }}" required>
                </div>

                {{-- Niños --}}
                <div class="field">
                    <label>Niños</label>
                    <input type="number" name="ninos" min="0" max="6"
                        value="{{ old('ninos', 0) }}">
                </div>

                {{-- Tipo habitación --}}
                <div class="field">
                    <label>Tipo de Habitación</label>
                    <select id="tipo_habitacion" name="tipo_habitacion_id" required>
                        <option value="">Seleccione un tipo</option>

                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->id }}"
                                data-precio="{{ $tipo->precio_noche }}"
                                @if(isset($tipoSeleccionado) && $tipoSeleccionado->id == $tipo->id)
                                    selected
                                @endif
                            >
                                {{ $tipo->nombre }} ({{ $tipo->capacidad }} personas)
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Habitaciones disponibles --}}
                <div class="field">
                    <label>Habitación disponible</label>
                    <select id="habitacion" name="habitacion_id" required>
                        <option value="">Seleccione un tipo primero</option>
                    </select>
                </div>

                {{-- Servicios adicionales --}}
                <div class="field-full">
                    <label class="font-semibold">Servicios adicionales</label>

                    <div class="services-box">

                        @php
                            $serviciosDisponibles = [
                                'desayuno' => 'Desayuno buffet',
                                'spa' => 'Acceso al Spa',
                                'parqueadero' => 'Parqueadero',
                                'mascotas' => 'Alojamiento para mascotas',
                                'transporte' => 'Transporte aeropuerto',
                            ];
                        @endphp

                        @foreach ($serviciosDisponibles as $key => $label)
                            <label class="flex items-center space-x-2 my-1">
                                <input type="checkbox"
                                       name="servicios[]"
                                       value="{{ $key }}"
                                       @if( is_array(old('servicios')) && in_array($key, old('servicios')) )
                                           checked
                                       @endif
                                       class="h-4 w-4">
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach

                    </div>
                </div>

                {{-- Peticiones especiales --}}
                <div class="field-full">
                    <label>Peticiones especiales</label>
                    <textarea name="peticiones" rows="2"
                        placeholder="Por ejemplo: cuna, piso alto, accesibilidad…">{{ old('peticiones') }}</textarea>
                </div>

                {{-- Precio total --}}
                <div class="field-full">
                    <label class="font-semibold text-gray-700">Precio total:</label>
                    <p id="precio-total" class="text-xl font-bold text-blue-600">COP $0</p>
                </div>

                {{-- Términos --}}
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="terminos" name="terminos" class="h-4 w-4" required>
                    <label for="terminos" class="text-sm text-gray-700">
                        Acepto 
                        <a href="#" class="text-blue-300 underline">términos y condiciones</a>
                    </label>
                </div>

                {{-- Botón --}}
                <div class="field-full">
                    <button type="submit" class="btn-reservar">Reservar ahora</button>
                </div>

            </div>
        </form>

    </div>

</div>

@endsection
