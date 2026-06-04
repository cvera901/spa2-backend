<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservas = Reserva::with(['cliente', 'servicio', 'empleado']) // con with se cargan las relaciones para mostrar información completa de cada reserva
            ->where('estado', '!=', 'cancelada')
            ->get();  //  Cargar relaciones para mostrar información completa
        return response()->json($reservas);
    }   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //crear una nueva reserva
    {
        $request->validate([ // validar las entradas recibidas para crear una reserva
            'cliente_id'=>'required|exists:clientes,id',
            'servicio_id'=>'required|exists:servicios,id',
            'empleado_id'=>'required|exists:empleados,id',
            'fecha'=>'required|date',
            'hora'=>'required|date_format:H:i',
            'observacion'=>'nullable|string|max:255',
            'estado'=>'required|in:pendiente,confirmada,cancelada,finalizada',
        ]);

        $existereserva = Reserva::where('empleado_id', $request->empleado_id) // verificar que no exista una reserva para el mismo empleado, fecha y hora antes de crear una nueva reserva
            ->where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->exists(); // Verificar si ya existe una reserva para el mismo empleado, fecha y hora

        if ($existereserva) { // si ya existe una reserva para el mismo empleado, fecha y hora, devuelve una respuesta 
            return response()->json(['message'=>'Ya existe una reserva para este empleado en esta fecha y hora'], 409);
        }

        $reserva= Reserva::create($request->all()); // Crear una nueva reserva
        return response()->json(['message'=>'Reserva creada exitosamente','data'=>$reserva],201); // responder con un json la respuesta positiva con los datos cargados
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function show($id) // Mostrar los detalles de una reserva específica
    {
        //Buscar la reserva por su id y cargar las relaciones para mostrar información completa
        $reserva = Reserva::with(['cliente','servicio','empleado'
        ])->findOrFail($id); // Si no se encuentra la reserva, se lanzará una excepción y se devolverá una respuesta de error 404   

        return response()->json($reserva);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function edit(Reserva $reserva) // Mostrar el formulario para editar una reserva específica
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reserva $reserva) // Actualizar una reserva específica
    {
        $request->validate([
            'cliente_id'=>'required|exists:clientes,id',
            'servicio_id'=>'required|exists:servicios,id',
            'empleado_id'=>'required|exists:empleados,id',
            'fecha'=>'required|date',
            'hora'=>'required|date_format:H:i',
            'observacion'=>'nullable|string|max:255',
            'estado'=>'required|in:pendiente,confirmada,cancelada,finalizada',
        ]);

        // verificar que no exista otra reserva para el mismo empleado, fecha y hora, excluyendo la reserva actual para evitar conflictos al actualizar
        $evitarconflicto = Reserva::where('empleado_id', $request->empleado_id)
            ->where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('id', '!=', $reserva->id) // Excluir la reserva actual para evitar conflictos al actualizar
            ->exists(); // Verificar si ya existe una reserva para el mismo empleado, fecha y hora, excluyendo la reserva actual

        if ($evitarconflicto) { // si ya existe otra reserva devuelve una respuesta de error indicando que ya existe
            return response()->json(['message'=>'Ya existe una reserva para este empleado en esta fecha y hora'], 422);
        }

        $reserva->update($request->all()); // Actualizar la reserva con los datos recibidos

        $reserva->load(['cliente','servicio','empleado']); // Cargar relaciones para mostrar información completa después de la actualización

        return response()->json(['message'=>'Reserva actualizada exitosamente','data'=>$reserva]); // responder con un json la respuesta positiva con los datos actualizados

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reserva $reserva) // Eliminar una reserva específica
    {
        if($reserva->estado === 'cancelada'){ // verificar si la reserva ya está cancelada antes de eliminarla
            return response()->json(['message'=>'La reserva ya está cancelada'], 422);
        }

        $reserva->update([
            'estado'=>'cancelada'
        ]); // cambiar el estado de la reserva a cancelada en lugar de eliminarla físicamente
        
            return response()->json(['message' => 'Reserva cancelada exitosamente', 'data' => $reserva
        ]); // responder con un json la respuesta positiva de cancelación de la reserva




    }
}
