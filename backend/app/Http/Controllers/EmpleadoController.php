<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleado = Empleado::latest()->get();
        return response()->json($empleado);
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
    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required|string|max:255',
            'telefono'=>'required|string|max:255',
            'especialidad'=>'required|string|max:255',
        ]);

        $empleado = Empleado::create($request->all());
        return response()->json(['message'=>'Empleado creado exitosamente','data'=>$empleado],201); // devolver una respuesta JSON con el empleado creado y un código de estado 201 (creado)

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(Empleado $empleado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id); //buscar el empleado por id
        $request->validate([
            'nombre'=>'required|string|max:255',
            'telefono'=>'required|string|max:255',
            'especialidad'=>'required|string|max;255',
        ]);

        $servicio->update($request->all()); // Actualizar el servicio con los datos recibidos

        return response()->json(['message'=>'Empleado actualizado exitosamente','data'=>$empleado]); // devolver una respuesta JSON con el empleado actualizado
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado)
    {
        //
    }
}
