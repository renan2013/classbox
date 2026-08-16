<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['category', 'attachments', 'author']);

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('synopsis', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->boolean('instructors_only')) {
            $query->where('show_in_instructors', true);
        }

        $limit = $request->input('limit', 20);
        $posts = $query->orderBy('order', 'asc')->orderBy('created_at', 'desc')->paginate($limit);

        return response()->json([
            'success' => true,
            'data' => $posts->items(),
            'meta' => [
                'current_page' => $posts->currentPage(),
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'last_page' => $posts->lastPage(),
            ]
        ]);
    }

    public function show($id)
    {
        $post = Post::with(['category', 'attachments', 'author'])->find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Publicación no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $post
        ]);
    }
}
