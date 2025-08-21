<?php

namespace App\Http\Controllers;

use App\Models\Asistente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AsistenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asistentes = Asistente::all();

        $respuesta = [
            'asistentes' => $asistentes,
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
            'email' => 'required|email',
            'telefono' => 'required',
            'evento_id' => 'required',
        ]);

        if ($validator->fails()) {
            $respuesta = [
                'mensaje' => 'Datos faltantes o inválidos',
                'status' => 400, // Petición inválida
            ];
            return response()->json($respuesta, 400);
        }

        $asistente = Asistente::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'evento_id' => $request->evento_id,
        ]);

        if (!$asistente) {
            $respuesta = [
                'mensaje' => 'Error al crear el asistente',
                'status' => 500, // Error interno del servidor
            ];
            return response()->json($respuesta, 500);
        }

        $respuesta = [
            'asistente' => $asistente,
            'status' => 201, // Creación exitosa
        ];
        return response()->json($respuesta, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $asistente = Asistente::find($id);

        if (!$asistente) {
            $respuesta = [
                'mensaje' => 'Asistente no encontrado',
                'status' => 404, // No encontrado
            ];
            return response()->json($respuesta, 404);
        }

        $respuesta = [
            'asistente' => $asistente,
            'status' => 200,
        ];
        return response()->json($respuesta);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $asistente = Asistente::find($id);

        if (!$asistente) {
            $respuesta = [
                'mensaje' => 'Asistente no encontrado',
                'status' => 404, // No encontrado
            ];
            return response()->json($respuesta, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'email' => 'required|email',
            'telefono' => 'required',
            'evento_id' => 'required|exists:eventos,id',
        ]);

        if ($validator->fails()) {
            $respuesta = [
                'mensaje' => 'Datos faltantes o inválidos',
                'status' => 400, // Petición inválida
            ];
            return response()->json($respuesta, 400);
        }

        $asistente->nombre = $request->nombre;
        $asistente->email = $request->email;
        $asistente->telefono = $request->telefono;
        $asistente->evento_id = $request->evento_id;
        $asistente->save();

        $respuesta = [
            'asistente' => $asistente,
            'status' => 200, // Actualización exitosa
        ];
        return response()->json($respuesta, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $asistente = Asistente::find($id);

        if (!$asistente) {
            $respuesta = [
                'mensaje' => 'Asistente no encontrado',
                'status' => 404, // No encontrado
            ];
            return response()->json($respuesta, 404);
        }

        $asistente->delete();

        $respuesta = [
            'mensaje' => 'Asistente eliminado exitosamente',
            'status' => 200,
        ];
        return response()->json($respuesta);
    }

}
