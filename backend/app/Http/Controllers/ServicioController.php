<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;


class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicio = Servicio::latest()->get();

        return response()->json($servicio);

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
            'precio'=>'required|numeric',
            'duracion'=>'required|string|max:255',
            'descripcion'=>'nullable|string',
        ]);

        $servicio = Servicio::create($request->all());
        return response()->json(['message'=>'Servicio creado exitosamente','data'=>$servicio],201); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function show(Servicio $servicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function edit(Servicio $servicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $servicio = Servicio::findOrFail($id); // Buscar el servicio por su ID

        $request-> validate([
            'nombre'=>'required|string|max:255',
            'precio'=>'required|numeric',
            'duracion'=>'required|string|max:255',
            'descripcion'=>'nullable|string',
        ]);
        
        $servicio->update($request->all()); // Actualizar el servicio con los datos recibidos

        return response()->json(['message'=>'Servicio actualizado exitosamente','data'=>$servicio]); // Devolver una respuesta JSON con el servicio actualizado   
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Servicio $servicio)
    {
        //
    }
}
