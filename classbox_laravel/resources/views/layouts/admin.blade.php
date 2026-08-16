<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Classbox CMS Laravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                        }
                    }
                }
            }
        }
    </script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .tox-tinymce { border-radius: 0.75rem !important; border-color: #e2e8f0 !important; }
    </style>
    @stack('styles')
</head>
<body class="h-full antialiased text-slate-800">
    <div class="min-h-full flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white flex flex-col shrink-0 border-r border-slate-800">
            <!-- Brand -->
            <div class="h-16 flex items-center px-6 gap-3 bg-slate-950/50 border-b border-slate-800">
                <img src="{{ asset('assets/img/logo_classbox_login.svg') }}" alt="Classbox Logo" class="h-8 max-w-[140px] object-contain">
                <span class="text-teal-400 text-[10px] font-bold px-1.5 py-0.5 rounded bg-teal-950/80 border border-teal-800/80">v3</span>
            </div>

            <!-- User Header Profile (Siempre visible en la parte superior) -->
            @auth
            <div class="p-3.5 border-b border-slate-800/80 bg-slate-950/30 flex items-center justify-between">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-teal-900/60 border border-teal-500/40 flex items-center justify-center font-bold text-xs text-teal-300 shrink-0 shadow-inner">
                        {{ strtoupper(substr(Auth::user()->full_name ?? Auth::user()->username, 0, 2)) }}
                    </div>
                    <div class="truncate">
                        <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->full_name ?? Auth::user()->username }}</p>
                        <p class="text-[11px] text-slate-400 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-400 rounded-lg hover:bg-slate-800 transition" title="Cerrar Sesión">
                        <i class="fa-solid fa-right-from-bracket text-xs"></i>
                    </button>
                </form>
            </div>
            @endauth

            <!-- Navigation Links -->
            <nav class="flex-1 px-3 py-4 space-y-1.5 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.dashboard*') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-gauge-high w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                @if(Auth::user()->hasModuleAccess('posts'))
                <div class="pt-2">
                    <p class="px-3.5 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Contenidos</p>
                </div>
                <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.posts*') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-newspaper w-5 text-center"></i>
                    <span>Publicaciones / Cursos</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.categories*') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-tags w-5 text-center"></i>
                    <span>Categorías</span>
                </a>
                @endif

                @if(Auth::user()->hasModuleAccess('admisiones'))
                <a href="{{ route('admin.admisiones.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.admisiones*') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-user-graduate w-5 text-center"></i>
                    <span>Admisiones</span>
                </a>
                @endif

                @if(Auth::user()->hasModuleAccess('testimonios'))
                <a href="{{ route('admin.testimonios.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.testimonios*') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-comment-dots w-5 text-center"></i>
                    <span>Testimonios</span>
                </a>
                @endif

                @if(Auth::user()->hasModuleAccess('galerias'))
                <a href="{{ route('admin.graduaciones.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.graduaciones*') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-images w-5 text-center"></i>
                    <span>Graduaciones & Fotos</span>
                </a>
                @endif

                @if(Auth::user()->hasModuleAccess('banners'))
                <a href="{{ route('admin.banners.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.banners*') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-panorama w-5 text-center"></i>
                    <span>Banners / Sliders</span>
                </a>
                @endif

                @if(Auth::user()->hasModuleAccess('portfolio'))
                <a href="{{ route('admin.portfolio.items.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.portfolio*') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-briefcase w-5 text-center"></i>
                    <span>Portafolio de Trabajos</span>
                </a>
                @endif

                @if(Auth::user()->hasModuleAccess('pages'))
                <a href="{{ route('admin.pages.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.pages*') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-file-lines w-5 text-center"></i>
                    <span>Páginas del Sitio</span>
                </a>
                @endif

                @if(Auth::user()->hasModuleAccess('media'))
                <a href="{{ route('admin.media.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.media*') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-photo-film w-5 text-center"></i>
                    <span>Biblioteca de Medios</span>
                </a>
                @endif

                <div class="pt-3">
                    <p class="px-3.5 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Configuración</p>
                </div>

                @if(Auth::user()->hasModuleAccess('home_sections'))
                <a href="{{ route('admin.home_sections.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.home_sections*') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-puzzle-piece w-5 text-center"></i>
                    <span>Constructor de Portada</span>
                </a>
                @endif

                @if(Auth::user()->hasModuleAccess('menus'))
                <a href="{{ route('admin.menus.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.menus*') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-bars w-5 text-center"></i>
                    <span>Menús del Sitio</span>
                </a>
                @endif

                @if(Auth::user()->hasModuleAccess('client_data'))
                <a href="{{ route('admin.client_data.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.client_data*') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-building w-5 text-center"></i>
                    <span>Datos Institucionales</span>
                </a>
                @endif

                @if(Auth::user()->isSuperAdmin() || Auth::user()->hasModuleAccess('users'))
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.users*') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-users-gear w-5 text-center"></i>
                    <span>Usuarios y Permisos</span>
                </a>
                @endif
            </nav>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <!-- Top Navbar -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0">
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-bold text-slate-800">@yield('page-title', 'Panel')</h2>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-xs text-slate-500 bg-slate-100 px-3 py-1.5 rounded-full border border-slate-200">
                        <i class="fa-regular fa-calendar mr-1.5 text-teal-600"></i>{{ date('d M, Y') }}
                    </span>
                    <a href="{{ env('FRONTEND_URL', 'http://127.0.0.1:8080') }}" target="_blank" rel="noopener noreferrer" class="text-xs font-semibold text-teal-700 bg-teal-50 border border-teal-200 hover:bg-teal-100 hover:border-teal-300 px-3.5 py-1.5 rounded-xl transition flex items-center gap-2 shadow-sm" title="Abrir sitio web en una pestaña nueva">
                        <i class="fa-solid fa-arrow-up-right-from-square text-[11px]"></i>
                        <span>Ver Sitio Web</span>
                    </a>
                </div>
            </header>

            <!-- Page Body -->
            <main class="flex-1 p-8">
                <!-- Alerts / Flash Messages -->
                @if(session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                        <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
                        <p class="text-sm font-medium text-rose-800">{{ session('error') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700"><i class="fa-solid fa-xmark"></i></button>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fa-solid fa-triangle-exclamation text-amber-600"></i>
                        <p class="text-sm font-bold text-amber-800">Por favor corrige los siguientes errores:</p>
                    </div>
                    <ul class="list-disc list-inside text-xs text-amber-700 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')

                <!-- Admin Footer Credits -->
                <footer class="mt-12 pt-6 border-t border-slate-200/80 text-center text-xs text-slate-400">
                    Desarrollado por <a href="https://renangalvan.net" target="_blank" class="text-teal-600 hover:text-teal-700 font-medium hover:underline">renangalvan.net</a> (+506) 87777849 - San José, Costa Rica
                </footer>
            </main>
        </div>
    </div>

    <!-- TinyMCE 6 WYSIWYG Editor CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>
    <script>
        function initTinyMCE(selector, uploadUrl = null) {
            tinymce.init({
                selector: selector,
                height: 380,
                menubar: 'edit view insert format tools table help',
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table link image media | removeformat code fullscreen',
                content_style: 'body { font-family: Plus Jakarta Sans, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; color: #334155; }',
                branding: false,
                promotion: false,
                images_upload_handler: uploadUrl ? function (blobInfo, progress) {
                    return new Promise((resolve, reject) => {
                        const xhr = new XMLHttpRequest();
                        xhr.withCredentials = false;
                        xhr.open('POST', uploadUrl);
                        
                        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        xhr.setRequestHeader('X-CSRF-TOKEN', token);

                        xhr.upload.onprogress = (e) => {
                            progress(e.loaded / e.total * 100);
                        };

                        xhr.onload = () => {
                            if (xhr.status < 200 || xhr.status >= 300) {
                                reject('Error HTTP: ' + xhr.status);
                                return;
                            }
                            const json = JSON.parse(xhr.responseText);
                            if (!json || typeof json.location != 'string') {
                                reject('Respuesta JSON inválida: ' + xhr.responseText);
                                return;
                            }
                            resolve(json.location);
                        };

                        xhr.onerror = () => {
                            reject('Error de conexión al subir la imagen.');
                        };

                        const formData = new FormData();
                        formData.append('file', blobInfo.blob(), blobInfo.filename());
                        xhr.send(formData);
                    });
                } : undefined
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
