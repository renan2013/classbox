<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Testimonio;
use Illuminate\Http\Request;

class TestimonioController extends Controller
{
    public function index(Request $request)
    {
        $query = Testimonio::where('is_active', true);

        if ($request->boolean('video')) {
            $query->whereNotNull('video_iframe')->where('video_iframe', '!=', '');
        }

        $limit = $request->input('limit', 10);
        $testimonios = $query->orderBy('created_at', 'desc')->limit($limit)->get();

        return response()->json([
            'success' => true,
            'data' => $testimonios
        ]);
    }
}
