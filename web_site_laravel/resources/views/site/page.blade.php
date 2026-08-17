@extends('layouts.app')

@section('title', ($page->meta_title ?: $page->title) . ' - ' . ($client_data->company_name ?? 'Classbox'))

@section('content')
<!-- Breadcrumb Start -->
<div class="bg-light py-3 border-bottom mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item">
                    <a href="{{ route('site.home') }}" class="text-primary text-decoration-none">
                        <i class="fa fa-home me-1"></i>Inicio
                    </a>
                </li>
                <li class="breadcrumb-item active text-muted" aria-current="page">{{ $page->title }}</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Dynamic Page Content Start -->
<div class="container-xxl py-4 py-md-5">
    <div class="container">
        <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm border">
            @if($page->featured_image)
                <div class="mb-4 text-center overflow-hidden rounded-4" style="max-height: 420px;">
                    <img src="{{ $page->featured_image_url }}" alt="{{ $page->title }}" class="img-fluid w-100" style="object-fit: cover; max-height: 420px;">
                </div>
            @endif

            <h1 class="mb-4 font-bold text-slate-900 display-6">{{ $page->title }}</h1>

            <div class="page-content typography-content text-slate-700 leading-relaxed" style="font-size: 1.05rem;">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</div>
<!-- Dynamic Page Content End -->
@endsection
