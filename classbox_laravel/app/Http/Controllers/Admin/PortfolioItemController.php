<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioCategory;
use App\Models\PortfolioItem;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioItemController extends Controller
{
    public function index(Request $request)
    {
        $query = PortfolioItem::with('category')->orderBy('order', 'asc')->orderBy('created_at', 'desc');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $items = $query->paginate(15);
        $categories = PortfolioCategory::orderBy('order', 'asc')->get();

        return view('admin.portfolio.items.index', compact('items', 'categories'));
    }

    public function create()
    {
        $categories = PortfolioCategory::where('is_active', true)->orderBy('order', 'asc')->get();
        return view('admin.portfolio.items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:portfolio_categories,id',
            'client_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:15360', // 15MB max
            'project_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->except('image');
        $data['is_active'] = $request->boolean('is_active', true);
        $data['order'] = $request->input('order', 0);

        // Optimizar a WebP (1200px max, calidad 85)
        if ($request->hasFile('image')) {
            $data['image_path'] = ImageService::optimizeAndStore($request->file('image'), 'portfolio', 1200, 85);
        }

        PortfolioItem::create($data);

        return redirect()->route('admin.portfolio.items.index')->with('success', 'Trabajo del portafolio guardado y optimizado a WebP con éxito.');
    }

    public function edit($id)
    {
        $item = PortfolioItem::findOrFail($id);
        $categories = PortfolioCategory::orderBy('order', 'asc')->get();
        return view('admin.portfolio.items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $item = PortfolioItem::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:portfolio_categories,id',
            'client_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:15360',
            'project_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->except('image');
        $data['is_active'] = $request->boolean('is_active');
        $data['order'] = $request->input('order', 0);

        if ($request->hasFile('image')) {
            if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
                Storage::disk('public')->delete($item->image_path);
            }
            $data['image_path'] = ImageService::optimizeAndStore($request->file('image'), 'portfolio', 1200, 85);
        }

        $item->update($data);

        return redirect()->route('admin.portfolio.items.index')->with('success', 'Trabajo del portafolio actualizado con éxito.');
    }

    public function destroy($id)
    {
        $item = PortfolioItem::findOrFail($id);

        if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
            Storage::disk('public')->delete($item->image_path);
        }

        $item->delete();

        return redirect()->route('admin.portfolio.items.index')->with('success', 'Trabajo del portafolio eliminado con éxito.');
    }
}
