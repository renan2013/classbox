<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('posts')->get();
        $query = Post::with(['category', 'attachments'])->where('is_published', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('synopsis', 'like', "%{$search}%");
            });
        }

        $posts = $query->orderBy('order', 'asc')->orderBy('created_at', 'desc')->paginate(12);

        return view('site.courses_index', compact('categories', 'posts'));
    }

    public function byCategory($id)
    {
        $category = Category::withCount('posts')->findOrFail($id);
        $posts = Post::with(['category', 'attachments'])
                     ->where('category_id', $id)
                     ->where('is_published', true)
                     ->orderBy('order', 'asc')
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('site.category_courses', compact('category', 'posts'));
    }

    public function show($id)
    {
        $post = Post::with(['category', 'attachments'])->findOrFail($id);
        $related_posts = Post::where('category_id', $post->category_id)
                             ->where('id', '!=', $post->id)
                             ->take(4)
                             ->get();

        $pdf_attachments = $post->attachments->where('type', 'pdf');
        $youtube_attachments = $post->attachments->where('type', 'youtube');
        $gallery_images = $post->attachments->whereIn('type', ['gallery_image', 'slider_image']);

        return view('site.course_detail', compact('post', 'related_posts', 'pdf_attachments', 'youtube_attachments', 'gallery_images'));
    }
}
