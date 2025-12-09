<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        
        $ultimaReserva = null;

       
        if (Auth::check()) {
            $ultimaReserva = Auth::user()
                ->reservas()        
                ->latest()
                ->first();
        }

        return view('home', compact('ultimaReserva'));
    }
}
