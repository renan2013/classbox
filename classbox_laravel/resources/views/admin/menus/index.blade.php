@extends('layouts.admin')

@section('title', 'Menús del Sitio')
@section('page-title', 'Gestor de Menús de Navegación')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Formulario Crear Menú -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
            <i class="fa-solid fa-plus-circle text-teal-600"></i> Nuevo Enlace de Menú
        </h3>

        <form action="{{ route('admin.menus.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Título del Enlace *</label>
                <input type="text" name="title" required placeholder="Ej: Quiénes Somos, Cursos..." 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">URL / Enlace *</label>
                <input type="text" name="url" required placeholder="Ej: about.php o https://..." 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Menú Superior / Padre (Opcional)</label>
                <select name="parent_id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                    <option value="">-- Es un menú principal (Sin padre) --</option>
                    @foreach($all_parents as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->title }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Orden de Visualización</label>
                <input type="number" name="display_order" value="0" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
            </div>

            <button type="submit" class="w-full py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-teal-600/20 transition">
                Agregar Menú
            </button>
        </form>
    </div>

    <!-- Lista Jerárquica de Menús -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 bg-slate-50/75 border-b border-slate-200">
            <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Estructura de Navegación</h3>
        </div>

        <div class="divide-y divide-slate-100 text-xs">
            @forelse($menus as $m)
                <div class="p-4 space-y-2 hover:bg-slate-50/50 transition">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded bg-slate-100 font-bold text-[10px] text-slate-500 flex items-center justify-center">{{ $m->display_order }}</span>
                            <span class="font-bold text-slate-800 text-sm">{{ $m->title }}</span>
                            <span class="text-[11px] text-slate-400 font-mono">({{ $m->url }})</span>
                        </div>
                        <form action="{{ route('admin.menus.destroy', $m->id) }}" method="POST" onsubmit="return confirm('¿Eliminar menú y sus submenús?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-rose-500 hover:text-rose-700">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </form>
                    </div>

                    @if($m->children->isNotEmpty())
                        <div class="pl-8 space-y-1.5 border-l-2 border-slate-200 ml-3">
                            @foreach($m->children as $sub)
                                <div class="flex items-center justify-between py-1 text-slate-600">
                                    <div class="flex items-center gap-2">
                                        <span class="text-slate-400 font-mono text-[10px]">↳</span>
                                        <span class="font-medium text-slate-700">{{ $sub->title }}</span>
                                        <span class="text-[10px] text-slate-400 font-mono">({{ $sub->url }})</span>
                                    </div>
                                    <form action="{{ route('admin.menus.destroy', $sub->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-400 hover:text-rose-600">
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <p class="p-6 text-center text-slate-400">No hay menús registrados.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
