@extends('layouts.admin')

@section('title', 'Nuevo Trabajo de Portafolio')
@section('page-title', 'Añadir Trabajo / Proyecto')

@section('content')
<div class="max-w-3xl mx-auto pb-12">
    <!-- Breadcrumb -->
    <div class="mb-5 flex items-center justify-between">
        <a href="{{ route('admin.portfolio.items.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-teal-600 transition">
            <i class="fa-solid fa-arrow-left"></i> Volver a Portafolio
        </a>
    </div>

    <form action="{{ route('admin.portfolio.items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
            <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-briefcase text-teal-600"></i> Información del Trabajo / Proyecto
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Título del Proyecto / Trabajo <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="Ej: Rediseño de Marca e Identidad Visual Mandara"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Categoría</label>
                    <select name="category_id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                        <option value="">-- Sin Categoría / General --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nombre del Cliente / Empresa (Opcional)</label>
                    <input type="text" name="client_name" value="{{ old('client_name') }}" placeholder="Ej: Servitec Soluciones Tecnológicas S.A."
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                </div>

                <!-- Image Upload -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Imagen / Logo del Proyecto <span class="text-rose-500">*</span></label>
                    <div class="flex items-center gap-4">
                        <div id="image_preview_box" class="hidden w-24 h-24 rounded-xl border border-slate-200 overflow-hidden bg-slate-100 shrink-0 p-1 flex items-center justify-center">
                            <img id="image_preview" src="#" alt="Preview" class="max-w-full max-h-full object-contain">
                        </div>
                        <input type="file" name="image" id="image_input" required accept="image/*"
                               class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer">
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1.5 flex items-center gap-1">
                        <i class="fa-solid fa-wand-magic-sparkles text-teal-600"></i> La imagen se convertirá y optimizará automáticamente a formato ligero <strong>WebP</strong>.
                    </p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Enlace / Sitio Web del Proyecto (Opcional)</label>
                    <input type="url" name="project_url" value="{{ old('project_url') }}" placeholder="https://..."
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Descripción Corta / Detalles (Opcional)</label>
                    <textarea name="description" rows="3" placeholder="Breve reseña del proyecto o técnica utilizada..."
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Orden de aparición</label>
                    <input type="number" name="order" value="{{ old('order', 0) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                </div>

                <div class="flex items-center pt-6">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded text-teal-600 focus:ring-teal-500">
                        <span class="text-xs text-slate-700 font-semibold">Trabajo Activo (Visible en el sitio web)</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.portfolio.items.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold shadow-sm shadow-teal-600/20">
                Guardar Proyecto
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('image_input')?.addEventListener('change', function(e) {
        const [file] = e.target.files;
        if (file) {
            const previewBox = document.getElementById('image_preview_box');
            const previewImg = document.getElementById('image_preview');
            previewImg.src = URL.createObjectURL(file);
            previewBox.classList.remove('hidden');
        }
    });
</script>
@endsection
