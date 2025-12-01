<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    protected $table = 'habitaciones';

    protected $fillable = [
        'numero',
        'tipo_habitacion_id',
        'estado',
    ];

    // Relaciones
    public function tipo()
    {
        return $this->belongsTo(TipoHabitacion::class, 'tipo_habitacion_id');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'habitacion_id');
    }
}
