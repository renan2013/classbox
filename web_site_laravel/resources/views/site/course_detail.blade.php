@extends('layouts.app')

@section('title', $post->title . ' - ' . ($client_data->company_name ?? 'Classbox'))

@section('content')
<!-- Breadcrumb Start -->
<div class="bg-light py-3 border-bottom mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('site.home') }}" class="text-primary text-decoration-none"><i class="fa fa-home me-1"></i>Inicio</a></li>
                @if($post->category)
                    <li class="breadcrumb-item"><a href="{{ route('site.category', $post->category_id) }}" class="text-primary text-decoration-none">{{ $post->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active text-muted" aria-current="page">{{ Str::limit($post->title, 45) }}</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Course Detail Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Columna Principal -->
            <div class="col-lg-8">
                @if($post->main_image)
                    <div class="mb-4 overflow-hidden rounded shadow-sm">
                        <img src="{{ asset('storage/' . $post->main_image) }}" class="img-fluid w-100" alt="{{ $post->title }}" style="max-height: 400px; object-fit: cover;">
                    </div>
                @endif

                <div class="mb-4">
                    <span class="badge bg-primary px-3 py-2 fs-6 mb-2">{{ $post->category->name ?? 'Especialidad' }}</span>
                    <h2 class="mb-3">{{ $post->title }}</h2>
                    <p class="fs-5 text-muted lead">{{ $post->synopsis }}</p>
                </div>

                <div class="course-content mb-5">
                    <h4 class="mb-3 border-bottom pb-2">Información del Programa</h4>
                    <div class="text-dark">
                        {!! $post->content !!}
                    </div>
                </div>

                <!-- Galería de Fotos Adicionales -->
                @if($gallery_images->isNotEmpty())
                    <div class="mb-5">
                        <h4 class="mb-3 border-bottom pb-2">Galería Multimedia</h4>
                        <div class="row g-3">
                            @foreach($gallery_images as $img)
                                <div class="col-md-4 col-6">
                                    <img src="{{ asset('storage/' . $img->value) }}" class="img-fluid rounded shadow-sm w-100" style="height: 160px; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Columna Lateral / Ficha y Matrícula -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px; z-index: 1;">
                    <!-- Video explicativo en primer lugar del sidebar -->
                    @if($youtube_attachments->isNotEmpty())
                        <div class="mb-4">
                            @foreach($youtube_attachments as $yt)
                                @php
                                    $yt_url = $yt->value;
                                    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $yt_url, $match)) {
                                        $video_id = $match[1];
                                        $embed_url = "https://www.youtube.com/embed/{$video_id}";
                                    } else {
                                        $embed_url = $yt_url;
                                    }
                                @endphp
                                <div class="ratio ratio-16x9 rounded-4 shadow overflow-hidden border">
                                    <iframe src="{{ $embed_url }}" title="Video del curso" allowfullscreen></iframe>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="bg-light p-4 rounded shadow-sm mb-4">
                        <h4 class="mb-4">Matrícula & Requisitos</h4>

                        <div class="d-grid gap-2 mb-4">
                            <a href="https://wa.me/50687220999?text=Hola,%20deseo%20matricular%20el%20curso:%20{{ urlencode($post->title) }}" target="_blank" 
                               class="btn btn-success py-3 font-bold fs-6 shadow">
                                <i class="fab fa-whatsapp me-2"></i> Matricular por WhatsApp
                            </a>
                            <a href="{{ route('site.contact') }}" class="btn btn-primary py-3 font-bold fs-6">
                                <i class="fa fa-envelope me-2"></i> Formulario de Admisión
                            </a>
                        </div>

                        <!-- Descargas de Temario en PDF -->
                        @if($pdf_attachments->isNotEmpty())
                            <div class="border-top pt-3 mb-4">
                                <h5 class="mb-3"><i class="fa fa-file-pdf text-danger me-2"></i>Descargar Programa</h5>
                                @foreach($pdf_attachments as $pdf)
                                    <a href="{{ asset('storage/' . $pdf->value) }}" target="_blank" class="btn btn-outline-danger w-100 text-start mb-2 text-truncate">
                                        <i class="fa fa-download me-2"></i> {{ $pdf->file_name ?? 'Folleto Informativo PDF' }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                    <!-- Instructor Card si existe -->
                    @if($post->instructor_name)
                        <div class="border-top pt-3">
                            <h5 class="mb-3">Docente a Cargo</h5>
                            <div class="d-flex align-items-center">
                                @if($post->instructor_photo)
                                    <img src="{{ asset('storage/' . $post->instructor_photo) }}" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                        <i class="fa fa-chalkboard-teacher fa-2x"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-0">{{ $post->instructor_name }}</h6>
                                    <small class="text-muted">{{ $post->instructor_title ?? 'Instructor Especializado' }}</small>
                                </div>
                            </div>
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Course Detail End -->
@endsection
