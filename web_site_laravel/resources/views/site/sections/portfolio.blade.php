<!-- Modular Section: Portafolio de Trabajos -->
<div class="container-xxl py-5" id="portfolio-section">
    <div class="container">
        <!-- Section Header -->
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="mb-3 text-dark fw-bold" style="font-size: 2.3rem;">{{ $section->title ?: 'Portafolio de Trabajos' }}</h1>
            @if($section->subtitle)
                <p class="text-muted mx-auto mb-4" style="max-width: 750px; font-size: 0.95rem; line-height: 1.6;">
                    {{ $section->subtitle }}
                </p>
            @endif
        </div>

        @php
            $pCategories = $portfolioCategories ?? App\Models\PortfolioCategory::where('is_active', true)->whereHas('items', fn($q) => $q->where('is_active', true))->orderBy('order', 'asc')->get();
            $pItems = $portfolioItems ?? App\Models\PortfolioItem::with('category')->where('is_active', true)->orderBy('order', 'asc')->orderBy('created_at', 'desc')->get();
        @endphp

        <!-- Interactive Category Filters -->
        @if($pCategories->isNotEmpty() && $pItems->isNotEmpty())
            <div class="row mb-4 wow fadeInUp" data-wow-delay="0.2s">
                <div class="col-12 text-center">
                    <div class="d-inline-flex flex-wrap justify-content-center gap-2 portfolio-filter-nav">
                        <button type="button" class="btn btn-sm btn-portfolio-filter active px-3 py-1.5 rounded-pill" data-filter="all">
                            Todo
                        </button>
                        @foreach($pCategories as $cat)
                            <button type="button" class="btn btn-sm btn-portfolio-filter px-3 py-1.5 rounded-pill" data-filter="cat-{{ $cat->id }}">
                                {{ $cat->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Portfolio Items Grid -->
        <div class="row g-4 justify-content-center" id="portfolio-grid">
            @forelse($pItems as $index => $item)
                @php
                    $catName = $item->category->name ?? 'General';
                @endphp
                <div class="col-lg-3 col-md-4 col-sm-6 portfolio-grid-item cat-{{ $item->category_id ?? 'general' }} wow fadeInUp" data-wow-delay="0.1s" data-index="{{ $index }}">
                    <div class="portfolio-card text-center p-3 rounded-4 shadow-sm bg-white h-100 d-flex flex-column justify-content-between position-relative">
                        <!-- Image / Logo Preview -->
                        <div class="portfolio-img-wrap rounded-3 d-flex align-items-center justify-content-center p-3" 
                             style="height: 200px; background: #ffffff; cursor: pointer;" 
                             onclick="openPortfolioLightbox({{ $index }})">
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="img-fluid portfolio-logo-img" style="max-height: 160px; max-width: 100%; object-fit: contain; transition: transform 0.3s ease;">
                            <div class="portfolio-hover-overlay rounded-3 d-flex align-items-center justify-content-center">
                                <i class="fa fa-search-plus text-white fs-3"></i>
                            </div>
                        </div>

                        <!-- Button "Ver Detalles" -->
                        <div class="pt-2 border-top border-slate-100 mt-2">
                            <button type="button" 
                                    class="btn btn-sm btn-outline-primary w-100 rounded-pill py-2 fw-bold d-flex align-items-center justify-content-center gap-2 shadow-sm"
                                    onclick="openPortfolioLightbox({{ $index }})">
                                <i class="fa fa-eye"></i> <span>Ver Detalles</span>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">
                    <i class="fa-solid fa-briefcase fa-3x mb-3 opacity-50"></i>
                    <p class="mb-0">Próximamente publicaremos nuestros trabajos destacados.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- ==========================================
     LIGHTBOX CAROUSEL OVERLAY PURO (Sin Contenedor ni Cajas, Imagen Gigante)
     ========================================== -->
<div id="portfolioLightbox" class="portfolio-lightbox-overlay" style="display: none;">
    <!-- Backdrop Blur Oscuro Transparente -->
    <div class="portfolio-lightbox-backdrop" onclick="closePortfolioLightbox()"></div>

    <!-- Top Floating Bar: Category + Counter + Close Button -->
    <div class="portfolio-lightbox-topbar">
        <div class="d-flex align-items-center gap-3">
            <span id="lightboxCategory" class="badge bg-primary text-white text-uppercase px-3 py-1.5 rounded-pill shadow" style="font-size: 0.8rem; letter-spacing: 0.5px;"></span>
            <span id="lightboxCounter" class="text-white-50 font-monospace small">1 / 1</span>
        </div>
        <button type="button" class="portfolio-lightbox-close" onclick="closePortfolioLightbox()" title="Cerrar (Esc)">
            <i class="fa fa-times"></i>
        </button>
    </div>

    <!-- Left Navigation Arrow (Anterior) -->
    <button type="button" class="portfolio-lightbox-btn portfolio-arrow-btn prev" onclick="prevPortfolioItem(event)" title="Anterior (Flecha izquierda)">
        <i class="fa fa-chevron-left"></i>
    </button>

    <!-- Right Navigation Arrow (Siguiente) -->
    <button type="button" class="portfolio-lightbox-btn portfolio-arrow-btn next" onclick="nextPortfolioItem(event)" title="Siguiente (Flecha derecha)">
        <i class="fa fa-chevron-right"></i>
    </button>

    <!-- Center Stage: Imagen Flotante Gigante + Info Debajo (Sin Cajas ni Marcos) -->
    <div class="portfolio-lightbox-stage">
        <!-- Floating Large Image -->
        <div class="portfolio-lightbox-img-wrapper">
            <img id="lightboxImg" src="#" alt="Proyecto" class="portfolio-lightbox-img">
        </div>

        <!-- Info Description Block underneath -->
        <div class="portfolio-lightbox-info text-center mt-3">
            <h3 id="lightboxTitle" class="text-white fw-bold mb-1" style="text-shadow: 0 2px 10px rgba(0,0,0,0.85); font-size: 1.6rem;"></h3>
            <p id="lightboxClient" class="text-primary fw-semibold mb-2" style="font-size: 1.05rem; text-shadow: 0 2px 8px rgba(0,0,0,0.85);"></p>
            <p id="lightboxDesc" class="text-white-50 small mx-auto mb-3" style="max-width: 700px; line-height: 1.6; text-shadow: 0 1px 6px rgba(0,0,0,0.85); font-size: 0.95rem;"></p>
            <div id="lightboxLinkWrap" class="d-none mt-2">
                <a id="lightboxLink" href="#" target="_blank" class="btn btn-primary px-4 py-2 rounded-pill shadow-lg fw-bold">
                    Visitar Proyecto <i class="fa fa-external-link-alt ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Estilos del Portafolio & Lightbox Puro -->
<style>
    .portfolio-card {
        border: 1px solid #e2e8f0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .portfolio-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04) !important;
        border-color: var(--primary, #06BBCC);
    }
    .portfolio-card:hover .portfolio-logo-img {
        transform: scale(1.06);
    }
    .portfolio-img-wrap {
        position: relative;
        overflow: hidden;
    }
    .portfolio-hover-overlay {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.35);
        opacity: 0;
        transition: opacity 0.25s ease;
    }
    .portfolio-img-wrap:hover .portfolio-hover-overlay {
        opacity: 1;
    }
    .btn-portfolio-filter {
        background: #f1f5f9;
        color: #475569;
        font-weight: 600;
        font-size: 0.85rem;
        border: 1px solid transparent;
        transition: all 0.2s ease;
    }
    .btn-portfolio-filter:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    .btn-portfolio-filter.active {
        background: var(--primary, #06BBCC);
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(6, 187, 204, 0.3);
    }
    .portfolio-grid-item.hide-item {
        display: none !important;
    }

    /* Lightbox Overlay Puro (Sin Contenedor) */
    .portfolio-lightbox-overlay {
        position: fixed;
        inset: 0;
        z-index: 999999;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 70px 20px 20px;
    }
    .portfolio-lightbox-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(10, 15, 30, 0.92);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        cursor: pointer;
    }
    .portfolio-lightbox-topbar {
        position: absolute;
        top: 25px;
        left: 40px;
        right: 40px;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: space-between;
        pointer-events: none;
    }
    .portfolio-lightbox-topbar > * {
        pointer-events: auto;
    }
    .portfolio-lightbox-close {
        background: rgba(255, 255, 255, 0.18);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #ffffff;
        width: 46px;
        height: 46px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.2s ease;
        backdrop-filter: blur(8px);
    }
    .portfolio-lightbox-close:hover {
        background: #e11d48;
        color: #ffffff;
        transform: scale(1.1);
        border-color: #e11d48;
        box-shadow: 0 0 20px rgba(225, 29, 72, 0.5);
    }
    .portfolio-lightbox-stage {
        position: relative;
        z-index: 2;
        max-width: 90vw;
        max-height: 85vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        overflow-y: auto;
        padding: 10px;
    }
    .portfolio-lightbox-img-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        max-height: 60vh;
        width: auto;
    }
    .portfolio-lightbox-img {
        max-height: 58vh;
        max-width: 80vw;
        object-fit: contain;
        filter: none;
        transition: opacity 0.25s ease, transform 0.25s ease;
    }
    .portfolio-lightbox-btn {
        position: absolute;
        z-index: 10;
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: #ffffff;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        cursor: pointer;
        transition: all 0.2s ease;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }
    .portfolio-lightbox-btn:hover {
        background: var(--primary, #06BBCC);
        color: #ffffff;
        transform: scale(1.12);
        border-color: var(--primary, #06BBCC);
        box-shadow: 0 0 25px rgba(6, 187, 204, 0.6);
    }
    .portfolio-arrow-btn.prev {
        left: 30px;
        top: 50%;
        transform: translateY(-50%);
    }
    .portfolio-arrow-btn.prev:hover {
        transform: translateY(-50%) scale(1.12);
    }
    .portfolio-arrow-btn.next {
        right: 30px;
        top: 50%;
        transform: translateY(-50%);
    }
    .portfolio-arrow-btn.next:hover {
        transform: translateY(-50%) scale(1.12);
    }

    @media (max-width: 768px) {
        .portfolio-lightbox-topbar {
            top: 15px;
            left: 15px;
            right: 15px;
        }
        .portfolio-arrow-btn.prev {
            left: 10px;
            width: 42px;
            height: 42px;
            font-size: 16px;
        }
        .portfolio-arrow-btn.next {
            right: 10px;
            width: 42px;
            height: 42px;
            font-size: 16px;
        }
        .portfolio-lightbox-close {
            width: 38px;
            height: 38px;
            font-size: 16px;
        }
        .portfolio-lightbox-img {
            max-height: 45vh;
            max-width: 90vw;
        }
    }
</style>

<!-- JS: Lightbox Carousel & Interactive Filter -->
<script>
    window.allPortfolioItems = [
        @foreach($pItems as $i)
            {
                image_url: "{{ $i->image_url }}",
                title: "{{ addslashes($i->title) }}",
                category: "{{ addslashes($i->category->name ?? 'General') }}",
                category_id: "{{ $i->category_id ?? 'general' }}",
                client_name: "{{ addslashes($i->client_name ?? '') }}",
                description: "{{ addslashes($i->description ?? '') }}",
                project_url: "{{ $i->project_url ?? '' }}"
            }@if(!$loop->last),@endif
        @endforeach
    ];

    let currentVisibleItems = [...window.allPortfolioItems];
    let currentLightboxIndex = 0;

    document.addEventListener('DOMContentLoaded', function() {
        // Filtrado por categoría
        const filterBtns = document.querySelectorAll('.btn-portfolio-filter');
        const gridItems = document.querySelectorAll('.portfolio-grid-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');

                if (filter === 'all') {
                    currentVisibleItems = [...window.allPortfolioItems];
                } else {
                    const catId = filter.replace('cat-', '');
                    currentVisibleItems = window.allPortfolioItems.filter(item => item.category_id == catId);
                }

                gridItems.forEach(item => {
                    if (filter === 'all' || item.classList.contains(filter)) {
                        item.classList.remove('hide-item');
                        item.style.opacity = '0';
                        setTimeout(() => { item.style.opacity = '1'; item.style.transition = 'opacity 0.3s ease'; }, 10);
                    } else {
                        item.classList.add('hide-item');
                    }
                });
            });
        });

        // Navegación con teclado (Esc, Izquierda, Derecha)
        document.addEventListener('keydown', function(e) {
            const lightbox = document.getElementById('portfolioLightbox');
            if (lightbox && lightbox.style.display !== 'none') {
                if (e.key === 'Escape') closePortfolioLightbox();
                if (e.key === 'ArrowLeft') prevPortfolioItem(e);
                if (e.key === 'ArrowRight') nextPortfolioItem(e);
            }
        });
    });

    function openPortfolioLightbox(index) {
        if (!currentVisibleItems || currentVisibleItems.length === 0) return;

        const targetItem = window.allPortfolioItems[index];
        let foundIdx = currentVisibleItems.findIndex(it => it.title === targetItem.title && it.image_url === targetItem.image_url);
        currentLightboxIndex = foundIdx !== -1 ? foundIdx : 0;

        renderLightboxItem();
        
        const lightbox = document.getElementById('portfolioLightbox');
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closePortfolioLightbox() {
        const lightbox = document.getElementById('portfolioLightbox');
        lightbox.style.display = 'none';
        document.body.style.overflow = '';
    }

    function prevPortfolioItem(e) {
        if (e) e.stopPropagation();
        if (currentVisibleItems.length <= 1) return;
        currentLightboxIndex = (currentLightboxIndex - 1 + currentVisibleItems.length) % currentVisibleItems.length;
        renderLightboxItem();
    }

    function nextPortfolioItem(e) {
        if (e) e.stopPropagation();
        if (currentVisibleItems.length <= 1) return;
        currentLightboxIndex = (currentLightboxIndex + 1) % currentVisibleItems.length;
        renderLightboxItem();
    }

    function renderLightboxItem() {
        const item = currentVisibleItems[currentLightboxIndex];
        if (!item) return;

        const imgEl = document.getElementById('lightboxImg');
        imgEl.style.opacity = '0';
        imgEl.style.transform = 'scale(0.96)';

        setTimeout(() => {
            imgEl.src = item.image_url;
            imgEl.alt = item.title;
            imgEl.style.opacity = '1';
            imgEl.style.transform = 'scale(1)';
        }, 100);

        document.getElementById('lightboxTitle').textContent = item.title;
        document.getElementById('lightboxCategory').textContent = item.category || 'General';
        document.getElementById('lightboxCounter').textContent = (currentLightboxIndex + 1) + ' / ' + currentVisibleItems.length;

        const clientEl = document.getElementById('lightboxClient');
        if (item.client_name && item.client_name.trim() !== '') {
            clientEl.innerHTML = '<i class="fa fa-building me-1"></i> Cliente: ' + item.client_name;
            clientEl.classList.remove('d-none');
        } else {
            clientEl.classList.add('d-none');
        }

        const descEl = document.getElementById('lightboxDesc');
        if (item.description && item.description.trim() !== '') {
            descEl.textContent = item.description;
            descEl.classList.remove('d-none');
        } else {
            descEl.classList.add('d-none');
        }

        const linkWrap = document.getElementById('lightboxLinkWrap');
        const link = document.getElementById('lightboxLink');
        if (item.project_url && item.project_url.trim() !== '') {
            link.href = item.project_url;
            linkWrap.classList.remove('d-none');
        } else {
            linkWrap.classList.add('d-none');
        }
    }
</script>
