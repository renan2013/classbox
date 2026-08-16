<?php

namespace App\Http\Controllers;

use App\Models\Graduacion;
use Illuminate\Http\Request;

class GraduacionController extends Controller
{
    public function index()
    {
        $graduaciones = Graduacion::with('attachments')->latest()->paginate(9);
        return view('site.graduaciones', compact('graduaciones'));
    }

    public function show($id)
    {
        $graduacion = Graduacion::with('attachments')->findOrFail($id);
        $other_graduations = Graduacion::where('id', '!=', $id)->latest()->take(3)->get();

        return view('site.graduacion_detail', compact('graduacion', 'other_graduations'));
    }
}
