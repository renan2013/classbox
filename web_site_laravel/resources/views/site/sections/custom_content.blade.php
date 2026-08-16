@php
    $rawHtml = $section->settings['custom_html'] ?? '';
    $scopedId = 'custom-block-' . $section->id;
    
    // 1. Limpiar etiquetas de documento completo que rompen el DOM
    $cleanHtml = preg_replace('/<\/?(html|head|body)[^>]*>/i', '', $rawHtml);
    $cleanHtml = preg_replace('/<!DOCTYPE[^>]*>/i', '', $cleanHtml);
    
    // 2. Aislar y encapsular reglas CSS para que no afecten al resto del sitio (Navbar, Footer, etc.)
    $cleanHtml = preg_replace_callback('/<style\b[^>]*>(.*?)<\/style>/is', function($matches) use ($scopedId) {
        $css = $matches[1];
        $scopedCss = preg_replace_callback('/([^{}]+)\{/i', function($m) use ($scopedId) {
            $selectors = explode(',', $m[1]);
            $scopedSelectors = array_map(function($sel) use ($scopedId) {
                $sel = trim($sel);
                if (empty($sel) || str_starts_with($sel, '@') || str_starts_with($sel, ':root')) return $sel;
                if ($sel === 'body') return '#' . $scopedId;
                return '#' . $scopedId . ' ' . $sel;
            }, $selectors);
            return implode(', ', $scopedSelectors) . '{';
        }, $css);
        return '<style>' . $scopedCss . '</style>';
    }, $cleanHtml);
@endphp

<!-- Modular Section: Custom Content / HTML -->
<div class="container-xxl py-5">
    <div class="container">
        @if($section->title || $section->subtitle)
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                @if($section->subtitle)
                    <h6 class="section-title bg-white text-center text-primary px-3">{{ $section->subtitle }}</h6>
                @endif
                @if($section->title)
                    <h1 class="mb-5">{{ $section->title }}</h1>
                @endif
            </div>
        @endif
        <div id="{{ $scopedId }}" class="custom-content-wrapper position-relative">
            {!! $cleanHtml !!}
        </div>
    </div>
</div>
