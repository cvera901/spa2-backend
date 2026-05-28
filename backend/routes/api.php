<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ReservaController;



/*
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('clientes', ClienteController::class); // Ruta para el recurso de clientes
Route::apiResource('servicios', ServicioController::class); // Ruta para el recurso de servicios
Route::apiResource('empleados', EmpleadoController::class); // Ruta para el recurso de empleados
Route::apiResource('reservas', ReservaController::class); // Ruta para el recurso de reservas

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}


);
