@extends('layouts.admin')

@section('title', 'Publicaciones y Cursos')
@section('page-title', 'Gestión de Publicaciones / Cursos')

@section('content')
<div class="space-y-6">
    <!-- Action Bar & Filters -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.posts.index') }}" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <div class="relative flex-1 sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por título o sinopsis..." 
                       class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
            </div>

            <select name="category_id" onchange="this.form.submit()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-500">
                <option value="">Todas las Categorías</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-semibold transition">Filtrar</button>
            @if(request()->hasAny(['search', 'category_id']))
                <a href="{{ route('admin.posts.index') }}" class="text-xs text-slate-500 hover:text-slate-800 underline">Limpiar</a>
            @endif
        </form>

        <a href="{{ route('admin.posts.create') }}" class="w-full md:w-auto px-4 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-teal-600/20 flex items-center justify-center gap-2 transition">
            <i class="fa-solid fa-plus"></i>
            <span>Nueva Publicación</span>
        </a>
    </div>

    <!-- Posts Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider">
                        <th class="py-3.5 px-4">Portada</th>
                        <th class="py-3.5 px-4">Título / Sinopsis</th>
                        <th class="py-3.5 px-4">Categoría</th>
                        <th class="py-3.5 px-4">Elementos Adjuntos</th>
                        <th class="py-3.5 px-4">Docente</th>
                        <th class="py-3.5 px-4">Fecha</th>
                        <th class="py-3.5 px-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($posts as $p)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 px-4">
                                @if($p->main_image)
                                    <img src="{{ asset('storage/' . $p->main_image) }}" class="w-12 h-12 rounded-lg object-cover border border-slate-200 shadow-sm">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 text-sm">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3 px-4 max-w-xs">
                                <p class="font-bold text-slate-800 text-xs truncate" title="{{ $p->title }}">{{ $p->title }}</p>
                                <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ $p->synopsis ?? 'Sin descripción corta' }}</p>
                            </td>
                            <td class="py-3 px-4">
                                <span class="bg-teal-50 text-teal-700 border border-teal-200 text-[10px] font-semibold px-2 py-0.5 rounded-full whitespace-nowrap">
                                    {{ $p->category->name ?? 'Sin Categoría' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    @php
                                        $galCount = $p->attachments->where('type', 'gallery_image')->count();
                                        $sliderCount = $p->attachments->where('type', 'slider_image')->count();
                                        $pdfCount = $p->attachments->where('type', 'pdf')->count();
                                        $ytCount = $p->attachments->where('type', 'youtube')->count();
                                    @endphp
                                    @if($sliderCount > 0)
                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-teal-50 text-teal-700 border border-teal-200 rounded text-[10px] font-semibold" title="Activo en Slider rotativo de portada">
                                            <i class="fa-solid fa-panorama"></i> Slide
                                        </span>
                                    @endif
                                    @if($galCount > 0)
                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-purple-50 text-purple-700 border border-purple-200 rounded text-[10px]" title="{{ $galCount }} fotos de galería">
                                            <i class="fa-solid fa-images"></i> {{ $galCount }}
                                        </span>
                                    @endif
                                    @if($pdfCount > 0)
                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-rose-50 text-rose-700 border border-rose-200 rounded text-[10px]" title="PDF Folleto">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </span>
                                    @endif
                                    @if($ytCount > 0)
                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-red-50 text-red-700 border border-red-200 rounded text-[10px]" title="Video YouTube">
                                            <i class="fa-brands fa-youtube"></i>
                                        </span>
                                    @endif
                                    @if($galCount == 0 && $pdfCount == 0 && $ytCount == 0)
                                        <span class="text-[11px] text-slate-400">-</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                @if($p->instructor_name)
                                    <div class="flex items-center gap-2">
                                        @if($p->instructor_photo)
                                            <img src="{{ asset('storage/' . $p->instructor_photo) }}" class="w-6 h-6 rounded-full object-cover border border-slate-200">
                                        @endif
                                        <span class="text-[11px] text-slate-700 truncate max-w-[110px]" title="{{ $p->instructor_name }}">{{ $p->instructor_name }}</span>
                                    </div>
                                @else
                                    <span class="text-[11px] text-slate-400">N/A</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-slate-500 whitespace-nowrap">
                                {{ $p->created_at ? $p->created_at->format('d/m/Y') : '-' }}
                            </td>
                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.posts.edit', $p->id) }}" class="p-1.5 bg-slate-100 hover:bg-teal-50 text-slate-600 hover:text-teal-600 rounded-lg transition" title="Editar">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $p->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta publicación?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 rounded-lg transition" title="Eliminar">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <i class="fa-regular fa-folder-open text-3xl mb-2 text-slate-300 block"></i>
                                No se encontraron publicaciones registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
