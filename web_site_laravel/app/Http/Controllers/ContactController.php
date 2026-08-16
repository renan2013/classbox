<?php

namespace App\Http\Controllers;

use App\Models\ClientData;
use App\Models\Matricula;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $client_data = ClientData::first();
        return view('site.contact', compact('client_data'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:50',
            'programa' => 'nullable|string|max:255',
            'nacionalidad' => 'nullable|string|max:100',
        ]);

        Matricula::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'programa' => $request->programa ?? 'Contacto Web',
            'nacionalidad' => $request->nacionalidad ?? 'Costarricense',
            'codigo_pais' => '506',
            'estado' => 'pendiente',
        ]);

        return back()->with('success', '¡Muchas gracias por contactarnos! Hemos recibido tu solicitud y un asesor se comunicará contigo por WhatsApp o correo a la brevedad.');
    }
}
