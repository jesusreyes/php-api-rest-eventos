<?php

namespace App\Http\Controllers;

use App\Models\Ponente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PonenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $ponentes = Ponente::all();

        $respuesta = [
            'ponentes' => $ponentes,
            'status' => 200,
        ];
        return response()->json($respuesta);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'biografia' => 'required',
            'especialidad' => 'required',
        ]);

        if ($validator->fails()) {
            $respuesta = [
                'mensaje' => 'Datos faltantes',
                'status' => 400, // Petición inválida
            ];
            return response()->json($respuesta, 400);
        }

        $ponente = Ponente::create([
            'nombre' => $request->nombre,
            'biografia' => $request->biografia,
            'especialidad' => $request->especialidad,
        ]);

        if (!$ponente) {
            $respuesta = [
                'mensaje' => 'Error al crear el ponente',
                'status' => 500, // Error interno del servidor
            ];
            return response()->json($respuesta, 500);
        }

        $respuesta = [
            'ponente' => $ponente,
            'status' => 201, // Creación exitosa
        ];

        return response()->json($respuesta, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ponente = Ponente::find($id);

        if (!$ponente) {
            $respuesta = [
                'mensaje' => 'Ponente no encontrado',
                'status' => 404, // No encontrado
            ];
            return response()->json($respuesta, 404);
        }

        $respuesta = [
            'ponente' => $ponente,
            'status' => 200,
        ];
        return response()->json($respuesta);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $ponente = Ponente::find($id);

        if (!$ponente) {
            $respuesta = [
                'mensaje' => 'Ponente no encontrado',
                'status' => 404, // No encontrado
            ];
            return response()->json($respuesta, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'biografia' => 'required',
            'especialidad' => 'required',
        ]);

        if ($validator->fails()) {
            $respuesta = [
                'mensaje' => 'Datos faltantes',
                'status' => 400, // Petición inválida
            ];
            return response()->json($respuesta, 400);
        }

        $ponente->nombre = $request->nombre;
        $ponente->biografia = $request->biografia;
        $ponente->especialidad = $request->especialidad;
        $ponente->save();

        $respuesta = [
            'ponente' => $ponente,
            'status' => 200, // Actualización exitosa
        ];

        return response()->json($respuesta, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ponente = Ponente::find($id);

        if (!$ponente) {
            $respuesta = [
                'mensaje' => 'Ponente no encontrado',
                'status' => 404, // No encontrado
            ];
            return response()->json($respuesta, 404);
        }

        $ponente->delete();

        $respuesta = [
            'mensaje' => 'Ponente eliminado',
            'status' => 200,
        ];

        return response()->json($respuesta, 200);
    }
}
