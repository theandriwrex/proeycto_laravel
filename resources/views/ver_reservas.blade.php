@extends('layouts.app')

@section('title', 'Historial de Reservas')

@push('styles')
 <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('scripts')
    @vite(['resources/js/verReservas.js'])
@endpush



@section('content')

{{-- HERO --}}
<section class="relative h-[50vh] md:h-[70vh] flex items-center justify-center bg-cover bg-center"
         style="background-image: url('https://www.venicecollection.com/palazzo-veneziano/wp-content/uploads/sites/2/2017/08/Luxury-Spa-Suite-05-1600x800.jpg');">
    <div class="bg-black bg-opacity-50 p-10 rounded-xl text-center text-white max-w-xl">
      <h2 class="text-4xl md:text-5xl font-bold mb-4">Historial de Reservas</h2>
      <p class="text-lg">Consulta tus reservas pasadas y futuras en un solo lugar.</p>
    </div>
</section>

<section class="py-16">
    <div class="container mx-auto">

        {{-- BOTONES --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 px-4">

            <h3 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">Mis Reservas</h3>

            <div class="flex space-x-3">
                <a href="{{ route('reservas.pdfGeneral') }}" 
                   target="_blank"
                   class="inline-flex items-center bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-500">
                    PDF General
                </a>

                <a href="{{ route('reservas.excelGeneral') }}"
                   target="_blank"
                   class="inline-flex items-center bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-500">
                    Excel General
                </a>
            </div>
        </div>

        {{-- TABLA --}}
        <div class="overflow-x-auto shadow-lg rounded-xl">
            <table class="min-w-full bg-white border border-gray-200 rounded-xl">
                <thead>
                    <tr class="bg-indigo-600 text-white text-sm uppercase">
                        <th class="py-3 px-4">#Reserva</th>
                        <th class="py-3 px-4">Cliente</th>
                        <th class="py-3 px-4">Habitación</th>
                        <th class="py-3 px-4">Tipo</th>
                        <th class="py-3 px-4">Ingreso</th>
                        <th class="py-3 px-4">Salida</th>
                        <th class="py-3 px-4">Adultos</th>
                        <th class="py-3 px-4">Niños</th>
                        <th class="py-3 px-4">Peticiones</th>
                        <th class="py-3 px-4">Total</th>
                        <th class="py-3 px-4">Estado</th>
                        <th class="py-3 px-4">Acciones</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">

                    @forelse ($reservas as $reserva)

                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 text-center">{{ $reserva->id }}</td>

                        <td class="py-3 px-4">{{ $reserva->usuario->name }}</td>

                        <td class="py-3 px-4">
                            Habitación {{ $reserva->habitacion->numero }}
                        </td>

                        <td class="py-3 px-4">
                            {{ $reserva->habitacion->tipo->nombre }}
                        </td>

                        <td class="py-3 px-4">{{ $reserva->fecha_ingreso }}</td>
                        <td class="py-3 px-4">{{ $reserva->fecha_salida }}</td>

                        <td class="py-3 px-4 text-center">{{ $reserva->adultos }}</td>
                        <td class="py-3 px-4 text-center">{{ $reserva->ninos }}</td>

                        <td class="py-3 px-4">{{ $reserva->peticiones ?? '—' }}</td>

                        <td class="py-3 px-4 font-semibold">
                            ${{ number_format($reserva->precio_total, 0, ',', '.') }}
                        </td>

                        <td class="py-3 px-4">
                            @if ($reserva->estado === 'confirmada')
                                <span class="bg-green-600 text-white px-3 py-1 rounded">Activa</span>
                            @else
                                <span class="bg-red-600 text-white px-3 py-1 rounded">Cancelada</span>
                            @endif
                        </td>

                        <td class="py-3 px-4 space-y-2 text-center">

                            {{-- CANCELAR --}}
                            @if ($reserva->estado == 'confirmada')
                                <form action="{{ route('reservas.cancelar', $reserva->id) }}" method="POST"
                                      onsubmit="return confirm('¿Seguro que deseas cancelar esta reserva?')">
                                    @csrf
                                    @method('PUT')
                                    <button class="text-red-600 hover:text-red-800 font-semibold">Cancelar</button>
                                </form>
                            @endif

                            {{-- EDITAR --}}
                            <a href="{{ route('reservas.editar', $reserva->id) }}"
                               class="text-yellow-600 hover:text-yellow-800 font-semibold">
                               Editar
                            </a>

                            {{-- PDF --}}
                            <a href="{{ route('reservas.pdf', $reserva->id) }}"
                                target="_blank"
                                class="text-indigo-600 hover:text-indigo-800 font-semibold">
                                PDF
                            </a>


                            {{-- ENVIAR CORREO --}}
                            <button class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-500 enviar-correo"
                                    data-id="{{ $reserva->id }}"
                                    data-email="{{ Auth::user()->email }}">
                                Enviar Confirmación
                            </button>

                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="12" class="py-6 text-center text-gray-500">
                            No tienes reservas.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</section>


@endsection
