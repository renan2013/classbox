<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $pages = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|max:10240',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_published' => 'nullable|boolean',
        ]);

        $data = $request->except(['featured_image']);
        $data['user_id'] = Auth::id();
        $data['is_published'] = $request->boolean('is_published', true);
        $data['slug'] = Str::slug($request->filled('slug') ? $request->slug : $request->title);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = ImageService::optimizeAndStore($request->file('featured_image'), 'pages', 1400, 82);
        }

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'Página estática creada exitosamente.');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $id,
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|max:10240',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_published' => 'nullable|boolean',
        ]);

        $data = $request->except(['featured_image']);
        $data['is_published'] = $request->boolean('is_published');
        $data['slug'] = Str::slug($request->filled('slug') ? $request->slug : $request->title);

        if ($request->hasFile('featured_image')) {
            if ($page->featured_image && Storage::disk('public')->exists($page->featured_image)) {
                Storage::disk('public')->delete($page->featured_image);
            }
            $data['featured_image'] = ImageService::optimizeAndStore($request->file('featured_image'), 'pages', 1400, 82);
        }

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Página actualizada correctamente.');
    }

    public function toggleStatus($id)
    {
        $page = Page::findOrFail($id);
        $page->is_published = !$page->is_published;
        $page->save();

        $statusText = $page->is_published ? 'publicada (visible)' : 'en borrador (oculta)';
        return back()->with('success', "Página '{$page->title}' ahora está {$statusText}.");
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $systemSlugs = ['quienes-somos', 'sobre-nosotros', 'about', 'contacto', 'docentes', 'testimonios', 'graduaciones', 'portafolio', 'inicio'];

        if (in_array($page->slug, $systemSlugs)) {
            return back()->with('error', "La página '{$page->title}' es una página base del sistema y no se puede eliminar. Puedes ocultarla cambiando su estado a Borrador con el botón del ojo.");
        }

        if ($page->featured_image && Storage::disk('public')->exists($page->featured_image)) {
            Storage::disk('public')->delete($page->featured_image);
        }

        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Página eliminada.');
    }
}
