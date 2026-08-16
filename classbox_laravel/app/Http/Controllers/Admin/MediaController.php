<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = MediaFile::with('user');

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('file_type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('file_name', 'like', "%{$search}%")
                  ->orWhere('alt_text', 'like', "%{$search}%");
            });
        }

        $files = $query->orderBy('created_at', 'desc')->paginate(24)->withQueryString();

        // Estadísticas rápidas de la biblioteca
        $totalFiles = MediaFile::count();
        $totalBytes = MediaFile::sum('file_size');
        $imageCount = MediaFile::where('file_type', 'image')->count();
        $docCount = MediaFile::where('file_type', 'document')->count();
        $otherCount = $totalFiles - $imageCount - $docCount;

        return view('admin.media.index', compact(
            'files',
            'totalFiles',
            'totalBytes',
            'imageCount',
            'docCount',
            'otherCount'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files' => 'nullable|array',
            'files.*' => 'file|max:51200', // Máximo 50MB por archivo
            'file' => 'nullable|file|max:51200',
        ]);

        $uploadedFiles = [];
        if ($request->hasFile('files')) {
            $uploadedFiles = $request->file('files');
        } elseif ($request->hasFile('file')) {
            $uploadedFiles = [$request->file('file')];
        }

        if (empty($uploadedFiles)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'No se recibió ningún archivo.'], 400);
            }
            return back()->with('error', 'Por favor selecciona al menos un archivo.');
        }

        $savedFiles = [];
        foreach ($uploadedFiles as $file) {
            $mime = $file->getMimeType() ?? '';
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = strtolower($file->getClientOriginalExtension());
            $size = $file->getSize();
            $fileType = $this->determineFileType($extension, $mime);
            $dimensions = null;

            if ($fileType === 'image' && !in_array($extension, ['svg', 'gif'])) {
                // Optimizar imágenes a WebP
                $path = ImageService::optimizeAndStore($file, 'media', 1600, 82);
                $finalFileName = basename($path);
                $mime = 'image/webp';
                if (Storage::disk('public')->exists($path)) {
                    $size = Storage::disk('public')->size($path);
                }
            } else {
                // Guardar archivo original con nombre seguro
                $finalFileName = Str::slug($originalName) . '-' . Str::random(6) . '.' . $extension;
                $path = $file->storeAs('media', $finalFileName, 'public');
            }

            $media = MediaFile::create([
                'name' => $originalName,
                'file_name' => $finalFileName,
                'file_path' => $path,
                'file_type' => $fileType,
                'mime_type' => $mime,
                'file_size' => $size,
                'dimensions' => $dimensions,
                'alt_text' => $originalName,
                'user_id' => Auth::id(),
            ]);

            $savedFiles[] = $media;
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => count($savedFiles) . ' archivo(s) subido(s) correctamente.',
                'files' => $savedFiles,
            ]);
        }

        return redirect()->route('admin.media.index')->with('success', count($savedFiles) . ' archivo(s) subido(s) a la biblioteca de medios.');
    }

    public function update(Request $request, $id)
    {
        $media = MediaFile::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'alt_text' => 'nullable|string|max:255',
        ]);

        $media->update([
            'name' => $request->name,
            'alt_text' => $request->alt_text,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'media' => $media]);
        }

        return back()->with('success', 'Información del archivo actualizada.');
    }

    public function destroy($id)
    {
        $media = MediaFile::findOrFail($id);

        if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        $media->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Archivo eliminado.']);
        }

        return back()->with('success', 'Archivo eliminado de la biblioteca.');
    }

    private function determineFileType(string $ext, string $mime): string
    {
        if (str_starts_with($mime, 'image/') || in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'ico'])) {
            return 'image';
        }
        if (in_array($ext, ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv', 'rtf'])) {
            return 'document';
        }
        if (str_starts_with($mime, 'video/') || in_array($ext, ['mp4', 'mov', 'avi', 'webm', 'mkv'])) {
            return 'video';
        }
        if (str_starts_with($mime, 'audio/') || in_array($ext, ['mp3', 'wav', 'ogg', 'm4a', 'aac'])) {
            return 'audio';
        }
        if (in_array($ext, ['zip', 'rar', '7z', 'tar', 'gz'])) {
            return 'archive';
        }
        return 'other';
    }
}
