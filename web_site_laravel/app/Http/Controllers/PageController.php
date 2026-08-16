<?php

namespace App\Http\Controllers;

use App\Models\ClientData;
use App\Models\Post;
use App\Models\Testimonio;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $client_data = ClientData::first();
        return view('site.about', compact('client_data'));
    }

    public function team()
    {
        $instructors = Post::where('show_in_instructors', true)->whereNotNull('instructor_name')->where('instructor_name', '!=', '')->get();
        return view('site.team', compact('instructors'));
    }

    public function testimonials()
    {
        $testimonios = Testimonio::where('is_active', true)->latest()->paginate(9);
        return view('site.testimonials', compact('testimonios'));
    }
}
