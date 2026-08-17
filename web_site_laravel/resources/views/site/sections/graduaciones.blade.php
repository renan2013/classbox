<!-- Modular Section: Graduaciones -->
@if(isset($graduaciones) && $graduaciones->isNotEmpty())
<div class="container-xxl py-4 py-md-4">
    <div class="container">
        <div class="text-center wow fadeInUp mb-4" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3 mb-2">{{ $section->subtitle ?? 'Casos de Éxito' }}</h6>
            <h1 class="mb-0">{{ $section->title ?? 'Nuestras Graduaciones' }}</h1>
        </div>
        <div class="row g-4 justify-content-center">
            @php
                $limit = $section->settings['limit'] ?? 4;
                $displayGrads = $graduaciones->take($limit);
            @endphp
            @foreach($displayGrads as $g)
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <a href="{{ route('site.graduacion.show', $g->id) }}" class="d-block text-decoration-none h-100">
                        <div class="card h-100 shadow-sm border-0 overflow-hidden">
                            @if($g->main_image)
                                <img src="{{ asset('storage/' . $g->main_image) }}" class="w-100" style="height: 200px; object-fit: cover;" alt="{{ $g->title }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="height: 200px;">
                                    <i class="fa fa-graduation-cap fa-3x"></i>
                                </div>
                            @endif
                            <div class="card-body bg-light text-center p-3">
                                <h6 class="card-title text-dark mb-1">{{ $g->title }}</h6>
                                <small class="text-muted">{{ $g->date ? date('M Y', strtotime($g->date)) : '' }}</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
