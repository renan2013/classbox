@extends('layouts.admin')

@section('title', 'Páginas del Sitio')
@section('page-title', 'Gestión de Páginas Estáticas e Institucionales')

@section('content')
<div class="space-y-6 pb-12">
    <!-- Action Bar & Filters -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.pages.index') }}" class="flex items-center gap-2 w-full sm:w-auto">
            <div class="relative flex-1 sm:w-72">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por título o slug..." 
                       class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
            </div>
            <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-semibold transition">Buscar</button>
            @if(request('search'))
                <a href="{{ route('admin.pages.index') }}" class="text-xs text-slate-500 hover:text-slate-800 underline">Limpiar</a>
            @endif
        </form>

        <a href="{{ route('admin.pages.create') }}" class="w-full sm:w-auto px-4 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-teal-600/20 flex items-center justify-center gap-2 transition">
            <i class="fa-solid fa-plus"></i>
            <span>Nueva Página</span>
        </a>
    </div>

    <!-- Pages Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider">
                        <th class="py-3.5 px-4">Página / Título</th>
                        <th class="py-3.5 px-4">Ruta (Slug URL)</th>
                        <th class="py-3.5 px-4">Estado</th>
                        <th class="py-3.5 px-4">SEO Configurado</th>
                        <th class="py-3.5 px-4">Fecha</th>
                        <th class="py-3.5 px-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($pages as $p)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    @if($p->featured_image)
                                        <img src="{{ $p->featured_image_url }}" class="w-10 h-10 rounded-lg object-cover border border-slate-200 shadow-sm">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 text-sm">
                                            <i class="fa-regular fa-file-lines"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-slate-800 text-xs">{{ $p->title }}</p>
                                        <span class="text-[10px] text-slate-400">{{ Str::limit(strip_tags($p->content), 45) ?: 'Sin contenido' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ $p->public_url }}" target="_blank" class="inline-flex items-center gap-1 font-mono text-[11px] text-teal-700 bg-teal-50 border border-teal-200 px-2 py-0.5 rounded-lg hover:bg-teal-100 transition" title="Ver en el sitio web">
                                    <span>/{{ $p->slug }}</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                </a>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $p->is_published ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                    {{ $p->is_published ? 'Publicada' : 'Borrador' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                @if($p->meta_title || $p->meta_description)
                                    <span class="inline-flex items-center gap-1 text-[10px] text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                        <i class="fa-solid fa-check"></i> Optimizado
                                    </span>
                                @else
                                    <span class="text-[10px] text-slate-400">Por defecto</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-slate-500 whitespace-nowrap">
                                {{ $p->created_at->format('d/m/Y') }}
                            </td>
                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    {{-- Botón de Visibilidad (Ojo) --}}
                                    <form action="{{ route('admin.pages.toggle_status', $p->id) }}" method="POST">
                                        @csrf
                                        @if($p->is_published)
                                            <button type="submit" class="p-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg transition" title="Página publicada. Clic para ocultar (borrador)">
                                                <i class="fa-solid fa-eye text-xs"></i>
                                            </button>
                                        @else
                                            <button type="submit" class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-400 rounded-lg transition" title="Página en borrador. Clic para publicar">
                                                <i class="fa-solid fa-eye-slash text-xs"></i>
                                            </button>
                                        @endif
                                    </form>

                                    <a href="{{ route('admin.pages.edit', $p->id) }}" class="p-1.5 bg-slate-100 hover:bg-teal-50 text-slate-600 hover:text-teal-600 rounded-lg transition" title="Editar">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>

                                    @php
                                        $isSystemPage = in_array($p->slug, ['quienes-somos', 'sobre-nosotros', 'about', 'contacto', 'docentes', 'testimonios', 'graduaciones', 'portafolio', 'inicio']);
                                    @endphp

                                    @if($isSystemPage)
                                        <span class="p-1.5 text-slate-300 cursor-help" title="Página base del sistema. No se puede eliminar, pero puedes ocultarla usando el botón de visibilidad.">
                                            <i class="fa-solid fa-shield-halved text-xs"></i>
                                        </span>
                                    @else
                                        <form action="{{ route('admin.pages.destroy', $p->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta página?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 rounded-lg transition" title="Eliminar">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="fa-regular fa-file-lines text-3xl mb-2 text-slate-300 block"></i>
                                No hay páginas creadas todavía. Crea páginas como "Quiénes Somos" o "Términos y Condiciones".
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pages->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $pages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
