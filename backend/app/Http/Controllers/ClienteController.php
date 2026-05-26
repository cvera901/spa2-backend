<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

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
    public function show($id) // Mostrar un cliente específico
     {
        $cliente = Cliente::findOrFail($id); // Buscar el cliente por su ID

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404); // Devolver un error si el cliente no existe
        }

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
    public function update(Request $request, $id)
    {
        $Cliente = Cliente::findOrFail($id); // Buscar el cliente por su ID

        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'fecha_nacimiento' => 'required|date'
        ]);

        $Cliente->update($request->all()); // Actualizar los datos del cliente

        return response()->json(['message' => 'Cliente actualizado exitosamente', 'data' => $Cliente]); // Devolver una respuesta JSON con el cliente actualizado
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        //
    }
}
