<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Classbox CMS Laravel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="h-full flex items-center justify-center p-6 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950">
    <div class="w-full max-w-md">
        <!-- Card Container -->
        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/20">
            <!-- Header with Official Logo -->
            <div class="text-center mb-6">
                <div class="flex items-center justify-center mb-3">
                    <img src="{{ asset('assets/img/logo_classbox_login.svg') }}" alt="Classbox Logo" class="h-14 max-w-[200px] object-contain drop-shadow-md">
                </div>
                <p class="text-xs text-slate-500">
                    Ingresa tus credenciales de administrador de
                    <span class="block font-bold text-slate-800 text-sm mt-0.5">{{ $clientData->company_name ?? 'Sitio Web' }}</span>
                </p>
            </div>

            <!-- Error Feedback -->
            @if($errors->any())
            <div class="mb-5 bg-rose-50 border border-rose-200 text-rose-700 text-xs p-3 rounded-lg flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-rose-500 text-base"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            @if(session('info'))
            <div class="mb-5 bg-teal-50 border border-teal-200 text-teal-700 text-xs p-3 rounded-lg flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-teal-500 text-base"></i>
                <span>{{ session('info') }}</span>
            </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="username" class="block text-xs font-semibold text-slate-700 mb-1.5">Usuario / Correo</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="fa-solid fa-user text-sm"></i>
                        </span>
                        <input type="text" name="username" id="username" value="{{ old('username', 'renangalvan') }}" required
                               class="w-full pl-9 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition"
                               placeholder="Ej: renangalvan">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">Contraseña</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </span>
                        <input type="password" name="password" id="password" required
                               class="w-full pl-9 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 text-slate-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                        <span>Recordarme</span>
                    </label>
                </div>

                <button type="submit"
                        class="w-full mt-2 py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm rounded-xl shadow-lg shadow-teal-600/30 transition duration-150 flex items-center justify-center gap-2">
                    <span>Acceder al Panel</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6">
            Desarrollado por <a href="https://renangalvan.net" target="_blank" class="text-teal-400 hover:underline">renangalvan.net</a> (+506) 87777849 - San José, Costa Rica
        </p>
    </div>
</body>
</html>
