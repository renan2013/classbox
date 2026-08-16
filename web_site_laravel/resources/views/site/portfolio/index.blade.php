@extends('layouts.app')

@section('title', 'Portafolio de Trabajos - ' . ($client_data->company_name ?? 'CEFI'))

@section('content')
<!-- Breadcrumb Start -->
<div class="bg-light py-3 border-bottom mb-2">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('site.home') }}" class="text-primary text-decoration-none"><i class="fa fa-home me-1"></i>Inicio</a></li>
                <li class="breadcrumb-item active text-muted" aria-current="page">Portafolio</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Breadcrumb End -->

@include('site.sections.portfolio', [
    'section' => (object) [
        'title' => 'Portafolio de Trabajos y Proyectos',
        'subtitle' => 'A lo largo de más de 25 años de trabajo queremos compartir algunos de nuestros trabajos que ponemos a su disposición'
    ]
])
@endsection
