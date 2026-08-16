@extends('layouts.admin')

@section('title', 'Testimonios')
@section('page-title', 'Gestor de Testimonios y Reseñas')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Formulario Crear Testimonio -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
            <i class="fa-solid fa-plus-circle text-teal-600"></i> Nuevo Testimonio
        </h3>

        <form action="{{ route('admin.testimonios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nombre del Estudiante *</label>
                <input type="text" name="nombre" required placeholder="Ej: Marcela Vargas" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Profesión / Carrera</label>
                <input type="text" name="profesion" placeholder="Ej: Asistente Dental" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Comentario / Opinión *</label>
                <textarea name="comentario" rows="3" required placeholder="Comentario sobre su experiencia..."
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Código Embebido de Video (iframe)</label>
                <textarea name="video_iframe" rows="2" placeholder='<iframe src="https://..."></iframe>'
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Foto del Estudiante</label>
                <input type="file" name="foto" accept="image/*" 
                       class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700">
            </div>

            <button type="submit" class="w-full py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-teal-600/20 transition">
                Publicar Testimonio
            </button>
        </form>
    </div>

    <!-- Lista de Testimonios -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 bg-slate-50/75 border-b border-slate-200">
            <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Testimonios Registrados</h3>
        </div>

        <div class="divide-y divide-slate-100 text-xs">
            @forelse($testimonios as $t)
                <div class="p-4 flex items-start justify-between hover:bg-slate-50/50 transition">
                    <div class="flex items-start gap-3">
                        @if($t->foto)
                            <img src="{{ asset('storage/' . $t->foto) }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 shrink-0">
                        @else
                            <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center font-bold shrink-0">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        @endif
                        <div>
                            <h4 class="font-bold text-slate-800">{{ $t->nombre }} <span class="text-slate-400 font-normal">({{ $t->profesion ?? 'Estudiante' }})</span></h4>
                            <p class="text-slate-600 mt-1 italic">"{{ $t->comentario }}"</p>
                            @if($t->video_iframe)
                                <span class="inline-flex items-center gap-1 text-[10px] text-red-600 font-semibold bg-red-50 px-2 py-0.5 rounded-full mt-2">
                                    <i class="fa-brands fa-youtube"></i> Incluye Video
                                </span>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('admin.testimonios.destroy', $t->id) }}" method="POST" onsubmit="return confirm('¿Eliminar testimonio?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 rounded-lg transition" title="Eliminar">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </form>
                </div>
            @empty
                <p class="p-6 text-center text-slate-400">No hay testimonios registrados.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
