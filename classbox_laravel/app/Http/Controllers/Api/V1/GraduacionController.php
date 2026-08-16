<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Graduacion;
use Illuminate\Http\Request;

class GraduacionController extends Controller
{
    public function index()
    {
        $graduaciones = Graduacion::with('attachments')->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $graduaciones
        ]);
    }

    public function show($id)
    {
        $graduacion = Graduacion::with('attachments')->find($id);

        if (!$graduacion) {
            return response()->json([
                'success' => false,
                'message' => 'Graduación no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $graduacion
        ]);
    }
}
