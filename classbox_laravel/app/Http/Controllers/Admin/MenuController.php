<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Page;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

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
            'url' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:menus,id',
            'target' => 'nullable|string|in:_self,_blank',
            'page_content' => 'nullable|string',
        ]);

        $url = trim($request->url ?? '');
        $title = trim($request->title);
        $hasContent = $request->filled('page_content');

        // Si se ingresó contenido HTML o la URL apunta a /pagina/... o se dejó vacía para auto-generar
        if ($hasContent || empty($url) || str_starts_with($url, '/pagina/')) {
            $slug = \Illuminate\Support\Str::slug($title);
            if (!empty($url) && str_starts_with($url, '/pagina/')) {
                $customSlug = ltrim(str_replace('/pagina/', '', $url), '/');
                if (!empty($customSlug)) {
                    $slug = $customSlug;
                }
            }
            if (empty($slug)) {
                $slug = 'pagina-' . time();
            }

            // Crear o actualizar la página con el HTML
            Page::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'content' => $request->page_content ?? '',
                    'is_published' => true,
                    'user_id' => auth()->id() ?? 1,
                ]
            );

            $url = '/pagina/' . $slug;
        }

        Menu::create([
            'title' => $title,
            'url' => $url ?: '/',
            'display_order' => $request->display_order ?? 0,
            'parent_id' => $request->parent_id,
            'target' => $request->target ?? '_self',
            'is_active' => true,
        ]);

        return back()->with('success', 'Elemento de menú y su página creados exitosamente.');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $all_parents = Menu::whereNull('parent_id')->where('id', '!=', $id)->orderBy('display_order', 'asc')->get();
        $custom_pages = Page::where('is_published', true)->orderBy('title', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();

        // Buscar contenido HTML de la página si es una página dinámica
        $pageContent = null;
        if (str_starts_with($menu->url, '/pagina/')) {
            $slug = ltrim(str_replace('/pagina/', '', $menu->url), '/');
            $page = Page::where('slug', $slug)->first();
            $pageContent = $page?->content;
        }

        return view('admin.menus.edit', compact('menu', 'all_parents', 'custom_pages', 'categories', 'pageContent'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:100',
            'url' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:menus,id',
            'target' => 'nullable|string|in:_self,_blank',
            'page_content' => 'nullable|string',
        ]);

        $url = trim($request->url ?? '');
        $title = trim($request->title);
        $hasContent = $request->has('page_content');

        if ($hasContent || str_starts_with($url, '/pagina/') || empty($url)) {
            $slug = \Illuminate\Support\Str::slug($title);
            if (!empty($url) && str_starts_with($url, '/pagina/')) {
                $customSlug = ltrim(str_replace('/pagina/', '', $url), '/');
                if (!empty($customSlug)) {
                    $slug = $customSlug;
                }
            }
            if (empty($slug)) {
                $slug = 'pagina-' . time();
            }

            if ($hasContent) {
                Page::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'title' => $title,
                        'content' => $request->page_content ?? '',
                        'is_published' => true,
                        'user_id' => auth()->id() ?? 1,
                    ]
                );
                $url = '/pagina/' . $slug;
            }
        }

        $menu->update([
            'title' => $title,
            'url' => $url ?: '/',
            'display_order' => $request->display_order ?? 0,
            'parent_id' => $request->parent_id,
            'target' => $request->target ?? '_self',
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : $menu->is_active,
        ]);

        return redirect()->route('admin.menus.index')->with('success', 'Menú y contenido de página actualizados exitosamente.');
    }

    public function toggleStatus($id)
    {
        try {
            if (Schema::hasTable('menus') && !Schema::hasColumn('menus', 'is_active')) {
                Schema::table('menus', function (Blueprint $table) {
                    $table->boolean('is_active')->default(true)->after('target');
                });
                Menu::whereNull('is_active')->update(['is_active' => true]);
            }
        } catch (\Throwable $e) {
            // Ignorar si ya existe
        }

        $menu = Menu::findOrFail($id);
        $current = ($menu->is_active !== null) ? (bool)$menu->is_active : true;
        $menu->is_active = !$current;
        $menu->save();

        $statusText = $menu->is_active ? 'visible en el sitio web' : 'oculto del sitio web';
        return back()->with('success', "Menú '{$menu->title}' ahora está {$statusText}.");
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $systemUrls = ['', '/', '#', '/graduaciones', '/quienes-somos', '/docentes', '/testimonios', '/contacto', '/portafolio', '/sobre-nosotros', '/about'];

        if (in_array(rtrim($menu->url, '/'), $systemUrls) || str_starts_with($menu->url, '/categoria/')) {
            return back()->with('error', "El menú '{$menu->title}' es una página base del sistema y no se puede eliminar. Puedes ocultarlo del sitio web haciendo clic en el icono del ojo.");
        }

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

