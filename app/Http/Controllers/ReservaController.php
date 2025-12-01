<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function store(ReservaRequest $request)
    {
        
        $habitacion = Habitacion::findOrFail($request->habitacion_id);

        
        $entrada = new \DateTime($request->fecha_entrada);
        $salida  = new \DateTime($request->fecha_salida);
        $noches  = $entrada->diff($salida)->days;

        
        $precioTotal = $noches * $habitacion->precio_noche;

        
        $reserva = Reserva::create([
            'user_id'       => Auth::id(),
            'habitacion_id' => $habitacion->id,
            'fecha_entrada' => $request->fecha_entrada,
            'fecha_salida'  => $request->fecha_salida,
            'precio_total'  => $precioTotal,
            'estado'        => 'pendiente'
        ]);

        return response()->json([
            'message' => 'Reserva creada correctamente.',
            'reserva' => $reserva
        ]);
    }
}
