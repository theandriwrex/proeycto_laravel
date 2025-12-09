<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservaRequest;
use App\Models\Reserva;
use App\Models\Habitacion;
use App\Models\TipoHabitacion;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Exports\ReservasUsuarioExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmacionReserva;


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
    public function store(Request $request)
    {
        $request->validate([
            'fecha_ingreso' => 'required|date|after_or_equal:today',
            'fecha_salida' => 'required|date|after:fecha_ingreso',
            'hora_llegada' => 'nullable',
            'adultos' => 'required|integer|min:1|max:6',
            'ninos' => 'nullable|integer|min:0|max:6',
            'tipo_habitacion_id' => 'required|exists:tipo_habitaciones,id',
            'habitacion_id' => 'required|exists:habitaciones,id',
            'peticiones' => 'nullable|string|max:500',
            'servicios' => 'nullable|array',            // 👈 Acepta array
            'servicios.*' => 'string|max:50',           // 👈 Cada valor del array
            'terminos' => 'accepted'
        ]);

        // Buscar tipo para sacar precio por noche
        $tipo = TipoHabitacion::findOrFail($request->tipo_habitacion_id);

        // Calcular noches
        $noches = (new \DateTime($request->fecha_ingreso))
            ->diff(new \DateTime($request->fecha_salida))
            ->days;

        $precioTotal = $tipo->precio_noche * $noches;

       
        
        $tarifas = [
            'desayuno'   => 20000,
            'spa'        => 45000,
            'parqueadero'=> 10000,
            'mascotas'   => 35000,
            'transporte' => 50000,
        ];

        if ($request->has('servicios')) {
            foreach ($request->servicios as $servicio) {
                if (isset($tarifas[$servicio])) {
                    $precioTotal += $tarifas[$servicio];
                }
            }
        }
       

        $reserva = Reserva::create([
            'user_id'            => Auth::id(),
            'habitacion_id'      => $request->habitacion_id,
            'fecha_ingreso'      => $request->fecha_ingreso,
            'fecha_salida'       => $request->fecha_salida,
            'hora_llegada'       => $request->hora_llegada,
            'adultos'            => $request->adultos,
            'ninos'              => $request->ninos,
            'peticiones'         => $request->peticiones,

            
            'servicios'          => $request->servicios ? json_encode($request->servicios) : null,

            'precio_total'       => $precioTotal,

            
            'estado'             => 'confirmada',
        ]);

        return redirect()
        ->route('ver_reservas', $reserva->id)
        ->with('success', 'Reserva creada correctamente.');
    }


    public function cancelar($id)
    {
        $reserva = Reserva::findOrFail($id);

        $reserva->estado = 'cancelada';
        $reserva->save();

        return redirect()->back()->with('success', 'Reserva cancelada correctamente.');
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


    public function verReservas()
    {
        $reservas = Reserva::with(['habitacion.tipo', 'usuario'])->get();

        return view('ver_reservas', compact('reservas'));
    }

    public function pdfReserva($id)
    {
        $reserva = Reserva::with(['habitacion.tipo', 'usuario'])->findOrFail($id);

        $reserva->servicios_lista = $reserva->servicios ? json_decode($reserva->servicios, true) : [];

        $data = [
            'titulo' => 'Reporte de Reserva',
            'reserva' => $reserva
        ];

        
        $pdf = Pdf::loadView('pdf_individual', $data);

        $nombreArchivo = "Reserva_{$reserva->id}_{$reserva->usuario->name}.pdf";

        return $pdf->stream($nombreArchivo);
    }


    public function pdfGeneral()
    {
        
        $reservas = Reserva::with(['usuario', 'habitacion.tipo'])->get();

        $titulo = "Reporte General de Reservas";

        $data = [
            'titulo' => $titulo,
            'reservas' => $reservas
        ];

        $pdf = Pdf::loadView('pdf_general', $data);

        return $pdf->stream('reporte_general_reservas.pdf');
    }



    public function excelGeneral()
    {
        return Excel::download(new ReservasUsuarioExport, 'mis_reservas.xlsx');
    }


    public function edit($id)
    {
        $reserva = Reserva::findOrFail($id);

        // Si guardas servicios en JSON, por ejemplo
        $servicios_guardados = $reserva->servicios ? json_decode($reserva->servicios, true) : [];

        return view('editar', compact('reserva', 'servicios_guardados'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'adultos' => 'required|integer|min:1|max:6',
            'ninos'   => 'nullable|integer|min:0|max:6',
            'fecha_ingreso' => 'required|date|after_or_equal:today',
            'fecha_salida'  => 'required|date|after:fecha_ingreso',
            'peticiones'       => 'nullable|string|max:500',
            'servicios'     => 'nullable|array',
            'servicios.*'   => 'string|max:50',
        ]);

        $reserva = Reserva::findOrFail($id);

        $reserva->adultos       = $request->adultos;
        $reserva->ninos         = $request->ninos;
        $reserva->fecha_ingreso = $request->fecha_ingreso;
        $reserva->fecha_salida  = $request->fecha_salida;
        $reserva->peticiones       = $request->peticiones;
        $reserva->servicios     = json_encode($request->servicios ?? []);

        $reserva->save();

        return redirect()->route('ver_reservas')->with('success', 'Reserva actualizada correctamente.');
    }

    public function enviarConfirmacion($id)
    {
        $reserva = Reserva::with('usuario', 'habitacion.tipo')->findOrFail($id);

        // Enviar correo
        Mail::send('emails.confirmacion_reserva', ['reserva' => $reserva], function($message) use ($reserva) {
            $message->to($reserva->usuario->email, $reserva->usuario->name)
                    ->subject("Confirmación de Reserva #{$reserva->id}");
        });

        return response()->json([
            'success' => true,
            'message' => 'Correo de confirmación enviado correctamente.'
        ]);
    }

}


