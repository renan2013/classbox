@php
    $client_data = App\Models\ClientData::first();
    $menus = App\Models\Menu::tree();
    $categories = App\Models\Category::withCount('posts')->get();

    // Comprobar Bypass de Desarrollador
    $bypassKey = $client_data?->maintenance_bypass_key ?: 'cefi2026';
    $isBypassParam = request('bypass') === $bypassKey;
    $isExitParam = request()->has('exit_bypass');

    if ($isExitParam) {
        setcookie('dev_bypass', '', time() - 3600, '/');
        unset($_COOKIE['dev_bypass']);
    } elseif ($isBypassParam) {
        setcookie('dev_bypass', '1', time() + (86400 * 7), '/');
        $_COOKIE['dev_bypass'] = '1';
    }

    $isDevBypass = (isset($_COOKIE['dev_bypass']) && $_COOKIE['dev_bypass'] === '1') || $isBypassParam;
    $showMaintenanceScreen = ($client_data?->maintenance_mode ?? false) && !$isDevBypass;
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>@yield('title', ($client_data->meta_title ?: ($client_data->company_name ?? 'CEFI - Centro de Formación Integral')))</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="@yield('meta_keywords', ($client_data->meta_keywords ?? 'cursos tecnicos, capacitacion, educacion virtual, costa rica'))" name="keywords">
    <meta content="@yield('meta_description', ($client_data->meta_description ?? 'Centro de Formación Integral - Cursos técnicos, diplomados y capacitaciones profesionales'))" name="description">

    <!-- Favicon -->
    @if($client_data?->favicon_url)
        <link href="{{ $client_data->favicon_url }}" rel="icon">
    @else
        <link href="{{ asset('img/favicon.ico') }}" rel="icon">
    @endif

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@300;400;500;600;700&family=Nunito:wght@600;700;800&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}?v={{ file_exists(public_path('css/style.css')) ? filemtime(public_path('css/style.css')) : time() }}" rel="stylesheet">

    <style>
        :root {
            --bs-primary: {{ $client_data->primary_color ?: '#06BBCC' }};
            --primary: {{ $client_data->primary_color ?: '#06BBCC' }};
            --secondary: {{ $client_data->secondary_color ?: '#181d38' }};
            --topbar-bg: {{ $client_data->topbar_bg_color ?: '#181d38' }};
            --topbar-text: {{ $client_data->topbar_text_color ?: '#ffffff' }};
            --navbar-bg: {{ $client_data->navbar_bg_color ?: '#ffffff' }};
            --navbar-text: {{ $client_data->navbar_text_color ?: '#181d38' }};
            --footer-bg: {{ $client_data->footer_bg_color ?: '#181d38' }};
            --footer-text: {{ $client_data->footer_text_color ?: '#ffffff' }};
            --card-bg: {{ $client_data->card_bg_color ?: '#ffffff' }};
            --card-border: {{ $client_data->card_border_color ?: '#e2e8f0' }};
        }

        /* Color Primario Dinámico */
        .bg-primary, .btn-primary, .badge.bg-primary, .owl-carousel .owl-nav .owl-prev, .owl-carousel .owl-nav .owl-next {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
        }
        .btn-primary:hover {
            opacity: 0.92;
        }
        .text-primary, .section-title, .breadcrumb-item.active {
            color: var(--primary) !important;
        }
        .border-primary {
            border-color: var(--primary) !important;
        }
        .btn-outline-primary {
            color: var(--primary) !important;
            border-color: var(--primary) !important;
        }
        .btn-outline-primary:hover {
            background-color: var(--primary) !important;
            color: #ffffff !important;
        }

        /* Topbar Dinámico */
        .topbar-custom {
            background-color: var(--topbar-bg) !important;
            color: var(--topbar-text) !important;
        }
        .topbar-custom small, .topbar-custom i {
            color: var(--topbar-text) !important;
        }

        /* Navbar Dinámico */
        .navbar { z-index: 9999 !important; }
        .navbar-custom {
            background-color: var(--navbar-bg) !important;
        }
        .navbar-custom .navbar-nav .nav-link {
            color: var(--navbar-text) !important;
        }
        .navbar-custom .navbar-nav .nav-link:hover,
        .navbar-custom .navbar-nav .nav-link.active {
            color: var(--primary) !important;
        }

        /* Tarjetas / Cards de Cursos Dinámicas */
        .course-item, .card, .course-card {
            background-color: var(--card-bg) !important;
            border-color: var(--card-border) !important;
        }
        .course-card img, .course-item img { height: 200px; object-fit: cover; }

        /* Footer Dinámico */
        .footer-custom {
            background-color: var(--footer-bg) !important;
            color: var(--footer-text) !important;
        }
        .footer-custom h4, .footer-custom h5, .footer-custom .text-white {
            color: var(--footer-text) !important;
        }
        .footer-custom .btn-link {
            color: var(--footer-text) !important;
            opacity: 0.85;
        }
        .footer-custom .btn-link:hover {
            opacity: 1;
            color: var(--primary) !important;
        }
        .footer-custom .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Botón WhatsApp Flotante */
        .btn-whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 20px;
            right: 20px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.3);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-whatsapp-float:hover {
            background-color: #128c7e;
            color: #FFF;
            transform: scale(1.1);
        }
    </style>

    <!-- Google Analytics -->
    @if($client_data?->google_analytics_id)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $client_data->google_analytics_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $client_data->google_analytics_id }}');
        </script>
    @endif

    <!-- Custom Head Scripts -->
    @if($client_data?->custom_head_scripts)
        {!! $client_data->custom_head_scripts !!}
    @endif

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>

<body>
    @if($showMaintenanceScreen)
        <!-- Maintenance Mode Screen -->
        <div class="min-vh-100 d-flex align-items-center justify-content-center bg-light text-center p-4">
            <div class="card border-0 shadow-lg p-5 rounded-3" style="max-width: 620px;">
                @if($client_data?->logo_url)
                    <img src="{{ $client_data->logo_url }}" alt="Logo" class="mx-auto mb-4" style="max-height: 75px; width: auto; object-fit: contain;">
                @else
                    <i class="fa fa-tools fa-4x text-primary mb-4"></i>
                @endif
                <h2 class="text-dark font-bold mb-3">Modo Mantenimiento</h2>
                <p class="text-muted fs-5 mb-4">
                    {{ $client_data->maintenance_message ?: 'Estamos actualizando nuestra plataforma para brindarte una mejor experiencia. ¡Volvemos pronto!' }}
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="https://wa.me/{{ $client_data->whatsapp_country_code ?? '506' }}{{ $client_data->whatsapp_number ?? '87220999' }}" target="_blank" class="btn btn-success px-4 py-2">
                        <i class="fab fa-whatsapp me-2"></i> Contactar por WhatsApp
                    </a>
                </div>
            </div>
        </div>
    @else
        @if($client_data?->maintenance_mode && $isDevBypass)
            <!-- Developer Bypass Top Notification -->
            <div class="bg-warning text-dark py-2 px-4 text-center fw-bold sticky-top w-100 d-flex justify-content-between align-items-center shadow-sm" style="z-index: 999999; font-size: 13px;">
                <span><i class="fa fa-exclamation-triangle me-2"></i> <strong>Modo Mantenimiento Activo</strong> — Navegando en Vista Previa de Desarrollador (Bypass). El público general solo ve la pantalla de mantenimiento.</span>
                <a href="{{ request()->url() }}?exit_bypass=1" class="btn btn-sm btn-dark py-1 px-3" style="font-size: 11px;">Salir de Vista Previa</a>
            </div>
        @endif
        <!-- Topbar Start -->
        <div class="container-fluid topbar-custom px-5 d-none d-lg-block">
            <div class="row gx-0 align-items-center" style="height: 45px;">
                <div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
                    <div class="d-inline-flex align-items-center" style="height: 45px;">
                        <small class="me-3"><i class="fa fa-map-marker-alt me-2"></i>{{ $client_data->address ?? 'San José, Costa Rica' }}</small>
                        <small class="me-3"><i class="fa fa-phone-alt me-2"></i>{{ $client_data->phone ?? '+(506) 2221-7870' }}</small>
                        <small><i class="fa fa-envelope-open me-2"></i>{{ $client_data->email ?? 'contacto@ceficr.com' }}</small>
                    </div>
                </div>
                <div class="col-lg-4 text-center text-lg-end">
                    <div class="d-inline-flex align-items-center" style="height: 45px;">
                        @if($client_data?->facebook_url)
                            <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="{{ $client_data->facebook_url }}" target="_blank"><i class="fab fa-facebook-f fw-normal"></i></a>
                        @endif
                        @if($client_data?->instagram_url)
                            <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="{{ $client_data->instagram_url }}" target="_blank"><i class="fab fa-instagram fw-normal"></i></a>
                        @endif
                        @if($client_data?->youtube_url)
                            <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="{{ $client_data->youtube_url }}" target="_blank"><i class="fab fa-youtube fw-normal"></i></a>
                        @endif
                        @if($client_data?->tiktok_url)
                            <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="{{ $client_data->tiktok_url }}" target="_blank"><i class="fab fa-tiktok fw-normal"></i></a>
                        @endif
                        @if($client_data?->linkedin_url)
                            <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="{{ $client_data->linkedin_url }}" target="_blank"><i class="fab fa-linkedin-in fw-normal"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Topbar End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-custom navbar-light shadow sticky-top p-0">
        <a href="{{ route('site.home') }}" class="navbar-brand d-flex align-items-center px-4 px-lg-5 py-2">
            @if($client_data?->logo_url)
                <img src="{{ $client_data->logo_url }}" alt="{{ $client_data->company_name ?? 'Logo' }}" class="site-logo-img" style="max-height: 41px; width: auto; object-fit: contain;">
            @else
                <h2 class="m-0 text-primary site-logo-text" style="font-size: 1.45rem;"><i class="fa fa-book-reader me-3"></i>{{ $client_data->company_name ?? 'CEFI' }}</h2>
            @endif
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                @if(isset($site_menus) && $site_menus->isNotEmpty())
                    @foreach($site_menus as $menuItem)
                        @php
                            $targetAttr = ($menuItem->target === '_blank') ? 'target="_blank"' : '';
                            $resolvedUrl = site_url($menuItem->url);
                            $cleanPath = ltrim($menuItem->url, '/');
                            $isActive = (request()->url() === $resolvedUrl || ($cleanPath !== '' && request()->is($cleanPath)) || ($cleanPath === '' && request()->is('/')));
                        @endphp
                        @if($menuItem->children->isNotEmpty())
                            <div class="nav-item dropdown">
                                <a href="{{ $resolvedUrl }}" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{ $menuItem->title }}</a>
                                <div class="dropdown-menu fade-down m-0">
                                    @foreach($menuItem->children as $child)
                                        @php
                                            $childResolvedUrl = site_url($child->url);
                                            $childTarget = ($child->target === '_blank') ? 'target="_blank"' : '';
                                        @endphp
                                        <a href="{{ $childResolvedUrl }}" {!! $childTarget !!} class="dropdown-item">{{ $child->title }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ $resolvedUrl }}" {!! $targetAttr !!} class="nav-item nav-link {{ $isActive ? 'active' : '' }}">{{ $menuItem->title }}</a>
                        @endif
                    @endforeach
                @else
                    {{-- Fallback si la tabla está vacía --}}
                    <a href="{{ route('site.home') }}" class="nav-item nav-link {{ request()->routeIs('site.home') ? 'active' : '' }}">Inicio</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Escuelas</a>
                        <div class="dropdown-menu fade-down m-0">
                            @foreach($categories as $cat)
                                <a href="{{ route('site.category', $cat->id) }}" class="dropdown-item">{{ $cat->name }}</a>
                            @endforeach
                        </div>
                    </div>
                    <a href="{{ route('site.graduaciones') }}" class="nav-item nav-link {{ request()->routeIs('site.graduaciones*') ? 'active' : '' }}">Graduaciones</a>
                    <a href="{{ route('site.about') }}" class="nav-item nav-link {{ request()->routeIs('site.about') ? 'active' : '' }}">Quiénes Somos</a>
                    <a href="{{ route('site.team') }}" class="nav-item nav-link {{ request()->routeIs('site.team') ? 'active' : '' }}">Docentes</a>
                    <a href="{{ route('site.testimonials') }}" class="nav-item nav-link {{ request()->routeIs('site.testimonials') ? 'active' : '' }}">Testimonios</a>
                    <a href="{{ route('site.contact') }}" class="nav-item nav-link {{ request()->routeIs('site.contact') ? 'active' : '' }}">Contacto</a>
                @endif
            </div>
            <a href="https://wa.me/{{ $client_data->whatsapp_country_code ?? '506' }}{{ $client_data->whatsapp_number ?? '87220999' }}" target="_blank" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">
                Matrícula Online <i class="fa fa-arrow-right ms-3"></i>
            </a>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Main Content -->
    @yield('content')

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/{{ $client_data->whatsapp_country_code ?? '506' }}{{ $client_data->whatsapp_number ?? '87220999' }}" target="_blank" class="btn-whatsapp-float" title="Contactar por WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Footer Start -->
    <div class="container-fluid footer-custom footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-white mb-3">Enlaces Rápidos</h4>
                    <a class="btn btn-link" href="{{ route('site.about') }}">Quiénes Somos</a>
                    <a class="btn btn-link" href="{{ route('site.contact') }}">Contáctanos</a>
                    <a class="btn btn-link" href="{{ route('site.graduaciones') }}">Graduaciones</a>
                    <a class="btn btn-link" href="{{ route('site.testimonials') }}">Testimonios</a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-white mb-3">Contacto Directo</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>{{ $client_data->address ?? 'San José, Costa Rica' }}</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>{{ $client_data->phone ?? '+(506) 2221-7870' }}</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>{{ $client_data->email ?? 'contacto@ceficr.com' }}</p>
                    <div class="d-flex pt-2">
                        @if($client_data?->facebook_url)
                            <a class="btn btn-outline-light btn-social me-2" href="{{ $client_data->facebook_url }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if($client_data?->instagram_url)
                            <a class="btn btn-outline-light btn-social me-2" href="{{ $client_data->instagram_url }}" target="_blank"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if($client_data?->youtube_url)
                            <a class="btn btn-outline-light btn-social me-2" href="{{ $client_data->youtube_url }}" target="_blank"><i class="fab fa-youtube"></i></a>
                        @endif
                        @if($client_data?->tiktok_url)
                            <a class="btn btn-outline-light btn-social me-2" href="{{ $client_data->tiktok_url }}" target="_blank"><i class="fab fa-tiktok"></i></a>
                        @endif
                        @if($client_data?->linkedin_url)
                            <a class="btn btn-outline-light btn-social me-2" href="{{ $client_data->linkedin_url }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    @if($client_data?->logo_dark_url)
                        <img src="{{ $client_data->logo_dark_url }}" alt="{{ $client_data->company_name ?? 'Logo' }}" class="mb-3" style="max-height: 55px; width: auto; object-fit: contain;">
                    @elseif($client_data?->logo_url)
                        <img src="{{ $client_data->logo_url }}" alt="{{ $client_data->company_name ?? 'Logo' }}" class="mb-3" style="max-height: 55px; width: auto; object-fit: contain;">
                    @else
                        <h4 class="text-white mb-3">Sobre {{ $client_data->company_name ?? 'CEFI' }}</h4>
                    @endif
                    @if($client_data?->meta_description)
                        <p class="text-white-50">{{ $client_data->meta_description }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; {{ date('Y') }} <a class="border-bottom text-primary" href="{{ route('site.home') }}">{{ $client_data->company_name ?? 'CEFI' }}</a>. Todos los derechos reservados.
                    </div>
                    <div class="col-md-6 text-center text-md-end text-white-50">
                        Desarrollado con <span class="text-primary font-bold">Classbox Laravel</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->
    @endif

    <!-- Custom Body Scripts -->
    @if($client_data?->custom_body_scripts)
        {!! $client_data->custom_body_scripts !!}
    @endif

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
