<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Matricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdmisionController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:50',
            'programa' => 'nullable|string|max:255',
            'nacionalidad' => 'nullable|string|max:100',
            'codigo_pais' => 'nullable|string|max:10',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $matricula = Matricula::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'programa' => $request->programa ?? 'Admisión General',
            'nacionalidad' => $request->nacionalidad ?? 'Costarricense',
            'codigo_pais' => $request->codigo_pais ?? '506',
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'estado' => 'pendiente',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Solicitud de admisión registrada exitosamente.',
            'data' => $matricula
        ], 201);
    }
}
