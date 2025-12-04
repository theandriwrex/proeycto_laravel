<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoHabitacion;


class TipoHabitacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoHabitacion::create([
            'nombre' => 'Estandar',
            'precio_noche' => 80000,
            'capacidad' => 1,
            'descripcion' => 'Habitación sencilla para una persona',
        ]);

        TipoHabitacion::create([
            'nombre' => 'Premium',
            'precio_noche' => 120000,
            'capacidad' => 2,
            'descripcion' => 'Habitación doble para dos personas',
        ]);

        TipoHabitacion::create([
            'nombre' => 'Suite',
            'precio_noche' => 250000,
            'capacidad' => 4,
            'descripcion' => 'Suite de lujo con vista panorámica',
        ]);
    }
}
