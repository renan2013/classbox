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
                    <div class="course-item bg-light shadow-sm rounded h-100 d-flex flex-column justify-content-between overflow-hidden">
                        <div>
                            <div class="position-relative overflow-hidden w-100" style="height: 220px; background-color: #f1f5f9;">
                                @if($post->main_image)
                                    <img class="w-100 h-100" src="{{ asset('storage/' . $post->main_image) }}" alt="{{ $post->title }}" style="height: 220px; width: 100%; object-fit: cover; object-position: center; display: block;">
                                @else
                                    <div class="w-100 h-100 bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 220px;">
                                        <i class="fa fa-book fa-3x"></i>
                                    </div>
                                @endif
                                <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-3" style="z-index: 2;">
                                    <a href="{{ route('site.course.show', $post->id) }}" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end shadow-sm" style="border-radius: 30px 0 0 30px;">Ver Programa</a>
                                    <a href="{{ route('site.contact') }}" class="flex-shrink-0 btn btn-sm btn-primary px-3 shadow-sm" style="border-radius: 0 30px 30px 0;">Matricular</a>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="mb-2">
                                    <small class="badge bg-primary px-2 py-1">{{ $post->category->name ?? 'General' }}</small>
                                </div>
                                <h5 class="mb-2 text-dark">{{ $post->title }}</h5>
                                <p class="text-muted small mb-0">{{ Str::limit($post->synopsis, 100) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
