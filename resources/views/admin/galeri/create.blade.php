@extends('layouts.admin')

@section('title', 'Tambah Galeri')

@section('main-content')
<div class="bg-white rounded-xl shadow-md p-6 mb-6 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 flex items-center mb-6">
        <i class="fas fa-plus text-blue-600 mr-3"></i>
        Tambah Galeri
    </h1>
    
    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mt-2 ml-4 list-disc">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    
    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" id="galeri-form">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Info Galeri -->
            <div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Judul Galeri</label>
                    <input type="text" name="judul" value="{{ old('judul') }}" class="form-input w-full" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" class="form-input w-full" placeholder="Deskripsi galeri...">{{ old('deskripsi') }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Kategori</label>
                    <select name="kategori" class="form-input w-full" required>
                        <option value="">Pilih Kategori</option>
                        <option value="fasilitas" {{ old('kategori') == 'fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                        <option value="aktivitas" {{ old('kategori') == 'aktivitas' ? 'selected' : '' }}>Kegiatan</option>
                        <option value="kompetisi" {{ old('kategori') == 'kompetisi' ? 'selected' : '' }}>Kompetisi</option>
                        <option value="sekolah" {{ old('kategori') == 'sekolah' ? 'selected' : '' }}>Sekolah</option>
                    </select>
                </div>
            </div>

            <!-- Upload Foto -->
            <div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Upload Foto</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                        <input type="file" name="foto[]" id="foto-input" class="hidden" multiple accept="image/*">
                        <div id="upload-area" class="cursor-pointer" onclick="document.getElementById('foto-input').click()">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-600 mb-2">Klik untuk upload foto atau drag & drop</p>
                            <p class="text-sm text-gray-500">Pilih satu atau lebih foto (JPG, PNG, GIF, WEBP)</p>
                            <p class="text-sm text-gray-500">Maksimal 8MB per foto, maksimal 500 foto</p>
                        </div>
                    </div>
                    <div id="file-count" class="text-sm text-blue-600 mt-2 hidden">
                        <i class="fas fa-images mr-1"></i>
                        <span id="count-text">0 foto dipilih</span>
                    </div>
                </div>

                <!-- Preview Area -->
                <div id="preview-area" class="hidden">
                    <label class="block text-gray-700 font-medium mb-2">
                        Preview & Pilih Thumbnail 
                        <span class="text-sm text-gray-500">(Klik pada foto untuk set sebagai thumbnail)</span>
                    </label>
                    <div id="photo-previews" class="grid grid-cols-2 gap-3 max-h-64 overflow-y-auto border rounded-lg p-3 bg-gray-50"></div>
                    <input type="hidden" name="thumbnail_index" id="thumbnail-index" value="0">
                    <div class="mt-2 flex justify-between items-center">
                        <button type="button" onclick="document.getElementById('foto-input').click()" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            <i class="fas fa-plus mr-1"></i>Tambah Foto Lagi
                        </button>
                        <button type="button" onclick="clearAllPhotos()" class="text-red-600 hover:text-red-700 text-sm font-medium">
                            <i class="fas fa-trash mr-1"></i>Hapus Semua
                        </button>
                    </div>
                    <div class="mt-2 text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-1"></i>
                        Foto yang dipilih sebagai thumbnail akan ditandai dengan <span class="bg-blue-600 text-white px-2 py-1 rounded text-xs"><i class="fas fa-star mr-1"></i>Thumbnail</span>
                    </div>
                </div>
            </div>
        </div>

    <!-- Progress Bar -->
    <div id="upload-progress" class="hidden mb-6">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-blue-800">Mengupload galeri...</span>
                <span id="progress-percentage" class="text-sm font-bold text-blue-800">0%</span>
            </div>
            <div class="w-full bg-blue-200 rounded-full h-3 mb-3">
                <div id="progress-bar" class="bg-blue-600 h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
            </div>
            <!-- Detailed Progress Info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
                <div class="text-center">
                    <div class="text-xs text-gray-600">Kecepatan Upload</div>
                    <div id="upload-speed" class="text-sm font-semibold text-blue-700">-</div>
                </div>
                <div class="text-center">
                    <div class="text-xs text-gray-600">Estimasi Waktu</div>
                    <div id="upload-eta" class="text-sm font-semibold text-blue-700">-</div>
                </div>
                <div class="text-center">
                    <div class="text-xs text-gray-600">Progress Data</div>
                    <div id="upload-size" class="text-sm font-semibold text-blue-700">0 MB / 0 MB</div>
                </div>
            </div>
            <!-- Current Photo Progress -->
            <div id="current-photo-section" class="bg-white rounded-lg p-3 border border-blue-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-medium text-gray-700">
                        <i class="fas fa-image mr-1"></i>
                        <span id="current-photo-info">Mempersiapkan foto...</span>
                    </span>
                    <span id="photo-progress-count" class="text-xs text-gray-600">0 / 0</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="photo-progress-bar" class="bg-green-500 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>
            <div class="mt-2 text-xs text-blue-700">
                <span id="upload-status">Mempersiapkan upload...</span>
            </div>
        </div>
    </div>        <div class="flex justify-between items-center mt-6 pt-6 border-t">
            <a href="{{ route('admin.galeri.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold" id="submit-btn">
                <i class="fas fa-save mr-2"></i>Simpan Galeri
            </button>
        </div>
    </form>
</div>

<script>
// Utility functions untuk progress bar
function formatBytes(bytes) {
    if (bytes === 0) return '0 B';
    
    const k = 1024;
    const sizes = ['B', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function formatTime(seconds) {
    if (!isFinite(seconds) || seconds <= 0) {
        return '00:00';
    }
    
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const secs = Math.floor(seconds % 60);
    
    if (hours > 0) {
        return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }
    
    return `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
}

function formatSpeed(bytesPerSecond) {
    const speed = formatBytes(bytesPerSecond);
    return speed + '/s';
}

document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements
    const fotoInput = document.getElementById('foto-input');
    const previewArea = document.getElementById('preview-area');
    const photoPreviewsContainer = document.getElementById('photo-previews');
    const thumbnailIndexInput = document.getElementById('thumbnail-index');
    const uploadArea = document.getElementById('upload-area');
    const galeriForm = document.getElementById('galeri-form');
    const submitBtn = document.getElementById('submit-btn');
    const fileCountDiv = document.getElementById('file-count');
    const countText = document.getElementById('count-text');
    
    // Stop execution if critical elements are missing
    if (!fotoInput || !previewArea || !photoPreviewsContainer) {
        alert('Error: Elemen form tidak ditemukan. Silakan refresh halaman.');
        return;
    }
    
    // Store files and thumbnail index
    let currentFiles = [];
    let selectedThumbnailIndex = 0;
    const maxFileSize = {{ $maxFileSize }} * 1024 * 1024; // Convert to bytes
    
    // File input change handler
    fotoInput.addEventListener('change', function() {
        handleFiles(this.files);
    });
    
    // Drag and drop handlers
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('bg-blue-50', 'border-blue-300');
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('bg-blue-50', 'border-blue-300');
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('bg-blue-50', 'border-blue-300');
        handleFiles(e.dataTransfer.files);
    });
    
    // Form submission handler
    galeriForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        
        if (currentFiles.length === 0) {
            alert('Silakan pilih minimal 1 foto untuk galeri');
            return false;
        }
        
        // Update form data
        updateFormFiles();
        thumbnailIndexInput.value = selectedThumbnailIndex;
        
        // Start upload with progress
        uploadWithProgress();
    });
    
    function handleFiles(files) {
        if (!files || files.length === 0) {
            return;
        }
        
        // Check if adding these files would exceed 500
        if (files.length + currentFiles.length > 500) {
            alert('Maksimal 500 foto yang dapat diupload sekaligus. Anda telah memilih ' + 
                  currentFiles.length + ' foto dan mencoba menambahkan ' + files.length + ' foto lagi.');
            return;
        }
        
        Array.from(files).forEach(file => {
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert(`File "${file.name}" bukan gambar yang valid.`);
                return;
            }
            
            // Validate file size (8MB limit)
            if (file.size > maxFileSize) {
                const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                alert(`File "${file.name}" terlalu besar (${sizeMB}MB). Maksimal 8MB.`);
                return;
            }
            
            // Check total files limit
            if (currentFiles.length >= 500) {
                alert('Maksimal 500 foto yang dapat diupload.');
                return;
            }
            
            // Add to current files
            currentFiles.push(file);
        });
        
        // Update display
        updatePreview();
        updateFileCounter();
        
        // Reset input
        fotoInput.value = '';
    }
    
    function updatePreview() {
        // Clear existing previews
        photoPreviewsContainer.innerHTML = '';
        
        if (currentFiles.length === 0) {
            previewArea.classList.add('hidden');
            return;
        }
        
        // Show preview area
        previewArea.classList.remove('hidden');
        
        // Create previews
        currentFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewDiv = createPreviewElement(e.target.result, index, file.name);
                photoPreviewsContainer.appendChild(previewDiv);
                
                // Set first image as thumbnail by default
                if (index === 0 && selectedThumbnailIndex === 0) {
                    setTimeout(() => selectThumbnail(0), 100);
                } else if (index === selectedThumbnailIndex) {
                    setTimeout(() => selectThumbnail(selectedThumbnailIndex), 100);
                }
            };
            reader.readAsDataURL(file);
        });
    }
    
    function createPreviewElement(src, index, filename) {
        const div = document.createElement('div');
        div.className = 'relative group border-2 border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-all cursor-pointer';
        div.dataset.index = index;
        
        div.innerHTML = `
            <div class="relative">
                <img src="${src}" class="w-full h-24 object-cover" alt="Preview ${index + 1}" title="Klik untuk pilih sebagai thumbnail">
                <button type="button" onclick="removePhoto(${index})" class="absolute top-1 left-1 bg-red-600 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs opacity-80 hover:opacity-100 transition-opacity" title="Hapus foto">
                    <i class="fas fa-times"></i>
                </button>
                <div class="thumbnail-badge absolute top-1 right-1 bg-blue-600 text-white text-xs px-2 py-1 rounded hidden">
                    <i class="fas fa-star mr-1"></i>Thumbnail
                </div>
                <div class="absolute bottom-1 left-1 bg-black bg-opacity-75 text-white text-xs px-2 py-1 rounded">
                    ${index + 1}
                </div>
                <div class="absolute bottom-1 right-1 bg-black bg-opacity-75 text-white text-xs px-1 rounded max-w-20 truncate" title="${filename}">
                    ${filename.length > 8 ? filename.substring(0, 8) + '...' : filename}
                </div>
            </div>
        `;
        
        // Add click handler for thumbnail selection
        div.addEventListener('click', function() {
            selectThumbnail(index);
        });
        
        return div;
    }
    
    function selectThumbnail(index) {
        if (index >= currentFiles.length) {
            return;
        }
        
        // Update selected index
        selectedThumbnailIndex = index;
        
        // Remove all existing badges and borders
        document.querySelectorAll('.thumbnail-badge').forEach(badge => {
            badge.classList.add('hidden');
        });
        document.querySelectorAll('#photo-previews > div').forEach(div => {
            div.classList.remove('border-blue-500');
            div.classList.add('border-gray-200');
        });
        
        // Add badge and border to selected item
        const selectedDiv = document.querySelector(`[data-index="${index}"]`);
        if (selectedDiv) {
            const badge = selectedDiv.querySelector('.thumbnail-badge');
            if (badge) {
                badge.classList.remove('hidden');
            }
            selectedDiv.classList.remove('border-gray-200');
            selectedDiv.classList.add('border-blue-500');
        }
    }
    
    function removePhoto(index) {
        // Remove from array
        currentFiles.splice(index, 1);
        
        // Adjust selected thumbnail index
        if (selectedThumbnailIndex > index) {
            selectedThumbnailIndex--;
        } else if (selectedThumbnailIndex === index) {
            selectedThumbnailIndex = 0; // Reset to first image
        }
        
        // Update display
        updatePreview();
        updateFileCounter();
        updateFormFiles();
    }
    
    function clearAllPhotos() {
        if (currentFiles.length === 0) return;
        
        if (confirm('Yakin ingin menghapus semua foto?')) {
            currentFiles = [];
            selectedThumbnailIndex = 0;
            updatePreview();
            updateFileCounter();
            updateFormFiles();
        }
    }
    
    function updateFileCounter() {
        if (currentFiles.length > 0) {
            fileCountDiv.classList.remove('hidden');
            countText.textContent = `${currentFiles.length} foto dipilih`;
        } else {
            fileCountDiv.classList.add('hidden');
        }
    }
    
    function updateFormFiles() {
        // Create new DataTransfer object
        const dt = new DataTransfer();
        
        // Add all current files
        currentFiles.forEach(file => {
            dt.items.add(file);
        });
        
        // Update the file input
        fotoInput.files = dt.files;
    }
    
    // Upload with progress function
    function uploadWithProgress() {
        const progressDiv = document.getElementById('upload-progress');
        const progressBar = document.getElementById('progress-bar');
        const progressPercentage = document.getElementById('progress-percentage');
        const uploadStatus = document.getElementById('upload-status');
        const uploadSpeed = document.getElementById('upload-speed');
        const uploadEta = document.getElementById('upload-eta');
        const uploadSize = document.getElementById('upload-size');
        const currentPhotoInfo = document.getElementById('current-photo-info');
        const photoProgressCount = document.getElementById('photo-progress-count');
        const photoProgressBar = document.getElementById('photo-progress-bar');
        const currentPhotoSection = document.getElementById('current-photo-section');
        
        // Show progress bar
        progressDiv.classList.remove('hidden');
        if (currentFiles.length > 0) {
            currentPhotoSection.classList.remove('hidden');
        }
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengupload...';
        
        // Initialize progress info
        const totalFiles = currentFiles.length;
        photoProgressCount.textContent = `0 / ${totalFiles}`;
        currentPhotoInfo.textContent = 'Mempersiapkan upload...';
        
        // Create FormData
        const formData = new FormData(galeriForm);
        
        // Create XMLHttpRequest
        const xhr = new XMLHttpRequest();
        
        // Track upload progress
        let uploadStartTime = Date.now();
        let lastLoaded = 0;
        let lastTime = Date.now();
        let currentPhotoIndex = 0;
        
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                const percentComplete = Math.round((e.loaded / e.total) * 100);
                const currentTime = Date.now();
                const timeDiff = currentTime - lastTime;
                
                // Calculate upload speed and ETA
                let speed = 0;
                let eta = 0;
                
                if (timeDiff > 1000 && e.loaded > lastLoaded) {
                    const bytesDiff = e.loaded - lastLoaded;
                    speed = bytesDiff / (timeDiff / 1000); // bytes per second
                    const remaining = e.total - e.loaded;
                    eta = remaining / speed; // seconds remaining
                    
                    lastLoaded = e.loaded;
                    lastTime = currentTime;
                }
                
                // Update main progress bar
                progressBar.style.width = percentComplete + '%';
                progressPercentage.textContent = percentComplete + '%';
                
                // Update size progress
                const totalSizeMB = (e.total / (1024 * 1024)).toFixed(1);
                const uploadedSizeMB = (e.loaded / (1024 * 1024)).toFixed(1);
                uploadSize.textContent = `${uploadedSizeMB} MB / ${totalSizeMB} MB`;
                
                // Update speed
                if (speed > 0) {
                    if (speed > 1024 * 1024) {
                        uploadSpeed.textContent = `${(speed / (1024 * 1024)).toFixed(1)} MB/s`;
                    } else if (speed > 1024) {
                        uploadSpeed.textContent = `${(speed / 1024).toFixed(1)} KB/s`;
                    } else {
                        uploadSpeed.textContent = `${speed.toFixed(0)} B/s`;
                    }
                } else {
                    uploadSpeed.textContent = 'Menghitung...';
                }
                
                // Update ETA
                if (eta > 0 && percentComplete < 95) {
                    if (eta > 60) {
                        uploadEta.textContent = `${Math.ceil(eta / 60)} menit`;
                    } else {
                        uploadEta.textContent = `${Math.ceil(eta)} detik`;
                    }
                } else if (percentComplete >= 95) {
                    uploadEta.textContent = 'Sebentar lagi...';
                } else {
                    uploadEta.textContent = 'Menghitung...';
                }
                
                // Estimate current photo progress
                const estimatedPhotoIndex = Math.floor((percentComplete / 100) * totalFiles);
                const photoProgress = ((percentComplete / 100) * totalFiles) - estimatedPhotoIndex;
                
                if (estimatedPhotoIndex < totalFiles) {
                    currentPhotoInfo.textContent = `Mengupload foto ${estimatedPhotoIndex + 1}: ${currentFiles[estimatedPhotoIndex].name}`;
                    photoProgressCount.textContent = `${estimatedPhotoIndex} / ${totalFiles}`;
                    photoProgressBar.style.width = (photoProgress * 100) + '%';
                } else {
                    currentPhotoInfo.textContent = 'Memproses semua foto...';
                    photoProgressCount.textContent = `${totalFiles} / ${totalFiles}`;
                    photoProgressBar.style.width = '100%';
                }
                
                // Update main status text
                if (percentComplete < 10) {
                    uploadStatus.textContent = `Mempersiapkan ${totalFiles} foto (${totalSizeMB} MB)...`;
                } else if (percentComplete < 95) {
                    uploadStatus.textContent = `Mengupload foto ${estimatedPhotoIndex + 1} dari ${totalFiles}...`;
                } else {
                    uploadStatus.textContent = 'Menyelesaikan upload dan memproses data...';
                }
            }
        });
        
        // Handle upload completion
        xhr.addEventListener('load', function() {
            if (xhr.status === 200) {
                try {
                    // Try to parse JSON response
                    const response = JSON.parse(xhr.responseText);
                    
                    if (response.success) {
                        // Success - redirect to gallery index
                        uploadStatus.textContent = 'Upload berhasil! Mengalihkan...';
                        progressBar.style.width = '100%';
                        progressPercentage.textContent = '100%';
                        
                        setTimeout(() => {
                            window.location.href = '{{ route("admin.galeri.index") }}';
                        }, 1000);
                    } else {
                        throw new Error(response.message || 'Upload gagal');
                    }
                } catch (e) {
                    // If not JSON, assume it's a redirect (success)
                    uploadStatus.textContent = 'Upload berhasil! Mengalihkan...';
                    progressBar.style.width = '100%';
                    progressPercentage.textContent = '100%';
                    
                    setTimeout(() => {
                        window.location.href = '{{ route("admin.galeri.index") }}';
                    }, 1000);
                }
            } else {
                // Error
                handleUploadError('Server error: ' + xhr.status);
            }
        });
        
        // Handle upload errors
        xhr.addEventListener('error', function() {
            handleUploadError('Terjadi kesalahan saat upload. Periksa koneksi internet Anda.');
        });
        
        xhr.addEventListener('timeout', function() {
            handleUploadError('Upload timeout. File terlalu besar atau koneksi lambat.');
        });
        
        // Set timeout (10 minutes for large uploads)
        xhr.timeout = 600000;
        
        // Start upload
        xhr.open('POST', galeriForm.action);
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('input[name="_token"]').value);
        xhr.send(formData);
    }
    
    // Handle upload error
    function handleUploadError(message) {
        const progressDiv = document.getElementById('upload-progress');
        const progressBar = document.getElementById('progress-bar');
        const progressPercentage = document.getElementById('progress-percentage');
        const uploadStatus = document.getElementById('upload-status');
        const uploadSpeed = document.getElementById('upload-speed');
        const uploadEta = document.getElementById('upload-eta');
        const uploadSize = document.getElementById('upload-size');
        const currentPhotoInfo = document.getElementById('current-photo-info');
        const photoProgressBar = document.getElementById('photo-progress-bar');
        
        // Update progress bar to error state
        progressBar.classList.remove('bg-blue-600');
        progressBar.classList.add('bg-red-600');
        progressBar.parentElement.classList.remove('bg-blue-200');
        progressBar.parentElement.classList.add('bg-red-200');
        
        // Update photo progress bar to error state
        photoProgressBar.classList.remove('bg-green-500');
        photoProgressBar.classList.add('bg-red-500');
        
        // Update status and info
        uploadStatus.textContent = message;
        uploadStatus.classList.add('text-red-700');
        currentPhotoInfo.textContent = 'Upload dibatalkan karena error';
        uploadSpeed.textContent = 'Error';
        uploadEta.textContent = 'Error';
        
        // Re-enable submit button
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Coba Lagi';
        
        // Hide progress after delay
        setTimeout(() => {
            progressDiv.classList.add('hidden');
            // Reset progress bar styles
            progressBar.classList.remove('bg-red-600');
            progressBar.classList.add('bg-blue-600');
            progressBar.parentElement.classList.remove('bg-red-200');
            progressBar.parentElement.classList.add('bg-blue-200');
            photoProgressBar.classList.remove('bg-red-500');
            photoProgressBar.classList.add('bg-green-500');
            uploadStatus.classList.remove('text-red-700');
            
            // Reset values
            progressBar.style.width = '0%';
            photoProgressBar.style.width = '0%';
            progressPercentage.textContent = '0%';
            uploadSpeed.textContent = '-';
            uploadEta.textContent = '-';
            uploadSize.textContent = '0 MB / 0 MB';
            currentPhotoInfo.textContent = 'Mempersiapkan foto...';
        }, 5000);
        
        alert(message);
    }
    
    // Make functions global for onclick handlers
    window.removePhoto = removePhoto;
    window.clearAllPhotos = clearAllPhotos;
    window.selectThumbnail = selectThumbnail;
});
</script>

<style>
.form-input {
    @apply border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500;
}

.thumbnail-badge {
    z-index: 10;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.8); }
    to { opacity: 1; transform: scale(1); }
}

#photo-previews .relative:hover {
    transform: scale(1.02);
    transition: transform 0.2s ease;
}

/* Progress bar animations */
#upload-progress {
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

#progress-bar {
    transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

#progress-bar::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(
        45deg,
        rgba(255, 255, 255, 0.1) 25%,
        transparent 25%,
        transparent 50%,
        rgba(255, 255, 255, 0.1) 50%,
        rgba(255, 255, 255, 0.1) 75%,
        transparent 75%
    );
    background-size: 1rem 1rem;
    animation: progressShine 1s linear infinite;
}

#photo-progress-bar {
    transition: width 0.3s ease;
    position: relative;
}

#photo-progress-bar::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(
        45deg,
        rgba(255, 255, 255, 0.2) 25%,
        transparent 25%,
        transparent 50%,
        rgba(255, 255, 255, 0.2) 50%,
        rgba(255, 255, 255, 0.2) 75%,
        transparent 75%
    );
    background-size: 0.5rem 0.5rem;
    animation: photoProgressShine 0.8s linear infinite;
}

@keyframes progressShine {
    0% {
        transform: translateX(-100%);
    }
    100% {
        transform: translateX(100%);
    }
}

@keyframes photoProgressShine {
    0% {
        transform: translateX(-100%);
    }
    100% {
        transform: translateX(100%);
    }
}

/* Upload info animations */
#upload-speed,
#upload-eta,
#upload-size {
    animation: fadeInUp 0.3s ease;
    transition: all 0.2s ease;
}

#current-photo-info {
    animation: slideInLeft 0.4s ease;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 200px;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-10px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Pulsing animation for upload status */
#upload-status {
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.7;
    }
}

/* Smooth transitions for form elements */
#galeri-form input,
#galeri-form textarea,
#galeri-form select {
    transition: all 0.2s ease;
}

#galeri-form input:focus,
#galeri-form textarea:focus,
#galeri-form select:focus {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
}

/* Button loading state */
#submit-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none !important;
}

#submit-btn {
    transition: all 0.2s ease;
}

#submit-btn:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}
</style>
@endsection
