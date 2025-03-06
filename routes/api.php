<?php

use App\Http\Controllers\PlantasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/


//READ
/* Route::get('/plantas', function () {    //localhost:8000/api/plantas
    return "Lista Plantas";
}); */
Route::get('/plantas',[PlantasController::class, 'listarPlantas']);


//READ SOLO 1
/* Route::get('/plantas/{id}', function () {
    return "Lista Planta";
}); */
Route::get('/plantas/{id}',[PlantasController::class, 'mostrarPlanta']);

//CREATE
/* Route::post('/plantas', function () {
    return "Creando Plantas";
}); */
Route::post('/plantas',[PlantasController::class, 'crearPlanta']);

//UPDATE SOLO 1
/* Route::put('/plantas/{id}', function () {
    return "Actualizando Planta";
}); */
Route::put('/plantas/{id}', [PlantasController::class, 'modificarPlanta']);
//DELETE
/* Route::delete('/plantas/{id}', function () {
    return "Borrando Planta";
}); */
Route::delete('/plantas/{id}',[PlantasController::class, 'borrarPlanta']);

//Barra de busqueda
Route::get('/plantas', [PlantasController::class, 'filtrar']);
