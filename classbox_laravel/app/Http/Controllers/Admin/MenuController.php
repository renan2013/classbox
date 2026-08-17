<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Page;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('children')->whereNull('parent_id')->orderBy('display_order', 'asc')->get();
        
        // Auto-inicializar menús predeterminados si la tabla está vacía
        if ($menus->isEmpty()) {
            $this->createDefaultMenus();
            $menus = Menu::with('children')->whereNull('parent_id')->orderBy('display_order', 'asc')->get();
        }

        $all_parents = Menu::whereNull('parent_id')->orderBy('display_order', 'asc')->get();
        $custom_pages = Page::where('is_published', true)->orderBy('title', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.menus.index', compact('menus', 'all_parents', 'custom_pages', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'display_order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:menus,id',
            'target' => 'nullable|string|in:_self,_blank',
        ]);

        Menu::create([
            'title' => $request->title,
            'url' => $request->url,
            'display_order' => $request->display_order ?? 0,
            'parent_id' => $request->parent_id,
            'target' => $request->target ?? '_self',
        ]);

        return back()->with('success', 'Elemento de menú creado exitosamente.');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $all_parents = Menu::whereNull('parent_id')->where('id', '!=', $id)->orderBy('display_order', 'asc')->get();
        $custom_pages = Page::where('is_published', true)->orderBy('title', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.menus.edit', compact('menu', 'all_parents', 'custom_pages', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'display_order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:menus,id',
            'target' => 'nullable|string|in:_self,_blank',
        ]);

        $menu->update([
            'title' => $request->title,
            'url' => $request->url,
            'display_order' => $request->display_order ?? 0,
            'parent_id' => $request->parent_id,
            'target' => $request->target ?? '_self',
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : $menu->is_active,
        ]);

        return redirect()->route('admin.menus.index')->with('success', 'Menú actualizado exitosamente.');
    }

    public function toggleStatus($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->is_active = !$menu->is_active;
        $menu->save();

        $statusText = $menu->is_active ? 'visible en el sitio web' : 'oculto del sitio web';
        return back()->with('success', "Menú '{$menu->title}' ahora está {$statusText}.");
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        // Eliminar submenús asociados si existen
        $menu->children()->delete();
        $menu->delete();

        return back()->with('success', 'Menú eliminado.');
    }

    public function seedDefaults()
    {
        Menu::truncate();
        $this->createDefaultMenus();

        return back()->with('success', 'Se ha restaurado la estructura de menús predeterminada del sitio web.');
    }

    private function createDefaultMenus(): void
    {
        // 1. Inicio
        Menu::create([
            'title' => 'Inicio',
            'url' => '/',
            'display_order' => 1,
            'parent_id' => null,
            'target' => '_self',
        ]);

        // 2. Escuelas / Categorías (Dropdown)
        $escuelasMenu = Menu::create([
            'title' => 'Escuelas',
            'url' => '#',
            'display_order' => 2,
            'parent_id' => null,
            'target' => '_self',
        ]);

        $categories = Category::orderBy('id', 'asc')->get();
        if ($categories->isNotEmpty()) {
            $catOrder = 1;
            foreach ($categories as $cat) {
                Menu::create([
                    'title' => $cat->name,
                    'url' => '/categoria/' . $cat->id,
                    'display_order' => $catOrder++,
                    'parent_id' => $escuelasMenu->id,
                    'target' => '_self',
                ]);
            }
        }

        // 3. Graduaciones
        Menu::create([
            'title' => 'Graduaciones',
            'url' => '/graduaciones',
            'display_order' => 3,
            'parent_id' => null,
            'target' => '_self',
        ]);

        // 4. Quiénes Somos
        Menu::create([
            'title' => 'Quiénes Somos',
            'url' => '/quienes-somos',
            'display_order' => 4,
            'parent_id' => null,
            'target' => '_self',
        ]);

        // 5. Docentes
        Menu::create([
            'title' => 'Docentes',
            'url' => '/docentes',
            'display_order' => 5,
            'parent_id' => null,
            'target' => '_self',
        ]);

        // 6. Testimonios
        Menu::create([
            'title' => 'Testimonios',
            'url' => '/testimonios',
            'display_order' => 6,
            'parent_id' => null,
            'target' => '_self',
        ]);

        // 7. Contacto
        Menu::create([
            'title' => 'Contacto',
            'url' => '/contacto',
            'display_order' => 7,
            'parent_id' => null,
            'target' => '_self',
        ]);
    }
}

