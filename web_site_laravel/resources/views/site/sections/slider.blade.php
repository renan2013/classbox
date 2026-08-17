@php
    $client_data = $client_data ?? App\Models\ClientData::first();
    $hasCustomBanners = $banners->isNotEmpty() || $postSlides->isNotEmpty();
    $globalSliderStyle = $client_data?->slider_overlay_style ?: 'none';
    $globalAlign = $client_data?->slider_content_alignment ?: 'center';
    $globalVAlign = $client_data?->slider_content_vertical_alignment ?: 'bottom';
    $globalTitleSize = $client_data?->slider_title_size ?: 'md';
    $globalTitleWeight = $client_data?->slider_title_weight ?: 'light';
    $globalFontFamily = $client_data?->slider_font_family ?: 'roboto';
    $globalButtonStyle = $client_data?->slider_button_style ?: 'text_link';
    $globalTitleColor = $client_data?->slider_title_color ?: '#334155';
    $globalSubtitleColor = $client_data?->slider_subtitle_color ?: ($client_data->primary_color ?? '#06BBCC');
    $globalShowSubtitle = $client_data?->slider_show_subtitle ?? false;
    $globalShowTitle = $client_data?->slider_show_title ?? true;
    $globalShowButton = $client_data?->slider_show_button ?? true;

    if (!function_exists('getSlideOverlayStyle')) {
        function getSlideOverlayStyle($style, $client_data = null) {
            $primary = $client_data->primary_color ?? '#06BBCC';
            switch ($style) {
                case 'none':
                    return 'background: transparent !important;';
                case 'bottom_gradient':
                    return 'background: linear-gradient(to top, rgba(15, 23, 42, 0.90) 0%, rgba(15, 23, 42, 0.50) 45%, rgba(15, 23, 42, 0.05) 80%, transparent 100%) !important;';
                case 'left_gradient':
                    return 'background: linear-gradient(to right, rgba(15, 23, 42, 0.90) 0%, rgba(15, 23, 42, 0.55) 50%, rgba(15, 23, 42, 0.08) 80%, transparent 100%) !important;';
                case 'glass_card':
                    return 'background: transparent !important;';
                case 'brand_tint':
                    $hex = str_replace('#', '', $primary);
                    if(strlen($hex) == 3) {
                        $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
                        $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
                        $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
                    } else {
                        $r = hexdec(substr($hex, 0, 2) ?: '6');
                        $g = hexdec(substr($hex, 2, 2) ?: '187');
                        $b = hexdec(substr($hex, 4, 2) ?: '204');
                    }
                    return "background: linear-gradient(135deg, rgba($r, $g, $b, 0.6) 0%, rgba(15, 23, 42, 0.82) 100%) !important;";
                case 'full_dark':
                default:
                    return 'background: rgba(15, 23, 42, 0.6) !important;';
            }
        }
    }

    if (!function_exists('getSlideAlignClasses')) {
        function getSlideAlignClasses($align) {
            switch ($align) {
                case 'center':
                    return 'justify-content-center text-center';
                case 'right':
                    return 'justify-content-end text-end';
                case 'left':
                default:
                    return 'justify-content-start text-start';
            }
        }
    }

    if (!function_exists('getSlideVerticalAlignClasses')) {
        function getSlideVerticalAlignClasses($vAlign) {
            switch ($vAlign) {
                case 'top':
                    return 'align-items-start pt-5';
                case 'bottom':
                    return 'align-items-end pb-5';
                case 'center':
                default:
                    return 'align-items-center';
            }
        }
    }

    if (!function_exists('getSlideTitleClass')) {
        function getSlideTitleClass($size) {
            switch ($size) {
                case 'sm':
                    return 'display-6';
                case 'md':
                    return 'display-5';
                case 'xl':
                    return 'display-2';
                case 'lg':
                default:
                    return 'display-4';
            }
        }
    }

    if (!function_exists('getSlideFontWeightCss')) {
        function getSlideFontWeightCss($weight) {
            switch ($weight) {
                case 'light':
                    return 'font-weight: 300; letter-spacing: -0.2px;';
                case 'normal':
                    return 'font-weight: 400;';
                case 'medium':
                    return 'font-weight: 500;';
                case 'bold':
                default:
                    return 'font-weight: 700;';
            }
        }
    }

    if (!function_exists('getSlideFontFamilyCss')) {
        function getSlideFontFamilyCss($font) {
            switch ($font) {
                case 'roboto':
                    return "font-family: 'Roboto', sans-serif;";
                case 'inter':
                    return "font-family: 'Inter', sans-serif;";
                case 'heebo':
                    return "font-family: 'Heebo', sans-serif;";
                case 'nunito':
                default:
                    return "font-family: 'Nunito', sans-serif;";
            }
        }
    }

    if (!function_exists('getSlideBtnClass')) {
        function getSlideBtnClass($style) {
            switch ($style) {
                case 'text_link':
                    return 'slider-minimal-link text-decoration-none fw-normal animated slideInLeft d-inline-flex align-items-center gap-1';
                case 'white':
                    return 'btn btn-light text-dark fw-bold py-md-3 px-md-5 animated slideInLeft shadow';
                case 'dark':
                    return 'btn btn-dark text-white fw-bold py-md-3 px-md-5 animated slideInLeft shadow';
                case 'outline':
                    return 'btn btn-outline-light fw-bold py-md-3 px-md-5 animated slideInLeft shadow';
                case 'primary':
                default:
                    return 'btn btn-primary fw-bold py-md-3 px-md-5 animated slideInLeft shadow';
            }
        }
    }
@endphp

<!-- Modular Section: Carousel / Slider -->
<div class="container-fluid p-0 mb-5">
    <div class="owl-carousel header-carousel position-relative">
        @if($hasCustomBanners)
            {{-- Banners generales --}}
            @foreach($banners as $b)
                @php
                    $bStyle = $b->overlay_style ?: $globalSliderStyle;
                    $overlayCss = getSlideOverlayStyle($bStyle, $client_data);
                    $alignClass = getSlideAlignClasses($b->content_alignment ?: $globalAlign);
                    $vAlignClass = getSlideVerticalAlignClasses($b->content_vertical_alignment ?: $globalVAlign);
                    $titleClass = getSlideTitleClass($b->title_size ?: $globalTitleSize);
                    $bWeight = $b->title_weight ?: $globalTitleWeight;
                    $bFont = $b->font_family ?: $globalFontFamily;
                    $weightCss = getSlideFontWeightCss($bWeight);
                    $fontCss = getSlideFontFamilyCss($bFont);
                    $btnStyle = $b->button_style ?: $globalButtonStyle;
                    $btnClass = getSlideBtnClass($btnStyle);
                    $tColor = $b->title_color ?: $globalTitleColor;
                    $subColor = $b->subtitle_color ?: $globalSubtitleColor;
                    $isGlass = ($bStyle === 'glass_card');
                    $isTextLink = ($btnStyle === 'text_link');

                    $showSub = ($b->show_subtitle ?? true) && !empty($b->subtitle);
                    $showTitle = ($b->show_title ?? true) && !empty($b->title);
                    $showBtn = ($b->show_button ?? true) && !empty($b->button_text);
                    $hasAnyText = $showSub || $showTitle || $showBtn;
                @endphp
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid w-100" src="{{ $b->image_url }}" alt="{{ $b->title }}" style="max-height: 600px; object-fit: cover;">
                    @if($hasAnyText)
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex slider-mobile-overlay {{ $vAlignClass }}" style="{{ $overlayCss }}">
                            <div class="container">
                                <div class="row {{ $alignClass }}">
                                    <div class="col-sm-10 col-lg-8">
                                        @if($isGlass)
                                            <div class="p-4 p-md-5 rounded-4 shadow-lg text-white" style="background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.15);">
                                        @endif

                                        @if($showSub)
                                            <h5 class="text-uppercase mb-2 animated slideInDown slider-mobile-badge" style="color: {{ $subColor }} !important; {{ $fontCss }} font-weight: 600; font-size: 0.95rem; letter-spacing: 1px;">
                                                {{ $b->subtitle }}
                                            </h5>
                                        @endif
                                        @if($showTitle)
                                            <h1 class="{{ $titleClass }} animated slideInDown mb-3 slider-mobile-title" style="color: {{ $tColor }} !important; {{ $fontCss }} {{ $weightCss }} line-height: 1.25;">
                                                {{ $b->title }}
                                            </h1>
                                        @endif
                                        @if($showBtn)
                                            @if($isTextLink)
                                                <a href="{{ $b->button_url ?? route('site.contact') }}" class="{{ $btnClass }} slider-mobile-btn" style="color: {{ $client_data->primary_color ?? '#06BBCC' }}; {{ $fontCss }} font-size: 1.1rem;">
                                                    <span>{{ $b->button_text }}</span> <i class="fa fa-arrow-right ms-1 text-xs"></i>
                                                </a>
                                            @else
                                                <a href="{{ $b->button_url ?? route('site.contact') }}" class="{{ $btnClass }} slider-mobile-btn">
                                                    {{ $b->button_text }}
                                                </a>
                                            @endif
                                        @endif

                                        @if($isGlass)
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach

            {{-- Slides vinculados a cursos/publicaciones --}}
            @foreach($postSlides as $ps)
                @php
                    $overlayCss = getSlideOverlayStyle($globalSliderStyle, $client_data);
                    $alignClass = getSlideAlignClasses($globalAlign);
                    $vAlignClass = getSlideVerticalAlignClasses($globalVAlign);
                    $titleClass = getSlideTitleClass($globalTitleSize);
                    $weightCss = getSlideFontWeightCss($globalTitleWeight);
                    $fontCss = getSlideFontFamilyCss($globalFontFamily);
                    $btnClass = getSlideBtnClass($globalButtonStyle);
                    $isGlass = ($globalSliderStyle === 'glass_card');
                    $isTextLink = ($globalButtonStyle === 'text_link');

                    $showSub = $globalShowSubtitle;
                    $showTitle = $globalShowTitle;
                    $showBtn = $globalShowButton;
                    $hasAnyText = $showSub || $showTitle || $showBtn;
                @endphp
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid w-100" src="{{ asset('storage/' . $ps->value) }}" alt="{{ $ps->post->title ?? 'Slide' }}" style="max-height: 600px; object-fit: cover;">
                    @if($hasAnyText)
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex slider-mobile-overlay {{ $vAlignClass }}" style="{{ $overlayCss }}">
                            <div class="container">
                                <div class="row {{ $alignClass }}">
                                    <div class="col-sm-10 col-lg-8">
                                        @if($isGlass)
                                            <div class="p-4 p-md-5 rounded-4 shadow-lg text-white" style="background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.15);">
                                        @endif

                                        @if($showSub)
                                            <h5 class="text-uppercase mb-2 animated slideInDown slider-mobile-badge" style="color: {{ $globalSubtitleColor }} !important; {{ $fontCss }} font-weight: 600; font-size: 0.95rem; letter-spacing: 1px;">
                                                {{ $ps->post->category->name ?? 'PROGRAMA DESTACADO' }}
                                            </h5>
                                        @endif
                                        @if($showTitle)
                                            <h1 class="{{ $titleClass }} animated slideInDown mb-3 slider-mobile-title" style="color: {{ $globalTitleColor }} !important; {{ $fontCss }} {{ $weightCss }} line-height: 1.25;">
                                                {{ $ps->post->title ?? '' }}
                                            </h1>
                                        @endif
                                        @if($showBtn)
                                            @if($isTextLink)
                                                <a href="{{ route('site.course.show', $ps->post->id) }}" class="{{ $btnClass }} slider-mobile-btn" style="color: {{ $client_data->primary_color ?? '#06BBCC' }}; {{ $fontCss }} font-size: 1.1rem;">
                                                    <span>Ver Programa Completo</span> <i class="fa fa-arrow-right ms-1 text-xs"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('site.course.show', $ps->post->id) }}" class="{{ $btnClass }} slider-mobile-btn">
                                                    Ver Programa Completo
                                                </a>
                                            @endif
                                        @endif

                                        @if($isGlass)
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            {{-- Default Fallback Slide --}}
            @php
                $overlayCss = getSlideOverlayStyle($globalSliderStyle, $client_data);
                $alignClass = getSlideAlignClasses($globalAlign);
                $vAlignClass = getSlideVerticalAlignClasses($globalVAlign);
                $titleClass = getSlideTitleClass($globalTitleSize);
                $weightCss = getSlideFontWeightCss($globalTitleWeight);
                $fontCss = getSlideFontFamilyCss($globalFontFamily);
                $btnClass = getSlideBtnClass($globalButtonStyle);
                $isGlass = ($globalSliderStyle === 'glass_card');
                $isTextLink = ($globalButtonStyle === 'text_link');
                $fallbackSubtitle = $client_data?->slider_default_subtitle ?: 'EDUCACIÓN PROFESIONAL';
                $fallbackTitle = $client_data?->slider_default_title ?: 'Creamos su página web de acuerdo a sus necesidades';
                $fallbackBtnText = $client_data?->slider_default_button_text ?: 'Quiero saber más';
                $fallbackBtnUrl = $client_data?->slider_default_button_url ?: route('site.contact');

                $showSub = $globalShowSubtitle && !empty($fallbackSubtitle);
                $showTitle = $globalShowTitle && !empty($fallbackTitle);
                $showBtn = $globalShowButton && !empty($fallbackBtnText);
                $hasAnyText = $showSub || $showTitle || $showBtn;
            @endphp
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid w-100" src="{{ asset('img/carousel-1.jpg') }}" alt="Educación" style="max-height: 600px; object-fit: cover;">
                @if($hasAnyText)
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex slider-mobile-overlay {{ $vAlignClass }}" style="{{ $overlayCss }}">
                        <div class="container">
                            <div class="row {{ $alignClass }}">
                                <div class="col-sm-10 col-lg-8">
                                    @if($isGlass)
                                        <div class="p-4 p-md-5 rounded-4 shadow-lg text-white" style="background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.15);">
                                    @endif

                                    @if($showSub)
                                        <h5 class="text-uppercase mb-2 animated slideInDown slider-mobile-badge" style="color: {{ $globalSubtitleColor }} !important; {{ $fontCss }} font-weight: 600; font-size: 0.95rem; letter-spacing: 1px;">
                                            {{ $fallbackSubtitle }}
                                        </h5>
                                    @endif
                                    @if($showTitle)
                                        <h1 class="{{ $titleClass }} animated slideInDown mb-3 slider-mobile-title" style="color: {{ $globalTitleColor }} !important; {{ $fontCss }} {{ $weightCss }} line-height: 1.25;">
                                            {{ $fallbackTitle }}
                                        </h1>
                                    @endif
                                    @if($showBtn)
                                        @if($isTextLink)
                                            <a href="{{ $fallbackBtnUrl }}" class="{{ $btnClass }} slider-mobile-btn" style="color: {{ $client_data->primary_color ?? '#06BBCC' }}; {{ $fontCss }} font-size: 1.1rem;">
                                                <span>{{ $fallbackBtnText }}</span> <i class="fa fa-arrow-right ms-1 text-xs"></i>
                                            </a>
                                        @else
                                            <a href="{{ $fallbackBtnUrl }}" class="{{ $btnClass }} slider-mobile-btn">
                                                {{ $fallbackBtnText }}
                                            </a>
                                        @endif
                                    @endif

                                    @if($isGlass)
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

<style>
    .slider-minimal-link {
        transition: transform 0.2s ease, opacity 0.2s ease;
    }
    .slider-minimal-link:hover {
        transform: translateX(4px);
        opacity: 0.85;
    }

    /* Estilo Cinemático Elegante para Móviles */
    @media (max-width: 768px) {
        .header-carousel .owl-carousel-item {
            height: 480px;
            max-height: 75vh;
            min-height: 420px;
        }

        .header-carousel .owl-carousel-item img {
            height: 100% !important;
            object-fit: cover !important;
            object-position: center 15% !important;
        }

        .header-carousel .slider-mobile-overlay {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.10) 0%, rgba(15, 23, 42, 0.30) 40%, rgba(15, 23, 42, 0.72) 70%, rgba(15, 23, 42, 0.94) 100%) !important;
            align-items: flex-end !important;
            padding-bottom: 2.2rem !important;
        }

        .header-carousel .slider-mobile-badge {
            display: inline-block !important;
            font-size: 0.75rem !important;
            letter-spacing: 1.5px !important;
            text-transform: uppercase !important;
            font-weight: 600 !important;
            padding: 4px 14px !important;
            border-radius: 30px !important;
            background: rgba(255, 255, 255, 0.18) !important;
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
            color: #ffffff !important;
            margin-bottom: 10px !important;
            text-shadow: 0 1px 3px rgba(0,0,0,0.5) !important;
        }

        .header-carousel .slider-mobile-title {
            font-size: 1.5rem !important;
            line-height: 1.3 !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.7) !important;
            margin-bottom: 16px !important;
        }

        .header-carousel .slider-mobile-btn {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            padding: 10px 24px !important;
            border-radius: 50px !important;
            font-size: 0.92rem !important;
            font-weight: 600 !important;
            background-color: var(--primary) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.4) !important;
            text-decoration: none !important;
            border: none !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease !important;
        }
        .header-carousel .slider-mobile-btn:active {
            transform: scale(0.97);
        }
    }
</style>
