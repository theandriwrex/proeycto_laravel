<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HabitacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Habitacion::create([
            'numero' => '101',
            'tipo_habitacion_id' => 1,
            'estado' => 'disponible',
        ]);

        Habitacion::create([
            'numero' => '102',
            'tipo_habitacion_id' => 2,
            'estado' => 'disponible',
        ]);

        Habitacion::create([
            'numero' => '201',
            'tipo_habitacion_id' => 3,
            'estado' => 'disponible',
        ]);
    }
}
