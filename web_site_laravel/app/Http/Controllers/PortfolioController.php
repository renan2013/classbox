<?php

namespace App\Http\Controllers;

use App\Models\PortfolioCategory;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $categories = PortfolioCategory::where('is_active', true)
            ->whereHas('items', function($q) {
                $q->where('is_active', true);
            })
            ->orderBy('order', 'asc')
            ->get();

        $query = PortfolioItem::with('category')
            ->where('is_active', true)
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc');

        if ($request->filled('categoria')) {
            $slug = $request->categoria;
            $query->whereHas('category', function($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }

        $items = $query->get();

        return view('site.portfolio.index', compact('categories', 'items'));
    }
}
