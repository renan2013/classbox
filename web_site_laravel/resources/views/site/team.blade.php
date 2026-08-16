@extends('layouts.app')

@section('title', 'Equipo Docente - CEFI')

@section('content')
<!-- Breadcrumb Start -->
<div class="bg-light py-3 border-bottom mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('site.home') }}" class="text-primary text-decoration-none"><i class="fa fa-home me-1"></i>Inicio</a></li>
                <li class="breadcrumb-item active text-muted" aria-current="page">Equipo Docente</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Team Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Docentes</h6>
            <h1 class="mb-5">Nuestros Instructores Expertos</h1>
        </div>
        <div class="row g-4">
            @forelse($instructors as $inst)
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item bg-light text-center rounded overflow-hidden shadow-sm">
                        <div class="overflow-hidden">
                            @if($inst->instructor_photo)
                                <img class="img-fluid w-100" src="{{ asset('storage/' . $inst->instructor_photo) }}" alt="{{ $inst->instructor_name }}" style="height: 250px; object-fit: cover;">
                            @else
                                <div class="bg-primary text-white py-5 d-flex align-items-center justify-content-center" style="height: 250px;">
                                    <i class="fa fa-user-tie fa-4x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h5 class="mb-0 text-dark">{{ $inst->instructor_name }}</h5>
                            <small class="text-primary font-bold">{{ $inst->instructor_title ?? 'Docente Especializado' }}</small>
                            <p class="text-muted small mt-2 mb-0">{{ $inst->title }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="bg-light p-5 rounded">
                        <h4>Equipo docente en actualización</h4>
                        <p class="text-muted">Pronto podrás conocer más detalles sobre todo nuestro cuerpo docente.</p>
                        <a href="{{ route('site.home') }}" class="btn btn-primary mt-3">Volver al Inicio</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Team End -->
@endsection
