<!-- Modular Section: CTA Banner -->
<div class="container-xxl py-4 py-md-4">
    <div class="container">
        <div class="bg-primary text-white rounded-3 p-5 shadow-lg position-relative overflow-hidden" style="background: linear-gradient(135deg, #06BBCC 0%, #034870 100%);">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    @if($section->subtitle)
                        <span class="badge bg-white text-primary text-uppercase px-3 py-2 mb-2 font-bold">{{ $section->subtitle }}</span>
                    @endif
                    <h2 class="display-6 text-white font-bold mb-3">{{ $section->title ?? '¿Listo para Iniciar Tu Carrera Profesional?' }}</h2>
                    <p class="lead mb-0 text-white-50">Consulta sobre nuestros planes de estudio, horarios flexibles y facilidades de matrícula.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ $section->settings['button_url'] ?? route('site.contact') }}" class="btn btn-light btn-lg px-4 py-3 font-bold shadow text-primary">
                        {{ $section->settings['button_text'] ?? 'Solicitar Información' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
