@extends('layouts.admin')

@section('title', 'Graduaciones y Galerías')
@section('page-title', 'Álbumes de Graduaciones & Galerías')

@section('content')
<div class="space-y-6">
    <!-- Formulario Crear Graduación -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
            <i class="fa-solid fa-graduation-cap text-teal-600"></i> Registrar Nuevo Álbum de Graduación
        </h3>

        <form action="{{ route('admin.graduaciones.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Título de la Graduación *</label>
                <input type="text" name="title" required placeholder="Ej: Graduación Febrero 2026" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Descripción / Resumen</label>
                <textarea name="synopsis" rows="2" placeholder="Breve reseña del evento..."
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Foto Principal / Portada</label>
                <input type="file" name="main_image" accept="image/*" 
                       class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Fotos del Álbum (Múltiples)</label>
                <input type="file" name="photos[]" multiple accept="image/*" 
                       class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-purple-50 file:text-purple-700">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Enlace de Video de YouTube (Opcional)</label>
                <input type="url" name="video_url" placeholder="https://youtu.be/..." 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-teal-600/20 transition">
                    Guardar Álbum
                </button>
            </div>
        </form>
    </div>

    <!-- Grid de Álbumes -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($graduaciones as $g)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between">
                <div>
                    @if($g->main_image)
                        <img src="{{ asset('storage/' . $g->main_image) }}" class="w-full h-44 object-cover">
                    @else
                        <div class="w-full h-44 bg-slate-100 flex items-center justify-center text-slate-400 text-2xl">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                    @endif

                    <div class="p-4 space-y-2">
                        <h4 class="font-bold text-slate-800 text-sm">{{ $g->title }}</h4>
                        <p class="text-xs text-slate-500 line-clamp-2">{{ $g->synopsis }}</p>
                        <p class="text-[11px] text-teal-600 font-semibold flex items-center gap-1">
                            <i class="fa-solid fa-images"></i> {{ $g->attachments->count() }} fotos en galería
                        </p>
                    </div>
                </div>

                <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] text-slate-400">{{ $g->created_at->format('d/m/Y') }}</span>
                    <form action="{{ route('admin.graduaciones.destroy', $g->id) }}" method="POST" onsubmit="return confirm('¿Eliminar álbum?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs font-semibold">
                            <i class="fa-solid fa-trash mr-1"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white p-8 rounded-2xl border border-slate-200 text-center text-slate-400 text-xs">
                No hay álbumes de graduación registrados todavía.
            </div>
        @endforelse
    </div>
</div>
@endsection
