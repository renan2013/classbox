@extends('layouts.admin')

@section('title', 'Editar Menú de Navegación')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h1 class="text-xl font-bold text-slate-900 flex items-center gap-2.5">
                <i class="fa-solid fa-pen-to-square text-teal-600"></i> Editar Enlace: {{ $menu->title }}
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Modifica el título, URL de destino, posición jerárquica u orden de este elemento de navegación.
            </p>
        </div>
        <a href="{{ route('admin.menus.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Volver a la Lista</span>
        </a>
    </div>

    <!-- Formulario de Edición -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
        <!-- Selector Rápido de Destino -->
        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
            <label class="block text-[11px] font-bold text-slate-700">
                ⚡ Cambiar rápidamente a una página existente:
            </label>
            <select id="quickLinkSelector" onchange="applyQuickLink(this)" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                <option value="">-- Seleccionar destino rápido --</option>
                
                <optgroup label="🏠 Páginas del Sistema">
                    <option data-title="Inicio" data-url="/">Inicio (/)</option>
                    <option data-title="Portafolio" data-url="/portafolio">Portafolio de Trabajos (/portafolio)</option>
                    <option data-title="Graduaciones" data-url="/graduaciones">Graduaciones & Fotos (/graduaciones)</option>
                    <option data-title="Quiénes Somos" data-url="/quienes-somos">Quiénes Somos (/quienes-somos)</option>
                    <option data-title="Docentes" data-url="/docentes">Docentes (/docentes)</option>
                    <option data-title="Testimonios" data-url="/testimonios">Testimonios (/testimonios)</option>
                    <option data-title="Contacto" data-url="/contacto">Contacto (/contacto)</option>
                </optgroup>

                @if($custom_pages->isNotEmpty())
                    <optgroup label="📄 Páginas Dinámicas Creadas">
                        @foreach($custom_pages as $cp)
                            <option data-title="{{ $cp->title }}" data-url="/pagina/{{ $cp->slug }}">{{ $cp->title }} (/pagina/{{ $cp->slug }})</option>
                        @endforeach
                    </optgroup>
                @endif

                @if($categories->isNotEmpty())
                    <optgroup label="🏷️ Escuelas / Categorías">
                        @foreach($categories as $cat)
                            <option data-title="{{ $cat->name }}" data-url="/categoria/{{ $cat->id }}">{{ $cat->name }} (/categoria/{{ $cat->id }})</option>
                        @endforeach
                    </optgroup>
                @endif

                <optgroup label="📂 Menú Contenedor (Dropdown)">
                    <option data-title="Menú Desplegable" data-url="#">Menú contenedor sin enlace (#)</option>
                </optgroup>
            </select>
        </div>

        <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Título del Enlace *</label>
                <input type="text" name="title" id="menuTitle" value="{{ old('title', $menu->title) }}" required 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">URL / Enlace *</label>
                <input type="text" name="url" id="menuUrl" value="{{ old('url', $menu->url) }}" required 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500 focus:bg-white transition font-mono">
                <span class="block text-[10px] text-slate-400 mt-1">Si apunta a <code class="text-teal-600 font-mono">/pagina/{slug}</code>, puedes editar su HTML justo abajo.</span>
            </div>

            <!-- Campo de Contenido HTML para esta Página -->
            <div class="p-4 bg-slate-50/75 border border-slate-200 rounded-xl space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-bold text-slate-800 flex items-center gap-1.5">
                        <i class="fa-solid fa-code text-teal-600 text-xs"></i> Contenido HTML de la Página:
                    </label>
                    <span class="text-[10px] bg-teal-100 text-teal-800 px-2 py-0.5 rounded font-semibold">Editar HTML</span>
                </div>
                <textarea name="page_content" id="page_content" rows="8" placeholder="<p>Escribe o pega aquí el código HTML para esta página...</p>"
                          class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-lg text-xs text-slate-800 font-mono focus:ring-2 focus:ring-teal-500 transition leading-relaxed">{{ old('page_content', $pageContent) }}</textarea>
                <p class="text-[10px] text-slate-500">Puedes escribir o pegar cualquier estructura HTML. El contenido se mostrará dentro de la plantilla institucional del sitio.</p>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Menú Superior / Padre</label>
                <select name="parent_id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                    <option value="">-- Menú Principal (Nivel Superior) --</option>
                    @foreach($all_parents as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id', $menu->parent_id) == $parent->id ? 'selected' : '' }}>
                            ↳ Submenú dentro de: {{ $parent->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Orden de Visualización</label>
                    <input type="number" name="display_order" value="{{ old('display_order', $menu->display_order) }}" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 text-center font-bold">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Abrir Enlace En</label>
                    <select name="target" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                        <option value="_self" {{ old('target', $menu->target) == '_self' ? 'selected' : '' }}>Misma Pestaña</option>
                        <option value="_blank" {{ old('target', $menu->target) == '_blank' ? 'selected' : '' }}>Nueva Pestaña</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-3">
                <button type="submit" class="flex-1 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-teal-600/20 transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Guardar Cambios y HTML</span>
                </button>
                <a href="{{ route('admin.menus.index') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function applyQuickLink(select) {
    const option = select.options[select.selectedIndex];
    if (!option || !option.value) return;

    const title = option.getAttribute('data-title');
    const url = option.getAttribute('data-url');

    if (title) {
        document.getElementById('menuTitle').value = title;
    }
    if (url) {
        document.getElementById('menuUrl').value = url;
    }
}
</script>
@endsection
