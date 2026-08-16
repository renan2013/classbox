@extends('layouts.admin')

@section('title', 'Portafolio de Trabajos')
@section('page-title', 'Portafolio de Trabajos / Proyectos')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Portafolio de Trabajos y Proyectos</h2>
            <p class="text-xs text-slate-500 mt-1">Muestra tus proyectos realizados, logos de clientes, sitios web o trabajos con filtros interactivos.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.portfolio.categories.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 transition shadow-sm">
                <i class="fa-solid fa-tags text-teal-600"></i> Gestionar Categorías
            </a>
            <a href="{{ route('admin.portfolio.items.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold shadow-sm shadow-teal-600/20 transition">
                <i class="fa-solid fa-plus"></i> Nuevo Trabajo
            </a>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <!-- Filters & Search Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
        <form method="GET" action="{{ route('admin.portfolio.items.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="w-full sm:w-64">
                <select name="category_id" onchange="this.form.submit()" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:ring-2 focus:ring-teal-500">
                    <option value="">Todas las Categorías</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full sm:flex-1 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por título, cliente o descripción..."
                       class="w-full pl-9 pr-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
            </div>
            <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-semibold">
                Filtrar
            </button>
            @if(request('category_id') || request('search'))
                <a href="{{ route('admin.portfolio.items.index') }}" class="w-full sm:w-auto px-3 py-2 text-center text-xs text-slate-500 hover:text-slate-800">
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    <!-- Items Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($items as $item)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col group hover:shadow-md transition">
                <!-- Thumbnail / Image -->
                <div class="h-44 bg-slate-100 relative overflow-hidden flex items-center justify-center p-3">
                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="max-h-full max-w-full object-contain group-hover:scale-105 transition duration-300">
                    <div class="absolute top-2 left-2 flex gap-1">
                        @if($item->category)
                            <span class="px-2 py-0.5 rounded-md text-[9px] font-bold bg-slate-900/75 text-white backdrop-blur-xs">
                                {{ $item->category->name }}
                            </span>
                        @endif
                    </div>
                    <div class="absolute top-2 right-2">
                        @if($item->is_active)
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 block ring-2 ring-white" title="Activo"></span>
                        @else
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-400 block ring-2 ring-white" title="Inactivo"></span>
                        @endif
                    </div>
                </div>

                <!-- Info -->
                <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                    <div>
                        <h4 class="font-bold text-slate-800 text-xs line-clamp-1" title="{{ $item->title }}">{{ $item->title }}</h4>
                        @if($item->client_name)
                            <p class="text-[11px] font-medium text-teal-600 mt-0.5"><i class="fa-regular fa-building mr-1"></i>{{ $item->client_name }}</p>
                        @endif
                        @if($item->description)
                            <p class="text-[11px] text-slate-400 mt-1 line-clamp-2">{{ $item->description }}</p>
                        @endif
                    </div>

                    <!-- Footer Actions -->
                    <div class="flex items-center justify-between pt-2 border-t border-slate-100 text-[11px]">
                        <span class="text-slate-400 font-semibold">Orden: #{{ $item->order }}</span>
                        <div class="flex items-center gap-1.5">
                            @if($item->project_url)
                                <a href="{{ $item->project_url }}" target="_blank" class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 hover:bg-teal-50 hover:text-teal-600 flex items-center justify-center transition" title="Ver Enlace Externo">
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                </a>
                            @endif
                            <a href="{{ route('admin.portfolio.items.edit', $item->id) }}" class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 hover:bg-teal-50 hover:text-teal-600 flex items-center justify-center transition" title="Editar">
                                <i class="fa-solid fa-pen text-[10px]"></i>
                            </a>
                            <form action="{{ route('admin.portfolio.items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este trabajo del portafolio?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 hover:bg-rose-50 hover:text-rose-600 flex items-center justify-center transition" title="Eliminar">
                                    <i class="fa-solid fa-trash text-[10px]"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-400">
                <i class="fa-solid fa-briefcase text-4xl mb-3 opacity-40"></i>
                <p class="text-xs font-medium">No se encontraron trabajos o proyectos registrados.</p>
                <a href="{{ route('admin.portfolio.items.create') }}" class="mt-3 inline-block text-xs font-bold text-teal-600 hover:underline">
                    + Subir el primer trabajo / proyecto
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $items->links() }}
    </div>
</div>
@endsection
