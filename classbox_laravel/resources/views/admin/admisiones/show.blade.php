@extends('layouts.admin')

@section('title', 'Detalle de Solicitud')
@section('page-title', 'Admisión: ' . $matricula->nombre)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h3 class="font-bold text-slate-800 text-base">{{ $matricula->nombre }}</h3>
                <p class="text-xs text-slate-500">Solicitud recibida el {{ $matricula->created_at->format('d/m/Y a las H:i') }}</p>
            </div>
            <a href="https://wa.me/{{ $matricula->codigo_pais ?? '506' }}{{ $matricula->whatsapp }}" target="_blank" 
               class="px-3.5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl text-xs flex items-center gap-2 shadow-lg shadow-emerald-500/20 transition">
                <i class="fa-brands fa-whatsapp text-sm"></i> Chatear por WhatsApp
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                <p class="text-slate-400 font-semibold uppercase text-[10px]">Programa de Interés</p>
                <p class="font-bold text-slate-800 text-sm mt-0.5">{{ $matricula->programa }}</p>
            </div>

            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                <p class="text-slate-400 font-semibold uppercase text-[10px]">Correo Electrónico</p>
                <p class="font-bold text-slate-800 text-sm mt-0.5">{{ $matricula->email }}</p>
            </div>

            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                <p class="text-slate-400 font-semibold uppercase text-[10px]">Número de WhatsApp</p>
                <p class="font-bold text-slate-800 text-sm mt-0.5">+{{ $matricula->codigo_pais ?? '506' }} {{ $matricula->whatsapp }}</p>
            </div>

            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                <p class="text-slate-400 font-semibold uppercase text-[10px]">Nacionalidad</p>
                <p class="font-bold text-slate-800 text-sm mt-0.5">{{ $matricula->nacionalidad }}</p>
            </div>
        </div>

        <!-- Formulario de Estado y Notas de Seguimiento -->
        <form action="{{ route('admin.admisiones.update', $matricula->id) }}" method="POST" class="pt-4 border-t border-slate-100 space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Estado de la Solicitud</label>
                <select name="estado" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 font-bold">
                    <option value="pendiente" {{ $matricula->estado == 'pendiente' ? 'selected' : '' }}>⏳ Pendiente</option>
                    <option value="contactado" {{ $matricula->estado == 'contactado' ? 'selected' : '' }}>📞 Contactado / En seguimiento</option>
                    <option value="matriculado" {{ $matricula->estado == 'matriculado' ? 'selected' : '' }}>🎓 Matriculado</option>
                    <option value="cancelado" {{ $matricula->estado == 'cancelado' ? 'selected' : '' }}>❌ Cancelado / No interesado</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Notas Internas de Seguimiento</label>
                <textarea name="notas" rows="3" placeholder="Comentarios sobre llamadas, acuerdos de pago, etc..."
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">{{ $matricula->notas }}</textarea>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.admisiones.index') }}" class="text-xs text-slate-500 hover:text-slate-800">
                    &larr; Volver al listado
                </a>
                <button type="submit" class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold shadow-md">
                    Actualizar Estado
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
