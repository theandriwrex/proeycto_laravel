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

        {{-- Mensajes de error globales --}}
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

                {{-- Fecha entrada --}}
                <div class="field">
                    <label>Fecha de Ingreso</label>
                    <input type="date" name="fecha_ingreso" id="fecha_ingreso"
                        value="{{ old('fecha_entrada') }}" required>
                </div>

                {{-- Fecha salida --}}
                <div class="field">
                    <label>Fecha de Salida</label>
                    <input type="date" name="fecha_salida" id="fecha_salida"
                        value="{{ old('fecha_salida') }}" required>
                </div>

                {{-- Hora llegada (solo visual) --}}
                <div class="field-full">
                    <label>Hora Estimada de Llegada</label>
                    <input type="time" name="hora_llegada" value="{{ old('hora_llegada') }}">
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
                                {{-- Preselección si viene ?tipo=xxxx incluido --}}
                                @if(isset($tipoSeleccionado) && $tipoSeleccionado == $tipo->id) selected @endif>
                                {{ $tipo->nombre }} ({{ $tipo->capacidad }} personas)
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Habitación --}}
                <div class="field">
                    <label>Habitación disponible</label>
                    <select id="habitacion" name="habitacion_id" required>
                        <option value="">Seleccione un tipo primero</option>
                    </select>
                </div>

                {{-- Peticiones --}}
                <div class="field-full">
                    <label>Peticiones especiales</label>
                    <textarea name="peticiones" rows="2"
                        placeholder="Por ejemplo: cuna, piso alto, accesibilidad…">{{ old('peticiones') }}</textarea>
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
