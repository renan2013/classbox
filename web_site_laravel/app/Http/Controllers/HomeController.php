<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Banner;
use App\Models\Category;
use App\Models\ClientData;
use App\Models\Graduacion;
use App\Models\HomeSection;
use App\Models\PortfolioCategory;
use App\Models\PortfolioItem;
use App\Models\Post;
use App\Models\Testimonio;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Obtener secciones activas ordenadas por la posición del Page Builder
        $sections = HomeSection::where('is_active', true)->orderBy('order', 'asc')->get();

        // 2. Si no hubiera secciones configuradas, fallback a orden estándar
        if ($sections->isEmpty()) {
            $sections = collect([
                (object) ['section_key' => 'slider', 'title' => null, 'subtitle' => null, 'settings' => []],
                (object) ['section_key' => 'categories', 'title' => 'Áreas de Formación', 'subtitle' => 'Nuestras Escuelas', 'settings' => []],
                (object) ['section_key' => 'featured_posts', 'title' => 'Programas Destacados', 'subtitle' => 'Cursos Populares', 'settings' => ['limit' => 6]],
                (object) ['section_key' => 'testimonials', 'title' => 'Lo Que Dicen Nuestros Estudiantes', 'subtitle' => 'Testimonios', 'settings' => []],
            ]);
        }

        // 3. Consultar datos necesarios para los bloques
        $banners = Banner::where('is_active', true)->orderBy('order', 'asc')->get();
        $postSlides = Attachment::where('type', 'slider_image')->with('post')->whereHas('post', fn($q) => $q->where('is_published', true))->get();
        
        $categories = Category::withCount('posts')->get();
        $featured_posts = Post::with('category')->where('is_published', true)->orderBy('order', 'asc')->get();
        $testimonios = Testimonio::where('is_active', true)->latest()->get();
        $graduaciones = Graduacion::with('attachments')->latest()->take(6)->get();
        
        $portfolioCategories = PortfolioCategory::where('is_active', true)->whereHas('items', fn($q) => $q->where('is_active', true))->orderBy('order', 'asc')->get();
        $portfolioItems = PortfolioItem::with('category')->where('is_active', true)->orderBy('order', 'asc')->orderBy('created_at', 'desc')->get();
        
        $client_data = ClientData::first();

        return view('site.home', compact(
            'sections',
            'banners',
            'postSlides',
            'categories',
            'featured_posts',
            'testimonios',
            'graduaciones',
            'portfolioCategories',
            'portfolioItems',
            'client_data'
        ));
    }
}
