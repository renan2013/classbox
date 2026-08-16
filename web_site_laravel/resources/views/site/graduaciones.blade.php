@extends('layouts.app')

@section('title', 'Nuestras Graduaciones - CEFI')

@section('content')
<!-- Breadcrumb Start -->
<div class="bg-light py-3 border-bottom mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('site.home') }}" class="text-primary text-decoration-none"><i class="fa fa-home me-1"></i>Inicio</a></li>
                <li class="breadcrumb-item active text-muted" aria-current="page">Graduaciones</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Graduaciones Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Galería de Eventos</h6>
            <h1 class="mb-5">Ceremonias y Egresados</h1>
        </div>

        <div class="row g-4">
            @forelse($graduaciones as $grad)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="card h-100 shadow-sm border-0 overflow-hidden">
                        <a href="{{ route('site.graduacion.show', $grad->id) }}" class="d-block overflow-hidden">
                            @if($grad->main_image)
                                <img src="{{ asset('storage/' . $grad->main_image) }}" class="card-img-top w-100" alt="{{ $grad->title }}" style="height: 250px; object-fit: cover;">
                            @else
                                <div class="bg-light text-center py-5 text-muted" style="height: 250px;">
                                    <i class="fa fa-graduation-cap fa-4x text-primary"></i>
                                </div>
                            @endif
                        </a>
                        <div class="card-body">
                            <span class="badge bg-primary mb-2">Ceremonia</span>
                            <h5 class="card-title mb-2 text-dark">{{ $grad->title }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($grad->synopsis, 100) }}</p>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center pb-3">
                            <small class="text-muted"><i class="fa fa-calendar-alt me-1"></i>{{ $grad->created_at->format('d/m/Y') }}</small>
                            <a href="{{ route('site.graduacion.show', $grad->id) }}" class="btn btn-sm btn-outline-primary">Ver Álbum &rarr;</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="bg-light p-5 rounded">
                        <i class="fa fa-images fa-3x text-muted mb-3"></i>
                        <h4>Próximamente fotos de graduaciones</h4>
                        <p class="text-muted">Estaremos publicando las fotos y videos de las próximas ceremonias.</p>
                        <a href="{{ route('site.home') }}" class="btn btn-primary mt-3">Volver al Inicio</a>
                    </div>
                </div>
            @endforelse
        </div>

        @if($graduaciones->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $graduaciones->links() }}
            </div>
        @endif
    </div>
</div>
<!-- Graduaciones End -->
@endsection
