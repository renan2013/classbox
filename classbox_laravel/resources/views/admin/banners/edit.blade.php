@extends('layouts.admin')

@section('title', 'Editar Banner')
@section('page-title', 'Editar Banner / Slider')

@section('content')
<div class="max-w-3xl mx-auto pb-12">
    <!-- Breadcrumb -->
    <div class="mb-5 flex items-center justify-between">
        <a href="{{ route('admin.banners.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-teal-600 transition">
            <i class="fa-solid fa-arrow-left"></i> Volver a Banners
        </a>
    </div>

    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
            <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-teal-600"></i> Información del Banner
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Título Principal (Encabezado)</label>
                    <input type="text" name="title" value="{{ old('title', $banner->title) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Subtítulo o Descripción</label>
                    <textarea name="subtitle" rows="2"
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500 transition">{{ old('subtitle', $banner->subtitle) }}</textarea>
                </div>

                <!-- Desktop Image -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Imagen de Escritorio / PC</label>
                    <div class="flex items-center gap-4">
                        @if($banner->image_path)
                            <div class="w-28 h-14 rounded-xl border border-slate-200 overflow-hidden bg-slate-100 shrink-0 relative">
                                <img src="{{ $banner->image_url }}" alt="Actual" class="w-full h-full object-cover">
                                <span class="absolute bottom-0 inset-x-0 bg-slate-900/70 text-[8px] text-white text-center py-0.5">Actual</span>
                            </div>
                        @endif
                        <div id="desktop_preview_box" class="hidden w-28 h-14 rounded-xl border border-teal-300 overflow-hidden bg-teal-50 shrink-0 relative">
                            <img id="desktop_preview" src="#" alt="Nueva" class="w-full h-full object-cover">
                            <span class="absolute bottom-0 inset-x-0 bg-teal-600 text-[8px] text-white text-center py-0.5">Nueva</span>
                        </div>
                        <input type="file" name="image" id="desktop_image_input" accept="image/*"
                               class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer">
                    </div>
                </div>

                <!-- Mobile Image -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Imagen Móvil Opcional</label>
                    <div class="flex items-center gap-4">
                        @if($banner->mobile_image_path)
                            <div class="w-14 h-14 rounded-xl border border-slate-200 overflow-hidden bg-slate-100 shrink-0 relative">
                                <img src="{{ $banner->mobile_image_url }}" alt="Mobile Actual" class="w-full h-full object-cover">
                                <span class="absolute bottom-0 inset-x-0 bg-slate-900/70 text-[8px] text-white text-center py-0.5">Actual</span>
                            </div>
                        @endif
                        <div id="mobile_preview_box" class="hidden w-14 h-14 rounded-xl border border-indigo-300 overflow-hidden bg-indigo-50 shrink-0 relative">
                            <img id="mobile_preview" src="#" alt="Nueva" class="w-full h-full object-cover">
                            <span class="absolute bottom-0 inset-x-0 bg-indigo-600 text-[8px] text-white text-center py-0.5">Nueva</span>
                        </div>
                        <input type="file" name="mobile_image" id="mobile_image_input" accept="image/*"
                               class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                    </div>
                </div>

                <!-- Button Text & URL -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Texto del Botón CTA (Opcional)</label>
                    <input type="text" name="button_text" value="{{ old('button_text', $banner->button_text) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Enlace del Botón (URL)</label>
                    <input type="text" name="button_url" value="{{ old('button_url', $banner->button_url) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                </div>

                <!-- Estilo de Sombra / Filtro Visual -->
                <div class="md:col-span-2 pt-3 border-t border-slate-100">
                    <label class="block text-xs font-bold text-slate-800 mb-1">
                        <i class="fa-solid fa-wand-magic-sparkles text-teal-600 mr-1"></i> Estilo de Sombra y Filtro de la Imagen
                    </label>
                    <p class="text-[11px] text-slate-400 mb-3">Controla cómo se muestra la imagen y el efecto visual de contraste para el texto.</p>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <!-- 1. Imagen Pura -->
                        <label class="relative flex flex-col p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition text-center group has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/40 has-[:checked]:ring-2 has-[:checked]:ring-teal-500/20">
                            <input type="radio" name="overlay_style" value="none" {{ old('overlay_style', $banner->overlay_style) == 'none' ? 'checked' : '' }} class="sr-only">
                            <div class="h-10 w-full rounded-lg bg-gradient-to-r from-sky-400 to-indigo-400 mb-2 flex items-center justify-center text-white text-[10px] font-bold shadow-inner">100% Nítida</div>
                            <span class="text-xs font-bold text-slate-800">Imagen Pura</span>
                            <span class="text-[10px] text-slate-400">Sin sombras ni filtros</span>
                        </label>

                        <!-- 2. Gradiente Inferior -->
                        <label class="relative flex flex-col p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition text-center group has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/40 has-[:checked]:ring-2 has-[:checked]:ring-teal-500/20">
                            <input type="radio" name="overlay_style" value="bottom_gradient" {{ old('overlay_style', $banner->overlay_style ?? 'bottom_gradient') == 'bottom_gradient' ? 'checked' : '' }} class="sr-only">
                            <div class="h-10 w-full rounded-lg bg-gradient-to-t from-slate-900 via-slate-900/50 to-transparent mb-2 flex items-end justify-center pb-1 text-white text-[9px] font-bold shadow-inner">Sombra Abajo</div>
                            <span class="text-xs font-bold text-slate-800">Gradiente Inferior</span>
                            <span class="text-[10px] text-slate-400">Nítido arriba, sombra abajo</span>
                        </label>

                        <!-- 3. Gradiente Lateral -->
                        <label class="relative flex flex-col p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition text-center group has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/40 has-[:checked]:ring-2 has-[:checked]:ring-teal-500/20">
                            <input type="radio" name="overlay_style" value="left_gradient" {{ old('overlay_style', $banner->overlay_style) == 'left_gradient' ? 'checked' : '' }} class="sr-only">
                            <div class="h-10 w-full rounded-lg bg-gradient-to-r from-slate-900 via-slate-900/60 to-transparent mb-2 flex items-center justify-start pl-2 text-white text-[9px] font-bold shadow-inner">Texto Izq</div>
                            <span class="text-xs font-bold text-slate-800">Gradiente Lateral</span>
                            <span class="text-[10px] text-slate-400">Protege texto a la izq.</span>
                        </label>

                        <!-- 4. Glassmorphism -->
                        <label class="relative flex flex-col p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition text-center group has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/40 has-[:checked]:ring-2 has-[:checked]:ring-teal-500/20">
                            <input type="radio" name="overlay_style" value="glass_card" {{ old('overlay_style', $banner->overlay_style) == 'glass_card' ? 'checked' : '' }} class="sr-only">
                            <div class="h-10 w-full rounded-lg bg-sky-500/30 backdrop-blur-sm border border-white/40 mb-2 flex items-center justify-center text-slate-900 text-[10px] font-bold shadow-inner">Efecto Vidrio</div>
                            <span class="text-xs font-bold text-slate-800">Tarjeta Glassmorphism</span>
                            <span class="text-[10px] text-slate-400">Texto en caja de cristal</span>
                        </label>

                        <!-- 5. Sombra Completa -->
                        <label class="relative flex flex-col p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition text-center group has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/40 has-[:checked]:ring-2 has-[:checked]:ring-teal-500/20">
                            <input type="radio" name="overlay_style" value="full_dark" {{ old('overlay_style', $banner->overlay_style) == 'full_dark' ? 'checked' : '' }} class="sr-only">
                            <div class="h-10 w-full rounded-lg bg-slate-900/70 mb-2 flex items-center justify-center text-white text-[10px] font-bold shadow-inner">Oscuro Total</div>
                            <span class="text-xs font-bold text-slate-800">Sombra Completa</span>
                            <span class="text-[10px] text-slate-400">Contraste clásico total</span>
                        </label>

                        <!-- 6. Filtro de Marca -->
                        <label class="relative flex flex-col p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition text-center group has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/40 has-[:checked]:ring-2 has-[:checked]:ring-teal-500/20">
                            <input type="radio" name="overlay_style" value="brand_tint" {{ old('overlay_style', $banner->overlay_style) == 'brand_tint' ? 'checked' : '' }} class="sr-only">
                            <div class="h-10 w-full rounded-lg bg-gradient-to-br from-teal-500/70 to-slate-900/80 mb-2 flex items-center justify-center text-white text-[10px] font-bold shadow-inner">Color Marca</div>
                            <span class="text-xs font-bold text-slate-800">Filtro de Marca</span>
                            <span class="text-[10px] text-slate-400">Gradiente con color primario</span>
                        </label>
                    </div>
                </div>

                <!-- Tipografía y Alineación del Banner -->
                <div class="md:col-span-2 pt-3 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Alineación Horizontal</label>
                        <select name="content_alignment" class="w-full px-2.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                            <option value="left" {{ old('content_alignment', $banner->content_alignment) == 'left' ? 'selected' : '' }}>⬅️ Izquierda</option>
                            <option value="center" {{ old('content_alignment', $banner->content_alignment) == 'center' ? 'selected' : '' }}>↔️ Centro</option>
                            <option value="right" {{ old('content_alignment', $banner->content_alignment) == 'right' ? 'selected' : '' }}>➡️ Derecha</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Posición Vertical</label>
                        <select name="content_vertical_alignment" class="w-full px-2.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                            <option value="top" {{ old('content_vertical_alignment', $banner->content_vertical_alignment) == 'top' ? 'selected' : '' }}>⬆️ Superior (Arriba)</option>
                            <option value="center" {{ old('content_vertical_alignment', $banner->content_vertical_alignment ?? 'center') == 'center' ? 'selected' : '' }}>⏺️ Medio (Centrado)</option>
                            <option value="bottom" {{ old('content_vertical_alignment', $banner->content_vertical_alignment) == 'bottom' ? 'selected' : '' }}>⬇️ Inferior (Abajo)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Tamaño del Título</label>
                        <select name="title_size" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                            <option value="sm" {{ old('title_size', $banner->title_size) == 'sm' ? 'selected' : '' }}>Pequeño (32px)</option>
                            <option value="md" {{ old('title_size', $banner->title_size) == 'md' ? 'selected' : '' }}>Mediano (42px)</option>
                            <option value="lg" {{ old('title_size', $banner->title_size ?? 'lg') == 'lg' ? 'selected' : '' }}>Grande (54px)</option>
                            <option value="xl" {{ old('title_size', $banner->title_size) == 'xl' ? 'selected' : '' }}>Gigante (64px)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Grosor de Letra</label>
                        <select name="title_weight" class="w-full px-2.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                            <option value="light" {{ old('title_weight', $banner->title_weight ?? 'light') == 'light' ? 'selected' : '' }}>🪶 Delgado / Fino (300)</option>
                            <option value="normal" {{ old('title_weight', $banner->title_weight) == 'normal' ? 'selected' : '' }}>📄 Normal (400)</option>
                            <option value="bold" {{ old('title_weight', $banner->title_weight) == 'bold' ? 'selected' : '' }}>💪 Grueso (700)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Tipografía</label>
                        <select name="font_family" class="w-full px-2.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                            <option value="roboto" {{ old('font_family', $banner->font_family ?? 'roboto') == 'roboto' ? 'selected' : '' }}>✨ Roboto (Fina)</option>
                            <option value="inter" {{ old('font_family', $banner->font_family) == 'inter' ? 'selected' : '' }}>Inter</option>
                            <option value="heebo" {{ old('font_family', $banner->font_family) == 'heebo' ? 'selected' : '' }}>Heebo</option>
                            <option value="nunito" {{ old('font_family', $banner->font_family) == 'nunito' ? 'selected' : '' }}>Nunito</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Color del Título</label>
                        <div class="flex items-center gap-2">
                            <input type="color" value="{{ old('title_color', $banner->title_color ?: '#334155') }}" oninput="this.nextElementSibling.value = this.value" class="w-8 h-8 rounded border cursor-pointer p-0.5 bg-white">
                            <input type="text" name="title_color" value="{{ old('title_color', $banner->title_color ?: '#334155') }}" oninput="this.previousElementSibling.value = this.value" class="w-full px-2 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Color del Subtítulo</label>
                        <div class="flex items-center gap-2">
                            <input type="color" value="{{ old('subtitle_color', $banner->subtitle_color ?: '#06BBCC') }}" oninput="this.nextElementSibling.value = this.value" class="w-8 h-8 rounded border cursor-pointer p-0.5 bg-white">
                            <input type="text" name="subtitle_color" value="{{ old('subtitle_color', $banner->subtitle_color ?: '#06BBCC') }}" oninput="this.previousElementSibling.value = this.value" class="w-full px-2 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Estilo del Botón / Enlace</label>
                    <select name="button_style" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                        <option value="text_link" {{ old('button_style', $banner->button_style ?? 'text_link') == 'text_link' ? 'selected' : '' }}>🔗 Enlace Sutil con Flecha (ej: Quiero saber más →)</option>
                        <option value="primary" {{ old('button_style', $banner->button_style) == 'primary' ? 'selected' : '' }}>🔘 Botón Color Primario</option>
                        <option value="white" {{ old('button_style', $banner->button_style) == 'white' ? 'selected' : '' }}>🔘 Botón Blanco</option>
                        <option value="dark" {{ old('button_style', $banner->button_style) == 'dark' ? 'selected' : '' }}>🔘 Botón Oscuro</option>
                        <option value="outline" {{ old('button_style', $banner->button_style) == 'outline' ? 'selected' : '' }}>🔘 Botón Contorno</option>
                    </select>
                </div>

                <!-- Visibilidad de Elementos del Banner -->
                <div class="md:col-span-2 pt-3 border-t border-slate-100">
                    <label class="block text-xs font-bold text-slate-800 mb-2">👁️ Visibilidad en este Banner (Mostrar / Ocultar):</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="flex items-center gap-2.5 p-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition">
                            <input type="checkbox" name="show_subtitle" value="1" {{ old('show_subtitle', $banner->show_subtitle ?? true) ? 'checked' : '' }} class="rounded text-teal-600 focus:ring-teal-500">
                            <div>
                                <span class="block text-xs font-bold text-slate-700">Subtítulo</span>
                                <span class="block text-[10px] text-slate-400">Texto superior pequeño</span>
                            </div>
                        </label>
                        <label class="flex items-center gap-2.5 p-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition">
                            <input type="checkbox" name="show_title" value="1" {{ old('show_title', $banner->show_title ?? true) ? 'checked' : '' }} class="rounded text-teal-600 focus:ring-teal-500">
                            <div>
                                <span class="block text-xs font-bold text-slate-700">Título Principal</span>
                                <span class="block text-[10px] text-slate-400">Texto grande</span>
                            </div>
                        </label>
                        <label class="flex items-center gap-2.5 p-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition">
                            <input type="checkbox" name="show_button" value="1" {{ old('show_button', $banner->show_button ?? true) ? 'checked' : '' }} class="rounded text-teal-600 focus:ring-teal-500">
                            <div>
                                <span class="block text-xs font-bold text-slate-700">Botón / Enlace</span>
                                <span class="block text-[10px] text-slate-400">Botón de acción</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Orden de aparición</label>
                    <input type="number" name="order" value="{{ old('order', $banner->order) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                </div>

                <div class="flex items-center pt-6">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }} class="rounded text-teal-600 focus:ring-teal-500">
                        <span class="text-xs text-slate-700 font-semibold">Banner Activo (Visible en el sitio web)</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.banners.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">Cancelar</a>
            <button type="submit" class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-teal-600/30 transition flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const desktopInput = document.getElementById('desktop_image_input');
    const desktopBox = document.getElementById('desktop_preview_box');
    const desktopImg = document.getElementById('desktop_preview');

    if (desktopInput) {
        desktopInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                desktopImg.src = URL.createObjectURL(file);
                desktopBox.classList.remove('hidden');
            } else {
                desktopBox.classList.add('hidden');
            }
        });
    }

    const mobileInput = document.getElementById('mobile_image_input');
    const mobileBox = document.getElementById('mobile_preview_box');
    const mobileImg = document.getElementById('mobile_preview');

    if (mobileInput) {
        mobileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                mobileImg.src = URL.createObjectURL(file);
                mobileBox.classList.remove('hidden');
            } else {
                mobileBox.classList.add('hidden');
            }
        });
    }
</script>
@endpush
