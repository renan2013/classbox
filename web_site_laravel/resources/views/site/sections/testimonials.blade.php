<!-- Modular Section: Testimonials -->
@if($testimonios->isNotEmpty())
<div class="container-xxl py-4 py-md-4 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="text-center mb-4">
            <h6 class="section-title bg-white text-center text-primary px-3 mb-2">{{ $section->subtitle ?? 'Testimonios' }}</h6>
            <h1 class="mb-0">{{ $section->title ?? 'Lo Que Dicen Nuestros Estudiantes' }}</h1>
        </div>
        <div class="owl-carousel testimonial-carousel position-relative">
            @php
                $limit = $section->settings['limit'] ?? 6;
                $displayTestimonios = $testimonios->take($limit);
            @endphp
            @foreach($displayTestimonios as $t)
                <div class="testimonial-item text-center">
                    @if($t->image)
                        <img class="border rounded-circle p-2 mx-auto mb-3" src="{{ asset('storage/' . $t->image) }}" style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                        <div class="border rounded-circle p-2 mx-auto mb-3 d-flex align-items-center justify-content-center bg-light" style="width: 80px; height: 80px;">
                            <i class="fa fa-user fa-2x text-primary"></i>
                        </div>
                    @endif
                    <h5 class="mb-0">{{ $t->name }}</h5>
                    <p class="text-primary font-bold small mb-2">{{ $t->role ?? 'Graduado' }}</p>
                    <div class="testimonial-text bg-light text-center p-4 rounded shadow-sm">
                        <p class="mb-0 text-muted fst-italic">"{{ $t->content }}"</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
