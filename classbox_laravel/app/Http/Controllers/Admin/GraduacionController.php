<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Graduacion;
use App\Models\GraduacionAttachment;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GraduacionController extends Controller
{
    public function index()
    {
        $graduaciones = Graduacion::with('attachments')->latest()->paginate(15);
        return view('admin.graduaciones.index', compact('graduaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'synopsis' => 'nullable|string',
            'video_url' => 'nullable|string',
            'main_image' => 'nullable|image|max:10240',
            'photos.*' => 'nullable|image|max:10240',
        ]);

        $data = $request->except(['main_image', 'photos']);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('main_image')) {
            $data['main_image'] = ImageService::optimizeAndStore($request->file('main_image'), 'graduaciones', 1400, 80);
        }

        $graduacion = Graduacion::create($data);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = ImageService::optimizeAndStore($file, 'graduaciones_gallery', 1400, 80);
                GraduacionAttachment::create([
                    'graduacion_id' => $graduacion->id,
                    'type' => 'gallery_image',
                    'value' => $path,
                    'file_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp',
                ]);
            }
        }

        return back()->with('success', 'Graduación registrada con éxito e imágenes optimizadas en WebP.');
    }

    public function update(Request $request, $id)
    {
        $graduacion = Graduacion::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'synopsis' => 'nullable|string',
            'video_url' => 'nullable|string',
            'main_image' => 'nullable|image|max:10240',
            'photos.*' => 'nullable|image|max:10240',
        ]);

        $data = $request->except(['main_image', 'photos']);

        if ($request->hasFile('main_image')) {
            if ($graduacion->main_image && Storage::disk('public')->exists($graduacion->main_image)) {
                Storage::disk('public')->delete($graduacion->main_image);
            }
            $data['main_image'] = ImageService::optimizeAndStore($request->file('main_image'), 'graduaciones', 1400, 80);
        }

        $graduacion->update($data);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = ImageService::optimizeAndStore($file, 'graduaciones_gallery', 1400, 80);
                GraduacionAttachment::create([
                    'graduacion_id' => $graduacion->id,
                    'type' => 'gallery_image',
                    'value' => $path,
                    'file_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp',
                ]);
            }
        }

        return back()->with('success', 'Graduación actualizada con éxito.');
    }

    public function destroy($id)
    {
        $graduacion = Graduacion::findOrFail($id);
        if ($graduacion->main_image && Storage::disk('public')->exists($graduacion->main_image)) {
            Storage::disk('public')->delete($graduacion->main_image);
        }
        $graduacion->delete();

        return back()->with('success', 'Graduación eliminada.');
    }

    public function deleteAttachment($id)
    {
        $attachment = GraduacionAttachment::findOrFail($id);
        if (Storage::disk('public')->exists($attachment->value)) {
            Storage::disk('public')->delete($attachment->value);
        }
        $attachment->delete();

        return back()->with('success', 'Foto de graduación eliminada.');
    }
}
