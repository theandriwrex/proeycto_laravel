<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();

            // Usuario que hace la reserva
            $table->unsignedBigInteger('user_id');

            // Habitación reservada
            $table->unsignedBigInteger('habitacion_id');

            // Fechas de la reserva
            $table->date('fecha_entrada');
            $table->date('fecha_salida');

            // Precio final calculado
            $table->decimal('precio_total', 10, 2);

            // Estado de la reserva
            $table->enum('estado', [
                'pendiente',
                'confirmada',
                'cancelada'
            ])->default('pendiente');

            $table->timestamps();

            // Relaciones
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');

            $table->foreign('habitacion_id')
            ->references('id')->on('habitaciones')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
