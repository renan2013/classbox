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

            <!-- Selector Rápido de Destino -->
            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
                <label class="block text-[11px] font-bold text-slate-700">
                    ⚡ Autocompletar con Página del Sitio:
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
                <p class="text-[10px] text-slate-400">Al seleccionar una opción se completarán automáticamente el Título y la URL.</p>
            </div>

            <form action="{{ route('admin.menus.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Título del Enlace *</label>
                    <input type="text" name="title" id="menuTitle" required placeholder="Ej: Quiénes Somos, Cursos..." 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">URL / Enlace *</label>
                    <input type="text" name="url" id="menuUrl" required placeholder="Ej: /quienes-somos o https://..." 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500 focus:bg-white transition font-mono">
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
                    <span>Agregar al Menú</span>
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
                    <div class="p-4 space-y-3 hover:bg-slate-50/50 transition">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <span class="w-7 h-7 rounded-lg bg-teal-50 border border-teal-100 font-bold text-xs text-teal-700 flex items-center justify-center shrink-0 shadow-sm">
                                    {{ $m->display_order }}
                                </span>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-900 text-sm">{{ $m->title }}</span>
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
                                    <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50 border border-slate-200/80 hover:bg-white transition text-xs">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-5 h-5 rounded bg-slate-200/70 font-semibold text-[10px] text-slate-600 flex items-center justify-center">
                                                {{ $sub->display_order }}
                                            </span>
                                            <div>
                                                <span class="font-semibold text-slate-800">{{ $sub->title }}</span>
                                                <span class="text-[10px] text-slate-400 font-mono ml-1.5">({{ $sub->url }})</span>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-1">
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
