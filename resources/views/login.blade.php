@extends('layouts.auth')

@section('title', 'Registro')

@push('styles')
    @vite(['resources/css/registro.css'])
@endpush

@section('content')

    

    <header class = "container text-center py-5 shadow " style = "">
        <div>
            <h1>
                LOGIN 
            </h1>


            <div class = "login-box" >    

                <form method = "post" id = "form" action="/prime/index.php?controller=loginp&action=autenticar" >

                    <input type="text" name = "usuario" placeholder = "Usuario" >
                    <span id = "usuario_error" class ="error"></span>
                    <br> 
                    <input type="password" name="clave" placeholder="Contraseña" >
                    <span id = "clave_error" class ="error"></span>
                    <br>
                    <button type = "submit">check</button>

                </form>

                <div class="links-modern">
                    <ul>
                        <li><a href="index.php?controller=registrop&action=index">registrarme</a></li>
                        <li><a href="recuperar.php">Cambiar contraseña</a></li>
                    </ul>

                </div>
                    
            </div>

        </div>
    </header>

    <script src = "/prime/public/js/validacion_log.js" defer></script>





@endsection


@section('scripts')
    @vite(['resources/js/registro.js'])
@endsection