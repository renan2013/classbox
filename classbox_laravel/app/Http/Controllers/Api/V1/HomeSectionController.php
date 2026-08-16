<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use Illuminate\Http\Request;

class HomeSectionController extends Controller
{
    public function index()
    {
        $sections = HomeSection::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $sections,
        ]);
    }
}
