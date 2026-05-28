<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade'); // Relación con la tabla clientes
            $table->foreignId('servicio_id')->constrained()->onDelete('cascade'); // Relación con la tabla servicios
            $table->foreignId('empleado_id')->constrained()->onDelete('cascade'); // Relación con la tabla empleados

            $table->date('fecha');
            $table->time('hora');
            $table->text('observacion')->nullable();
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada'])->default('pendiente');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservas');
    }
}
