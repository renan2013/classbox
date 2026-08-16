@extends('layouts.admin')

@section('title', 'Nueva Publicación')
@section('page-title', 'Crear Publicación / Curso')

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    <!-- Breadcrumb / Back Link -->
    <div class="mb-5 flex items-center justify-between">
        <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-teal-600 transition">
            <i class="fa-solid fa-arrow-left"></i> Volver al listado
        </a>
    </div>

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="postForm">
        @csrf
        
        <!-- Tarjeta: Información Principal -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
            <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-file-pen text-teal-600"></i> Información Principal
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Título del Curso / Publicación <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="Ej: Técnico en Asistente de Pacientes"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Categoría <span class="text-rose-500">*</span></label>
                    <select name="category_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500 transition">
                        <option value="">Selecciona una categoría...</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Orden de visualización</label>
                    <input type="number" name="order" value="{{ old('order', 0) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500 transition">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Sinopsis / Descripción Corta</label>
                    <textarea name="synopsis" rows="2" placeholder="Resumen conciso para las tarjetas del sitio web..."
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500 transition">{{ old('synopsis') }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-semibold text-slate-700">Contenido Detallado (Editor Visual)</label>
                        <span class="text-[11px] text-teal-600 font-medium"><i class="fa-solid fa-wand-magic-sparkles mr-1"></i>Editor WYSIWYG activo</span>
                    </div>
                    <textarea id="post_content" name="content" rows="8" placeholder="Escribe o pega el contenido aquí...">{{ old('content') }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-semibold text-slate-700">Imagen Principal / Portada de la Tarjeta</label>
                        <span class="text-[10px] font-semibold text-teal-700 bg-teal-50 border border-teal-200 px-2 py-0.5 rounded-full">
                            <i class="fa-solid fa-ruler-combined mr-1"></i> Recomendado: 800 x 500 px (Horizontal)
                        </span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div id="main_image_preview_box" class="hidden w-24 h-16 rounded-xl border border-slate-200 overflow-hidden bg-slate-100 shrink-0">
                            <img id="main_image_preview" src="#" alt="Preview" class="w-full h-full object-cover">
                        </div>
                        <input type="file" name="main_image" id="main_image_input" accept="image/*"
                               class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer">
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">
                        <i class="fa-solid fa-circle-check text-teal-500 mr-1"></i> El sistema optimiza y recorta automáticamente a formato WebP para que todas las tarjetas se vean parejas en el sitio web.
                    </p>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Instructor / Docente -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-chalkboard-user text-indigo-600"></i> Datos del Instructor / Docente (Opcional)
                </h3>
                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="show_in_instructors" value="1" {{ old('show_in_instructors') ? 'checked' : '' }} class="rounded text-teal-600 focus:ring-teal-500">
                    <span class="text-xs text-slate-600 font-medium">Mostrar en sección de docentes</span>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nombre del Instructor</label>
                    <input type="text" name="instructor_name" value="{{ old('instructor_name') }}" placeholder="Ej: Dr. Carlos Mora"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Título / Especialidad</label>
                    <input type="text" name="instructor_title" value="{{ old('instructor_title') }}" placeholder="Ej: Especialista en Urgencias Médicas"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Foto del Instructor</label>
                    <div class="flex items-center gap-4">
                        <div id="instructor_photo_preview_box" class="hidden w-16 h-16 rounded-full border border-slate-200 overflow-hidden bg-slate-100 shrink-0">
                            <img id="instructor_photo_preview" src="#" alt="Preview" class="w-full h-full object-cover">
                        </div>
                        <input type="file" name="instructor_photo" id="instructor_photo_input" accept="image/*"
                               class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Archivos Adjuntos Multimedia -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
            <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-paperclip text-purple-600"></i> Archivos Adjuntos Multimedia
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Galería de Imágenes Adicionales (Múltiples fotos)</label>
                    <input type="file" name="gallery_images[]" id="gallery_images_input" multiple accept="image/*"
                           class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 cursor-pointer">
                    <div id="gallery_preview_container" class="mt-3 grid grid-cols-3 sm:grid-cols-4 gap-2"></div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                        <i class="fa-solid fa-panorama text-teal-600 mr-1"></i> Imagen para Slider / Portada Rotativa (Slides)
                    </label>
                    <div class="flex items-center gap-3">
                        <div id="slider_photo_preview_box" class="hidden w-20 h-12 rounded-xl border border-teal-300 overflow-hidden bg-teal-50 shrink-0">
                            <img id="slider_photo_preview" src="#" alt="Slide" class="w-full h-full object-cover">
                        </div>
                        <input type="file" name="slider_image" id="slider_photo_input" accept="image/*"
                               class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer">
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Si subes esta imagen, la publicación rotará en el slider principal del inicio con enlace directo a esta publicación.</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Folleto o Programa en PDF</label>
                    <input type="file" name="pdf_file" accept=".pdf"
                           class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 cursor-pointer">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Enlace de Video de YouTube</label>
                    <input type="url" name="youtube_url" value="{{ old('youtube_url') }}" placeholder="https://www.youtube.com/watch?v=..."
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.posts.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">Cancelar</a>
            <button type="submit" class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-teal-600/30 transition flex items-center gap-2">
                <i class="fa-solid fa-cloud-arrow-up"></i> Guardar Publicación
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar TinyMCE 6 con subida automática de imágenes a WebP
        initTinyMCE('#post_content', '{{ route('admin.posts.upload_editor_image') }}');

        // Previsualización de Imagen Principal
        const mainInput = document.getElementById('main_image_input');
        const mainBox = document.getElementById('main_image_preview_box');
        const mainImg = document.getElementById('main_image_preview');

        if (mainInput) {
            mainInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    mainImg.src = URL.createObjectURL(file);
                    mainBox.classList.remove('hidden');
                } else {
                    mainBox.classList.add('hidden');
                }
            });
        }

        // Previsualización de Foto del Instructor
        const instInput = document.getElementById('instructor_photo_input');
        const instBox = document.getElementById('instructor_photo_preview_box');
        const instImg = document.getElementById('instructor_photo_preview');

        if (instInput) {
            instInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    instImg.src = URL.createObjectURL(file);
                    instBox.classList.remove('hidden');
                } else {
                    instBox.classList.add('hidden');
                }
            });
        }

        // Previsualización de Foto del Slider
        const sliderInput = document.getElementById('slider_photo_input');
        const sliderBox = document.getElementById('slider_photo_preview_box');
        const sliderImg = document.getElementById('slider_photo_preview');

        if (sliderInput) {
            sliderInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    sliderImg.src = URL.createObjectURL(file);
                    sliderBox.classList.remove('hidden');
                } else {
                    sliderBox.classList.add('hidden');
                }
            });
        }

        // Previsualización de Galería Múltiple
        const galInput = document.getElementById('gallery_images_input');
        const galContainer = document.getElementById('gallery_preview_container');

        if (galInput && galContainer) {
            galInput.addEventListener('change', function(e) {
                galContainer.innerHTML = '';
                Array.from(e.target.files).forEach(file => {
                    const thumb = document.createElement('div');
                    thumb.className = 'w-full h-16 rounded-lg overflow-hidden border border-purple-200 bg-purple-50 relative';
                    thumb.innerHTML = `<img src="${URL.createObjectURL(file)}" class="w-full h-full object-cover">`;
                    galContainer.appendChild(thumb);
                });
            });
        }
    });
</script>
@endpush
