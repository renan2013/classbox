@extends('layouts.admin')

@section('title', 'Biblioteca de Medios')
@section('page-title', 'Biblioteca de Medios & Gestor de Archivos')

@section('content')
<div class="space-y-6 pb-12">
    <!-- Header Metrics & Actions -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-folder-open"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Total de Archivos</p>
                <h3 class="text-lg font-bold text-slate-800">{{ number_format($totalFiles) }}</h3>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-hard-drive"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Espacio Utilizado</p>
                <h3 class="text-lg font-bold text-slate-800">
                    @php
                        if ($totalBytes >= 1073741824) $spaceFormatted = number_format($totalBytes / 1073741824, 2) . ' GB';
                        elseif ($totalBytes >= 1048576) $spaceFormatted = number_format($totalBytes / 1048576, 2) . ' MB';
                        elseif ($totalBytes >= 1024) $spaceFormatted = number_format($totalBytes / 1024, 1) . ' KB';
                        else $spaceFormatted = $totalBytes . ' B';
                    @endphp
                    {{ $spaceFormatted }}
                </h3>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-image"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Imágenes WebP / Fotos</p>
                <h3 class="text-lg font-bold text-slate-800">{{ number_format($imageCount) }}</h3>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-file-pdf"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Documentos & Otros</p>
                <h3 class="text-lg font-bold text-slate-800">{{ number_format($docCount + $otherCount) }}</h3>
            </div>
        </div>
    </div>

    <!-- Drag & Drop Upload Container -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div id="dropZone" class="border-2 border-dashed border-slate-200 hover:border-teal-500 rounded-2xl p-8 text-center bg-slate-50/50 hover:bg-teal-50/20 transition cursor-pointer relative">
            <input type="file" id="mediaFileInput" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
            <div class="flex flex-col items-center justify-center pointer-events-none">
                <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-2xl mb-3 shadow-inner">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                </div>
                <h4 class="text-sm font-bold text-slate-800 mb-1">Arrastra y suelta cualquier tipo de archivo aquí</h4>
                <p class="text-xs text-slate-500 mb-3">Imágenes (se optimizan automáticamente a WebP), Documentos PDF, Word, Excel, Videos MP4, Audios, Archivos ZIP</p>
                <span class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold shadow-md shadow-teal-600/20">
                    O haz clic para examinar archivos
                </span>
            </div>
        </div>

        <!-- Live Upload Progress List -->
        <div id="uploadProgressContainer" class="hidden mt-4 space-y-2 border-t border-slate-100 pt-4">
            <div class="flex items-center justify-between text-xs font-semibold text-slate-700 mb-1">
                <span>Subiendo archivos...</span>
                <span id="uploadPercentage">0%</span>
            </div>
            <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                <div id="uploadProgressBar" class="h-full bg-teal-600 transition-all duration-200" style="width: 0%"></div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs & Search -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Type Tabs -->
        <div class="flex items-center gap-1.5 overflow-x-auto w-full md:w-auto pb-1 md:pb-0">
            @php $currentType = request('type', 'all'); @endphp
            <a href="{{ route('admin.media.index', array_merge(request()->query(), ['type' => 'all'])) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition whitespace-nowrap {{ $currentType === 'all' ? 'bg-teal-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Todos ({{ $totalFiles }})
            </a>
            <a href="{{ route('admin.media.index', array_merge(request()->query(), ['type' => 'image'])) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition whitespace-nowrap {{ $currentType === 'image' ? 'bg-teal-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                <i class="fa-regular fa-image mr-1"></i> Imágenes
            </a>
            <a href="{{ route('admin.media.index', array_merge(request()->query(), ['type' => 'document'])) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition whitespace-nowrap {{ $currentType === 'document' ? 'bg-teal-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                <i class="fa-regular fa-file-lines mr-1"></i> Documentos / PDFs
            </a>
            <a href="{{ route('admin.media.index', array_merge(request()->query(), ['type' => 'video'])) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition whitespace-nowrap {{ $currentType === 'video' ? 'bg-teal-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                <i class="fa-solid fa-film mr-1"></i> Videos
            </a>
            <a href="{{ route('admin.media.index', array_merge(request()->query(), ['type' => 'archive'])) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition whitespace-nowrap {{ $currentType === 'archive' ? 'bg-teal-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                <i class="fa-solid fa-file-zipper mr-1"></i> ZIPs
            </a>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.media.index') }}" class="flex items-center gap-2 w-full md:w-auto">
            @if(request('type'))
                <input type="hidden" name="type" value="{{ request('type') }}">
            @endif
            <div class="relative flex-1 md:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre..."
                       class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
            </div>
            <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-semibold transition">Buscar</button>
            @if(request()->hasAny(['search', 'type']))
                <a href="{{ route('admin.media.index') }}" class="text-xs text-slate-500 hover:text-slate-800 underline">Limpiar</a>
            @endif
        </form>
    </div>

    <!-- Media Grid -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        @if($files->isEmpty())
            <div class="py-16 text-center text-slate-400">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-300 mx-auto flex items-center justify-center text-2xl mb-3">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <h4 class="text-sm font-bold text-slate-700 mb-1">No hay archivos en la biblioteca</h4>
                <p class="text-xs text-slate-400">Sube tus primeras fotos, PDFs o documentos arrastrándolos al recuadro superior.</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4" id="mediaGrid">
                @foreach($files as $item)
                    <div class="group relative bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden hover:shadow-md transition flex flex-col justify-between" id="media-card-{{ $item->id }}">
                        <!-- Thumbnail Area -->
                        <div class="w-full aspect-square bg-slate-100 flex items-center justify-center overflow-hidden relative">
                            @if($item->file_type === 'image')
                                <img src="{{ $item->url }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" loading="lazy">
                            @elseif($item->file_type === 'document')
                                <div class="flex flex-col items-center justify-center p-2 text-rose-500">
                                    <i class="fa-solid fa-file-pdf text-3xl mb-1"></i>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-rose-700">PDF / DOC</span>
                                </div>
                            @elseif($item->file_type === 'video')
                                <div class="flex flex-col items-center justify-center p-2 text-purple-500">
                                    <i class="fa-solid fa-film text-3xl mb-1"></i>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-purple-700">VIDEO</span>
                                </div>
                            @elseif($item->file_type === 'audio')
                                <div class="flex flex-col items-center justify-center p-2 text-amber-500">
                                    <i class="fa-solid fa-music text-3xl mb-1"></i>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-700">AUDIO</span>
                                </div>
                            @elseif($item->file_type === 'archive')
                                <div class="flex flex-col items-center justify-center p-2 text-blue-500">
                                    <i class="fa-solid fa-file-zipper text-3xl mb-1"></i>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-blue-700">ZIP</span>
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center p-2 text-slate-400">
                                    <i class="fa-solid fa-file text-3xl mb-1"></i>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">ARCHIVO</span>
                                </div>
                            @endif

                            <!-- Quick Action Buttons Overlay -->
                            <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2 p-2">
                                <button type="button" onclick="copyUrlToClipboard('{{ $item->url }}')"
                                        class="p-2 rounded-lg bg-white/90 hover:bg-white text-teal-700 shadow-sm transition" title="Copiar Enlace Directo">
                                    <i class="fa-solid fa-link text-xs"></i>
                                </button>
                                <button type="button" onclick="openMediaDetails({{ json_encode($item) }})"
                                        class="p-2 rounded-lg bg-white/90 hover:bg-white text-indigo-700 shadow-sm transition" title="Ver Detalles">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </button>
                                <button type="button" onclick="deleteMediaFile({{ $item->id }})"
                                        class="p-2 rounded-lg bg-white/90 hover:bg-white text-rose-600 shadow-sm transition" title="Eliminar">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="p-2.5 bg-white border-t border-slate-100 flex flex-col justify-between">
                            <p class="text-[11px] font-semibold text-slate-800 truncate" title="{{ $item->name }}">{{ $item->name }}</p>
                            <div class="flex items-center justify-between text-[10px] text-slate-400 mt-1">
                                <span>{{ $item->formatted_size }}</span>
                                <span class="capitalize">{{ $item->file_type }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($files->hasPages())
                <div class="mt-6 pt-4 border-t border-slate-100">
                    {{ $files->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Modal: Detalles del Archivo -->
<div id="mediaDetailsModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-slate-200">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-teal-600"></i> Detalles del Archivo
            </h3>
            <button onclick="closeMediaDetails()" class="text-slate-400 hover:text-slate-600 p-1">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <div class="p-6 space-y-5">
            <!-- Preview Box -->
            <div class="w-full h-56 bg-slate-100 rounded-xl overflow-hidden flex items-center justify-center border border-slate-200" id="modalPreviewBox">
                <!-- Injected via JS -->
            </div>

            <!-- Copy URL Bar -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">URL Pública Directa (CDN)</label>
                <div class="flex items-center gap-2">
                    <input type="text" id="modalFileUrl" readonly
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 select-all font-mono">
                    <button type="button" onclick="copyModalUrl()" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold shrink-0 transition flex items-center gap-1.5">
                        <i class="fa-solid fa-copy"></i>
                        <span>Copiar</span>
                    </button>
                </div>
            </div>

            <!-- Edit Info Form -->
            <form id="modalUpdateForm" onsubmit="submitMediaUpdate(event)" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="hidden" id="modalFileId">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nombre del Archivo</label>
                    <input type="text" id="modalFileName" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Texto Alternativo (Alt Text / Accesibilidad)</label>
                    <input type="text" id="modalFileAlt" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-teal-500">
                </div>

                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-[11px] text-slate-600 space-y-1">
                    <p><strong class="text-slate-800">Tamaño:</strong> <span id="modalFileSize">-</span></p>
                    <p><strong class="text-slate-800">MIME:</strong> <span id="modalFileMime">-</span></p>
                </div>

                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-[11px] text-slate-600 space-y-1">
                    <p><strong class="text-slate-800">Fecha de Subida:</strong> <span id="modalFileDate">-</span></p>
                    <p><strong class="text-slate-800">Nombre Guardado:</strong> <span id="modalStoredName" class="truncate block font-mono text-[10px]">-</span></p>
                </div>

                <div class="md:col-span-2 flex items-center justify-between pt-3 border-t border-slate-100">
                    <button type="button" onclick="deleteFromModal()" class="text-xs text-rose-600 hover:text-rose-700 font-semibold flex items-center gap-1.5">
                        <i class="fa-solid fa-trash"></i> Eliminar Archivo
                    </button>
                    <button type="submit" class="px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold transition">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Toast Feedback -->
<div id="toastNotification" class="fixed bottom-6 right-6 z-50 hidden bg-slate-900 text-white text-xs font-semibold px-4 py-3 rounded-xl shadow-2xl border border-slate-700 flex items-center gap-2 transition-opacity">
    <i class="fa-solid fa-circle-check text-teal-400 text-sm"></i>
    <span id="toastMessage">¡Enlace copiado al portapapeles!</span>
</div>
@endsection

@push('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // 1. Manejo de Drag & Drop y Subida Asíncrona
    const fileInput = document.getElementById('mediaFileInput');
    const dropZone = document.getElementById('dropZone');
    const progressBox = document.getElementById('uploadProgressContainer');
    const progressBar = document.getElementById('uploadProgressBar');
    const progressText = document.getElementById('uploadPercentage');

    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                uploadFiles(e.target.files);
            }
        });

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-teal-500', 'bg-teal-50/40');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-teal-500', 'bg-teal-50/40');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-teal-500', 'bg-teal-50/40');
            if (e.dataTransfer.files.length > 0) {
                uploadFiles(e.dataTransfer.files);
            }
        });
    }

    function uploadFiles(files) {
        const formData = new FormData();
        Array.from(files).forEach(file => {
            formData.append('files[]', file);
        });

        progressBox.classList.remove('hidden');
        progressBar.style.width = '0%';
        progressText.innerText = '0%';

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route('admin.media.store') }}');
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        xhr.setRequestHeader('Accept', 'application/json');

        xhr.upload.onprogress = (e) => {
            if (e.lengthComputable) {
                const percent = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = percent + '%';
                progressText.innerText = percent + '%';
            }
        };

        xhr.onload = () => {
            if (xhr.status >= 200 && xhr.status < 300) {
                showToast('¡Archivos subidos exitosamente!');
                setTimeout(() => {
                    window.location.reload();
                }, 800);
            } else {
                alert('Error al subir archivos. Verifica que no superen el límite permitido.');
                progressBox.classList.add('hidden');
            }
        };

        xhr.onerror = () => {
            alert('Error de conexión.');
            progressBox.classList.add('hidden');
        };

        xhr.send(formData);
    }

    // 2. Copiar enlace al portapapeles
    function copyUrlToClipboard(url) {
        navigator.clipboard.writeText(url).then(() => {
            showToast('¡Enlace directo copiado al portapapeles!');
        });
    }

    function showToast(msg) {
        const toast = document.getElementById('toastNotification');
        document.getElementById('toastMessage').innerText = msg;
        toast.classList.remove('hidden');
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000);
    }

    // 3. Modal de Detalles
    const modal = document.getElementById('mediaDetailsModal');
    let currentMediaId = null;

    function openMediaDetails(item) {
        currentMediaId = item.id;
        document.getElementById('modalFileId').value = item.id;
        document.getElementById('modalFileName').value = item.name;
        document.getElementById('modalFileAlt').value = item.alt_text || '';
        document.getElementById('modalFileUrl').value = item.url;
        document.getElementById('modalFileSize').innerText = item.formatted_size;
        document.getElementById('modalFileMime').innerText = item.mime_type || '-';
        document.getElementById('modalFileDate').innerText = new Date(item.created_at).toLocaleDateString();
        document.getElementById('modalStoredName').innerText = item.file_name;

        const previewBox = document.getElementById('modalPreviewBox');
        if (item.file_type === 'image') {
            previewBox.innerHTML = `<img src="${item.url}" class="max-h-full max-w-full object-contain">`;
        } else if (item.file_type === 'video') {
            previewBox.innerHTML = `<video src="${item.url}" controls class="max-h-full max-w-full rounded-lg"></video>`;
        } else if (item.file_type === 'audio') {
            previewBox.innerHTML = `<audio src="${item.url}" controls class="w-4/5"></audio>`;
        } else {
            previewBox.innerHTML = `<div class="text-center p-4">
                <i class="${item.icon} text-5xl mb-2 block"></i>
                <a href="${item.url}" target="_blank" class="text-xs text-teal-600 hover:underline font-semibold">Descargar / Ver Archivo</a>
            </div>`;
        }

        modal.classList.remove('hidden');
    }

    function closeMediaDetails() {
        modal.classList.add('hidden');
        currentMediaId = null;
    }

    function copyModalUrl() {
        const urlInput = document.getElementById('modalFileUrl');
        copyUrlToClipboard(urlInput.value);
    }

    function submitMediaUpdate(e) {
        e.preventDefault();
        const id = document.getElementById('modalFileId').value;
        const name = document.getElementById('modalFileName').value;
        const alt = document.getElementById('modalFileAlt').value;

        fetch(`{{ url('admin/media') }}/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name: name, alt_text: alt })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('Información actualizada.');
                closeMediaDetails();
                setTimeout(() => window.location.reload(), 600);
            }
        })
        .catch(err => alert('Error al actualizar archivo.'));
    }

    function deleteMediaFile(id) {
        if (!confirm('¿Estás seguro de eliminar este archivo permanentemente?')) return;

        fetch(`{{ url('admin/media') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const card = document.getElementById(`media-card-${id}`);
                if (card) card.remove();
                showToast('Archivo eliminado.');
            }
        })
        .catch(err => alert('Error al eliminar archivo.'));
    }

    function deleteFromModal() {
        if (currentMediaId) {
            deleteMediaFile(currentMediaId);
            closeMediaDetails();
        }
    }
</script>
@endpush
