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
        Schema::create('habitaciones', function (Blueprint $table) {
            $table->id();

            // Número visible al cliente (101, 205, 305, etc.)
            $table->string('numero', 10)->unique();

            // Llave foránea hacia tipo_habitaciones
            $table->unsignedBigInteger('tipo_habitacion_id');

            // Opcional: estado de la habitación
            $table->enum('estado', ['disponible', 'ocupada', 'mantenimiento'])
                ->default('disponible');

            $table->timestamps();

            // Foreign key
            $table->foreign('tipo_habitacion_id')
            ->references('id')
            ->on('tipo_habitaciones')
            ->onDelete('cascade');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habitaciones');
    }
};
