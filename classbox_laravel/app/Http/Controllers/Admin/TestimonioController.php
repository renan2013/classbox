<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonio;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonioController extends Controller
{
    public function index()
    {
        $testimonios = Testimonio::latest()->paginate(15);
        return view('admin.testimonios.index', compact('testimonios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'profesion' => 'nullable|string|max:255',
            'comentario' => 'required|string',
            'video_iframe' => 'nullable|string',
            'foto' => 'nullable|image|max:10240',
        ]);

        $data = $request->except(['foto']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('foto')) {
            $data['foto'] = ImageService::optimizeAndStore($request->file('foto'), 'testimonios', 500, 80);
        }

        Testimonio::create($data);

        return back()->with('success', 'Testimonio registrado con éxito con foto optimizada.');
    }

    public function update(Request $request, $id)
    {
        $testimonio = Testimonio::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'profesion' => 'nullable|string|max:255',
            'comentario' => 'required|string',
            'video_iframe' => 'nullable|string',
            'foto' => 'nullable|image|max:10240',
        ]);

        $data = $request->except(['foto']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('foto')) {
            if ($testimonio->foto && Storage::disk('public')->exists($testimonio->foto)) {
                Storage::disk('public')->delete($testimonio->foto);
            }
            $data['foto'] = ImageService::optimizeAndStore($request->file('foto'), 'testimonios', 500, 80);
        }

        $testimonio->update($data);

        return back()->with('success', 'Testimonio actualizado.');
    }

    public function destroy($id)
    {
        $testimonio = Testimonio::findOrFail($id);
        if ($testimonio->foto && Storage::disk('public')->exists($testimonio->foto)) {
            Storage::disk('public')->delete($testimonio->foto);
        }
        $testimonio->delete();

        return back()->with('success', 'Testimonio eliminado.');
    }
}
