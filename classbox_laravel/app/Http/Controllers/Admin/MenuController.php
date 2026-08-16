<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('children')->whereNull('parent_id')->orderBy('display_order', 'asc')->get();
        $all_parents = Menu::whereNull('parent_id')->get();

        return view('admin.menus.index', compact('menus', 'all_parents'));
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

        return back()->with('success', 'Elemento de menú creado.');
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
        ]);

        return back()->with('success', 'Menú actualizado.');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return back()->with('success', 'Menú eliminado.');
    }
}
