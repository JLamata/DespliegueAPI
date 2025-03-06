<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantasModel;
use Illuminate\Support\Facades\Validator;

class PlantasController extends Controller
{
    // Listar todas las plantas
    public function listarPlantas()
    {
        $plantas = PlantasModel::all();


        if ($plantas->isEmpty()) {
            return response()->json(["message" => "No se encuentran plantas"], 200);
        }

        // converyir a array
        $plantas->each(function ($planta) {
            if ($planta->imagenes) {
                $planta->imagenes = json_decode($planta->imagenes, true); // Convertir la cadena JSON a un arreglo
            }
        });

        return response()->json(["plantas" => $plantas], 200);
    }

    // Crear una planta
    public function crearPlanta(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'categoria' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'nullable|url'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $precio = (float) $request->precio;
        $cantidad = (int) $request->cantidad;
        $imagenes = $request->imagenes ? json_encode($request->imagenes) : null;

        $planta = PlantasModel::create([
            'nombre' => $request->nombre,
            'categoria' => $request->categoria,
            'precio' => $precio,
            'cantidad' => $cantidad,
            'imagenes' => $imagenes,
        ]);

        if (!$planta) {
            return response()->json([
                'message' => 'Error al crear la planta'
            ], 500);
        }

        return response()->json([
            'message' => 'Planta creada con éxito',
            'planta' => $planta
        ], 201);
    }

    // Mostrar una planta por ID
    public function mostrarPlanta($id)
    {
        $planta = PlantasModel::find($id);

        if (!$planta) {
            return response()->json([
                'message' => 'Planta no encontrada',
                'status' => 404
            ], 404);
        }

        // hazlo array si existe
        if ($planta->imagenes) {
            $planta->imagenes = json_decode($planta->imagenes, true);
        }

        return response()->json($planta, 200);
    }


    // Eliminar una planta por ID
    public function borrarPlanta($id)
    {
        $planta = PlantasModel::find($id);

        if (!$planta) {
            return response()->json([
                'message' => 'Planta no encontrada',
                'status' => 404
            ], 404);
        }

        $planta->delete();

        return response()->json([
            'message' => 'Planta eliminada con éxito',
            'status' => 200
        ], 200);
    }

    // Modificar una planta por ID
    public function modificarPlanta(Request $request, $id)
    {
        $planta = PlantasModel::find($id);

        if (!$planta) {
            return response()->json([
                'message' => 'Planta no encontrada',
                'status' => 404
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'categoria' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'nullable|url'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $planta->nombre = $request->nombre;
        $planta->categoria = $request->categoria;
        $planta->precio = $request->precio;
        $planta->cantidad = $request->cantidad;

        if ($request->has('imagenes')) {
            $planta->imagenes = json_encode($request->imagenes);
        }

        $planta->save();

        return response()->json([
            'message' => 'Planta modificada con éxito',
            'planta' => $planta
        ], 200);
    }

    public function filtrar(Request $request){
            // termino introducido vacio? --> listar 
        if (!$request->has('buscar')) {
            return $this->listarPlantas();
        }

        $busqueda = $request->buscar;

        $plantas = PlantasModel::where('nombre', 'like', '%' . $busqueda . '%')
            ->orWhere('categoria', 'like', '%' . $busqueda . '%')
            ->get();

        //resultados vacio??
        if ($plantas->isEmpty()) {
            return response()->json(["message" => "No se encontraron plantas"], 200);
        }

        //array img
        $plantas->each(function ($planta) {
            if ($planta->imagenes) {
                $planta->imagenes = json_decode($planta->imagenes, true);
            }
        });

        return response()->json(["plantas" => $plantas], 200);
    }

}
