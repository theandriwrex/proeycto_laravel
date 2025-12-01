@extends('layouts.auth')

@section('title', 'Registro')

@push('styles')
    @vite(['resources/css/auth.css'])
@endpush

@section('content')

    

    <header class = "container text-center py-5 shadow " style = "">
        <div>
            <h1>
                LOGIN 
            </h1>


            <div class = "login-box" >    

                <form method = "post" id = "form" action="{{ route('login.post') }}" >
                    @csrf
                    <input type="text" name = "email" placeholder = "Correo" >
                    <span id = "usuario_error" class ="error"></span>
                    <br> 
                    <input type="password" name="password" placeholder="Contraseña" >
                    <span id = "clave_error" class ="error"></span>
                    <br>
                    <button type = "submit">check</button>

                </form>

                <div class="links-modern">
                    <ul>
                        <li><a href="{{route('register')}}">registrarme</a></li>
                        <li><a href="recuperar.php">Cambiar contraseña</a></li>
                    </ul>

                </div>
                    
            </div>

        </div>
    </header>

    
@endsection


@section('scripts')
    @vite(['resources/js/registro.js'])
@endsection