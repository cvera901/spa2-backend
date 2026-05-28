<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [ // Campos que se pueden asignar masivamente 
        'nombre',
        'telefono',
        'especialidad',
    ];
}
