<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Habitacion;

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
            'numero' => '103',
            'tipo_habitacion_id' => 1,
            'estado' => 'disponible',
        ]);

        Habitacion::create([
            'numero' => '104',
            'tipo_habitacion_id' => 1,
            'estado' => 'disponible',
        ]);


        Habitacion::create([
            'numero' => '102',
            'tipo_habitacion_id' => 2,
            'estado' => 'disponible',
        ]);

        Habitacion::create([
            'numero' => '202',
            'tipo_habitacion_id' => 2,
            'estado' => 'ocupada',
        ]);

        Habitacion::create([
            'numero' => '203',
            'tipo_habitacion_id' => 2,
            'estado' => 'disponible',
        ]);


        Habitacion::create([
            'numero' => '301',
            'tipo_habitacion_id' => 3,
            'estado' => 'disponible',
        ]);

        Habitacion::create([
            'numero' => '302',
            'tipo_habitacion_id' => 3,
            'estado' => 'disponible',
        ]);

        Habitacion::create([
            'numero' => '201',
            'tipo_habitacion_id' => 3,
            'estado' => 'disponible',
        ]);
    }
}
