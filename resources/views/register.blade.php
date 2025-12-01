@extends('layouts.auth')

@section('title', 'Registro')

@push('styles')
    @vite(['resources/css/auth.css'])
@endpush

@section('content')

    <header class = "container text-center py-5 shadow " style = "">
        <div>
            <h1>
                REGISTRO 
            </h1>

            <div class = "login-box" >
                
                @if ($errors->any())
                    <div class="errors" style="color: red; margin-bottom: 10px;">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
        
                <form method="post" id="form" action="{{ route('register.post') }}">

                    @csrf
                    <input type="text" id ="name" name="name" placeholder="ingrese su nombre" >
                    <span id = "nombre_error" class = "error" ></span>
                    <br>
                    <input type="text" id="email" name="email" placeholder="ingrese su correo /UNICO/">
                    <span id = "email_error" class = "error" ></span>
                    <br>
                    <input type="password" id="password" name="password" placeholder="password" >
                    <span id ="clave_error" class ="error"></span>
                    <ul id="requisitos">
                        <li class="requisito" id="reqLongitud">Mínimo 6 caracteres</li>
                        <li class="requisito" id="reqNumero">Al menos un número</li>
                        <li class="requisito" id="reqSimbolo">Al menos un símbolo</li>
                    </ul>
                    <br>

                    <button type="submit">Enviar</button>
                    
                    <div class = "links-modern">

                        <ul>
                            <li>
                                <p>ya tienes cuenta? <a href="{{ route('login') }}">iniciar sesion</a></p>
                            </li>
                        </ul>

                    </div>    
                    
                </form>
            </div>
        </div>
    </header>

@endsection


@push('scripts')
    @vite(['resources/js/validation_time_real.js'])
@endpush