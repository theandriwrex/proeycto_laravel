<?php

namespace App\Exports;

use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReservasUsuarioExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Reserva::where('user_id', Auth::id())
            ->with(['usuario', 'habitacion.tipo'])
            ->get()
            ->map(function ($r) {
                return [
                    'ID' => $r->id,
                    'Cliente' => $r->usuario->name,
                    'Habitación' => $r->habitacion->numero,
                    'Tipo' => $r->habitacion->tipo->nombre,
                    'Ingreso' => $r->fecha_ingreso,
                    'Salida' => $r->fecha_salida,
                    'Total' => $r->precio_total,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Cliente',
            'Habitación',
            'Tipo',
            'Ingreso',
            'Salida',
            'Total',
        ];
    }
}
