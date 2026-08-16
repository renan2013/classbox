@extends('layouts.app')

@section('title', $graduacion->title . ' - CEFI')

@section('content')
<!-- Breadcrumb Start -->
<div class="bg-light py-3 border-bottom mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('site.home') }}" class="text-primary text-decoration-none"><i class="fa fa-home me-1"></i>Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('site.graduaciones') }}" class="text-primary text-decoration-none">Graduaciones</a></li>
                <li class="breadcrumb-item active text-muted" aria-current="page">{{ Str::limit($graduacion->title, 40) }}</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Detail Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                @if($graduacion->main_image)
                    <div class="mb-4 rounded overflow-hidden shadow-sm">
                        <img src="{{ asset('storage/' . $graduacion->main_image) }}" class="img-fluid w-100" alt="{{ $graduacion->title }}" style="max-height: 450px; object-fit: cover;">
                    </div>
                @endif

                <h2 class="mb-3">{{ $graduacion->title }}</h2>
                <p class="text-muted mb-4">{{ $graduacion->synopsis }}</p>

                <!-- Video del evento si existe -->
                @if($graduacion->video_url)
                    <div class="mb-5">
                        <h4 class="mb-3 border-bottom pb-2"><i class="fab fa-youtube text-danger me-2"></i>Video de la Ceremonia</h4>
                        @php
                            $yt_url = $graduacion->video_url;
                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $yt_url, $match)) {
                                $video_id = $match[1];
                                $embed_url = "https://www.youtube.com/embed/{$video_id}";
                            } else {
                                $embed_url = $yt_url;
                            }
                        @endphp
                        <div class="ratio ratio-16x9 rounded shadow-sm overflow-hidden">
                            <iframe src="{{ $embed_url }}" title="Video de graduación" allowfullscreen></iframe>
                        </div>
                    </div>
                @endif

                <!-- Galería de Fotos -->
                @if($graduacion->attachments->isNotEmpty())
                    <div class="mb-5">
                        <h4 class="mb-3 border-bottom pb-2"><i class="fa fa-camera-retro text-primary me-2"></i>Galería de Recuerdos</h4>
                        <div class="row g-3">
                            @foreach($graduacion->attachments as $photo)
                                <div class="col-md-4 col-6">
                                    <a href="{{ asset('storage/' . $photo->value) }}" target="_blank" class="d-block overflow-hidden rounded shadow-sm">
                                        <img src="{{ asset('storage/' . $photo->value) }}" class="img-fluid w-100" style="height: 180px; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Columna Lateral -->
            <div class="col-lg-4">
                <div class="bg-light p-4 rounded shadow-sm">
                    <h5 class="mb-3">Otras Graduaciones</h5>
                    <div class="space-y-3">
                        @foreach($other_graduations as $og)
                            <div class="d-flex align-items-center mb-3">
                                @if($og->main_image)
                                    <img src="{{ asset('storage/' . $og->main_image) }}" class="rounded me-3" style="width: 70px; height: 70px; object-fit: cover;">
                                @else
                                    <div class="rounded bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 70px; height: 70px;">
                                        <i class="fa fa-graduation-cap fa-2x"></i>
                                    </div>
                                @endif
                                <div>
                                    <a href="{{ route('site.graduacion.show', $og->id) }}" class="text-dark font-bold text-decoration-none d-block mb-1">{{ $og->title }}</a>
                                    <small class="text-muted">{{ $og->created_at->format('d/m/Y') }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 pt-3 border-top text-center">
                        <a href="{{ route('site.graduaciones') }}" class="btn btn-outline-primary w-100">Ver todas las ceremonias</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Detail End -->
@endsection
