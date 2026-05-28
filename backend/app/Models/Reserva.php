<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [ // Campos que se pueden asignar masivamente
        'cliente_id',
        'servicio_id',
        'empleado_id',
        'fecha',
        'hora',
        'observacion',
        'estado',
    ];

    // Relaciones con otros modelos
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    
    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
