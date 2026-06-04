<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [ // Campos que se pueden asignar masivamente 
        'cedula_ruc',
        'nombre',
        'telefono',
        'especialidad',
    ];

    // Relación con reservas
    public function reservas(){
        return $this->hasMany(Reserva::class); // un empleado puede tener muchas reservas
    }
}
