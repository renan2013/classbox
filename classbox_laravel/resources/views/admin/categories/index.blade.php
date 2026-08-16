@extends('layouts.admin')

@section('title', 'Categorías')
@section('page-title', 'Gestor de Categorías')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Formulario Crear Categoría -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
            <i class="fa-solid fa-plus-circle text-teal-600"></i> Nueva Categoría
        </h3>

        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nombre de la Categoría *</label>
                <input type="text" name="name" required placeholder="Ej: Diplomados, Técnicos..." 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Icono / Imagen Representativa</label>
                <input type="file" name="image" accept="image/*" 
                       class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700">
            </div>

            <button type="submit" class="w-full py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-teal-600/20 transition">
                Guardar Categoría
            </button>
        </form>
    </div>

    <!-- Lista de Categorías -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 bg-slate-50/75 border-b border-slate-200">
            <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Categorías Registradas</h3>
        </div>

        <div class="divide-y divide-slate-100 text-xs">
            @forelse($categories as $cat)
                <div class="p-4 flex items-center justify-between hover:bg-slate-50/50 transition">
                    <div class="flex items-center gap-3">
                        @if($cat->image)
                            <img src="{{ asset('storage/' . $cat->image) }}" class="w-10 h-10 rounded-lg object-cover border border-slate-200">
                        @else
                            <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center font-bold">
                                <i class="fa-solid fa-tag"></i>
                            </div>
                        @endif
                        <div>
                            <h4 class="font-bold text-slate-800">{{ $cat->name }}</h4>
                            <p class="text-[11px] text-slate-500">{{ $cat->posts_count }} publicaciones asociadas</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta categoría?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 rounded-lg transition" title="Eliminar">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="p-6 text-center text-slate-400">No hay categorías creadas aún.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
