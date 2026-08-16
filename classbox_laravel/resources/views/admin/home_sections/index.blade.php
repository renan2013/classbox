@extends('layouts.admin')

@section('title', 'Constructor de Portada')
@section('page-title', 'Constructor de Portada (Page Builder)')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-12">
    <!-- Header & Info -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-puzzle-piece text-teal-600"></i> Estructura de la Página de Inicio
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">
                Arrastra las secciones o usa las flechas para ordenar los módulos. Activa o pausa cualquier bloque al instante.
            </p>
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto">
            <a href="{{ env('FRONTEND_URL', 'http://127.0.0.1:8080') }}" target="_blank" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> Ver Sitio
            </a>
            <button onclick="openAddSectionModal()" class="px-4 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-teal-600/20 transition flex items-center gap-1.5">
                <i class="fa-solid fa-plus"></i> Añadir Bloque
            </button>
        </div>
    </div>

    <!-- Sections List Container -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2">
            <i class="fa-solid fa-layer-group text-slate-400"></i> Bloques de la Portada (De arriba hacia abajo)
        </p>

        <div id="sortableSectionsList" class="space-y-3">
            @foreach($sections as $index => $sec)
                <div class="section-card bg-slate-50 hover:bg-white border border-slate-200 hover:border-teal-400 rounded-2xl p-4 transition-all duration-200 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4 select-none cursor-grab active:cursor-grabbing"
                     draggable="true" data-id="{{ $sec->id }}" id="section-row-{{ $sec->id }}">
                    
                    <!-- Left: Drag Handle, Number & Icon -->
                    <div class="flex items-center gap-3.5 w-full sm:w-auto">
                        <span class="drag-handle text-slate-300 hover:text-slate-600 cursor-grab px-1 text-base">
                            <i class="fa-solid fa-grip-vertical"></i>
                        </span>

                        <span class="order-badge w-6 h-6 rounded-lg bg-slate-200/80 text-slate-700 flex items-center justify-center text-xs font-mono font-bold shrink-0">
                            {{ $index + 1 }}
                        </span>

                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-lg shrink-0 shadow-sm">
                            <i class="{{ $sec->icon }}"></i>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold text-slate-800 flex items-center gap-2">
                                <span>{{ $sec->name }}</span>
                                <span class="font-mono text-[10px] text-slate-400 bg-slate-100 px-1.5 py-0.2 rounded border border-slate-200">
                                    {{ $sec->section_key }}
                                </span>
                            </h4>
                            <p class="text-[11px] text-slate-500 mt-0.5">
                                @if($sec->title)
                                    <span class="font-medium text-slate-700">"{{ $sec->title }}"</span>
                                    @if($sec->subtitle) • <span class="text-slate-400">{{ $sec->subtitle }}</span>@endif
                                @else
                                    <span class="italic text-slate-400">Sin título público fijado</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Right: Up/Down Buttons, Toggle Switch & Settings -->
                    <div class="flex items-center justify-between sm:justify-end gap-2 w-full sm:w-auto pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-200/60">
                        <!-- Up/Down Order Arrows -->
                        <div class="flex items-center gap-1 bg-white border border-slate-200 rounded-xl p-0.5 shadow-sm">
                            <button type="button" onclick="moveSection({{ $sec->id }}, -1)" class="p-1.5 text-slate-500 hover:text-teal-600 hover:bg-slate-50 rounded-lg transition" title="Mover arriba">
                                <i class="fa-solid fa-chevron-up text-xs"></i>
                            </button>
                            <button type="button" onclick="moveSection({{ $sec->id }}, 1)" class="p-1.5 text-slate-500 hover:text-teal-600 hover:bg-slate-50 rounded-lg transition" title="Mover abajo">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </button>
                        </div>

                        <!-- Active Toggle Switch -->
                        <button type="button" onclick="toggleSectionStatus({{ $sec->id }})" id="toggle-btn-{{ $sec->id }}"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold transition shadow-sm {{ $sec->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-400 border border-slate-200' }}">
                            <span class="w-2 h-2 rounded-full {{ $sec->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}" id="toggle-dot-{{ $sec->id }}"></span>
                            <span id="toggle-text-{{ $sec->id }}">{{ $sec->is_active ? 'Visible' : 'Pausado' }}</span>
                        </button>

                        <!-- Edit Settings Button -->
                        <button type="button" onclick="openEditModal({{ json_encode($sec) }})" class="p-2 bg-white hover:bg-slate-100 text-slate-600 hover:text-teal-600 border border-slate-200 rounded-xl transition shadow-sm" title="Configurar Sección">
                            <i class="fa-solid fa-gear text-xs"></i>
                        </button>

                        @if(in_array($sec->section_key, ['custom_content', 'cta_banner']))
                            <button type="button" onclick="deleteSection({{ $sec->id }})" class="p-2 bg-white hover:bg-rose-50 text-slate-400 hover:text-rose-600 border border-slate-200 rounded-xl transition shadow-sm" title="Eliminar Bloque">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal: Configuración de Sección -->
<div id="editSectionModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border border-slate-200 overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2" id="modalSectionTitle">
                <i class="fa-solid fa-gear text-teal-600"></i> Configuración del Bloque
            </h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 p-1">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <div id="sectionEditForm" class="p-6 space-y-4">
            <input type="hidden" id="modal_section_id">

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nombre Interno en Panel</label>
                <input type="text" id="modal_name" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Título Público (En Sitio Web)</label>
                    <input type="text" id="modal_title" placeholder="Ej: Programas Destacados" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Subtítulo / Badge Superior</label>
                    <input type="text" id="modal_subtitle" placeholder="Ej: Cursos Populares" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                </div>
            </div>

            <!-- Parámetro opcional: Límite de items -->
            <div id="modal_limit_container" class="hidden">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Cantidad de elementos a mostrar</label>
                <input type="number" id="modal_limit" min="1" max="30" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
            </div>

            <!-- Parámetros opcionales: Botón CTA -->
            <div id="modal_cta_container" class="hidden space-y-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Texto del Botón CTA</label>
                    <input type="text" id="modal_button_text" placeholder="Ej: Matricularme Hoy" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Enlace del Botón (URL)</label>
                    <input type="text" id="modal_button_url" placeholder="Ej: /contacto" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                </div>
            </div>

            <!-- Parámetro opcional: Custom HTML -->
            <div id="modal_html_container" class="hidden">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Código HTML o Contenido Libre</label>
                <textarea id="modal_custom_html" rows="5" placeholder="<p>Texto o código personalizado...</p>" class="w-full px-3.5 py-2 bg-slate-900 text-teal-300 font-mono text-xs rounded-xl border border-slate-700"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">Cancelar</button>
                <button type="button" id="sectionEditSubmitBtn" onclick="submitSectionUpdate()" class="px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Añadir Nueva Sección -->
<div id="addSectionModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-200 overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                <i class="fa-solid fa-plus text-teal-600"></i> Añadir Nuevo Bloque a la Portada
            </h3>
            <button onclick="closeAddSectionModal()" class="text-slate-400 hover:text-slate-600 p-1">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <form id="addSectionForm" onsubmit="submitAddSection(event)" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tipo de Bloque</label>
                <select id="add_section_key" name="section_key" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                    <option value="cta_banner">📢 Banner de Llamada a la Acción / Matrícula</option>
                    <option value="custom_content">🧩 Bloque de Texto / Código HTML Libre</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nombre Interno</label>
                <input type="text" id="add_name" name="name" required placeholder="Ej: Aviso Especial Matrícula 2026" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Título Público (Opcional)</label>
                <input type="text" id="add_title" name="title" placeholder="Ej: ¡Últimos cupos disponibles!" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Subtítulo (Opcional)</label>
                <input type="text" id="add_subtitle" name="subtitle" placeholder="Ej: Promoción Especial" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeAddSectionModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">Cancelar</button>
                <button type="submit" id="addSectionSubmitBtn" class="px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                    <i class="fa-solid fa-plus"></i> Añadir Sección
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Toast Feedback -->
<div id="toastNotification" class="fixed bottom-6 right-6 z-50 hidden bg-slate-900 text-white text-xs font-semibold px-4 py-3 rounded-xl shadow-2xl border border-slate-700 flex items-center gap-2 transition-opacity">
    <i class="fa-solid fa-circle-check text-teal-400 text-sm"></i>
    <span id="toastMessage">¡Estructura guardada!</span>
</div>
@endsection

@push('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // 1. Reordenar Secciones con Drag and Drop nativo
    const list = document.getElementById('sortableSectionsList');
    let draggedItem = null;

    if (list) {
        list.addEventListener('dragstart', (e) => {
            const row = e.target.closest('.section-card');
            if (!row) return;
            draggedItem = row;
            e.dataTransfer.effectAllowed = 'move';
            row.classList.add('opacity-40', 'border-teal-500');
        });

        list.addEventListener('dragover', (e) => {
            e.preventDefault();
            const targetRow = e.target.closest('.section-card');
            if (targetRow && targetRow !== draggedItem) {
                const rect = targetRow.getBoundingClientRect();
                const next = (e.clientY - rect.top) / (rect.bottom - rect.top) > 0.5;
                list.insertBefore(draggedItem, next ? targetRow.nextSibling : targetRow);
            }
        });

        list.addEventListener('dragend', () => {
            if (draggedItem) {
                draggedItem.classList.remove('opacity-40', 'border-teal-500');
                draggedItem = null;
                saveSectionsOrder();
            }
        });
    }

    // 2. Mover arriba / abajo con botones
    function moveSection(id, direction) {
        const row = document.getElementById(`section-row-${id}`);
        if (!row) return;

        if (direction === -1 && row.previousElementSibling) {
            row.parentNode.insertBefore(row, row.previousElementSibling);
            saveSectionsOrder();
        } else if (direction === 1 && row.nextElementSibling) {
            row.parentNode.insertBefore(row.nextElementSibling, row);
            saveSectionsOrder();
        }
    }

    function saveSectionsOrder() {
        const rows = document.querySelectorAll('.section-card');
        const orderIds = Array.from(rows).map(r => r.dataset.id);

        // Actualizar números de orden visuales
        rows.forEach((r, idx) => {
            const badge = r.querySelector('.order-badge');
            if (badge) badge.innerText = idx + 1;
        });

        fetch('{{ route('admin.home_sections.order') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ order: orderIds })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('¡Orden de la portada actualizado en tiempo real!');
            }
        });
    }

    // 3. Activar / Pausar Sección con 1 Clic
    function toggleSectionStatus(id) {
        fetch(`{{ url('admin/home-sections') }}/${id}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const btn = document.getElementById(`toggle-btn-${id}`);
                const dot = document.getElementById(`toggle-dot-${id}`);
                const txt = document.getElementById(`toggle-text-${id}`);

                if (data.is_active) {
                    btn.className = 'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold transition shadow-sm bg-emerald-50 text-emerald-700 border border-emerald-200';
                    dot.className = 'w-2 h-2 rounded-full bg-emerald-500';
                    txt.innerText = 'Visible';
                } else {
                    btn.className = 'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold transition shadow-sm bg-slate-100 text-slate-400 border border-slate-200';
                    dot.className = 'w-2 h-2 rounded-full bg-slate-400';
                    txt.innerText = 'Pausado';
                }
                showToast(data.message);
            }
        });
    }

    // 4. Modal de Configuración
    const editModal = document.getElementById('editSectionModal');

    function openEditModal(sec) {
        document.getElementById('modal_section_id').value = sec.id;
        document.getElementById('modal_name').value = sec.name;
        document.getElementById('modal_title').value = sec.title || '';
        document.getElementById('modal_subtitle').value = sec.subtitle || '';

        const settings = sec.settings || {};

        const limitCont = document.getElementById('modal_limit_container');
        if (['featured_posts', 'testimonials', 'graduaciones'].includes(sec.section_key)) {
            limitCont.classList.remove('hidden');
            document.getElementById('modal_limit').value = settings.limit || 6;
        } else {
            limitCont.classList.add('hidden');
        }

        const ctaCont = document.getElementById('modal_cta_container');
        if (sec.section_key === 'cta_banner') {
            ctaCont.classList.remove('hidden');
            document.getElementById('modal_button_text').value = settings.button_text || '';
            document.getElementById('modal_button_url').value = settings.button_url || '';
        } else {
            ctaCont.classList.add('hidden');
        }

        const htmlCont = document.getElementById('modal_html_container');
        if (sec.section_key === 'custom_content') {
            htmlCont.classList.remove('hidden');
            document.getElementById('modal_custom_html').value = settings.custom_html || '';
        } else {
            htmlCont.classList.add('hidden');
        }

        editModal.classList.remove('hidden');
    }

    function closeEditModal() {
        editModal.classList.add('hidden');
    }

    function submitSectionUpdate() {
        const id = document.getElementById('modal_section_id').value;
        const name = document.getElementById('modal_name').value;
        const title = document.getElementById('modal_title').value;
        const subtitle = document.getElementById('modal_subtitle').value;
        const limit = document.getElementById('modal_limit').value;
        const button_text = document.getElementById('modal_button_text').value;
        const button_url = document.getElementById('modal_button_url').value;
        const custom_html = document.getElementById('modal_custom_html').value;

        const btn = document.getElementById('sectionEditSubmitBtn');
        const originalHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Guardando...';

        fetch(`{{ url('admin/home-sections') }}/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                name: name,
                title: title,
                subtitle: subtitle,
                limit: limit,
                button_text: button_text,
                button_url: button_url,
                custom_html: custom_html
            })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
            if (data.success) {
                showToast('¡Configuración del bloque guardada con éxito!');
                closeEditModal();
                setTimeout(() => window.location.reload(), 400);
            } else {
                alert('No se pudo guardar la configuración.');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
            console.error(err);
            alert('Ocurrió un error al guardar.');
        });
    }

    // 5. Eliminar sección personalizada
    function deleteSection(id) {
        if (!confirm('¿Eliminar este bloque de la portada?')) return;
        fetch(`{{ url('admin/home-sections') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`section-row-${id}`).remove();
                showToast('Bloque eliminado.');
                saveSectionsOrder();
            }
        });
    }

    // 6. Modal Añadir Sección
    const addModal = document.getElementById('addSectionModal');
    function openAddSectionModal() { addModal.classList.remove('hidden'); }
    function closeAddSectionModal() { addModal.classList.add('hidden'); }

    function submitAddSection(e) {
        e.preventDefault();
        const key = document.getElementById('add_section_key').value;
        const name = document.getElementById('add_name').value;
        const title = document.getElementById('add_title').value;
        const subtitle = document.getElementById('add_subtitle').value;
        const btn = document.getElementById('addSectionSubmitBtn');
        btn.disabled = true;

        fetch('{{ route('admin.home_sections.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                section_key: key,
                name: name,
                title: title,
                subtitle: subtitle
            })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            if (data.success) {
                showToast(data.message || 'Sección añadida con éxito');
                closeAddSectionModal();
                setTimeout(() => window.location.reload(), 400);
            }
        })
        .catch(err => {
            btn.disabled = false;
            console.error(err);
        });
    }

    function showToast(msg) {
        const toast = document.getElementById('toastNotification');
        document.getElementById('toastMessage').innerText = msg;
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 3000);
    }
</script>
@endpush
