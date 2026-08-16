@extends('layouts.admin')

@section('title', 'Categorías de Portafolio')
@section('page-title', 'Categorías de Portafolio')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Categorías de Portafolio</h2>
            <p class="text-xs text-slate-500 mt-1">Organiza tus trabajos y proyectos por tipos (ej: Logos, Websites, Impresiones, Fotografía, etc.)</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.portfolio.items.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 transition shadow-sm">
                <i class="fa-solid fa-arrow-left"></i> Volver a Trabajos
            </a>
            <button onclick="openCreateCategoryModal()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold shadow-sm shadow-teal-600/20 transition">
                <i class="fa-solid fa-plus"></i> Nueva Categoría
            </button>
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

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/75 border-b border-slate-100 text-slate-500 font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5 w-16">Orden</th>
                        <th class="px-6 py-3.5">Nombre de la Categoría</th>
                        <th class="px-6 py-3.5">Slug (Filtro)</th>
                        <th class="px-6 py-3.5 text-center">Trabajos Asociados</th>
                        <th class="px-6 py-3.5 text-center">Estado</th>
                        <th class="px-6 py-3.5 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse($categories as $cat)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 font-bold text-slate-400">#{{ $cat->order }}</td>
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $cat->name }}</td>
                            <td class="px-6 py-4 font-mono text-[11px] text-slate-500">{{ $cat->slug }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                    {{ $cat->items_count }} {{ Str::plural('trabajo', $cat->items_count) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($cat->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Activa
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Inactiva
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" onclick="openEditCategoryModal({{ $cat->id }}, '{{ addslashes($cat->name) }}', {{ $cat->order }}, {{ $cat->is_active ? 1 : 0 }})"
                                            class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:bg-teal-50 hover:text-teal-600 flex items-center justify-center transition" title="Editar">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>
                                    <form action="{{ route('admin.portfolio.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:bg-rose-50 hover:text-rose-600 flex items-center justify-center transition" title="Eliminar">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <i class="fa-solid fa-tags text-4xl mb-3 opacity-40"></i>
                                <p class="text-xs">No hay categorías registradas aún.</p>
                                <button onclick="openCreateCategoryModal()" class="mt-3 text-xs font-bold text-teal-600 hover:underline">
                                    + Crear la primera categoría (ej: Logos, Websites, etc.)
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Crear Categoría -->
<div id="createCategoryModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4 animate-in fade-in zoom-in duration-150">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                <i class="fa-solid fa-tag text-teal-600"></i> Nueva Categoría de Portafolio
            </h3>
            <button type="button" onclick="closeCreateCategoryModal()" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('admin.portfolio.categories.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nombre de la Categoría <span class="text-rose-500">*</span></label>
                <input type="text" name="name" required placeholder="Ej: Diseño de Logos, Páginas Web, etc." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Orden</label>
                    <input type="number" name="order" value="0" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                </div>
                <div class="flex items-center pt-5">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded text-teal-600 focus:ring-teal-500">
                        <span class="text-xs text-slate-700 font-semibold">Activa</span>
                    </label>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeCreateCategoryModal()" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">Cancelar</button>
                <button type="submit" class="px-4 py-2 rounded-xl text-xs font-semibold bg-teal-600 hover:bg-teal-700 text-white shadow-sm">Guardar Categoría</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Categoría -->
<div id="editCategoryModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                <i class="fa-solid fa-pen text-teal-600"></i> Editar Categoría de Portafolio
            </h3>
            <button type="button" onclick="closeEditCategoryModal()" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="editCategoryForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nombre de la Categoría <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="edit_category_name" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Orden</label>
                    <input type="number" name="order" id="edit_category_order" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                </div>
                <div class="flex items-center pt-5">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" id="edit_category_is_active" value="1" class="rounded text-teal-600 focus:ring-teal-500">
                        <span class="text-xs text-slate-700 font-semibold">Activa</span>
                    </label>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeEditCategoryModal()" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">Cancelar</button>
                <button type="submit" class="px-4 py-2 rounded-xl text-xs font-semibold bg-teal-600 hover:bg-teal-700 text-white shadow-sm">Actualizar Categoría</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateCategoryModal() {
        document.getElementById('createCategoryModal').classList.remove('hidden');
    }
    function closeCreateCategoryModal() {
        document.getElementById('createCategoryModal').classList.add('hidden');
    }
    function openEditCategoryModal(id, name, order, isActive) {
        document.getElementById('editCategoryForm').action = `/admin/portfolio/categories/${id}`;
        document.getElementById('edit_category_name').value = name;
        document.getElementById('edit_category_order').value = order;
        document.getElementById('edit_category_is_active').checked = (isActive == 1);
        document.getElementById('editCategoryModal').classList.remove('hidden');
    }
    function closeEditCategoryModal() {
        document.getElementById('editCategoryModal').classList.add('hidden');
    }
</script>
@endsection
