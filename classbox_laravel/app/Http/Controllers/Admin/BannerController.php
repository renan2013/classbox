<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order', 'asc')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'image' => 'required|image|max:15360', // Máximo 15MB
            'mobile_image' => 'nullable|image|max:15360',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:255',
            'overlay_style' => 'nullable|string|max:50',
            'content_alignment' => 'nullable|string|max:20',
            'content_vertical_alignment' => 'nullable|string|max:20',
            'title_color' => 'nullable|string|max:20',
            'title_size' => 'nullable|string|max:20',
            'subtitle_color' => 'nullable|string|max:20',
            'title_weight' => 'nullable|string|max:20',
            'font_family' => 'nullable|string|max:30',
            'button_style' => 'nullable|string|max:20',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $data = $request->except(['image', 'mobile_image']);
        $data['user_id'] = Auth::id();
        $data['is_active'] = $request->boolean('is_active', true);
        $data['show_subtitle'] = $request->boolean('show_subtitle', true);
        $data['show_title'] = $request->boolean('show_title', true);
        $data['show_button'] = $request->boolean('show_button', true);
        $data['order'] = $request->input('order', 0);

        // Optimización de imagen de escritorio a WebP (1920px max)
        if ($request->hasFile('image')) {
            $data['image_path'] = ImageService::optimizeAndStore($request->file('image'), 'banners', 1920, 85);
        }

        // Optimización de imagen móvil a WebP (800px max)
        if ($request->hasFile('mobile_image')) {
            $data['mobile_image_path'] = ImageService::optimizeAndStore($request->file('mobile_image'), 'banners', 800, 85);
        }

        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner / Slider de portada creado y optimizado a WebP con éxito.');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'image' => 'nullable|image|max:15360',
            'mobile_image' => 'nullable|image|max:15360',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:255',
            'overlay_style' => 'nullable|string|max:50',
            'content_alignment' => 'nullable|string|max:20',
            'content_vertical_alignment' => 'nullable|string|max:20',
            'title_color' => 'nullable|string|max:20',
            'title_size' => 'nullable|string|max:20',
            'subtitle_color' => 'nullable|string|max:20',
            'title_weight' => 'nullable|string|max:20',
            'font_family' => 'nullable|string|max:30',
            'button_style' => 'nullable|string|max:20',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $data = $request->except(['image', 'mobile_image']);
        $data['is_active'] = $request->boolean('is_active');
        $data['show_subtitle'] = $request->boolean('show_subtitle');
        $data['show_title'] = $request->boolean('show_title');
        $data['show_button'] = $request->boolean('show_button');
        $data['order'] = $request->input('order', 0);

        if ($request->hasFile('image')) {
            if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
                Storage::disk('public')->delete($banner->image_path);
            }
            $data['image_path'] = ImageService::optimizeAndStore($request->file('image'), 'banners', 1920, 85);
        }

        if ($request->hasFile('mobile_image')) {
            if ($banner->mobile_image_path && Storage::disk('public')->exists($banner->mobile_image_path)) {
                Storage::disk('public')->delete($banner->mobile_image_path);
            }
            $data['mobile_image_path'] = ImageService::optimizeAndStore($request->file('mobile_image'), 'banners', 800, 85);
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner / Slider actualizado correctamente.');
    }

    public function toggleStatus($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->is_active = !$banner->is_active;
        $banner->save();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'is_active' => $banner->is_active]);
        }

        return back()->with('success', 'Estado del banner actualizado.');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
            Storage::disk('public')->delete($banner->image_path);
        }
        if ($banner->mobile_image_path && Storage::disk('public')->exists($banner->mobile_image_path)) {
            Storage::disk('public')->delete($banner->mobile_image_path);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner eliminado correctamente.');
    }
}
