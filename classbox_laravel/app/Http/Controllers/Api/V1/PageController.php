<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::where('is_published', true)
            ->select(['id', 'title', 'slug', 'featured_image', 'meta_title', 'meta_description', 'created_at'])
            ->orderBy('title', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $pages,
        ]);
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return response()->json([
            'status' => 'success',
            'data' => $page,
        ]);
    }
}
