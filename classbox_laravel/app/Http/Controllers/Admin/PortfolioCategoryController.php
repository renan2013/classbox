<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PortfolioCategoryController extends Controller
{
    public function index()
    {
        $categories = PortfolioCategory::withCount('items')->orderBy('order', 'asc')->get();
        return view('admin.portfolio.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (PortfolioCategory::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        PortfolioCategory::create([
            'name' => $request->name,
            'slug' => $slug,
            'order' => $request->input('order', 0),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.portfolio.categories.index')->with('success', 'Categoría de portafolio creada con éxito.');
    }

    public function update(Request $request, $id)
    {
        $category = PortfolioCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $slug = Str::slug($request->name);
        if ($slug !== $category->slug) {
            $originalSlug = $slug;
            $count = 1;
            while (PortfolioCategory::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = "{$originalSlug}-{$count}";
                $count++;
            }
        }

        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'order' => $request->input('order', 0),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.portfolio.categories.index')->with('success', 'Categoría de portafolio actualizada con éxito.');
    }

    public function destroy($id)
    {
        $category = PortfolioCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.portfolio.categories.index')->with('success', 'Categoría de portafolio eliminada con éxito.');
    }
}
