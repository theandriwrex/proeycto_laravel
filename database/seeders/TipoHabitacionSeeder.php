<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoHabitacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoHabitacion::create([
            'nombre' => 'Sencilla',
            'precio_noche' => 80000,
            'descripcion' => 'Habitación sencilla para una persona',
        ]);

        TipoHabitacion::create([
            'nombre' => 'Doble',
            'precio_noche' => 120000,
            'descripcion' => 'Habitación doble para dos personas',
        ]);

        TipoHabitacion::create([
            'nombre' => 'Suite',
            'precio_noche' => 250000,
            'descripcion' => 'Suite de lujo con vista panorámica',
        ]);
    }
}
