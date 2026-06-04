<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() // Listar todos los clientes
    {
       $clientes = Cliente::latest()->get();// Obtener todos los clientes ordenados por fecha de creación
       return response()->json($clientes); // Devolver los clientes en formato JSON
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
    public function store(Request $request) // Crear un nuevo cliente
    {
        $request->validate([
            'cedula_ruc' => 'required|string|max:255|unique:clientes,cedula_ruc', // Validar que la cédula o RUC sea única en la tabla clientes para evitar duplicados  
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'fecha_nacimiento' => 'required|date'
        ]);

        

        $cliente= Cliente::create($request->all()); // Crear un nuevo cliente con los datos recibidos
    
        return response()->json(['message' =>'Cliente creado exitosamente','data'=> $cliente],201); // Devolver una respuesta JSON con el cliente creado
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente) // Mostrar un cliente específico
    {
        return response()->json($cliente); // Devolver el cliente en formato JSON
        
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            
         'cedula_ruc' => ['required', 'string', 'max:255', Rule::unique('clientes', 'cedula_ruc')->ignore($cliente->id)], // Validar que la cédula o RUC sea única en la tabla clientes, excluyendo el cliente actual para evitar conflictos al actualizar
         'nombres' => 'required|string|max:255',
         'apellidos' => 'required|string|max:255',
         'telefono' => 'required|string|max:20',
         'email' => 'nullable|email|max:255',  
         'fecha_nacimiento' => 'required|date'   
        ]);

        $cliente->update($request->all()); // Actualizar los datos del cliente

        return response()->json(['message' => 'Cliente actualizado exitosamente', 'data' => $cliente]); // Devolver una respuesta JSON con el cliente actualizado
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        if($cliente->reservas()->exists()) { // Verificar si el cliente tiene reservas asociadas antes de eliminarlo
            return response()->json(['message'=>'No se puede eliminar el cliente porque tiene reservas asociadas'], 400); // Devolver una respuesta JSON con un mensaje de error y un código de estado 400 (Bad Request)
        }

        $cliente->delete(); // Eliminar el cliente
        return response()->json(['message'=>'Cliente eliminado exitosamente'], 200); // Devolver una respuesta JSON con un mensaje de éxito y un código de estado 200 (OK)
    }
}
