@extends('layouts.admin')

@section('title', 'Editar Página')
@section('page-title', 'Editar Página: ' . $page->title)

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    <!-- Breadcrumb -->
    <div class="mb-5 flex items-center justify-between">
        <a href="{{ route('admin.pages.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-teal-600 transition">
            <i class="fa-solid fa-arrow-left"></i> Volver a Páginas
        </a>
        <a href="{{ $page->public_url }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-teal-700 bg-teal-50 border border-teal-200 px-3 py-1.5 rounded-xl hover:bg-teal-100 transition">
            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> Ver en Sitio Web
        </a>
    </div>

    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Información de la Página -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
            <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-teal-600"></i> Contenido de la Página
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Título de la Página <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="pageTitle" value="{{ old('title', $page->title) }}" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Slug URL (Ruta amigable)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 font-mono text-xs">/</span>
                        <input type="text" name="slug" id="pageSlug" value="{{ old('slug', $page->slug) }}"
                               class="w-full pl-7 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 font-mono focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-semibold text-slate-700">Cuerpo del Contenido (Editor Visual)</label>
                        <span class="text-[11px] text-teal-600 font-medium"><i class="fa-solid fa-wand-magic-sparkles mr-1"></i>Editor WYSIWYG activo</span>
                    </div>
                    <textarea id="page_content" name="content" rows="12">{{ old('content', $page->content) }}</textarea>
                </div>

                <div class="md:col-span-2 pt-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Imagen Destacada / Cabecera (Opcional)</label>
                    <div class="flex items-center gap-4">
                        @if($page->featured_image)
                            <div class="w-20 h-20 rounded-xl border border-slate-200 overflow-hidden bg-slate-100 shrink-0 relative">
                                <img src="{{ $page->featured_image_url }}" alt="Actual" class="w-full h-full object-cover">
                                <span class="absolute bottom-0 inset-x-0 bg-slate-900/70 text-[8px] text-white text-center py-0.5">Actual</span>
                            </div>
                        @endif
                        <div id="page_img_preview_box" class="hidden w-20 h-20 rounded-xl border border-teal-300 overflow-hidden bg-teal-50 shrink-0 relative">
                            <img id="page_img_preview" src="#" alt="Nueva" class="w-full h-full object-cover">
                            <span class="absolute bottom-0 inset-x-0 bg-teal-600 text-[8px] text-white text-center py-0.5">Nueva</span>
                        </div>
                        <input type="file" name="featured_image" id="page_img_input" accept="image/*"
                               class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer">
                    </div>
                </div>
            </div>
        </div>

        <!-- Optimización SEO & Visibilidad -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
            <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-indigo-600"></i> Optimización para Buscadores (SEO)
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Meta Título (Título en Google)</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Meta Descripción (Resumen para resultados de Google y WhatsApp)</label>
                    <textarea name="meta_description" rows="2"
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">{{ old('meta_description', $page->meta_description) }}</textarea>
                </div>

                <div class="md:col-span-2 pt-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $page->is_published) ? 'checked' : '' }} class="rounded text-teal-600 focus:ring-teal-500">
                        <span class="text-xs text-slate-700 font-semibold">Página Publicada (Visible en el sitio web)</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.pages.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">Cancelar</a>
            <button type="submit" class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-teal-600/30 transition flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initTinyMCE('#page_content', '{{ route('admin.posts.upload_editor_image') }}');

        // Previsualización de imagen
        const imgInput = document.getElementById('page_img_input');
        const imgBox = document.getElementById('page_img_preview_box');
        const imgEl = document.getElementById('page_img_preview');

        if (imgInput) {
            imgInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    imgEl.src = URL.createObjectURL(file);
                    imgBox.classList.remove('hidden');
                } else {
                    imgBox.classList.add('hidden');
                }
            });
        }
    });
</script>
@endpush
