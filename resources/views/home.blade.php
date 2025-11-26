@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    <body>
        
        <section class="relative h-screen flex items-center justify-center" id="image_session">
            <div class="bg-black/50 p-10 rounded-xl text-center text-white"> 
                <h2 class="text-5xl font-bold mb-4">Vive la mejor experiencia</h2>
                <p class="text-lg mb-6">Confort, elegancia y el mejor servicio para tu estadía</p>
                <a href="index1.php" class="bg-indigo-600 px-6 py-3 rounded-lg text-lg hover:bg-indigo-500">Reserva Ahora</a>
            </div>
        </section>

        
        <section id="servicios" class="py-16 bg-gray-50">
            <div class="container mx-auto text-center">
            <h3 class="text-3xl font-bold mb-10">Nuestros Servicios</h3>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="p-6 bg-white shadow-lg rounded-xl">
                <h4 class="font-bold">WiFi Gratis</h4>
                <p>Conéctate en todo el hotel.</p>
                </div>
                <div class="p-6 bg-white shadow-lg rounded-xl">
                <h4 class="font-bold">Piscina</h4>
                <p>Disfruta de nuestra piscina climatizada.</p>
                </div>
                <div class="p-6 bg-white shadow-lg rounded-xl">
                <h4 class="font-bold">Spa & Relax</h4>
                <p>Relájate en manos de expertos.</p>
                </div>
                <div class="p-6 bg-white shadow-lg rounded-xl">
                <h4 class="font-bold">Restaurante</h4>
                <p>Gastronomía internacional.</p>
                </div>
            </div>
            </div>
        </section>

       <section id="habitaciones" class="py-16">
            <div class="container mx-auto text-center">
                <h3 class="text-3xl font-bold mb-10">Habitaciones Destacadas</h3>

                <div class="grid md:grid-cols-3 gap-8">

                    @auth
                        <a href="{{ route('reservas.formulario', ['tipo' => 'lujo']) }}">
                    @endauth
                    @guest
                        
                    @endguest

                        <div class="bg-white shadow-lg rounded-xl overflow-hidden 
                                    cursor-pointer transform transition duration-300 hover:scale-105 hover:shadow-2xl">
                            <img src="https://www.venicecollection.com/palazzo-veneziano/wp-content/uploads/sites/2/2017/08/Luxury-Spa-Suite-05-1600x800.jpg" alt="Habitación Lujo">
                            <div class="p-6">
                                <h4 class="font-bold">Suite Lujo</h4>
                                <p>$120 / noche</p>
                            </div>
                        </div>
                    </a>

                    @auth
                        <a href="{{ route('reservas.formulario', ['tipo' => 'premium']) }}">
                    @endauth
                    @guest
                       
                    @endguest

                        <div class="bg-white shadow-lg rounded-xl overflow-hidden
                                    cursor-pointer transform transition duration-300 hover:scale-105 hover:shadow-2xl">
                            <img src="https://www.hotelplaza.es/wp-content/uploads/sites/145/2024/05/HOTEL-PLAZA-CORUNA-DORMITORIO-HABITACION-PREMIUM-CORUNA-CENTRO-2200x1200.jpg" alt="Habitación Premium">
                            <div class="p-6">
                                <h4 class="font-bold">Premium</h4>
                                <p>$90 / noche</p>
                            </div>
                        </div>
                    </a>

                    @auth
                        <a href="{{ route('reservas.formulario', ['tipo' => 'estandar']) }}">
                    @endauth
                    @guest
                        
                    @endguest

                        <div class="bg-white shadow-lg rounded-xl overflow-hidden
                                    cursor-pointer transform transition duration-300 hover:scale-105 hover:shadow-2xl">
                            <img src="https://image-tc.galaxy.tf/wijpeg-4t6kmu8xttmb2d4mvbeayezok/palmira-estandar4_wide.jpg?crop=0%2C99%2C1900%2C1069" alt="Habitación Estándar">
                            <div class="p-6">
                                <h4 class="font-bold">Estándar</h4>
                                <p>$70 / noche</p>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </section>

    </body>
@endsection


