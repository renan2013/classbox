<!-- Modular Section: Featured Posts / Courses -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">{{ $section->subtitle ?? 'Cursos Populares' }}</h6>
            <h1 class="mb-5">{{ $section->title ?? 'Programas Destacados' }}</h1>
        </div>
        <div class="row g-4 justify-content-center">
            @php
                $limit = $section->settings['limit'] ?? 6;
                $displayPosts = $featured_posts->take($limit);
            @endphp
            @foreach($displayPosts as $post)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="card h-100 border-0 shadow-sm course-card-premium overflow-hidden d-flex flex-column justify-content-between">
                        <div>
                            <!-- Header de Imagen con Badge Flotante -->
                            <div class="position-relative overflow-hidden course-img-wrapper" style="height: 220px; background: #f8fafc;">
                                <a href="{{ route('site.course.show', $post->id) }}" class="d-block w-100 h-100">
                                    @if($post->main_image)
                                        <img class="w-100 h-100 course-img" src="{{ asset('storage/' . $post->main_image) }}" alt="{{ $post->title }}">
                                    @else
                                        <div class="w-100 h-100 bg-secondary text-white d-flex align-items-center justify-content-center">
                                            <i class="fa fa-book-open fa-3x opacity-50"></i>
                                        </div>
                                    @endif
                                </a>
                                <!-- Floating Badge -->
                                <div class="position-absolute top-0 start-0 m-3 z-index-2">
                                    <span class="badge bg-white text-dark shadow-sm px-3 py-2 rounded-pill fw-semibold border" style="font-size: 0.78rem;">
                                        <i class="fa fa-graduation-cap text-primary me-1"></i> {{ $post->category->name ?? 'General' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Contenido del Curso -->
                            <div class="p-4">
                                <h5 class="course-card-title mb-2">
                                    <a href="{{ route('site.course.show', $post->id) }}" class="text-dark text-decoration-none hover-primary">
                                        {{ $post->title }}
                                    </a>
                                </h5>
                                <p class="text-muted small course-card-desc mb-3">
                                    {{ Str::limit($post->synopsis ?: strip_tags($post->content), 100) }}
                                </p>

                                <div class="d-flex align-items-center text-muted small pt-2 border-top">
                                    <span class="d-inline-flex align-items-center me-3">
                                        <i class="fa fa-user-tie text-primary me-1"></i> {{ $post->instructor_name ?: 'CEFI Docentes' }}
                                    </span>
                                    <span class="d-inline-flex align-items-center ms-auto text-primary fw-semibold">
                                        <i class="fa fa-certificate me-1"></i> Certificado
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Footer con Botones de Acción -->
                        <div class="card-footer bg-light px-4 py-3 border-top-0 d-flex justify-content-between align-items-center gap-2">
                            <a href="{{ route('site.course.show', $post->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-2 fw-medium flex-fill text-center">
                                Ver Programa <i class="fa fa-arrow-right ms-1 text-xs"></i>
                            </a>
                            <a href="https://wa.me/50687220999?text=Hola,%20deseo%20matricular%20el%20curso:%20{{ urlencode($post->title) }}" target="_blank" class="btn btn-sm btn-primary rounded-pill px-3 py-2 fw-medium flex-fill text-center text-white">
                                <i class="fab fa-whatsapp me-1"></i> Matricular
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
