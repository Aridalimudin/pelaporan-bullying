<!-- File Upload Component -->
<div class="form-group">
    <label class="form-label">
        <span class="text-gray-800 font-semibold text-sm">Bukti Pendukung</span>
        <span class="text-gray-500 text-xs font-normal ml-1">(Opsional)</span>
    </label>

    <div class="file-upload-area" id="fileUploadArea">
        <input 
            type="file" 
            id="bukti" 
            name="bukti[]" 
            class="hidden" 
            multiple 
            accept="image/*,.pdf"
            onchange="handleFileSelect(event)"
        >
        <label for="bukti" class="file-upload-label">
            <div class="flex flex-col items-center">
                <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                <span class="text-sm font-semibold text-gray-700 mb-1">Klik atau seret bukti pendukung</span>
                <span class="text-xs text-gray-500">PNG, JPG, PDF (Max. 5MB per file)</span>
            </div>
        </label>
    </div>

    <div id="fileList" class="mt-3 space-y-2"></div>
</div>

<script>
let selectedFiles = [];

function handleFileSelect(event) {
    const files = Array.from(event.target.files);
    const fileList = document.getElementById('fileList');
    const maxSize = 5 * 1024 * 1024; 

    const validFiles = [];
    files.forEach(file => {
        if (file.size > maxSize) {
            alert(`File ${file.name} terlalu besar. Maksimal 5MB per file.`);
            return;
        }
        
        const fileType = file.type;
        if (!fileType.match('image.*') && fileType !== 'application/pdf') {
            alert(`File ${file.name} tidak didukung. Hanya PNG, JPG, dan PDF yang diperbolehkan.`);
            return;
        }
        
        validFiles.push(file);
    });

    selectedFiles = [...selectedFiles, ...validFiles];

    updateFileList();

    event.target.value = '';
}

function updateFileList() {
    const fileList = document.getElementById('fileList');
    fileList.innerHTML = '';
    
    if (selectedFiles.length === 0) return;
    
    selectedFiles.forEach((file, index) => {
        const fileItem = document.createElement('div');
        fileItem.className = 'file-item';
        
        const fileIcon = getFileIcon(file.type);
        const fileSize = formatFileSize(file.size);
        
        fileItem.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    ${fileIcon}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">${file.name}</p>
                        <p class="text-xs text-gray-500">${fileSize}</p>
                    </div>
                </div>
                <button 
                    type="button" 
                    onclick="removeFile(${index})" 
                    class="ml-3 text-red-500 hover:text-red-700 transition-colors flex-shrink-0"
                    title="Hapus file"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        `;
        fileList.appendChild(fileItem);
    });
}

function getFileIcon(fileType) {
    if (fileType === 'application/pdf') {
        return `
            <svg class="w-8 h-8 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 18h12V6h-4V2H4v16zm-2 1V0h12l4 4v16H2v-1z"/>
                <path d="M7 11h2v1H7v-1zm0-2h6v1H7V9zm0 4h4v1H7v-1z"/>
            </svg>
        `;
    } else {
        return `
            <svg class="w-8 h-8 text-primary-green flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        `;
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round((bytes / Math.pow(k, i)) * 100) / 100 + ' ' + sizes[i];
}

function removeFile(index) {
    selectedFiles.splice(index, 1);
    updateFileList();
}

window.resetFileUpload = function() {
    selectedFiles = [];
    updateFileList();
    document.getElementById('bukti').value = '';
}

const uploadArea = document.getElementById('fileUploadArea');

uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.classList.add('border-primary-green', 'bg-emerald-50');
});

uploadArea.addEventListener('dragleave', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('border-primary-green', 'bg-emerald-50');
});

uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('border-primary-green', 'bg-emerald-50');
    
    const files = e.dataTransfer.files;
    const input = document.getElementById('bukti');
    input.files = files;
    handleFileSelect({ target: input });
});
</script>