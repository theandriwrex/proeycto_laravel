@extends('layouts.auth')

@section('title', 'Registro')

@push('styles')
    @vite(['resources/css/registro.css'])
@endpush

@section('content')

    <header class = "container text-center py-5 shadow " style = "">
        <div>
            <h1>
                REGISTRO 
            </h1>

            <div class = "login-box" >    

                <form method="post" id="form" action="/prime/index.php?controller=registrop&action=guardar">

                    <input type="text" id ="usuario" name="usuario" placeholder="register user" >
                    <span id = "usuario_error" class = "error" ></span>
                    <br>
                    <input type="text" id ="nombre" name="nombre" placeholder="ingrese su nombre" >
                    <span id = "nombre_error" class = "error" ></span>
                    <br>
                    <input type="text" id="email" name="email" placeholder="ingrese su correo /UNICO/">
                    <span id = "email_error" class = "error" ></span>
                    <br>
                    <input type="password" id="clave" name="clave" placeholder="password" >
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
                                <p>ya tienes cuenta? <a href="index.php?controller=loginp&action=index">iniciar sesion</a></p>
                            </li>
                        </ul>

                    </div>    
                    
                </form>
            </div>
        </div>
    </header>

@endsection