<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Slides vinculados directamente a publicaciones / cursos
        $postSlides = Attachment::where('type', 'slider_image')
            ->with(['post:id,title,slug,synopsis,is_published'])
            ->whereHas('post', function ($q) {
                $q->where('is_published', true);
            })
            ->get()
            ->map(function ($att) {
                return [
                    'id' => 'post_slide_' . $att->id,
                    'title' => $att->post->title,
                    'subtitle' => $att->post->synopsis,
                    'image_url' => asset('storage/' . $att->value),
                    'mobile_image_url' => asset('storage/' . $att->value),
                    'button_text' => 'Ver Publicación',
                    'button_url' => '/curso/' . $att->post->id,
                    'post_id' => $att->post->id,
                    'is_post_slide' => true,
                ];
            });

        return response()->json([
            'status' => 'success',
            'banners' => $banners,
            'post_slides' => $postSlides,
            'all_slides' => $banners->concat($postSlides),
        ]);
    }
}
