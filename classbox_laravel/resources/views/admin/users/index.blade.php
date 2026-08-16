@extends('layouts.admin')

@section('title', 'Usuarios y Permisos')
@section('page-title', 'Gestor de Administradores y Permisos')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Formulario Crear Usuario -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
            <i class="fa-solid fa-user-plus text-teal-600"></i> Nuevo Administrador
        </h3>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nombre Completo *</label>
                <input type="text" name="full_name" required placeholder="Ej: Carolina Burgos" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nombre de Usuario *</label>
                <input type="text" name="username" required placeholder="Ej: cburgos" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Correo Electrónico (Opcional)</label>
                <input type="email" name="email" placeholder="cburgos@ceficr.com" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Contraseña Inicial *</label>
                <input type="password" name="password" required placeholder="••••••••" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Rol</label>
                <select name="role" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                    <option value="admin">Administrador Regular</option>
                    <option value="superadmin">Super Administrador (Acceso total)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-2">Módulos Asignados</label>
                <div class="space-y-1.5 p-3 bg-slate-50 rounded-xl border border-slate-100 max-h-40 overflow-y-auto">
                    @foreach($modules as $mod)
                        <label class="flex items-center gap-2 text-xs text-slate-600 cursor-pointer">
                            <input type="checkbox" name="modules[]" value="{{ $mod->id }}" class="rounded text-teal-600 focus:ring-teal-500">
                            <span>{{ $mod->display_name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="w-full py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-teal-600/20 transition">
                Crear Usuario
            </button>
        </form>
    </div>

    <!-- Lista de Administradores -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 bg-slate-50/75 border-b border-slate-200">
            <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Usuarios Administradores</h3>
        </div>

        <div class="divide-y divide-slate-100 text-xs">
            @foreach($users as $u)
                <div class="p-4 flex items-center justify-between hover:bg-slate-50/50 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-800 text-teal-400 font-bold flex items-center justify-center text-xs">
                            {{ strtoupper(substr($u->full_name ?? $u->username, 0, 2)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="font-bold text-slate-800">{{ $u->full_name }}</h4>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full uppercase {{ $u->isSuperAdmin() ? 'bg-purple-100 text-purple-800' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $u->role }}
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-400 font-mono">{{ $u->username }} • {{ $u->email ?? 'Sin correo' }}</p>
                            
                            @if(!$u->isSuperAdmin())
                                <div class="flex flex-wrap gap-1 mt-1.5">
                                    @foreach($u->modules as $um)
                                        <span class="text-[9px] bg-teal-50 text-teal-700 px-1.5 py-0.5 rounded border border-teal-100">{{ $um->display_name }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    @if(Auth::id() != $u->id)
                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('¿Eliminar usuario?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 rounded-lg transition" title="Eliminar">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
