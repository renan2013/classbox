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

@push('styles')
<style>
    .page-content {
        line-height: 1.8;
        color: #334155;
    }
    .page-content h1, .page-content h2, .page-content h3, .page-content h4, .page-content h5, .page-content h6 {
        color: #0f172a;
        font-weight: 700;
        margin-top: 1.75rem;
        margin-bottom: 0.75rem;
    }
    .page-content p {
        margin-bottom: 1.25rem;
    }
    .page-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.75rem;
        margin: 1.5rem 0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    .page-content blockquote {
        border-left: 4px solid var(--primary, #06BBCC);
        padding: 1rem 1.25rem;
        margin: 1.5rem 0;
        font-style: italic;
        color: #475569;
        background: #f8fafc;
        border-radius: 0 0.5rem 0.5rem 0;
    }
    .page-content table {
        width: 100%;
        margin-bottom: 1.5rem;
        border-collapse: collapse;
    }
    .page-content table th, .page-content table td {
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
    }
    .page-content table th {
        background-color: #f1f5f9;
        font-weight: 600;
        color: #1e293b;
    }
    .page-content ul, .page-content ol {
        margin-bottom: 1.25rem;
        padding-left: 1.5rem;
    }
    .page-content li {
        margin-bottom: 0.5rem;
    }
    .page-content iframe {
        max-width: 100%;
        border-radius: 0.75rem;
    }
</style>
@endpush
@endsection
