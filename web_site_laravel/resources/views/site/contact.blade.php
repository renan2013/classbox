@extends('layouts.app')

@section('title', 'Contacto y Matrícula - ' . ($client_data->company_name ?? 'CEFI'))

@section('content')
<!-- Breadcrumb Start -->
<div class="bg-light py-3 border-bottom mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('site.home') }}" class="text-primary text-decoration-none"><i class="fa fa-home me-1"></i>Inicio</a></li>
                <li class="breadcrumb-item active text-muted" aria-current="page">Contacto & Admisiones</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Contact Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Escríbenos</h6>
            <h1 class="mb-5">Inicia Tu Formación Profesional</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show p-4 mb-5 shadow-sm" role="alert">
                <h4 class="alert-heading"><i class="fa fa-check-circle me-2"></i>¡Solicitud Enviada!</h4>
                <p class="mb-0">{{ session('success') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <h5>Ponte en contacto</h5>
                <p class="mb-4">Nuestro equipo de asesores académicos está disponible para resolver todas tus dudas sobre horarios, financiamiento y modalidades de estudio.</p>
                <div class="d-flex align-items-center mb-3">
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary rounded-circle" style="width: 50px; height: 50px;">
                        <i class="fa fa-map-marker-alt text-white"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="text-primary mb-0">Ubicación</h5>
                        <p class="mb-0 text-muted">{{ $client_data->address ?? 'San José, Costa Rica' }}</p>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary rounded-circle" style="width: 50px; height: 50px;">
                        <i class="fa fa-phone-alt text-white"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="text-primary mb-0">Teléfono</h5>
                        <p class="mb-0 text-muted">{{ $client_data->phone ?? '+(506) 2221-7870' }}</p>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-success rounded-circle" style="width: 50px; height: 50px;">
                        <i class="fab fa-whatsapp text-white fs-4"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="text-success mb-0">WhatsApp</h5>
                        <p class="mb-0 text-muted">+{{ $client_data->whatsapp_country_code ?? '506' }} {{ $client_data->whatsapp_number ?? '87220999' }}</p>
                    </div>
                </div>
            </div>

            <!-- Formulario de Admisión -->
            <div class="col-lg-8 col-md-12 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-light p-4 p-md-5 rounded shadow-sm">
                    <h4 class="mb-4">Formulario de Admisión y Matrícula</h4>
                    <form action="{{ route('site.contact.submit') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre completo" required>
                                    <label for="nombre">Nombre Completo *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico" required>
                                    <label for="email">Correo Electrónico *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="WhatsApp" required>
                                    <label for="whatsapp">WhatsApp / Teléfono *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" value="Costarricense" placeholder="Nacionalidad">
                                    <label for="nacionalidad">Nacionalidad</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="programa" name="programa" placeholder="Programa de interés">
                                    <label for="programa">Curso o Carrera de Interés</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3 font-bold" type="submit">
                                    <i class="fa fa-paper-plane me-2"></i> Enviar Solicitud de Matrícula
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->
@endsection
