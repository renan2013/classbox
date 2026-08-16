<!-- Modular Section: Categories -->
<div class="container-xxl py-5 category">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">{{ $section->subtitle ?? 'Nuestras Escuelas' }}</h6>
            <h1 class="mb-5">{{ $section->title ?? 'Áreas de Formación' }}</h1>
        </div>
        <div class="row g-4">
            @foreach($categories as $cat)
                <div class="col-lg-3 col-md-6 wow zoomIn" data-wow-delay="0.1s">
                    <a class="position-relative d-block overflow-hidden rounded shadow-sm text-decoration-none" href="{{ route('site.category', $cat->id) }}">
                        @if($cat->image)
                            <img class="img-fluid w-100" src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}" style="height: 220px; width: 100%; object-fit: cover;">
                        @else
                            <div class="bg-primary text-white d-flex align-items-center justify-content-center" style="height: 220px;">
                                <i class="fa fa-graduation-cap fa-3x"></i>
                            </div>
                        @endif
                        <div class="bg-white text-center position-absolute bottom-0 end-0 start-0 py-3 px-3">
                            <h5 class="m-0 text-dark">{{ $cat->name }}</h5>
                            <small class="text-primary font-bold">{{ $cat->posts_count }} Cursos Disponibles</small>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
