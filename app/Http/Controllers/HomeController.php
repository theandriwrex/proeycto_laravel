<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Variable por defecto
        $ultimaReserva = null;

        // Si el usuario está autenticado, obtenemos su última reserva
        if (Auth::check()) {
            $ultimaReserva = Auth::user()
                ->reservas()        // Relación desde el modelo User
                ->latest()
                ->first();
        }

        return view('home', compact('ultimaReserva'));
    }
}
