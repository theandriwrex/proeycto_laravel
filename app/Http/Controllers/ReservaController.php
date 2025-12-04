<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservaRequest;
use App\Models\Reserva;
use App\Models\Habitacion;
use App\Models\TipoHabitacion;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservaController extends Controller
{
    /**
     * Vista del formulario de reserva
     */
    public function ShowReserva(Request $request)
    {
        $tipos = TipoHabitacion::all();

        // Si viene un tipo desde ?tipo=estandar
        $tipoSeleccionado = null;
        if ($request->has('tipo')) {
            $tipoSeleccionado = TipoHabitacion::where('nombre', ucfirst($request->tipo))->first();
        }

        return view('reserva', compact('tipos', 'tipoSeleccionado'));
    }

    /**
     * Crear la reserva
     */
    public function store(ReservaRequest $request)
    {
        // Obtener habitación seleccionada
        $habitacion = Habitacion::findOrFail($request->habitacion_id);

        // Validar que la habitación pertenece al tipo
        if ($habitacion->tipo_habitacion_id != $request->tipo_habitacion_id) {
            return response()->json([
                'message' => 'La habitación seleccionada no pertenece al tipo de habitación escogido.'
            ], 422);
        }

        // Validar capacidad
        $tipo = TipoHabitacion::findOrFail($request->tipo_habitacion_id);
        $totalPersonas = $request->adultos + $request->ninos;

        if ($totalPersonas > $tipo->capacidad) {
            return response()->json([
                'message' => "La capacidad máxima de esta habitación es {$tipo->capacidad} personas."
            ], 422);
        }

        // Fechas y cálculo de noches
        $entrada = Carbon::parse($request->fecha_ingreso);
        $salida  = Carbon::parse($request->fecha_salida);
        $noches  = $entrada->diffInDays($salida);

        if ($noches <= 0) {
            return response()->json([
                'message' => 'La fecha de salida debe ser posterior a la fecha de ingreso.'
            ], 422);
        }

        // Comprobar disponibilidad
        $reservaSolapada = Reserva::where('habitacion_id', $habitacion->id)
            ->where('estado', '!=', 'cancelada')
            ->where(function ($q) use ($entrada, $salida) {
                $q->whereBetween('fecha_ingreso', [$entrada, $salida])
                  ->orWhereBetween('fecha_salida', [$entrada, $salida])
                  ->orWhere(function ($q2) use ($entrada, $salida) {
                      $q2->where('fecha_ingreso', '<=', $entrada)
                         ->where('fecha_salida', '>=', $salida);
                  });
            })
            ->exists();

        if ($reservaSolapada) {
            return response()->json([
                'message' => 'Esta habitación no está disponible en las fechas seleccionadas.'
            ], 422);
        }

        // Precio total
        $precioTotal = $noches * $habitacion->precio_noche;

        // Crear reserva
        $reserva = Reserva::create([
            'user_id'             => Auth::id(),
            'tipo_habitacion_id'  => $tipo->id,
            'habitacion_id'       => $habitacion->id,

            'fecha_ingreso'       => $request->fecha_ingreso,
            'fecha_salida'        => $request->fecha_salida,
            'hora_llegada'        => $request->hora_llegada,

            'adultos'             => $request->adultos,
            'ninos'               => $request->ninos,
            'peticiones'          => $request->peticiones,

            'precio_total'        => $precioTotal,
            'estado'              => 'pendiente'
        ]);

        return response()->json([
            'message' => 'Reserva creada correctamente.',
            'reserva' => $reserva
        ]);
    }


    public function getHabitaciones($tipoId)
    {
        try {
            $habitaciones = Habitacion::where('tipo_habitacion_id', $tipoId)
                ->where('estado', 'disponible')
                ->get([
                    'id',
                    'numero',
                    'estado'
                ]);

            return response()->json([
                'success' => true,
                'data' => $habitaciones
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
