@extends('layouts.app')

@section('title', 'Testimonios de Estudiantes - CEFI')

@section('content')
<!-- Breadcrumb Start -->
<div class="bg-light py-3 border-bottom mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('site.home') }}" class="text-primary text-decoration-none"><i class="fa fa-home me-1"></i>Inicio</a></li>
                <li class="breadcrumb-item active text-muted" aria-current="page">Testimonios</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Testimonials Grid Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Opiniones</h6>
            <h1 class="mb-5">Experiencias de Nuestros Graduados</h1>
        </div>

        <div class="row g-4">
            @forelse($testimonios as $test)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="testimonial-item text-center p-4 bg-light rounded shadow-sm h-100 d-flex flex-column justify-content-between">
                        <div>
                            @if($test->foto)
                                <img class="border rounded-circle p-2 mx-auto mb-3" src="{{ asset('storage/' . $test->foto) }}" style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="border rounded-circle p-2 mx-auto mb-3 bg-primary text-white d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fa fa-user fa-2x"></i>
                                </div>
                            @endif
                            <h5 class="mb-0 text-dark">{{ $test->nombre }}</h5>
                            <p class="text-muted small">{{ $test->profesion ?? 'Estudiante' }}</p>
                            <div class="testimonial-text bg-white text-center p-4 rounded mt-3">
                                <p class="mb-0 italic text-muted">"{{ $test->comentario }}"</p>
                                @if($test->video_iframe)
                                    <div class="mt-3 ratio ratio-16x9">
                                        {!! $test->video_iframe !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="bg-light p-5 rounded">
                        <p class="text-muted">Próximamente más testimonios.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($testimonios->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $testimonios->links() }}
            </div>
        @endif
    </div>
</div>
<!-- Testimonials Grid End -->
@endsection
