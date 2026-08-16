<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = MediaFile::query();

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('file_type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $files = $query->orderBy('created_at', 'desc')->paginate($request->integer('per_page', 24));

        return response()->json([
            'status' => 'success',
            'data' => $files->items(),
            'pagination' => [
                'total' => $files->total(),
                'per_page' => $files->perPage(),
                'current_page' => $files->currentPage(),
                'last_page' => $files->lastPage(),
            ]
        ]);
    }

    public function show($id)
    {
        $file = MediaFile::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $file,
        ]);
    }
}
