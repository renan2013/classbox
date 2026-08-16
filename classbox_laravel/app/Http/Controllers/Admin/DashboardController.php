<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Graduacion;
use App\Models\Matricula;
use App\Models\Post;
use App\Models\Testimonio;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'total_categories' => Category::count(),
            'total_admisiones' => Matricula::count(),
            'pending_admisiones' => Matricula::where('estado', 'pendiente')->count(),
            'total_testimonios' => Testimonio::count(),
            'total_graduaciones' => Graduacion::count(),
            'total_users' => User::count(),
        ];

        $recent_posts = Post::with('category')->latest()->take(5)->get();
        $recent_admisiones = Matricula::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_posts', 'recent_admisiones'));
    }
}
