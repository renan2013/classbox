<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use Illuminate\Http\Request;

class HomeSectionController extends Controller
{
    public function index()
    {
        $sections = HomeSection::orderBy('order', 'asc')->get();
        return view('admin.home_sections.index', compact('sections'));
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:home_sections,id',
        ]);

        foreach ($request->order as $index => $id) {
            HomeSection::where('id', $id)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true, 'message' => 'Orden de la portada actualizado con éxito.']);
    }

    public function toggleStatus($id)
    {
        $section = HomeSection::findOrFail($id);
        $section->is_active = !$section->is_active;
        $section->save();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $section->is_active,
                'message' => 'Sección ' . ($section->is_active ? 'activada' : 'pausada') . ' en la portada.'
            ]);
        }

        return back()->with('success', 'Estado de la sección actualizado.');
    }

    public function update(Request $request, $id)
    {
        $section = HomeSection::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'limit' => 'nullable|integer|min:1|max:50',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:255',
            'custom_html' => 'nullable|string',
            'background_color' => 'nullable|string|max:50',
        ]);

        $settings = $section->settings ?? [];
        if ($request->filled('limit')) $settings['limit'] = (int) $request->limit;
        if ($request->has('button_text')) $settings['button_text'] = $request->button_text;
        if ($request->has('button_url')) $settings['button_url'] = $request->button_url;
        if ($request->has('custom_html')) $settings['custom_html'] = $request->custom_html;
        if ($request->has('background_color')) $settings['background_color'] = $request->background_color;

        $section->update([
            'name' => $request->name,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'settings' => $settings,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'section' => $section]);
        }

        return back()->with('success', 'Configuración de la sección guardada.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'section_key' => 'required|string|max:50',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
        ]);

        $maxOrder = HomeSection::max('order') ?? 0;

        $section = HomeSection::create([
            'section_key' => $request->section_key,
            'name' => $request->name,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'order' => $maxOrder + 1,
            'is_active' => true,
            'settings' => [],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'section' => $section,
                'message' => 'Nueva sección agregada a la portada con éxito.'
            ]);
        }

        return redirect()->route('admin.home_sections.index')->with('success', 'Nueva sección agregada a la portada.');
    }

    public function destroy($id)
    {
        $section = HomeSection::findOrFail($id);
        $section->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Sección eliminada de la portada.');
    }
}
