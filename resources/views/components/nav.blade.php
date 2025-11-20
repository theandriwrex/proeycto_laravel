<header class="bg-white shadow-md fixed w-full z-10">

        @if($user)
            <nav class="container mx-auto flex justify-between items-center p-4">
                <h1 id ="h1_nav" class="text-2xl font-bold text-indigo-600"> Bienvenido <!-- <?php echo $_SESSION ["nombre"]?>  --></h1>
                <ul class="flex space-x-6" id="navbar">
                    <li><a href="#image_session" class="hover:text-indigo-500">Inicio</a></li>
                    <li><a href="index.php?controller=His_reservas&action=index" class="hover:text-indigo-500">Mis_Reservas</a></li>
                    <li><a href="#habitaciones" class="hover:text-indigo-500">Habitaciones</a></li>
                    <li><a href="#servicios" class="hover:text-indigo-500">Servicios</a></li>
                    <li><a href="index.php?controller=Homep&action=logout" class="text-red-600 hover:text-red-800">salir</a></li>
                    <li><a href="index.php?controller=procesar_reserva&action=index" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-500">Reservar</a></li>
                </ul>
            </nav>
        @else
            <nav class="container mx-auto flex justify-between items-center p-4">
                <h1 class="text-2xl font-bold text-indigo-600">Hotel Spyce</h1>
                <ul class="flex space-x-6" id="navbar">
                    <li><a href="#inicio" class="hover:text-indigo-500">Inicio</a></li>
                    <li><a href="#habitaciones" class="hover:text-indigo-500">Habitaciones</a></li>
                    <li><a href="#servicios" class="hover:text-indigo-500">Servicios</a></li>
                    <li><a href="#contacto" class="hover:text-indigo-500">Contacto</a></li>
                    <li><a href="index.php?controller=Homep&action=login" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-500">Iniciar sesión</a></li>
                </ul>
            </nav>
        @endif
</header>  