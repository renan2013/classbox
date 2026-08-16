<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('posts')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'image' => 'nullable|image|max:10240',
        ]);

        $data = ['name' => $request->name];

        if ($request->hasFile('image')) {
            $data['image'] = ImageService::optimizeAndStore($request->file('image'), 'categories', 800, 80);
        }

        Category::create($data);

        return back()->with('success', 'Categoría creada con éxito con imagen optimizada.');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'image' => 'nullable|image|max:10240',
        ]);

        $category->name = $request->name;

        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $category->image = ImageService::optimizeAndStore($request->file('image'), 'categories', 800, 80);
        }

        $category->save();

        return back()->with('success', 'Categoría actualizada.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }
        $category->delete();

        return back()->with('success', 'Categoría eliminada.');
    }
}
