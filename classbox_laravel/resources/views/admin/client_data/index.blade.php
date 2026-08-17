@extends('layouts.admin')

@section('title', 'Configuración General & Identidad')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Configuración General del Sitio Web</h1>
            <p class="text-xs text-slate-500 mt-1">Personaliza la identidad de marca, paleta de colores, diseño del slider de portada, datos de contacto y SEO.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ env('FRONTEND_URL', 'http://127.0.0.1:8080') }}" target="_blank" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Ver Sitio Web en Vivo</span>
            </a>
            <button type="button" onclick="document.getElementById('clientDataSubmitBtn').click()" class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold shadow-sm transition flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Guardar Cambios</span>
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-xs flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('admin.client_data.update') }}" method="POST" enctype="multipart/form-data" id="clientDataForm" onsubmit="submitClientDataForm(event)" class="space-y-6">
        @csrf

        <!-- 1. IDENTIDAD DE MARCA & LOGOTIPOS -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-building text-teal-600"></i> Identidad de Marca & Logotipos
                </h3>
                <span class="text-[11px] text-slate-400">Nombre, dominio e imágenes de marca</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nombre de la Institución / Empresa</label>
                    <input type="text" name="company_name" value="{{ old('company_name', $client_data->company_name) }}" 
                           placeholder="Ej: CEFI - Centro de Formación Integral"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">URL Oficial del Sitio Web</label>
                    <input type="url" name="website_url" value="{{ old('website_url', $client_data->website_url) }}" 
                           placeholder="https://ceficr.com"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-800 mb-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-align-left text-teal-600"></i> Reseña Institucional para el Pie de Página (Footer)
                    </label>
                    <textarea name="meta_description" rows="3" 
                              placeholder="Ej: Especialistas en desarrollo de software, diseño gráfico, robótica y capacitación profesional..."
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500 focus:bg-white transition shadow-inner">{{ old('meta_description', $client_data->meta_description) }}</textarea>
                    <span class="block text-[11px] text-slate-400 mt-1">
                        <i class="fa-solid fa-circle-info text-teal-600 mr-1"></i> Este texto aparece en la esquina derecha del <strong>Pie de Página (Footer)</strong> del sitio web, debajo del logotipo.
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-3 border-t border-slate-100">
                <!-- Logo Principal -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Logo Principal (Fondo Claro)</label>
                    <div class="flex items-center gap-3">
                        @if($client_data->logo_path)
                            <div class="h-12 w-24 rounded-xl border border-slate-200 bg-white p-1 flex items-center justify-center shrink-0 shadow-sm">
                                <img src="{{ $client_data->logo_url }}" class="max-h-full max-w-full object-contain">
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700">
                    </div>
                </div>

                <!-- Favicon -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Favicon (Pestaña del Navegador)</label>
                    <div class="flex items-center gap-3">
                        @if($client_data->favicon_path)
                            <div class="h-12 w-12 rounded-xl border border-slate-200 bg-white p-1 flex items-center justify-center shrink-0 shadow-sm">
                                <img src="{{ $client_data->favicon_url }}" class="max-h-full max-w-full object-contain">
                            </div>
                        @endif
                        <input type="file" name="favicon" accept=".ico,.png,.svg,.jpg,.webp" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700">
                    </div>
                </div>

                <!-- Logo Fondo Oscuro -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Logo para Fondo Oscuro (Footer / Dark)</label>
                    <div class="flex items-center gap-3">
                        @if($client_data->logo_dark_path)
                            <div class="h-12 w-24 rounded-xl border border-slate-700 bg-slate-900 p-1 flex items-center justify-center shrink-0 shadow-sm">
                                <img src="{{ $client_data->logo_dark_url }}" class="max-h-full max-w-full object-contain">
                            </div>
                        @endif
                        <input type="file" name="logo_dark" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700">
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. PALETA DE COLORES & TEMA VISUAL DEL SITIO -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
            <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-palette text-amber-500"></i> Paleta de Colores & Tema Visual del Sitio Web
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Personaliza la identidad cromática del Navbar, Tarjetas, Botones y Pie de Página</p>
                </div>
                <span class="text-[11px] text-teal-600 font-semibold bg-teal-50 px-2.5 py-1 rounded-lg border border-teal-100">8 Puntos de Color Personalizables</span>
            </div>

            <!-- Presets Rápidos -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-2">⚡ Temas Rápidos Predefinidos (1 Clic):</label>
                <div class="flex flex-wrap gap-2.5">
                    <button type="button" onclick="applyPreset('#06BBCC', '#181d38', '#181d38', '#ffffff', '#ffffff', '#181d38', '#181d38', '#ffffff', '#ffffff', '#e2e8f0')" class="px-3.5 py-2 rounded-xl border border-slate-200 hover:border-teal-500 bg-slate-50 hover:bg-white text-xs font-medium text-slate-700 flex items-center gap-2 transition shadow-sm">
                        <span class="w-3.5 h-3.5 rounded-full bg-[#06BBCC] shadow-sm"></span> CEFI Clásico
                    </button>
                    <button type="button" onclick="applyPreset('#059669', '#064e3b', '#064e3b', '#ffffff', '#ffffff', '#064e3b', '#064e3b', '#ffffff', '#f0fdf4', '#bbf7d0')" class="px-3.5 py-2 rounded-xl border border-slate-200 hover:border-emerald-500 bg-slate-50 hover:bg-white text-xs font-medium text-slate-700 flex items-center gap-2 transition shadow-sm">
                        <span class="w-3.5 h-3.5 rounded-full bg-[#059669] shadow-sm"></span> Salud & Menta
                    </button>
                    <button type="button" onclick="applyPreset('#b91c1c', '#450a0a', '#450a0a', '#ffffff', '#ffffff', '#450a0a', '#450a0a', '#ffffff', '#fff5f5', '#fecaca')" class="px-3.5 py-2 rounded-xl border border-slate-200 hover:border-rose-500 bg-slate-50 hover:bg-white text-xs font-medium text-slate-700 flex items-center gap-2 transition shadow-sm">
                        <span class="w-3.5 h-3.5 rounded-full bg-[#b91c1c] shadow-sm"></span> Vino Tinto & Academia
                    </button>
                    <button type="button" onclick="applyPreset('#7c3aed', '#2e1065', '#1e1b4b', '#ffffff', '#ffffff', '#1e1b4b', '#1e1b4b', '#ffffff', '#f5f3ff', '#ddd6fe')" class="px-3.5 py-2 rounded-xl border border-slate-200 hover:border-purple-500 bg-slate-50 hover:bg-white text-xs font-medium text-slate-700 flex items-center gap-2 transition shadow-sm">
                        <span class="w-3.5 h-3.5 rounded-full bg-[#7c3aed] shadow-sm"></span> Tecnología Púrpura
                    </button>
                    <button type="button" onclick="applyPreset('#ea580c', '#7c2d12', '#7c2d12', '#ffffff', '#ffffff', '#7c2d12', '#7c2d12', '#ffffff', '#fff7ed', '#ffedd5')" class="px-3.5 py-2 rounded-xl border border-slate-200 hover:border-orange-500 bg-slate-50 hover:bg-white text-xs font-medium text-slate-700 flex items-center gap-2 transition shadow-sm">
                        <span class="w-3.5 h-3.5 rounded-full bg-[#ea580c] shadow-sm"></span> Creativo Naranja
                    </button>
                    <button type="button" onclick="applyPreset('#3b82f6', '#0f172a', '#020617', '#ffffff', '#0f172a', '#ffffff', '#020617', '#ffffff', '#1e293b', '#334155')" class="px-3.5 py-2 rounded-xl border border-slate-200 hover:border-blue-500 bg-slate-50 hover:bg-white text-xs font-medium text-slate-700 flex items-center gap-2 transition shadow-sm">
                        <span class="w-3.5 h-3.5 rounded-full bg-[#0f172a] shadow-sm"></span> Dark Corporativo
                    </button>
                </div>
            </div>

            <!-- Grilla Amplia de Selectores de Color (4 Columnas) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-2">
                <!-- Primario -->
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Color Primario (Botones)</label>
                    <div class="flex items-center gap-2">
                        <input type="color" id="primary_color_picker" value="{{ old('primary_color', $client_data->primary_color ?: '#06BBCC') }}" oninput="syncColor('primary_color', this.value)" class="w-10 h-10 rounded-lg border border-slate-300 cursor-pointer p-0.5 bg-white shrink-0">
                        <input type="text" name="primary_color" id="primary_color" value="{{ old('primary_color', $client_data->primary_color ?: '#06BBCC') }}" oninput="syncColorPicker('primary_color', this.value)" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800">
                    </div>
                </div>

                <!-- Topbar Fondo -->
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Fondo Barra Superior (Topbar)</label>
                    <div class="flex items-center gap-2">
                        <input type="color" id="topbar_bg_color_picker" value="{{ old('topbar_bg_color', $client_data->topbar_bg_color ?: '#181d38') }}" oninput="syncColor('topbar_bg_color', this.value)" class="w-10 h-10 rounded-lg border border-slate-300 cursor-pointer p-0.5 bg-white shrink-0">
                        <input type="text" name="topbar_bg_color" id="topbar_bg_color" value="{{ old('topbar_bg_color', $client_data->topbar_bg_color ?: '#181d38') }}" oninput="syncColorPicker('topbar_bg_color', this.value)" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800">
                    </div>
                </div>

                <!-- Navbar Fondo -->
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Fondo Barra Menú (Navbar)</label>
                    <div class="flex items-center gap-2">
                        <input type="color" id="navbar_bg_color_picker" value="{{ old('navbar_bg_color', $client_data->navbar_bg_color ?: '#ffffff') }}" oninput="syncColor('navbar_bg_color', this.value)" class="w-10 h-10 rounded-lg border border-slate-300 cursor-pointer p-0.5 bg-white shrink-0">
                        <input type="text" name="navbar_bg_color" id="navbar_bg_color" value="{{ old('navbar_bg_color', $client_data->navbar_bg_color ?: '#ffffff') }}" oninput="syncColorPicker('navbar_bg_color', this.value)" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800">
                    </div>
                </div>

                <!-- Navbar Texto -->
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Texto / Enlaces Menú</label>
                    <div class="flex items-center gap-2">
                        <input type="color" id="navbar_text_color_picker" value="{{ old('navbar_text_color', $client_data->navbar_text_color ?: '#181d38') }}" oninput="syncColor('navbar_text_color', this.value)" class="w-10 h-10 rounded-lg border border-slate-300 cursor-pointer p-0.5 bg-white shrink-0">
                        <input type="text" name="navbar_text_color" id="navbar_text_color" value="{{ old('navbar_text_color', $client_data->navbar_text_color ?: '#181d38') }}" oninput="syncColorPicker('navbar_text_color', this.value)" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800">
                    </div>
                </div>

                <!-- Cards Fondo -->
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Fondo de Tarjetas (Cards)</label>
                    <div class="flex items-center gap-2">
                        <input type="color" id="card_bg_color_picker" value="{{ old('card_bg_color', $client_data->card_bg_color ?: '#ffffff') }}" oninput="syncColor('card_bg_color', this.value)" class="w-10 h-10 rounded-lg border border-slate-300 cursor-pointer p-0.5 bg-white shrink-0">
                        <input type="text" name="card_bg_color" id="card_bg_color" value="{{ old('card_bg_color', $client_data->card_bg_color ?: '#ffffff') }}" oninput="syncColorPicker('card_bg_color', this.value)" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800">
                    </div>
                </div>

                <!-- Cards Borde -->
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Borde de Tarjetas (Cards)</label>
                    <div class="flex items-center gap-2">
                        <input type="color" id="card_border_color_picker" value="{{ old('card_border_color', $client_data->card_border_color ?: '#e2e8f0') }}" oninput="syncColor('card_border_color', this.value)" class="w-10 h-10 rounded-lg border border-slate-300 cursor-pointer p-0.5 bg-white shrink-0">
                        <input type="text" name="card_border_color" id="card_border_color" value="{{ old('card_border_color', $client_data->card_border_color ?: '#e2e8f0') }}" oninput="syncColorPicker('card_border_color', this.value)" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800">
                    </div>
                </div>

                <!-- Footer Fondo -->
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Fondo Pie de Página (Footer)</label>
                    <div class="flex items-center gap-2">
                        <input type="color" id="footer_bg_color_picker" value="{{ old('footer_bg_color', $client_data->footer_bg_color ?: '#181d38') }}" oninput="syncColor('footer_bg_color', this.value)" class="w-10 h-10 rounded-lg border border-slate-300 cursor-pointer p-0.5 bg-white shrink-0">
                        <input type="text" name="footer_bg_color" id="footer_bg_color" value="{{ old('footer_bg_color', $client_data->footer_bg_color ?: '#181d38') }}" oninput="syncColorPicker('footer_bg_color', this.value)" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800">
                    </div>
                </div>

                <!-- Footer Texto -->
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Texto Pie de Página (Footer)</label>
                    <div class="flex items-center gap-2">
                        <input type="color" id="footer_text_color_picker" value="{{ old('footer_text_color', $client_data->footer_text_color ?: '#ffffff') }}" oninput="syncColor('footer_text_color', this.value)" class="w-10 h-10 rounded-lg border border-slate-300 cursor-pointer p-0.5 bg-white shrink-0">
                        <input type="text" name="footer_text_color" id="footer_text_color" value="{{ old('footer_text_color', $client_data->footer_text_color ?: '#ffffff') }}" oninput="syncColorPicker('footer_text_color', this.value)" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800">
                    </div>
                </div>
            </div>

            <!-- Mini Maqueta Simulada en Vivo -->
            <div class="pt-4 border-t border-slate-100">
                <label class="block text-xs font-bold text-slate-800 mb-2.5">👁️ Vista Previa en Vivo de los Componentes:</label>
                <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-sm text-xs select-none">
                    <!-- Topbar Demo -->
                    <div id="demo_topbar" class="px-5 py-2.5 flex justify-between items-center text-xs" style="background-color: {{ $client_data->topbar_bg_color ?: '#181d38' }}; color: {{ $client_data->topbar_text_color ?: '#ffffff' }};">
                        <span><i class="fa fa-phone-alt me-1"></i> +(506) 2222-3333</span>
                        <span>contacto@institucion.com</span>
                    </div>
                    <!-- Navbar Demo -->
                    <div id="demo_navbar" class="px-5 py-3.5 flex justify-between items-center border-b border-slate-200/20" style="background-color: {{ $client_data->navbar_bg_color ?: '#ffffff' }}; color: {{ $client_data->navbar_text_color ?: '#181d38' }};">
                        <span class="font-bold text-sm">LOGO INSTITUCIÓN</span>
                        <div class="flex items-center gap-4 font-semibold text-xs">
                            <span>Inicio</span>
                            <span>Cursos</span>
                            <span>Contacto</span>
                            <span id="demo_btn" class="px-3.5 py-1.5 rounded-lg text-white text-xs font-bold shadow-sm" style="background-color: {{ $client_data->primary_color ?: '#06BBCC' }};">Matrícula Online</span>
                        </div>
                    </div>
                    <!-- Body / Card Demo -->
                    <div class="p-6 bg-slate-100/80 flex justify-center">
                        <div id="demo_card" class="w-80 p-4 rounded-xl shadow-sm" style="background-color: {{ $client_data->card_bg_color ?: '#ffffff' }}; border: 1px solid {{ $client_data->card_border_color ?: '#e2e8f0' }};">
                            <div class="h-24 bg-slate-200/80 rounded-lg mb-3 flex items-center justify-center text-slate-400 text-xs font-medium">Imagen del Programa</div>
                            <span id="demo_badge" class="px-2.5 py-1 rounded-md text-white text-[10px] font-bold inline-block mb-1.5" style="background-color: {{ $client_data->primary_color ?: '#06BBCC' }};">Especialidad</span>
                            <div class="font-bold text-slate-800 text-sm mb-1">Técnico en Farmacia y Salud</div>
                            <div class="text-xs text-slate-500 mb-3">Aprende habilidades prácticas con certificación profesional garantizada.</div>
                            <button type="button" id="demo_card_btn" class="w-full py-2 rounded-lg text-white text-xs font-bold shadow-sm" style="background-color: {{ $client_data->primary_color ?: '#06BBCC' }};">Ver Más Información</button>
                        </div>
                    </div>
                    <!-- Footer Demo -->
                    <div id="demo_footer" class="px-5 py-3.5 flex justify-between items-center text-xs" style="background-color: {{ $client_data->footer_bg_color ?: '#181d38' }}; color: {{ $client_data->footer_text_color ?: '#ffffff' }};">
                        <span>&copy; {{ date('Y') }} Institución. Todos los derechos reservados.</span>
                        <span class="opacity-75">Classbox CMS</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. CONFIGURACIÓN Y ESTILO DEL SLIDER PRINCIPAL (PORTADA) -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-6">
            <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-wand-magic-sparkles text-teal-600"></i> Configuración y Tipografía del Slider Principal (Portada)
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Controla el estilo de filtro, tipografía, grosor, alineaciones y visibilidad de los banners de inicio</p>
                </div>
                <span class="text-[11px] text-indigo-600 font-semibold bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100">Banner & Carrousel</span>
            </div>

            <!-- Estilo Global de Sombra / Filtro (6 Tarjetas) -->
            <div>
                <label class="block text-xs font-bold text-slate-800 mb-1">
                    🎨 Estilo Global de Sombra y Filtro del Slider:
                </label>
                <p class="text-xs text-slate-400 mb-3">Elige cómo se presentarán las imágenes fotográficas en el carrusel de inicio:</p>

                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
                    <!-- 1. Imagen Pura -->
                    <label class="relative flex flex-col p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition text-center group has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/40 has-[:checked]:ring-2 has-[:checked]:ring-teal-500/20 shadow-sm">
                        <input type="radio" name="slider_overlay_style" value="none" {{ old('slider_overlay_style', $client_data->slider_overlay_style) == 'none' ? 'checked' : '' }} class="sr-only">
                        <div class="h-10 w-full rounded-lg bg-gradient-to-r from-sky-400 to-indigo-400 mb-2 flex items-center justify-center text-white text-[10px] font-bold shadow-inner">100% Nítida</div>
                        <span class="text-xs font-bold text-slate-800">Imagen Pura</span>
                        <span class="text-[10px] text-slate-400">Sin sombras</span>
                    </label>

                    <!-- 2. Gradiente Suave (Nivel 1) -->
                    <label class="relative flex flex-col p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition text-center group has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/40 has-[:checked]:ring-2 has-[:checked]:ring-teal-500/20 shadow-sm">
                        <input type="radio" name="slider_overlay_style" value="bottom_gradient_soft" {{ old('slider_overlay_style', $client_data->slider_overlay_style) == 'bottom_gradient_soft' ? 'checked' : '' }} class="sr-only">
                        <div class="h-10 w-full rounded-lg border border-slate-200/80 mb-2 flex items-end justify-center pb-1 text-slate-800 text-[10px] font-bold shadow-inner" style="background: linear-gradient(to top, rgba(15,23,42,0.45) 0%, rgba(15,23,42,0.15) 20%, #ffffff 40%, #ffffff 100%);">Suave (35%)</div>
                        <span class="text-xs font-bold text-slate-800">Grad. Suave</span>
                        <span class="text-[10px] text-slate-400">Sombra ligera (40%)</span>
                    </label>

                    <!-- 3. Gradiente Medio (Nivel 2) -->
                    <label class="relative flex flex-col p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition text-center group has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/40 has-[:checked]:ring-2 has-[:checked]:ring-teal-500/20 shadow-sm">
                        <input type="radio" name="slider_overlay_style" value="bottom_gradient" {{ old('slider_overlay_style', $client_data->slider_overlay_style ?? 'bottom_gradient') == 'bottom_gradient' ? 'checked' : '' }} class="sr-only">
                        <div class="h-10 w-full rounded-lg border border-slate-200/80 mb-2 flex items-end justify-center pb-1 text-white text-[10px] font-bold shadow-inner" style="background: linear-gradient(to top, rgba(15,23,42,0.78) 0%, rgba(15,23,42,0.30) 22%, #ffffff 40%, #ffffff 100%);">Medio (70%)</div>
                        <span class="text-xs font-bold text-slate-800">Grad. Medio</span>
                        <span class="text-[10px] text-slate-400">Balance estándar (40%)</span>
                    </label>

                    <!-- 4. Gradiente Fuerte (Nivel 3) -->
                    <label class="relative flex flex-col p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition text-center group has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/40 has-[:checked]:ring-2 has-[:checked]:ring-teal-500/20 shadow-sm">
                        <input type="radio" name="slider_overlay_style" value="bottom_gradient_strong" {{ old('slider_overlay_style', $client_data->slider_overlay_style) == 'bottom_gradient_strong' ? 'checked' : '' }} class="sr-only">
                        <div class="h-10 w-full rounded-lg border border-slate-200/80 mb-2 flex items-end justify-center pb-1 text-white text-[10px] font-bold shadow-inner" style="background: linear-gradient(to top, rgba(15,23,42,0.95) 0%, rgba(15,23,42,0.45) 24%, #ffffff 40%, #ffffff 100%);">Fuerte (95%)</div>
                        <span class="text-xs font-bold text-slate-800">Grad. Fuerte</span>
                        <span class="text-[10px] text-slate-400">Alto contraste (40%)</span>
                    </label>

                    <!-- 5. Gradiente Lateral -->
                    <label class="relative flex flex-col p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition text-center group has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/40 has-[:checked]:ring-2 has-[:checked]:ring-teal-500/20 shadow-sm">
                        <input type="radio" name="slider_overlay_style" value="left_gradient" {{ old('slider_overlay_style', $client_data->slider_overlay_style) == 'left_gradient' ? 'checked' : '' }} class="sr-only">
                        <div class="h-10 w-full rounded-lg bg-gradient-to-r from-slate-900 via-slate-900/60 to-transparent mb-2 flex items-center justify-start pl-2 text-white text-[10px] font-bold shadow-inner">Texto Izq</div>
                        <span class="text-xs font-bold text-slate-800">Grad. Lateral</span>
                        <span class="text-[10px] text-slate-400">Protege texto</span>
                    </label>

                    <!-- 6. Glassmorphism -->
                    <label class="relative flex flex-col p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition text-center group has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/40 has-[:checked]:ring-2 has-[:checked]:ring-teal-500/20 shadow-sm">
                        <input type="radio" name="slider_overlay_style" value="glass_card" {{ old('slider_overlay_style', $client_data->slider_overlay_style) == 'glass_card' ? 'checked' : '' }} class="sr-only">
                        <div class="h-10 w-full rounded-lg bg-sky-500/30 backdrop-blur-sm border border-white/40 mb-2 flex items-center justify-center text-slate-900 text-[10px] font-bold shadow-inner">Efecto Vidrio</div>
                        <span class="text-xs font-bold text-slate-800">Glassmorphism</span>
                        <span class="text-[10px] text-slate-400">Caja de cristal</span>
                    </label>

                    <!-- 7. Sombra Completa -->
                    <label class="relative flex flex-col p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition text-center group has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/40 has-[:checked]:ring-2 has-[:checked]:ring-teal-500/20 shadow-sm">
                        <input type="radio" name="slider_overlay_style" value="full_dark" {{ old('slider_overlay_style', $client_data->slider_overlay_style) == 'full_dark' ? 'checked' : '' }} class="sr-only">
                        <div class="h-10 w-full rounded-lg bg-slate-900/70 mb-2 flex items-center justify-center text-white text-[10px] font-bold shadow-inner">Oscuro Total</div>
                        <span class="text-xs font-bold text-slate-800">Sombra Total</span>
                        <span class="text-[10px] text-slate-400">Contraste 100%</span>
                    </label>

                    <!-- 8. Filtro de Marca -->
                    <label class="relative flex flex-col p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition text-center group has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/40 has-[:checked]:ring-2 has-[:checked]:ring-teal-500/20 shadow-sm">
                        <input type="radio" name="slider_overlay_style" value="brand_tint" {{ old('slider_overlay_style', $client_data->slider_overlay_style) == 'brand_tint' ? 'checked' : '' }} class="sr-only">
                        <div class="h-10 w-full rounded-lg bg-gradient-to-br from-teal-500/70 to-slate-900/80 mb-2 flex items-center justify-center text-white text-[10px] font-bold shadow-inner">Color Marca</div>
                        <span class="text-xs font-bold text-slate-800">Color de Marca</span>
                        <span class="text-[10px] text-slate-400">Tinte corporativo</span>
                    </label>
                </div>
            </div>

            <!-- Grilla Amplia de Tipografía y Apariencia (4 Columnas) -->
            <div class="pt-4 border-t border-slate-100">
                <label class="block text-xs font-bold text-slate-800 mb-3">
                    📐 Tipografía, Alineación y Colores de Texto del Slider:
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Posición Horizontal -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Alineación Horizontal</label>
                        <select name="slider_content_alignment" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                            <option value="left" {{ old('slider_content_alignment', $client_data->slider_content_alignment) == 'left' ? 'selected' : '' }}>⬅️ Izquierda</option>
                            <option value="center" {{ old('slider_content_alignment', $client_data->slider_content_alignment) == 'center' ? 'selected' : '' }}>↔️ Centro (Recomendado)</option>
                            <option value="right" {{ old('slider_content_alignment', $client_data->slider_content_alignment) == 'right' ? 'selected' : '' }}>➡️ Derecha</option>
                        </select>
                    </div>

                    <!-- Posición Vertical -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Posición Vertical</label>
                        <select name="slider_content_vertical_alignment" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                            <option value="top" {{ old('slider_content_vertical_alignment', $client_data->slider_content_vertical_alignment) == 'top' ? 'selected' : '' }}>⬆️ Superior (Arriba)</option>
                            <option value="center" {{ old('slider_content_vertical_alignment', $client_data->slider_content_vertical_alignment ?? 'center') == 'center' ? 'selected' : '' }}>⏺️ Medio (Centrado)</option>
                            <option value="bottom" {{ old('slider_content_vertical_alignment', $client_data->slider_content_vertical_alignment) == 'bottom' ? 'selected' : '' }}>⬇️ Inferior (Abajo)</option>
                        </select>
                    </div>

                    <!-- Tamaño del Título -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tamaño del Título</label>
                        <select name="slider_title_size" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                            <option value="sm" {{ old('slider_title_size', $client_data->slider_title_size) == 'sm' ? 'selected' : '' }}>Pequeño (32px)</option>
                            <option value="md" {{ old('slider_title_size', $client_data->slider_title_size) == 'md' ? 'selected' : '' }}>Mediano (42px)</option>
                            <option value="lg" {{ old('slider_title_size', $client_data->slider_title_size ?? 'lg') == 'lg' ? 'selected' : '' }}>Grande (54px)</option>
                            <option value="xl" {{ old('slider_title_size', $client_data->slider_title_size) == 'xl' ? 'selected' : '' }}>Gigante (64px)</option>
                        </select>
                    </div>

                    <!-- Grosor del Título (Font Weight) -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Grosor de Letra</label>
                        <select name="slider_title_weight" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                            <option value="light" {{ old('slider_title_weight', $client_data->slider_title_weight ?? 'light') == 'light' ? 'selected' : '' }}>🪶 Delgado / Fino (300 - No invasivo)</option>
                            <option value="normal" {{ old('slider_title_weight', $client_data->slider_title_weight) == 'normal' ? 'selected' : '' }}>📄 Normal (400)</option>
                            <option value="medium" {{ old('slider_title_weight', $client_data->slider_title_weight) == 'medium' ? 'selected' : '' }}>📐 Medio (500)</option>
                            <option value="bold" {{ old('slider_title_weight', $client_data->slider_title_weight) == 'bold' ? 'selected' : '' }}>💪 Grueso / Negrita (700)</option>
                        </select>
                    </div>

                    <!-- Tipografía del Slider -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tipografía del Slider</label>
                        <select name="slider_font_family" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                            <option value="roboto" {{ old('slider_font_family', $client_data->slider_font_family ?? 'roboto') == 'roboto' ? 'selected' : '' }}>✨ Roboto (Fina y Elegante)</option>
                            <option value="inter" {{ old('slider_font_family', $client_data->slider_font_family) == 'inter' ? 'selected' : '' }}>Inter (Moderna)</option>
                            <option value="heebo" {{ old('slider_font_family', $client_data->slider_font_family) == 'heebo' ? 'selected' : '' }}>Heebo</option>
                            <option value="nunito" {{ old('slider_font_family', $client_data->slider_font_family) == 'nunito' ? 'selected' : '' }}>Nunito</option>
                        </select>
                    </div>

                    <!-- Estilo de Botón / Enlace -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Estilo de Botón / Enlace</label>
                        <select name="slider_button_style" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                            <option value="text_link" {{ old('slider_button_style', $client_data->slider_button_style ?? 'text_link') == 'text_link' ? 'selected' : '' }}>🔗 Enlace Sutil con Flecha (Quiero saber más →)</option>
                            <option value="primary" {{ old('slider_button_style', $client_data->slider_button_style) == 'primary' ? 'selected' : '' }}>🔘 Botón Primario</option>
                            <option value="white" {{ old('slider_button_style', $client_data->slider_button_style) == 'white' ? 'selected' : '' }}>🔘 Botón Blanco</option>
                            <option value="outline" {{ old('slider_button_style', $client_data->slider_button_style) == 'outline' ? 'selected' : '' }}>🔘 Botón de Contorno</option>
                        </select>
                    </div>

                    <!-- Color de Carrera / Título Principal -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">📝 Color del Título</label>
                        <div class="flex items-center gap-2">
                            <input type="color" id="slider_title_color_picker" value="{{ old('slider_title_color', $client_data->slider_title_color ?: '#334155') }}" oninput="syncColor('slider_title_color', this.value)" class="w-10 h-10 rounded-lg border border-slate-300 cursor-pointer p-0.5 bg-white shrink-0">
                            <input type="text" name="slider_title_color" id="slider_title_color" value="{{ old('slider_title_color', $client_data->slider_title_color ?: '#334155') }}" oninput="syncColorPicker('slider_title_color', this.value)" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono text-slate-800">
                        </div>
                    </div>

                    <!-- Color de Categoría / Subtítulo -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">🏷️ Color del Subtítulo</label>
                        <div class="flex items-center gap-2">
                            <input type="color" id="slider_subtitle_color_picker" value="{{ old('slider_subtitle_color', $client_data->slider_subtitle_color ?: '#06BBCC') }}" oninput="syncColor('slider_subtitle_color', this.value)" class="w-10 h-10 rounded-lg border border-slate-300 cursor-pointer p-0.5 bg-white shrink-0">
                            <input type="text" name="slider_subtitle_color" id="slider_subtitle_color" value="{{ old('slider_subtitle_color', $client_data->slider_subtitle_color ?: '#06BBCC') }}" oninput="syncColorPicker('slider_subtitle_color', this.value)" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono text-slate-800">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Textos del Banner por Defecto -->
            <div class="pt-4 border-t border-slate-100">
                <label class="block text-xs font-bold text-slate-800 mb-3">
                    ✍️ Textos Predeterminados del Slider Principal:
                </label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Texto de Categoría (Subtítulo)</label>
                        <input type="text" name="slider_default_subtitle" value="{{ old('slider_default_subtitle', $client_data->slider_default_subtitle ?: 'EDUCACIÓN PROFESIONAL') }}" placeholder="Ej: EDUCACIÓN PROFESIONAL"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Texto del Título Principal</label>
                        <input type="text" name="slider_default_title" value="{{ old('slider_default_title', $client_data->slider_default_title ?: 'Creamos su página web de acuerdo a sus necesidades') }}" placeholder="Ej: Creamos su página web..."
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Texto del Botón / Enlace</label>
                        <input type="text" name="slider_default_button_text" value="{{ old('slider_default_button_text', $client_data->slider_default_button_text ?: 'Quiero saber más') }}" placeholder="Ej: Quiero saber más"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                    </div>
                </div>
            </div>

            <!-- Visibilidad de Elementos del Slider -->
            <div class="pt-4 border-t border-slate-100">
                <label class="block text-xs font-bold text-slate-800 mb-2.5">
                    👁️ Visibilidad de Elementos en Portada (Mostrar / Ocultar a voluntad):
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition shadow-sm">
                        <input type="checkbox" name="slider_show_subtitle" value="1" {{ old('slider_show_subtitle', $client_data->slider_show_subtitle) ? 'checked' : '' }} class="rounded text-teal-600 focus:ring-teal-500 w-4 h-4">
                        <div>
                            <span class="block text-xs font-bold text-slate-800">Categoría (Subtítulo)</span>
                            <span class="block text-[11px] text-slate-400">Texto superior pequeño</span>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition shadow-sm">
                        <input type="checkbox" name="slider_show_title" value="1" {{ old('slider_show_title', $client_data->slider_show_title ?? true) ? 'checked' : '' }} class="rounded text-teal-600 focus:ring-teal-500 w-4 h-4">
                        <div>
                            <span class="block text-xs font-bold text-slate-800">Título Principal</span>
                            <span class="block text-[11px] text-slate-400">Texto principal del banner</span>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition shadow-sm">
                        <input type="checkbox" name="slider_show_button" value="1" {{ old('slider_show_button', $client_data->slider_show_button ?? true) ? 'checked' : '' }} class="rounded text-teal-600 focus:ring-teal-500 w-4 h-4">
                        <div>
                            <span class="block text-xs font-bold text-slate-800">Botón / Enlace</span>
                            <span class="block text-[11px] text-slate-400">Acción o "Quiero saber más →"</span>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- 4. GRID DE 2 COLUMNAS PARA INFORMACIÓN COMPLEMENTARIA -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Columna Izquierda: Contacto & Redes Sociales -->
            <div class="space-y-6">
                <!-- Información de Contacto -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-headset text-indigo-600"></i> Información de Contacto y Canales Directos
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Correo Electrónico Oficial</label>
                            <input type="email" name="email" value="{{ old('email', $client_data->email) }}" placeholder="contacto@ceficr.com"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Teléfonos de Atención</label>
                            <input type="text" name="phone" value="{{ old('phone', $client_data->phone) }}" placeholder="(+506) 2221-7870 / 2221-2502"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                        </div>

                        <div class="grid grid-cols-3 gap-2">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Cód. País</label>
                                <input type="text" name="whatsapp_country_code" value="{{ old('whatsapp_country_code', $client_data->whatsapp_country_code ?? '506') }}" 
                                       class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 text-center font-mono">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5"><i class="fa-brands fa-whatsapp text-emerald-600 mr-1"></i> WhatsApp Oficial</label>
                                <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $client_data->whatsapp_number) }}" placeholder="87220999"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Horario de Atención</label>
                            <input type="text" name="schedule_info" value="{{ old('schedule_info', $client_data->schedule_info) }}" placeholder="Lunes a Viernes: 8:00 AM - 6:00 PM"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Dirección Física</label>
                            <textarea name="address" rows="2" placeholder="San José, Costa Rica..."
                                      class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">{{ old('address', $client_data->address) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Enlace de Google Maps / Waze</label>
                            <input type="text" name="google_maps_url" value="{{ old('google_maps_url', $client_data->google_maps_url) }}" placeholder="https://maps.app.goo.gl/..."
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                        </div>
                    </div>
                </div>

                <!-- Redes Sociales Oficiales -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-share-nodes text-blue-600"></i> Redes Sociales Oficiales
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5"><i class="fa-brands fa-facebook text-blue-600 mr-1"></i> Facebook URL</label>
                            <input type="url" name="facebook_url" value="{{ old('facebook_url', $client_data->facebook_url) }}" placeholder="https://facebook.com/..."
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5"><i class="fa-brands fa-instagram text-pink-600 mr-1"></i> Instagram URL</label>
                            <input type="url" name="instagram_url" value="{{ old('instagram_url', $client_data->instagram_url) }}" placeholder="https://instagram.com/..."
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5"><i class="fa-brands fa-youtube text-red-600 mr-1"></i> YouTube URL</label>
                            <input type="url" name="youtube_url" value="{{ old('youtube_url', $client_data->youtube_url) }}" placeholder="https://youtube.com/@..."
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5"><i class="fa-brands fa-tiktok text-slate-900 mr-1"></i> TikTok URL</label>
                            <input type="url" name="tiktok_url" value="{{ old('tiktok_url', $client_data->tiktok_url) }}" placeholder="https://tiktok.com/@..."
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5"><i class="fa-brands fa-linkedin text-sky-700 mr-1"></i> LinkedIn URL</label>
                            <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $client_data->linkedin_url) }}" placeholder="https://linkedin.com/company/..."
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: SEO, Analítica & Modo Mantenimiento -->
            <div class="space-y-6">
                <!-- Optimización SEO Global -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass-chart text-purple-600"></i> Optimización SEO Global (Google)
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Meta Título Principal del Sitio</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title', $client_data->meta_title) }}" placeholder="CEFI | Centro de Formación Integral - Cursos y Capacitaciones en Costa Rica"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                        </div>

                        <div class="p-3 bg-purple-50/60 rounded-xl border border-purple-100 text-xs text-purple-900">
                            <span class="font-bold flex items-center gap-1.5 mb-1">
                                <i class="fa-solid fa-circle-info text-purple-600"></i> Meta Descripción SEO
                            </span>
                            <p class="text-[11px] text-purple-700 leading-relaxed">
                                La descripción de Google se sincroniza automáticamente con el campo <strong>"Reseña Institucional para el Pie de Página (Footer)"</strong> ubicado en la primera sección superior.
                            </p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Palabras Clave (Keywords separadas por coma)</label>
                            <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $client_data->meta_keywords) }}" placeholder="cursos costarica, capacitaciones, farmacia, inyectables, cefi"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                        </div>
                    </div>
                </div>

                <!-- Analítica & Scripts -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-code text-amber-600"></i> Analítica & Códigos de Seguimiento
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5"><i class="fa-brands fa-google text-amber-500 mr-1"></i> Google Analytics 4 ID</label>
                            <input type="text" name="google_analytics_id" value="{{ old('google_analytics_id', $client_data->google_analytics_id) }}" placeholder="G-XXXXXXXXXX"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 font-mono">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5"><i class="fa-brands fa-facebook text-blue-600 mr-1"></i> Meta / Facebook Pixel ID</label>
                            <input type="text" name="meta_pixel_id" value="{{ old('meta_pixel_id', $client_data->meta_pixel_id) }}" placeholder="123456789012345"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 font-mono">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Scripts en el &lt;head&gt; (Tag Manager, etc.)</label>
                            <textarea name="custom_head_scripts" rows="2" placeholder="<!-- Códigos para incluir antes de </head> -->"
                                      class="w-full px-3.5 py-2.5 bg-slate-900 text-teal-300 font-mono border border-slate-700 rounded-xl text-xs">{{ old('custom_head_scripts', $client_data->custom_head_scripts) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Scripts al final del &lt;body&gt; (Chatbots, Widgets, etc.)</label>
                            <textarea name="custom_body_scripts" rows="2" placeholder="<!-- Códigos para incluir antes de </body> -->"
                                      class="w-full px-3.5 py-2.5 bg-slate-900 text-teal-300 font-mono border border-slate-700 rounded-xl text-xs">{{ old('custom_body_scripts', $client_data->custom_body_scripts) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Modo Mantenimiento -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-rose-500"></i> Modo Mantenimiento & Seguridad
                    </h3>

                    <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white cursor-pointer transition">
                        <input type="checkbox" name="maintenance_mode" value="1" {{ old('maintenance_mode', $client_data->maintenance_mode) ? 'checked' : '' }} class="rounded text-rose-600 focus:ring-rose-500 w-4 h-4">
                        <div>
                            <span class="text-xs font-bold text-slate-800">Activar Pantalla de Mantenimiento</span>
                            <p class="text-[11px] text-slate-400">Si se activa, el sitio web principal mostrará una pantalla temporal de mantenimiento a los visitantes.</p>
                        </div>
                    </label>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Mensaje de Mantenimiento</label>
                        <input type="text" name="maintenance_message" value="{{ old('maintenance_message', $client_data->maintenance_message) }}" placeholder="Estamos actualizando nuestra plataforma para brindarte una mejor experiencia. ¡Volvemos pronto!"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                <i class="fa-solid fa-key text-teal-600 mr-1"></i> Clave Bypass
                            </label>
                            <input type="text" name="maintenance_bypass_key" value="{{ old('maintenance_bypass_key', $client_data->maintenance_bypass_key ?: 'cefi2026') }}" 
                                   placeholder="cefi2026"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 font-mono">
                        </div>

                        <div class="flex items-end">
                            <a href="{{ env('FRONTEND_URL', 'http://127.0.0.1:8080') }}?bypass={{ $client_data->maintenance_bypass_key ?: 'cefi2026' }}" target="_blank"
                               class="w-full text-center px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-teal-300 hover:text-white rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 shadow-sm">
                                <i class="fa-solid fa-eye text-sm"></i>
                                <span>Ver con Bypass</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end pb-8">
            <button type="submit" id="clientDataSubmitBtn" class="px-8 py-3.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-teal-600/30 transition flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Guardar Toda la Configuración</span>
            </button>
        </div>
    </form>
</div>

<!-- Toast Feedback -->
<div id="toastNotification" class="fixed bottom-6 right-6 z-50 hidden bg-slate-900 text-white text-xs font-semibold px-4 py-3 rounded-xl shadow-2xl border border-slate-700 flex items-center gap-2 transition-opacity">
    <i class="fa-solid fa-circle-check text-teal-400 text-sm"></i>
    <span id="toastMessage">¡Configuración guardada!</span>
</div>
@endsection

@push('scripts')
<script>
    async function submitClientDataForm(e) {
        e.preventDefault();
        const form = document.getElementById('clientDataForm');
        const btn = document.getElementById('clientDataSubmitBtn');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const originalHtml = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Guardando configuración...</span>';

        const formData = new FormData(form);

        try {
            const res = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await res.json();
            btn.disabled = false;
            btn.innerHTML = originalHtml;

            if (res.ok && data.success) {
                showToast(data.message || '¡Configuración guardada exitosamente!');
                setTimeout(() => window.location.reload(), 500);
            } else {
                alert(data.message || 'Hubo un error al guardar la configuración.');
            }
        } catch (err) {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
            form.submit();
        }
    }

    function showToast(msg) {
        const toast = document.getElementById('toastNotification');
        const toastMsg = document.getElementById('toastMessage');
        toastMsg.textContent = msg;
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 3500);
    }

    function syncColor(field, val) {
        const textInput = document.getElementById(field);
        if (textInput) textInput.value = val;
        updateLiveDemo();
    }

    function syncColorPicker(field, val) {
        const picker = document.getElementById(field + '_picker');
        if (picker && /^#[0-9A-F]{6}$/i.test(val)) {
            picker.value = val;
        }
        updateLiveDemo();
    }

    function applyPreset(primary, topbarBg, topbarText, navbarBg, navbarText, cardBg, cardBorder, footerBg, footerText, cardBorderCustom) {
        setAndSync('primary_color', primary);
        setAndSync('topbar_bg_color', topbarBg);
        setAndSync('navbar_bg_color', navbarBg);
        setAndSync('navbar_text_color', navbarText);
        setAndSync('card_bg_color', cardBg);
        setAndSync('card_border_color', cardBorderCustom || cardBorder);
        setAndSync('footer_bg_color', footerBg);
        setAndSync('footer_text_color', footerText);
        updateLiveDemo();
    }

    function setAndSync(field, val) {
        const textInput = document.getElementById(field);
        const picker = document.getElementById(field + '_picker');
        if (textInput) textInput.value = val;
        if (picker && /^#[0-9A-F]{6}$/i.test(val)) picker.value = val;
    }

    function updateLiveDemo() {
        const primary = document.getElementById('primary_color')?.value || '#06BBCC';
        const topbarBg = document.getElementById('topbar_bg_color')?.value || '#181d38';
        const navbarBg = document.getElementById('navbar_bg_color')?.value || '#ffffff';
        const navbarText = document.getElementById('navbar_text_color')?.value || '#181d38';
        const cardBg = document.getElementById('card_bg_color')?.value || '#ffffff';
        const cardBorder = document.getElementById('card_border_color')?.value || '#e2e8f0';
        const footerBg = document.getElementById('footer_bg_color')?.value || '#181d38';
        const footerText = document.getElementById('footer_text_color')?.value || '#ffffff';

        const demoTopbar = document.getElementById('demo_topbar');
        if (demoTopbar) demoTopbar.style.backgroundColor = topbarBg;

        const demoNavbar = document.getElementById('demo_navbar');
        if (demoNavbar) {
            demoNavbar.style.backgroundColor = navbarBg;
            demoNavbar.style.color = navbarText;
        }

        const demoBtn = document.getElementById('demo_btn');
        if (demoBtn) demoBtn.style.backgroundColor = primary;

        const demoCard = document.getElementById('demo_card');
        if (demoCard) {
            demoCard.style.backgroundColor = cardBg;
            demoCard.style.borderColor = cardBorder;
        }

        const demoBadge = document.getElementById('demo_badge');
        if (demoBadge) demoBadge.style.backgroundColor = primary;

        const demoCardBtn = document.getElementById('demo_card_btn');
        if (demoCardBtn) demoCardBtn.style.backgroundColor = primary;

        const demoFooter = document.getElementById('demo_footer');
        if (demoFooter) {
            demoFooter.style.backgroundColor = footerBg;
            demoFooter.style.color = footerText;
        }
    }
</script>
@endpush
