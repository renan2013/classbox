@extends('layouts.app')

@section('title', $category->name . ' - CEFI')

@section('content')
<!-- Courses Grid Start -->
<div class="container-xxl py-4">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Catálogo Académico</h6>
            <h1 class="mb-5">Cursos Disponibles en {{ $category->name }}</h1>
        </div>
        <div class="row g-4">
            @forelse($posts as $post)
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="card h-100 shadow-sm border-0 course-card overflow-hidden">
                        <a href="{{ route('site.course.show', $post->id) }}" class="d-block overflow-hidden">
                            @if($post->main_image)
                                <img src="{{ asset('storage/' . $post->main_image) }}" class="card-img-top w-100" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-light text-center py-5 text-muted" style="height: 200px;">
                                    <i class="fa fa-book-open fa-3x"></i>
                                </div>
                            @endif
                        </a>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <span class="badge bg-primary mb-2">{{ $category->name }}</span>
                                <h5 class="card-title mb-2 text-dark">{{ $post->title }}</h5>
                                <p class="card-text text-muted small">{{ Str::limit($post->synopsis, 90) }}</p>
                            </div>
                            <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
                                <a href="{{ route('site.course.show', $post->id) }}" class="btn btn-sm btn-outline-primary">Ver Detalles</a>
                                <a href="https://wa.me/50687220999?text=Hola,%20solicito%20información%20sobre%20el%20curso:%20{{ urlencode($post->title) }}" target="_blank" class="btn btn-sm btn-success">
                                    <i class="fab fa-whatsapp"></i> Info
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="bg-light p-5 rounded">
                        <i class="fa fa-info-circle fa-3x text-muted mb-3"></i>
                        <h4>Próximamente más programas</h4>
                        <p class="text-muted">Actualmente estamos actualizando los cursos de esta categoría. ¡Vuelve a consultar pronto!</p>
                        <a href="{{ route('site.home') }}" class="btn btn-primary mt-3">Volver al Inicio</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Courses Grid End -->
@endsection
