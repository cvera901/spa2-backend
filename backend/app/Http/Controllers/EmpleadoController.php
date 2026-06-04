<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleado = Empleado::latest()->get(); // obtener todos los datos de la tabla empleados ordenados por fecha de creación de forma descendente
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
            'cedula_ruc'=>'required|string|max:255|unique:empleados,cedula_ruc', // Validar que la cédula sea única en la tabla empleados
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
        return response()->json($empleado); // Devolver una respuesta JSON con los datos del empleado encontrado

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
    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'cedula_ruc' => ['required', 'string', 'max:255', Rule::unique('empleados', 'cedula_ruc')->ignore($empleado->id)],  
            // Validar que la cédula sea única en la tabla empleados, excluyendo el empleado actual
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'especialidad' => 'required|string|max:255',
        ]);

        $empleado->update($request->all()); // Actualizar el empleado con los datos recibidos en la solicitud
        return response()->json(['message'=>'Empleado actualizado exitosamente','data'=>$empleado],200); // Devolver una respuesta JSON con el empleado actualizado y un código de estado 200 (OK)  
    }
        

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado)
    {
        if($empleado->reservas()->exists()) { // Verificar si el empleado tiene reservas asociadas antes de eliminarlo
            return response()->json(['message'=>'No se puede eliminar el empleado porque tiene reservas asociadas'], 400); // Devolver una respuesta JSON con un mensaje de error y un código de estado 400 (Bad Request)
        }
        $empleado->delete();
        return response()->json(['message'=>'Empleado eliminado exitosamente'], 200); // Devolver una respuesta JSON con un mensaje de éxito y un código de estado 200 (OK) 
    }
}
