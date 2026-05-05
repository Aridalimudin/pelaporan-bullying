<div class="form-group">
    <label class="form-label">
        <span class="text-gray-800 font-semibold text-sm">Bukti Pendukung</span>
        <span class="text-gray-500 text-xs font-normal ml-1">(Opsional, maks. 5 file)</span>
    </label>

    <div class="file-upload-area" id="fileUploadArea">
        <input
            type="file"
            id="bukti"
            name="bukti[]"
            class="hidden"
            multiple
            accept="image/jpeg,image/jpg,image/png,image/webp,video/mp4,video/quicktime,video/x-msvideo,video/webm"
            onchange="handleFileSelect(event)"
        >
        <label for="bukti" class="file-upload-label">
            <div class="flex flex-col items-center">
                <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                <span class="text-sm font-semibold text-gray-700 mb-1">Klik atau seret bukti pendukung</span>
                <span class="text-xs text-gray-500">Foto (JPG, PNG, WEBP) maks. 5MB · Video (MP4, MOV) maks. 50MB</span>
            </div>
        </label>
    </div>

    <div id="fileList" class="mt-3"></div>
</div>

{{-- Lightbox overlay --}}
<div id="imgLightbox" class="lightbox-overlay hidden" onclick="if(event.target===this)closeLightbox()">
    <div class="lightbox-box">
        <button class="lightbox-close" onclick="closeLightbox()">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img id="lightboxImg" src="" alt="" class="lightbox-img">
        <p id="lightboxName" class="lightbox-name"></p>
    </div>
</div>

<style>
/* ── Preview image grid ── */
.preview-image-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 10px;
    margin-bottom: 10px;
}

.preview-img-wrap {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    aspect-ratio: 1;
    background: #f3f4f6;
    border: 1.5px solid #e5e7eb;
    animation: slideInUp 0.25s ease;
    transition: border-color 0.2s;
}

.preview-img-wrap:hover {
    border-color: #10b981;
}

.preview-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    cursor: zoom-in;
    transition: transform 0.2s ease;
    display: block;
}

.preview-img-wrap:hover .preview-img {
    transform: scale(1.04);
}

.preview-img-size {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.55));
    color: white;
    font-size: 9px;
    font-weight: 600;
    padding: 10px 5px 4px;
    text-align: center;
    pointer-events: none;
}

.preview-img-remove {
    position: absolute;
    top: 4px;
    right: 4px;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: rgba(239,68,68,0.85);
    color: white;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.15s ease;
}

.preview-img-remove svg { width: 12px; height: 12px; }

.preview-img-wrap:hover .preview-img-remove {
    opacity: 1;
}

/* ── Lightbox ── */
.lightbox-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.85);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99999;
    padding: 20px;
    animation: fadeIn 0.2s ease;
}

.lightbox-overlay.hidden { display: none; }

@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

.lightbox-box {
    position: relative;
    max-width: 90vw;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}

.lightbox-img {
    max-width: 100%;
    max-height: 80vh;
    border-radius: 12px;
    object-fit: contain;
    box-shadow: 0 25px 60px rgba(0,0,0,0.5);
    animation: scaleIn 0.2s ease;
}

@keyframes scaleIn { from { transform: scale(0.92); opacity: 0; } to { transform: scale(1); opacity: 1; } }

.lightbox-name {
    color: rgba(255,255,255,0.8);
    font-size: 13px;
    text-align: center;
    max-width: 400px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.lightbox-close {
    position: absolute;
    top: -14px;
    right: -14px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: white;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    transition: background 0.15s;
    z-index: 1;
}

.lightbox-close svg { width: 18px; height: 18px; color: #374151; }
.lightbox-close:hover { background: #fee2e2; }
.lightbox-close:hover svg { color: #ef4444; }

/* ── File type badges ── */
.file-type-badge {
    font-size: 10px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    flex-shrink: 0;
}
.file-type-badge.image { background: #d1fae5; color: #065f46; }
.file-type-badge.video { background: #dbeafe; color: #1e40af; }
</style>

<script>
let selectedFiles = [];

const ALLOWED_IMAGE_TYPES = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
const ALLOWED_VIDEO_TYPES = ['video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/webm'];
const MAX_IMAGE_SIZE = 5  * 1024 * 1024;  // 5 MB
const MAX_VIDEO_SIZE = 50 * 1024 * 1024;  // 50 MB
const MAX_FILES      = 5;

function handleFileSelect(event) {
    const files = Array.from(event.target.files);

    files.forEach(file => {
        if (selectedFiles.length >= MAX_FILES) {
            alert(`Maksimal ${MAX_FILES} file bukti.`);
            return;
        }

        const type    = file.type;
        const isImage = ALLOWED_IMAGE_TYPES.includes(type);
        const isVideo = ALLOWED_VIDEO_TYPES.includes(type);

        if (!isImage && !isVideo) {
            alert(`File "${file.name}" tidak didukung.\nHanya foto (JPG, PNG, WEBP) dan video (MP4, MOV, AVI, WEBM).`);
            return;
        }

        const maxSize = isImage ? MAX_IMAGE_SIZE : MAX_VIDEO_SIZE;
        const label   = isImage ? '5MB' : '50MB';
        if (file.size > maxSize) {
            alert(`File "${file.name}" terlalu besar. Batas: ${label}.`);
            return;
        }

        const isDuplicate = selectedFiles.some(f => f.name === file.name && f.size === file.size);
        if (isDuplicate) return;

        selectedFiles.push(file);
    });

    updateFileList();
    event.target.value = '';
}

function updateFileList() {
    const fileList = document.getElementById('fileList');
    fileList.innerHTML = '';
    if (selectedFiles.length === 0) return;

    const images = selectedFiles.filter(f => ALLOWED_IMAGE_TYPES.includes(f.type));
    const videos = selectedFiles.filter(f => ALLOWED_VIDEO_TYPES.includes(f.type));

    /* ── Grid preview foto ── */
    if (images.length > 0) {
        const grid = document.createElement('div');
        grid.className = 'preview-image-grid';

        images.forEach(file => {
            const realIndex = selectedFiles.indexOf(file);
            const wrap      = document.createElement('div');
            wrap.className  = 'preview-img-wrap';

            const img   = document.createElement('img');
            img.className = 'preview-img';
            img.alt     = file.name;
            img.title   = 'Klik untuk perbesar';
            img.addEventListener('click', () => openLightbox(file));

            // Baca dan tampilkan sebagai preview
            const reader = new FileReader();
            reader.onload = e => { img.src = e.target.result; };
            reader.readAsDataURL(file);

            const sizeBadge       = document.createElement('span');
            sizeBadge.className   = 'preview-img-size';
            sizeBadge.textContent = formatFileSize(file.size);

            const removeBtn     = document.createElement('button');
            removeBtn.type      = 'button';
            removeBtn.className = 'preview-img-remove';
            removeBtn.title     = 'Hapus foto';
            removeBtn.innerHTML = `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>`;
            removeBtn.addEventListener('click', e => { e.stopPropagation(); removeFile(realIndex); });

            wrap.append(img, sizeBadge, removeBtn);
            grid.appendChild(wrap);
        });

        fileList.appendChild(grid);
    }

    /* ── List video ── */
    videos.forEach(file => {
        const realIndex = selectedFiles.indexOf(file);
        const item      = document.createElement('div');
        item.className  = 'file-item';
        item.style.marginBottom = '8px';
        // Buat object URL untuk preview video langsung
        const videoURL = URL.createObjectURL(file);
        item.innerHTML = `
            <div class="preview-img-wrap" style="aspect-ratio:16/9; width:100%; max-width:320px;">
                <video
                    src="${videoURL}"
                    class="preview-img"
                    controls
                    preload="metadata"
                    style="object-fit:contain; background:#000; cursor:default;"
                ></video>
                <span class="preview-img-size">${formatFileSize(file.size)}</span>
                <button type="button" class="preview-img-remove" style="opacity:1;"
                    onclick="removeFile(${realIndex})" title="Hapus video">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <p class="text-xs text-gray-500 mt-1 truncate" style="max-width:320px;">
                <span class="file-type-badge video" style="margin-right:6px;">Video</span>${file.name}
            </p>`;
        fileList.appendChild(item);
    });
}

/* ── Lightbox ── */
function openLightbox(file) {
    const lb   = document.getElementById('imgLightbox');
    const img  = document.getElementById('lightboxImg');
    const name = document.getElementById('lightboxName');

    const reader = new FileReader();
    reader.onload = e => {
        img.src          = e.target.result;
        name.textContent = file.name;
        lb.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };
    reader.readAsDataURL(file);
}

function closeLightbox() {
    document.getElementById('imgLightbox').classList.add('hidden');
    document.body.style.overflow = '';
}

// ESC untuk tutup lightbox
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeLightbox();
});

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k     = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i     = Math.floor(Math.log(bytes) / Math.log(k));
    return (bytes / Math.pow(k, i)).toFixed(1) + ' ' + sizes[i];
}

function removeFile(index) {
    selectedFiles.splice(index, 1);
    updateFileList();
}

window.resetFileUpload = function() {
    selectedFiles = [];
    updateFileList();
    document.getElementById('bukti').value = '';
};

/* ── Drag & drop ── */
const uploadArea = document.getElementById('fileUploadArea');
uploadArea.addEventListener('dragover',  e => { e.preventDefault(); uploadArea.classList.add('border-primary-green', 'bg-emerald-50'); });
uploadArea.addEventListener('dragleave', e => { e.preventDefault(); uploadArea.classList.remove('border-primary-green', 'bg-emerald-50'); });
uploadArea.addEventListener('drop', e => {
    e.preventDefault();
    uploadArea.classList.remove('border-primary-green', 'bg-emerald-50');
    handleFileSelect({ target: { files: e.dataTransfer.files, value: '' } });
});
</script>