<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';

    protected $fillable = [
        'user_id',
        'habitacion_id',
        'fecha_ingreso',
        'fecha_salida',
        'adultos',
        'ninos',
        'peticiones',
        'servicios',
        'precio_total',
        'estado',
    ];

    protected $casts = [
        'servicios' => 'array', 
        'fecha_ingreso' => 'date',
        'fecha_salida' => 'date',
    ];

    // RELACIONES
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class, 'habitacion_id');
    }
}
