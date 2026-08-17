@extends('layouts.admin')

@section('title', 'Menús de Navegación')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h1 class="text-xl font-bold text-slate-900 flex items-center gap-2.5">
                <i class="fa-solid fa-bars text-teal-600"></i> Gestor de Menús de Navegación
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Configura los enlaces de la barra superior. Puedes vincular páginas del sistema, páginas estáticas/dinámicas creadas en el CMS, categorías o URLs personalizadas.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('admin.menus.seed_defaults') }}" method="POST" onsubmit="return confirm('¿Restaurar la estructura de menús original por defecto? Se reconfigurarán los enlaces principales.')">
                @csrf
                <button type="submit" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition flex items-center gap-2">
                    <i class="fa-solid fa-rotate-left text-slate-500"></i>
                    <span>Restaurar Predeterminados</span>
                </button>
            </form>
            <a href="{{ env('FRONTEND_URL', 'http://127.0.0.1:8080') }}" target="_blank" class="px-4 py-2.5 bg-teal-50 hover:bg-teal-100 text-teal-700 rounded-xl text-xs font-bold transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Ver Sitio Web</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-xs flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Formulario Crear Menú -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-plus-circle text-teal-600"></i> Añadir Enlace de Menú
                </h3>
                <span class="text-[11px] text-teal-600 font-medium">Nuevo elemento</span>
            </div>

            <!-- Selector Rápido de Destino Opcional -->
            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
                <label class="block text-[11px] font-bold text-slate-700">
                    ⚡ Opcional: Vincular a Página / Categoría existente:
                </label>
                <select id="quickLinkSelector" onchange="applyQuickLink(this)" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Usar página HTML propia o elegir existente --</option>
                    
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
                <p class="text-[10px] text-slate-400">Si dejas esto en blanco, se creará una nueva página con el título que escribas abajo.</p>
            </div>

            <form action="{{ route('admin.menus.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Título del Enlace / Menú *</label>
                    <input type="text" name="title" id="menuTitle" required placeholder="Ej: Servicios Especiales, Convenios..." 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500 focus:bg-white transition font-medium">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-semibold text-slate-700">URL / Enlace Predeterminado</label>
                        <span class="text-[10px] text-teal-600 font-medium">Auto-generado</span>
                    </div>
                    <input type="text" name="url" id="menuUrl" placeholder="Ej: /pagina/mi-menu o https://..." 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500 focus:bg-white transition font-mono">
                    <span class="block text-[10px] text-slate-400 mt-1">Se genera automáticamente como <code class="text-teal-600 font-mono">/pagina/{slug}</code> o puedes cambiarlo por cualquier link.</span>
                </div>

                <!-- Campo para escribir o pegar HTML -->
                <div class="p-3.5 bg-slate-50/75 border border-slate-200 rounded-xl space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-code text-teal-600 text-xs"></i> Contenido HTML de la Página:
                        </label>
                        <span class="text-[10px] bg-teal-100 text-teal-800 px-2 py-0.5 rounded font-semibold">Pega tu HTML</span>
                    </div>
                    <textarea name="page_content" id="page_content" rows="6" placeholder="<p>Escribe o pega aquí el código HTML que se publicará en esta página...</p>"
                              class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs text-slate-800 font-mono focus:ring-2 focus:ring-teal-500 focus:bg-white transition"></textarea>
                    <p class="text-[10px] text-slate-500">Puedes pegar código HTML, textos, tablas o imágenes. Se publicará manteniendo el diseño y estilo completo del sitio web.</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Menú Superior / Padre (Opcional)</label>
                    <select name="parent_id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                        <option value="">-- Menú Principal (Nivel Superior) --</option>
                        @foreach($all_parents as $parent)
                            <option value="{{ $parent->id }}">↳ Submenú dentro de: {{ $parent->title }}</option>
                        @endforeach
                    </select>
                    <span class="block text-[10px] text-slate-400 mt-1">Si seleccionas un padre, aparecerá desplegable en el menú.</span>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Orden</label>
                        <input type="number" name="display_order" value="{{ ($menus->max('display_order') ?? 0) + 1 }}" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 text-center font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Abrir Enlace En</label>
                        <select name="target" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                            <option value="_self">Misma Pestaña</option>
                            <option value="_blank">Nueva Pestaña</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-teal-600/20 transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>Guardar y Agregar al Menú</span>
                </button>
            </form>
        </div>

        <!-- Lista Jerárquica de Menús -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="p-4 bg-slate-50/75 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-sitemap text-slate-500"></i>
                    <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Estructura de Navegación del Sitio</h3>
                </div>
                <span class="text-[11px] text-slate-400 font-medium">{{ $menus->count() }} enlaces principales</span>
            </div>

            <div class="divide-y divide-slate-100 flex-1">
                @forelse($menus as $m)
                    @php
                        $isActive = ($m->is_active !== null && $m->is_active !== '') ? (bool)$m->is_active : true;
                    @endphp
                    <div class="p-4 space-y-3 hover:bg-slate-50/50 transition {{ !$isActive ? 'bg-slate-50/70 opacity-70' : '' }}">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <span class="w-7 h-7 rounded-lg {{ $isActive ? 'bg-teal-50 border-teal-100 text-teal-700' : 'bg-slate-100 border-slate-200 text-slate-400' }} border font-bold text-xs flex items-center justify-center shrink-0 shadow-sm">
                                    {{ $m->display_order }}
                                </span>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold {{ $isActive ? 'text-slate-900' : 'text-slate-500 line-through' }} text-sm">{{ $m->title }}</span>
                                        
                                        @if(!$isActive)
                                            <span class="px-2 py-0.5 rounded-md bg-slate-200 text-slate-600 text-[10px] font-semibold">
                                                Oculto en Sitio
                                            </span>
                                        @endif

                                        @if($m->children->isNotEmpty())
                                            <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 text-[10px] font-semibold border border-amber-200">
                                                Desplegable ({{ $m->children->count() }} submenús)
                                            </span>
                                        @endif
                                        @if($m->target === '_blank')
                                            <span class="text-slate-400 text-[10px]" title="Abre en nueva pestaña">
                                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                            </span>
                                        @endif
                                    </div>
                                    <span class="text-[11px] text-slate-400 font-mono">{{ $m->url }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-1.5 shrink-0">
                                {{-- Botón Ojo (Mostrar / Ocultar) --}}
                                <form action="{{ route('admin.menus.toggle_status', $m->id) }}" method="POST">
                                    @csrf
                                    @if($isActive)
                                        <button type="submit" class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-lg text-xs font-semibold transition flex items-center gap-1.5" title="Menú visible en el sitio. Clic para ocultar">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                            <span class="hidden sm:inline">Visible</span>
                                        </button>
                                    @else
                                        <button type="submit" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-500 border border-slate-200 rounded-lg text-xs font-semibold transition flex items-center gap-1.5" title="Menú oculto en el sitio. Clic para mostrar">
                                            <i class="fa-solid fa-eye-slash text-xs"></i>
                                            <span class="hidden sm:inline">Oculto</span>
                                        </button>
                                    @endif
                                </form>

                                <a href="{{ route('admin.menus.edit', $m->id) }}" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition flex items-center gap-1">
                                    <i class="fa-solid fa-pen text-[10px]"></i>
                                    <span>Editar</span>
                                </a>
                                <form action="{{ route('admin.menus.destroy', $m->id) }}" method="POST" onsubmit="return confirm('¿Eliminar \'{{ $m->title }}\' y todos sus submenús?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition" title="Eliminar menú">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Submenús Anidados --}}
                        @if($m->children->isNotEmpty())
                            <div class="pl-8 space-y-2 border-l-2 border-teal-200 ml-3.5 pt-1 pb-1">
                                @foreach($m->children as $sub)
                                    @php
                                        $isSubActive = ($sub->is_active !== null && $sub->is_active !== '') ? (bool)$sub->is_active : true;
                                    @endphp
                                    <div class="flex items-center justify-between p-2 rounded-xl {{ $isSubActive ? 'bg-slate-50 border-slate-200/80 hover:bg-white' : 'bg-slate-100/70 border-slate-200 opacity-60' }} border transition text-xs">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-5 h-5 rounded bg-slate-200/70 font-semibold text-[10px] text-slate-600 flex items-center justify-center">
                                                {{ $sub->display_order }}
                                            </span>
                                            <div>
                                                <span class="font-semibold {{ $isSubActive ? 'text-slate-800' : 'text-slate-500 line-through' }}">{{ $sub->title }}</span>
                                                <span class="text-[10px] text-slate-400 font-mono ml-1.5">({{ $sub->url }})</span>
                                                @if(!$isSubActive)
                                                    <span class="ml-1 text-[9px] text-slate-400 font-bold uppercase">(Oculto)</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-1">
                                            {{-- Ojo para submenú --}}
                                            <form action="{{ route('admin.menus.toggle_status', $sub->id) }}" method="POST">
                                                @csrf
                                                @if($isSubActive)
                                                    <button type="submit" class="p-1 text-emerald-600 hover:text-emerald-800 transition" title="Submenú visible. Clic para ocultar">
                                                        <i class="fa-solid fa-eye text-xs"></i>
                                                    </button>
                                                @else
                                                    <button type="submit" class="p-1 text-slate-400 hover:text-slate-600 transition" title="Submenú oculto. Clic para mostrar">
                                                        <i class="fa-solid fa-eye-slash text-xs"></i>
                                                    </button>
                                                @endif
                                            </form>

                                            <a href="{{ route('admin.menus.edit', $sub->id) }}" class="p-1 text-slate-400 hover:text-slate-700 transition" title="Editar submenú">
                                                <i class="fa-solid fa-pen text-[10px]"></i>
                                            </a>
                                            <form action="{{ route('admin.menus.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('¿Eliminar submenú \'{{ $sub->title }}\'?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 text-slate-400 hover:text-rose-600 transition" title="Eliminar">
                                                    <i class="fa-solid fa-xmark text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="p-12 text-center space-y-3">
                        <i class="fa-solid fa-sitemap text-3xl text-slate-300"></i>
                        <p class="text-slate-500 font-medium">No hay menús registrados.</p>
                        <form action="{{ route('admin.menus.seed_defaults') }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold transition">
                                Cargar Menús Predeterminados del Sitio
                            </button>
                        </form>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('menuTitle');
    const urlInput = document.getElementById('menuUrl');
    let userEditedUrl = false;

    urlInput.addEventListener('input', function() {
        userEditedUrl = true;
    });

    titleInput.addEventListener('input', function() {
        if (!userEditedUrl) {
            const slug = titleInput.value
                .toLowerCase()
                .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            urlInput.value = slug ? ('/pagina/' + slug) : '';
        }
    });
});

function applyQuickLink(select) {
    const option = select.options[select.selectedIndex];
    if (!option || !option.value) return;

    const title = option.getAttribute('data-title');
    const url = option.getAttribute('data-url');

    if (title) {
        document.getElementById('menuTitle').value = title;
    }
    if (url) {
        const urlInput = document.getElementById('menuUrl');
        urlInput.value = url;
    }
}
</script>
@endsection
