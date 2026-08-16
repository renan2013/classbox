@extends('layouts.admin')

@section('title', 'Banners y Sliders')
@section('page-title', 'Gestión de Banners & Sliders de Portada')

@section('content')
<div class="space-y-6 pb-12">
    <!-- Action Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="text-sm font-bold text-slate-800">Carruseles y Banners del Inicio</h3>
            <p class="text-xs text-slate-500">Administra las imágenes de portada, botones de llamada a la acción y avisos.</p>
        </div>

        <a href="{{ route('admin.banners.create') }}" class="w-full sm:w-auto px-4 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-teal-600/20 flex items-center justify-center gap-2 transition">
            <i class="fa-solid fa-plus"></i>
            <span>Nuevo Banner</span>
        </a>
    </div>

    <!-- Banners Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider">
                        <th class="py-3.5 px-4">Banner (Desktop / Mobile)</th>
                        <th class="py-3.5 px-4">Título / Subtítulo</th>
                        <th class="py-3.5 px-4">Botón CTA</th>
                        <th class="py-3.5 px-4">Orden</th>
                        <th class="py-3.5 px-4">Estado</th>
                        <th class="py-3.5 px-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($banners as $b)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-24 h-12 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden relative group shrink-0">
                                        <img src="{{ $b->image_url }}" alt="{{ $b->title }}" class="w-full h-full object-cover">
                                        <span class="absolute bottom-0 right-0 bg-slate-900/70 text-[8px] text-white px-1 rounded-tl">PC</span>
                                    </div>
                                    @if($b->mobile_image_path)
                                        <div class="w-8 h-12 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden relative shrink-0">
                                            <img src="{{ $b->mobile_image_url }}" alt="Mobile" class="w-full h-full object-cover">
                                            <span class="absolute bottom-0 right-0 bg-teal-800/80 text-[7px] text-white px-0.5 rounded-tl">Móvil</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4 max-w-xs">
                                <p class="font-bold text-slate-800 text-xs truncate">{{ $b->title ?? 'Sin título' }}</p>
                                <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ $b->subtitle ?? '-' }}</p>
                            </td>
                            <td class="py-3 px-4">
                                @if($b->button_text)
                                    <a href="{{ $b->button_url ?? '#' }}" target="_blank" class="inline-flex items-center gap-1 px-2 py-0.5 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-lg text-[10px] font-semibold transition truncate max-w-[120px]">
                                        <span>{{ $b->button_text }}</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                    </a>
                                @else
                                    <span class="text-slate-400 text-[11px]">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 font-mono font-semibold text-slate-600">
                                {{ $b->order }}
                            </td>
                            <td class="py-3 px-4">
                                <form action="{{ route('admin.banners.toggle_status', $b->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold transition {{ $b->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $b->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                        <span>{{ $b->is_active ? 'Activo' : 'Inactivo' }}</span>
                                    </button>
                                </form>
                            </td>
                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.banners.edit', $b->id) }}" class="p-1.5 bg-slate-100 hover:bg-teal-50 text-slate-600 hover:text-teal-600 rounded-lg transition" title="Editar">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.banners.destroy', $b->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este banner?')">
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
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="fa-regular fa-panorama text-3xl mb-2 text-slate-300 block"></i>
                                No hay banners registrados. Crea el primer slider para la página de inicio.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($banners->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $banners->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
