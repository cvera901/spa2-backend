<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombres',
        'apellidos',
        'telefono',
        'email',
        'fecha_nacimiento',
    ];

    // Relación con reservas
    public function reservas(){
        return $this->hasMany(Reserva::class); // un cliente puede tener muchas reservas
    }
}
