@extends('layouts.app')

@section('title', 'Quiénes Somos - ' . ($client_data->company_name ?? 'CEFI'))

@section('content')
<!-- Breadcrumb Start -->
<div class="bg-light py-3 border-bottom mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('site.home') }}" class="text-primary text-decoration-none"><i class="fa fa-home me-1"></i>Inicio</a></li>
                <li class="breadcrumb-item active text-muted" aria-current="page">Quiénes Somos</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                <div class="position-relative h-100">
                    <img class="img-fluid position-absolute w-100 h-100 rounded" src="{{ asset('img/about.jpg') }}" alt="Sobre CEFI" style="object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <h6 class="section-title bg-white text-start text-primary pe-3">Nuestra Institución</h6>
                <h1 class="mb-4">Bienvenido a CEFI</h1>
                <p class="mb-4">El <strong>Centro de Formación Integral (CEFI)</strong> es una institución líder en educación técnica y capacitación continua en Costa Rica, orientada a dotar a nuestros estudiantes de competencias reales para el empleo.</p>
                <p class="mb-4">A través de metodologías ágiles, plataformas virtuales interactivas y docentes con sólida trayectoria en sus industrias, formamos profesionales capacitados para afrontar los desafíos del mundo laboral actual.</p>
                <div class="row gy-2 gx-4 mb-4">
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Instructores Especializados</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Clases Virtuales en Vivo</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Certificados y Títulos</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Soporte Académico Continuo</p>
                    </div>
                </div>
                <a class="btn btn-primary py-3 px-5 mt-2" href="{{ route('site.contact') }}">Quiero Matricularme</a>
            </div>
        </div>
    </div>
</div>
<!-- About End -->
@endsection
