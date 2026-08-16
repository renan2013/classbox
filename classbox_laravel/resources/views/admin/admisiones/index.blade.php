@extends('layouts.admin')

@section('title', 'Admisiones y Prospectos')
@section('page-title', 'Gestión de Admisiones y Matrículas')

@section('content')
<div class="space-y-6">
    <!-- Action Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.admisiones.index') }}" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <div class="relative flex-1 sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre, email, whatsapp..." 
                       class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-teal-500">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
            </div>

            <select name="estado" onchange="this.form.submit()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700">
                <option value="">Todos los Estados</option>
                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="contactado" {{ request('estado') == 'contactado' ? 'selected' : '' }}>Contactado</option>
                <option value="matriculado" {{ request('estado') == 'matriculado' ? 'selected' : '' }}>Matriculado</option>
                <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>

            <button type="submit" class="px-3 py-2 bg-slate-800 text-white rounded-xl text-xs font-semibold">Filtrar</button>
            @if(request()->hasAny(['search', 'estado']))
                <a href="{{ route('admin.admisiones.index') }}" class="text-xs text-slate-500 hover:text-slate-800 underline">Limpiar</a>
            @endif
        </form>

        <a href="{{ route('admin.admisiones.export') }}" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-emerald-600/20 flex items-center gap-2 transition">
            <i class="fa-solid fa-file-excel"></i>
            <span>Exportar CSV</span>
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider">
                        <th class="py-3.5 px-4">Estudiante / Prospecto</th>
                        <th class="py-3.5 px-4">Programa de Interés</th>
                        <th class="py-3.5 px-4">Contacto (WhatsApp / Email)</th>
                        <th class="py-3.5 px-4">Fecha</th>
                        <th class="py-3.5 px-4">Estado</th>
                        <th class="py-3.5 px-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($admisiones as $adm)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 px-4">
                                <p class="font-bold text-slate-800">{{ $adm->nombre }}</p>
                                <p class="text-[11px] text-slate-400">{{ $adm->nacionalidad }}</p>
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-700">
                                {{ $adm->programa }}
                            </td>
                            <td class="py-3 px-4">
                                <p class="flex items-center gap-1.5 text-emerald-700 font-medium">
                                    <i class="fa-brands fa-whatsapp text-emerald-500"></i> +{{ $adm->codigo_pais ?? '506' }} {{ $adm->whatsapp }}
                                </p>
                                <p class="text-[11px] text-slate-500">{{ $adm->email }}</p>
                            </td>
                            <td class="py-3 px-4 text-slate-500">
                                {{ $adm->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full uppercase
                                    {{ $adm->estado == 'pendiente' ? 'bg-amber-100 text-amber-800' : '' }}
                                    {{ $adm->estado == 'contactado' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $adm->estado == 'matriculado' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $adm->estado == 'cancelado' ? 'bg-rose-100 text-rose-800' : '' }}">
                                    {{ $adm->estado }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('admin.admisiones.show', $adm->id) }}" class="p-1.5 bg-slate-100 hover:bg-teal-50 text-slate-600 hover:text-teal-600 rounded-lg transition" title="Ver Detalle">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                No se encontraron solicitudes de admisión.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($admisiones->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $admisiones->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
