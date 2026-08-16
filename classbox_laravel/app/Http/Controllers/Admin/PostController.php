<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\Post;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['category', 'author', 'attachments']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('synopsis', 'like', "%{$search}%");
            });
        }

        $posts = $query->orderBy('order', 'asc')->orderBy('created_at', 'desc')->paginate(15);
        $categories = Category::all();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'synopsis' => 'nullable|string',
            'content' => 'nullable|string',
            'main_image' => 'nullable|image|max:10240',
            'order' => 'nullable|integer',
            'instructor_name' => 'nullable|string|max:255',
            'instructor_title' => 'nullable|string|max:255',
            'instructor_photo' => 'nullable|image|max:10240',
            'show_in_instructors' => 'nullable|boolean',
        ]);

        $data = $request->except(['main_image', 'instructor_photo', 'gallery_images', 'youtube_url', 'pdf_file']);
        $data['user_id'] = Auth::id();
        $data['show_in_instructors'] = $request->boolean('show_in_instructors');

        // Optimización automática de imagen principal
        if ($request->hasFile('main_image')) {
            $data['main_image'] = ImageService::optimizeAndStore($request->file('main_image'), 'posts', 1200, 80);
        }

        // Optimización automática de foto de instructor
        if ($request->hasFile('instructor_photo')) {
            $data['instructor_photo'] = ImageService::optimizeAndStore($request->file('instructor_photo'), 'instructors', 600, 80);
        }

        $post = Post::create($data);

        // Guardar imágenes de galería optimizadas a WebP
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $path = ImageService::optimizeAndStore($file, 'attachments', 1200, 80);
                Attachment::create([
                    'post_id' => $post->id,
                    'type' => 'gallery_image',
                    'value' => $path,
                    'file_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp',
                ]);
            }
        }

        // Guardar URLs de YouTube
        if ($request->filled('youtube_url')) {
            Attachment::create([
                'post_id' => $post->id,
                'type' => 'youtube',
                'value' => $request->youtube_url,
            ]);
        }

        // Guardar PDFs
        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $path = $file->store('pdfs', 'public');
            Attachment::create([
                'post_id' => $post->id,
                'type' => 'pdf',
                'value' => $path,
                'file_name' => $file->getClientOriginalName(),
            ]);
        }

        // Guardar Imagen para Slide de Portada (Slider)
        if ($request->hasFile('slider_image')) {
            $file = $request->file('slider_image');
            $path = ImageService::optimizeAndStore($file, 'sliders', 1920, 85);
            Attachment::create([
                'post_id' => $post->id,
                'type' => 'slider_image',
                'value' => $path,
                'file_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp',
            ]);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Publicación creada exitosamente con imágenes optimizadas.');
    }

    public function edit($id)
    {
        $post = Post::with(['attachments', 'category'])->findOrFail($id);
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'synopsis' => 'nullable|string',
            'content' => 'nullable|string',
            'main_image' => 'nullable|image|max:10240',
            'order' => 'nullable|integer',
            'instructor_name' => 'nullable|string|max:255',
            'instructor_title' => 'nullable|string|max:255',
            'instructor_photo' => 'nullable|image|max:10240',
            'show_in_instructors' => 'nullable|boolean',
        ]);

        $data = $request->except(['main_image', 'instructor_photo', 'gallery_images']);
        $data['show_in_instructors'] = $request->boolean('show_in_instructors');

        if ($request->hasFile('main_image')) {
            if ($post->main_image && Storage::disk('public')->exists($post->main_image)) {
                Storage::disk('public')->delete($post->main_image);
            }
            $data['main_image'] = ImageService::optimizeAndStore($request->file('main_image'), 'posts', 1200, 80);
        }

        if ($request->hasFile('instructor_photo')) {
            if ($post->instructor_photo && Storage::disk('public')->exists($post->instructor_photo)) {
                Storage::disk('public')->delete($post->instructor_photo);
            }
            $data['instructor_photo'] = ImageService::optimizeAndStore($request->file('instructor_photo'), 'instructors', 600, 80);
        }

        $post->update($data);

        // Subir nuevos adjuntos optimizados si se envían
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $path = ImageService::optimizeAndStore($file, 'attachments', 1200, 80);
                Attachment::create([
                    'post_id' => $post->id,
                    'type' => 'gallery_image',
                    'value' => $path,
                    'file_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp',
                ]);
            }
        }

        if ($request->filled('youtube_url')) {
            Attachment::create([
                'post_id' => $post->id,
                'type' => 'youtube',
                'value' => $request->youtube_url,
            ]);
        }

        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $path = $file->store('pdfs', 'public');
            Attachment::create([
                'post_id' => $post->id,
                'type' => 'pdf',
                'value' => $path,
                'file_name' => $file->getClientOriginalName(),
            ]);
        }

        // Actualizar / Reemplazar Imagen para Slide de Portada (Slider)
        if ($request->hasFile('slider_image')) {
            $existingSlider = $post->attachments()->where('type', 'slider_image')->first();
            if ($existingSlider) {
                if (Storage::disk('public')->exists($existingSlider->value)) {
                    Storage::disk('public')->delete($existingSlider->value);
                }
                $existingSlider->delete();
            }
            $file = $request->file('slider_image');
            $path = ImageService::optimizeAndStore($file, 'sliders', 1920, 85);
            Attachment::create([
                'post_id' => $post->id,
                'type' => 'slider_image',
                'value' => $path,
                'file_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp',
            ]);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Publicación actualizada exitosamente con optimización de imágenes.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->main_image && Storage::disk('public')->exists($post->main_image)) {
            Storage::disk('public')->delete($post->main_image);
        }
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Publicación eliminada correctamente.');
    }

    public function deleteAttachment($id)
    {
        $attachment = Attachment::findOrFail($id);
        if (in_array($attachment->type, ['gallery_image', 'slider_image', 'pdf']) && Storage::disk('public')->exists($attachment->value)) {
            Storage::disk('public')->delete($attachment->value);
        }
        $attachment->delete();

        return back()->with('success', 'Adjunto eliminado.');
    }

    /**
     * Sube y optimiza a WebP una imagen insertada directamente desde el editor visual TinyMCE.
     */
    public function uploadEditorImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $path = ImageService::optimizeAndStore($request->file('file'), 'editor', 1400, 82);
            return response()->json([
                'location' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['error' => 'No se pudo subir la imagen.'], 400);
    }
}
