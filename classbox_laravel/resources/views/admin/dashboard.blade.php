@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Resumen General')

@section('content')
<div class="space-y-8">
    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Posts -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Publicaciones</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['total_posts'] }}</h3>
                <a href="{{ route('admin.posts.index') }}" class="text-xs text-teal-600 font-medium hover:underline mt-2 inline-block">Ver cursos &rarr;</a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-newspaper"></i>
            </div>
        </div>

        <!-- Admisiones Pendientes -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Admisiones</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <h3 class="text-2xl font-bold text-slate-800">{{ $stats['total_admisiones'] }}</h3>
                    @if($stats['pending_admisiones'] > 0)
                        <span class="text-[11px] font-semibold text-amber-700 bg-amber-100 px-2 py-0.5 rounded-full">{{ $stats['pending_admisiones'] }} pendientes</span>
                    @endif
                </div>
                <a href="{{ route('admin.admisiones.index') }}" class="text-xs text-teal-600 font-medium hover:underline mt-2 inline-block">Ver solicitudes &rarr;</a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
        </div>

        <!-- Categorías -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Categorías</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['total_categories'] }}</h3>
                <a href="{{ route('admin.categories.index') }}" class="text-xs text-teal-600 font-medium hover:underline mt-2 inline-block">Gestionar áreas &rarr;</a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-tags"></i>
            </div>
        </div>

        <!-- Testimonios -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Testimonios</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['total_testimonios'] }}</h3>
                <a href="{{ route('admin.testimonios.index') }}" class="text-xs text-teal-600 font-medium hover:underline mt-2 inline-block">Ver opiniones &rarr;</a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-comment-dots"></i>
            </div>
        </div>
    </div>

    <!-- Two-column Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Últimas Publicaciones -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-teal-600"></i> Últimas Publicaciones
                </h3>
                <a href="{{ route('admin.posts.create') }}" class="text-xs font-semibold text-teal-600 bg-teal-50 px-2.5 py-1 rounded-lg hover:bg-teal-100 transition">
                    + Nueva
                </a>
            </div>

            @if($recent_posts->isEmpty())
                <p class="text-xs text-slate-400 text-center py-6">No hay publicaciones registradas aún.</p>
            @else
                <div class="space-y-3">
                    @foreach($recent_posts as $p)
                        <div class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition border border-slate-100">
                            <div class="flex items-center gap-3 min-w-0">
                                @if($p->main_image)
                                    <img src="{{ asset('storage/' . $p->main_image) }}" class="w-10 h-10 rounded-lg object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 text-xs">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                @endif
                                <div class="truncate">
                                    <h4 class="text-xs font-bold text-slate-800 truncate">{{ $p->title }}</h4>
                                    <p class="text-[11px] text-slate-500">{{ $p->category->name ?? 'Sin categoría' }} • {{ $p->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.posts.edit', $p->id) }}" class="text-xs text-slate-400 hover:text-teal-600 p-2">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Últimas Solicitudes de Admisión -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-envelope-open-text text-indigo-600"></i> Admisiones Recientes
                </h3>
                <a href="{{ route('admin.admisiones.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">
                    Ver todas
                </a>
            </div>

            @if($recent_admisiones->isEmpty())
                <p class="text-xs text-slate-400 text-center py-6">No hay solicitudes de admisión recientes.</p>
            @else
                <div class="space-y-3">
                    @foreach($recent_admisiones as $adm)
                        <div class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition border border-slate-100">
                            <div class="min-w-0">
                                <h4 class="text-xs font-bold text-slate-800">{{ $adm->nombre }}</h4>
                                <p class="text-[11px] text-slate-500 truncate">{{ $adm->programa }} • {{ $adm->whatsapp }}</p>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full uppercase
                                {{ $adm->estado == 'pendiente' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ $adm->estado == 'contactado' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $adm->estado == 'matriculado' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                {{ $adm->estado == 'cancelado' ? 'bg-rose-100 text-rose-800' : '' }}">
                                {{ $adm->estado }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
