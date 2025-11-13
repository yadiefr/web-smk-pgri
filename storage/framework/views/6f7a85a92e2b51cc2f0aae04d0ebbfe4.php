

<?php $__env->startSection('title', 'Tambah Data Keterlambatan'); ?>

<?php $__env->startPush('meta'); ?>
    <meta http-equiv="content-language" content="id-ID">
    <meta name="locale" content="id-ID">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* Date input styling - using native HTML5 date picker */
input[type="date"] {
    cursor: pointer;
}

input[type="date"]::-webkit-calendar-picker-indicator {
    cursor: pointer;
}

.flatpickr-current-month .flatpickr-monthDropdown-months {
    background: #f8fafc;
}

.date-picker-trigger {
    cursor: pointer;
    position: absolute;
    inset-y-0;
    right-0;
    display: flex;
    align-items: center;
    padding-right: 12px;
    color: #6b7280;
    z-index: 10;
}

.date-picker-trigger:hover {
    color: #374151;
}
</style>
<?php $__env->stopPush(); ?>



<?php $__env->startSection('content'); ?>
<div class="p-1 sm:p-6">
    <!-- Header -->
    <div class="mb-2 sm:mb-6">
        <div class="flex items-center gap-2 sm:gap-4 mb-2 sm:mb-4 px-2 sm:px-0">
            <a href="<?php echo e(route('kesiswaan.keterlambatan.index')); ?>" 
               class="text-gray-600 hover:text-gray-800 transition-colors p-1">
                <i class="fas fa-arrow-left text-lg sm:text-xl"></i>
            </a>
            <div class="min-w-0 flex-1">
                <h1 class="text-lg sm:text-2xl font-bold text-gray-800 truncate">Tambah Data Keterlambatan</h1>
                <p class="text-gray-600 mt-0.5 text-xs sm:text-base">Input siswa yang terlambat apel pagi</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-gray-100 p-2 sm:p-6 mx-1 sm:mx-0">
        <form action="<?php echo e(route('kesiswaan.keterlambatan.store')); ?>" method="POST" id="keterlambatanForm">
            <?php echo csrf_field(); ?>
            
            <div class="space-y-3 sm:space-y-6">
                <!-- Tanggal -->
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['tanggal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="tanggal" 
                           name="tanggal" 
                           value="<?php echo e(old('tanggal', date('Y-m-d'))); ?>" 
                           required>
                    <?php $__errorArgs = ['tanggal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Pilih Siswa dengan Pencarian Terintegrasi -->
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2 sm:mb-2 gap-1 sm:gap-2">
                        <label class="block text-sm font-medium text-gray-700">
                            Pilih Siswa yang Terlambat <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-2 text-sm">
                            <span id="selected-count" class="text-blue-600 font-medium">0 dipilih</span>
                            <span class="text-gray-300">|</span>
                            <button type="button" onclick="clearAllSelected()" class="text-red-600 hover:text-red-800">
                                <span class="hidden sm:inline">Hapus Semua</span>
                                <i class="fas fa-trash sm:hidden"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Search dan Filter Container -->
                    <div class="bg-gray-50 p-1.5 sm:p-3 rounded-lg mb-2 sm:mb-3 space-y-1.5 sm:space-y-3">
                        <div class="flex flex-col sm:flex-row gap-1.5 sm:gap-3">
                            <!-- Search Input -->
                            <div class="flex-1 relative order-1 sm:order-1">
                                <input type="text" 
                                       id="search_siswa" 
                                       placeholder="Cari nama siswa atau NIS..."
                                       class="w-full px-3 py-2 pl-8 sm:pl-10 pr-8 sm:pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <div class="absolute inset-y-0 left-0 pl-2 sm:pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400 text-xs sm:text-sm"></i>
                                </div>
                                <button type="button" id="clear-search" class="absolute inset-y-0 right-0 pr-2 sm:pr-3 flex items-center text-gray-400 hover:text-gray-600 hidden">
                                    <i class="fas fa-times text-xs sm:text-sm"></i>
                                </button>
                            </div>
                            
                            <!-- Filter Kelas -->
                            <div class="w-full sm:w-48 order-2 sm:order-2">
                                <select id="filter_kelas" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    <option value="">Semua Kelas</option>
                                    <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($k->nama_kelas); ?>"><?php echo e($k->nama_kelas); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            

                        </div>
                    </div>
                    
                    <div id="siswa-container" class="border border-gray-300 rounded-lg bg-white max-h-80 sm:max-h-96 overflow-y-auto">
                        <div id="siswa-loading" class="text-center py-4 sm:py-8 hidden">
                            <div class="flex items-center justify-center text-gray-500 text-sm">
                                <div class="animate-spin rounded-full h-4 w-4 sm:h-6 sm:w-6 border-b-2 border-blue-500 mr-2 sm:mr-3"></div>
                                Memuat data siswa...
                            </div>
                        </div>
                        
                        <div id="siswa-list">
                            <?php if($siswa && $siswa->count() > 0): ?>
                                <?php $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center p-2 sm:p-3 border-b border-gray-100 hover:bg-blue-50 transition-colors cursor-pointer" 
                                     data-siswa-id="<?php echo e($s['id']); ?>"
                                     data-siswa-name="<?php echo e($s['nama']); ?>"
                                     data-siswa-nis="<?php echo e($s['nis']); ?>"
                                     data-siswa-kelas="<?php echo e($s['kelas_nama']); ?>"
                                     data-siswa-kelas-id="<?php echo e($s['kelas_id'] ?? ''); ?>">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-medium text-gray-900 truncate"><?php echo e($s['nama']); ?></div>
                                                <div class="flex items-center gap-2 mt-0.5">
                                                    <span class="text-xs text-gray-500">NIS: <?php echo e($s['nis']); ?></span>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        <?php echo e($s['kelas_nama']); ?>

                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-3 flex-shrink-0">
                                                <button type="button" class="select-btn px-3 py-1 text-xs font-medium rounded-full transition-colors bg-green-100 text-green-700 hover:bg-green-200" onclick="selectStudent(<?php echo e(json_encode($s)); ?>, this)">
                                                    Pilih
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div id="siswa-empty" class="text-center text-gray-500 py-4 sm:py-8">
                                    <i class="fas fa-search text-2xl sm:text-3xl mb-2"></i>
                                    <p class="text-sm sm:text-base">Tidak ada siswa yang ditemukan</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Dynamic empty state for filtering -->
                        <div id="filter-empty-state" class="text-center text-gray-500 py-4 sm:py-8 hidden">
                            <i class="fas fa-filter text-2xl sm:text-3xl mb-2"></i>
                            <p class="text-sm sm:text-base">Tidak ada siswa yang sesuai dengan filter</p>
                            <button type="button" onclick="clearFilters()" class="mt-2 px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600">
                                Reset Filter
                            </button>
                        </div>
                    </div>
                    
                    <?php $__errorArgs = ['siswa_data'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Selected Students Details -->
                <div>
                    <div class="mb-2 sm:mb-3">
                        <label class="block text-sm font-medium text-gray-700">
                            Detail Keterlambatan Siswa <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs sm:text-sm text-gray-500 mt-0.5 sm:mt-1">Isi jam terlambat dan alasan untuk setiap siswa yang dipilih</p>
                    </div>
                    
                    <div id="selected-students-details" class="space-y-2 sm:space-y-4 min-h-[80px] sm:min-h-[100px] border border-gray-200 rounded-lg p-2 sm:p-4 bg-gray-50">
                        <!-- Batch controls -->
                        <div id="batch-controls" class="mb-2 hidden">
                            <!-- Batch reason controls -->
                            <div class="flex items-start gap-3 mb-4">
                                <div class="flex items-center mt-1">
                                    <input id="use_batch_reason" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded" />
                                </div>
                                <div class="flex-1">
                                    <label for="batch_reason" class="block text-sm font-medium text-gray-700">Alasan Bersama untuk Siswa Terpilih</label>
                                    <div class="mt-1 flex gap-2">
                                        <input id="batch_reason" type="text" placeholder="Masukkan alasan yang akan diterapkan ke semua siswa terpilih..." 
                                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <button id="applyBatchReason" type="button" class="px-3 py-2 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600">Terapkan</button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Centang untuk menerapkan alasan ini ke semua siswa terpilih. Anda tetap bisa mengubah alasan per siswa setelah menerapkan.</p>
                                </div>
                            </div>

                            <!-- Batch time controls -->
                            <div class="flex items-start gap-3">
                                <div class="flex items-center mt-1">
                                    <input id="use_batch_time" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded" />
                                </div>
                                <div class="flex-1">
                                    <label for="batch_time" class="block text-sm font-medium text-gray-700">Jam Terlambat Bersama untuk Siswa Terpilih</label>
                                    <div class="mt-1 flex gap-2">
                                        <input id="batch_time" type="time" 
                                               class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <button id="applyBatchTime" type="button" class="px-3 py-2 bg-green-500 text-white rounded-lg text-sm hover:bg-green-600">Terapkan</button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Centang untuk menerapkan jam ini ke semua siswa terpilih. Anda tetap bisa mengubah jam per siswa setelah menerapkan.</p>
                                </div>
                            </div>
                        </div>

                        <div id="no-students-selected" class="text-center text-gray-500 py-4 sm:py-8">
                            <i class="fas fa-user-plus text-2xl sm:text-3xl mb-2"></i>
                            <p class="text-sm sm:text-base">Pilih siswa dari daftar di atas untuk mengisi detail keterlambatan</p>
                        </div>
                    </div>
                </div>

                <!-- Global Settings -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status Default
                        </label>
                        <select name="status" 
                                id="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                required>
                            <option value="belum_ditindak" <?php echo e(old('status', 'belum_ditindak') == 'belum_ditindak' ? 'selected' : ''); ?>>
                                Belum Ditindak
                            </option>
                            <option value="sudah_ditindak" <?php echo e(old('status') == 'sudah_ditindak' ? 'selected' : ''); ?>>
                                Sudah Ditindak
                            </option>
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Status akan diterapkan untuk semua siswa</p>
                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="sanksi" class="block text-sm font-medium text-gray-700 mb-2">
                            Sanksi/Tindakan Umum
                        </label>
                        <textarea name="sanksi" 
                                  id="sanksi"
                                  rows="2"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['sanksi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  placeholder="Sanksi yang sama untuk semua siswa (opsional)..."><?php echo e(old('sanksi')); ?></textarea>
                        <?php $__errorArgs = ['sanksi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Catatan Petugas -->
                <div>
                    <label for="catatan_petugas" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan dari kesiswaan
                    </label>
                    <textarea name="catatan_petugas" 
                              id="catatan_petugas"
                              rows="2"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['catatan_petugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                              placeholder="Catatan tambahan petugas (opsional)..."><?php echo e(old('catatan_petugas')); ?></textarea>
                    <?php $__errorArgs = ['catatan_petugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex flex-col sm:flex-row sm:justify-end gap-2 sm:gap-3 mt-4 sm:mt-8 pt-3 sm:pt-6 border-t border-gray-200">
                <a href="<?php echo e(route('kesiswaan.keterlambatan.index')); ?>" 
                   class="w-full sm:w-auto px-4 sm:px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-center">
                    <i class="fas fa-arrow-left sm:hidden mr-2"></i>
                    Batal
                </a>
                <button type="submit" 
                        class="w-full sm:w-auto px-4 sm:px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 flex items-center justify-center gap-2"
                        id="submitBtn">
                    <i class="fas fa-save"></i>
                    <span id="submitText" class="hidden sm:inline">Simpan Data Keterlambatan</span>
                    <span class="sm:hidden">Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
// Global variables for selected students
let selectedStudents = new Map();

// Function to filter students based on search and class
function filterStudents() {
    const searchInput = document.getElementById('search_siswa');
    const filterKelas = document.getElementById('filter_kelas');
    const studentCards = document.querySelectorAll('[data-siswa-id]');
    
    const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
    const selectedKelas = filterKelas ? filterKelas.value : '';
    
    let visibleCount = 0;
    
    studentCards.forEach(card => {
        const siswaName = card.getAttribute('data-siswa-name') || '';
        const siswaNis = card.getAttribute('data-siswa-nis') || '';
        const siswaKelas = card.getAttribute('data-siswa-kelas') || '';
        
        const matchesSearch = !searchTerm || 
            siswaName.toLowerCase().includes(searchTerm) || 
            siswaNis.includes(searchTerm);
            
        // Match by kelas name (dropdown now uses nama_kelas as value)
        const matchesKelas = !selectedKelas || siswaKelas === selectedKelas;
        
        const shouldShow = matchesSearch && matchesKelas;
        
        card.style.display = shouldShow ? 'block' : 'none';
        if (shouldShow) visibleCount++;
    });
    

    
    // Update empty state
    const filterEmptyState = document.getElementById('filter-empty-state');
    const siswaList = document.getElementById('siswa-list');
    
    if (visibleCount === 0 && (searchTerm || selectedKelas)) {
        if (filterEmptyState) filterEmptyState.style.display = 'block';
        if (siswaList) siswaList.style.display = 'none';
    } else {
        if (filterEmptyState) filterEmptyState.style.display = 'none';
        if (siswaList) siswaList.style.display = 'block';
    }
}

// Function to clear all filters
function clearFilters() {
    const searchInput = document.getElementById('search_siswa');
    const filterKelas = document.getElementById('filter_kelas');
    const clearSearchBtn = document.getElementById('clear-search');
    
    if (searchInput) {
        searchInput.value = '';
    }
    if (filterKelas) {
        filterKelas.value = '';
    }
    if (clearSearchBtn) {
        clearSearchBtn.classList.add('hidden');
    }
    
    filterStudents();
}

// Function to select/deselect student
function selectStudent(siswa, button) {
    const siswaId = siswa.id.toString();
    
    if (selectedStudents.has(siswaId)) {
        // Remove student
        selectedStudents.delete(siswaId);
        button.textContent = 'Pilih';
        button.className = 'select-btn px-3 py-1 text-xs font-medium rounded-full transition-colors bg-green-100 text-green-700 hover:bg-green-200';
    } else {
        // Add student with default values
        const now = new Date();
        const defaultTime = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
        
        selectedStudents.set(siswaId, {
            ...siswa,
            jam_terlambat: defaultTime,
            alasan_terlambat: ''
        });
        
        button.textContent = 'Hapus';
        button.className = 'select-btn px-3 py-1 text-xs font-medium rounded-full transition-colors bg-red-100 text-red-700 hover:bg-red-200';
    }
    
    updateSelectedCount();
    updateSelectedDetails();
}

// Global functions for onclick handlers  
window.selectStudent = function(siswa, button) {
    const siswaId = siswa.id.toString();
    
    if (selectedStudents.has(siswaId)) {
        // Remove student
        selectedStudents.delete(siswaId);
        button.textContent = 'Pilih';
        button.className = 'select-btn px-3 py-1 text-xs font-medium rounded-full transition-colors bg-green-100 text-green-700 hover:bg-green-200';
    } else {
        // Add student with default values
        const now = new Date();
        const defaultTime = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
        
        selectedStudents.set(siswaId, {
            ...siswa,
            jam_terlambat: defaultTime,
            alasan_terlambat: ''
        });
        
        button.textContent = 'Hapus';
        button.className = 'select-btn px-3 py-1 text-xs font-medium rounded-full transition-colors bg-red-100 text-red-700 hover:bg-red-200';
    }
    
    // Call update functions
    const selectedCount = document.getElementById('selected-count');
    if (selectedCount) {
        selectedCount.textContent = selectedStudents.size + ' dipilih';
    }
    
    // Update details
    const selectedDetailsContainer = document.getElementById('selected-students-details');
    if (selectedDetailsContainer) {
        updateSelectedDetailsGlobal();
    }
    
    // Update submit button
    const submitText = document.getElementById('submitText');
    if (submitText) {
        const count = selectedStudents.size;
        if (count === 0) {
            submitText.textContent = 'Simpan Data Keterlambatan';
        } else if (count === 1) {
            submitText.textContent = 'Simpan 1 Siswa Terlambat';
        } else {
            submitText.textContent = `Simpan ${count} Siswa Terlambat`;
        }
    }
};

window.removeStudent = function(siswaId) {
    selectedStudents.delete(siswaId);
    
    // Update button in list
    const listItem = document.querySelector(`[data-siswa-id="${siswaId}"] .select-btn`);
    if (listItem) {
        listItem.textContent = 'Pilih';
        listItem.className = 'select-btn px-3 py-1 text-xs font-medium rounded-full transition-colors bg-green-100 text-green-700 hover:bg-green-200';
    }
    
    // Update count
    const selectedCount = document.getElementById('selected-count');
    if (selectedCount) {
        selectedCount.textContent = selectedStudents.size + ' dipilih';
    }
    
    // Update details
    window.updateSelectedDetailsGlobal();
    
    // Update submit button
    const submitText = document.getElementById('submitText');
    if (submitText) {
        const count = selectedStudents.size;
        if (count === 0) {
            submitText.textContent = 'Simpan Data Keterlambatan';
        } else if (count === 1) {
            submitText.textContent = 'Simpan 1 Siswa Terlambat';
        } else {
            submitText.textContent = `Simpan ${count} Siswa Terlambat`;
        }
    }
};

window.updateStudentData = function(siswaId, field, value) {
    if (selectedStudents.has(siswaId)) {
        const studentData = selectedStudents.get(siswaId);
        studentData[field] = value;
        selectedStudents.set(siswaId, studentData);
    }
};

window.clearAllSelected = function() {
    selectedStudents.clear();
    
    // Reset all buttons
    document.querySelectorAll('.select-btn').forEach(button => {
        button.textContent = 'Pilih';
        button.className = 'select-btn px-3 py-1 text-xs font-medium rounded-full transition-colors bg-green-100 text-green-700 hover:bg-green-200';
    });
    
    // Update count
    const selectedCount = document.getElementById('selected-count');
    if (selectedCount) {
        selectedCount.textContent = '0 dipilih';
    }
    
    // Update details
    window.updateSelectedDetailsGlobal();
    
    // Update submit button
    const submitText = document.getElementById('submitText');
    if (submitText) {
        submitText.textContent = 'Simpan Data Keterlambatan';
    }
};

window.updateSelectedDetailsGlobal = function() {
    const selectedDetailsContainer = document.getElementById('selected-students-details');
    if (!selectedDetailsContainer) return;
    
    if (selectedStudents.size === 0) {
        selectedDetailsContainer.innerHTML = '<div id="no-students-selected" class="text-center text-gray-500 py-4 sm:py-8"><i class="fas fa-user-plus text-2xl sm:text-3xl mb-2"></i><p class="text-sm sm:text-base">Pilih siswa dari daftar di atas untuk mengisi detail keterlambatan</p></div>';
        return;
    }

    // Batch controls
    let batchHTML = `
        <div id="batch-controls-inner" class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Batch reason controls -->
                <div class="flex flex-col">
                    <label for="batch_reason_inner" class="block text-sm font-medium text-gray-700 mb-1">Alasan Bersama untuk Siswa Terpilih</label>
                    <div class="flex gap-2">
                        <input id="batch_reason_inner" type="text" placeholder="Masukkan alasan yang akan diterapkan ke semua siswa terpilih..." 
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button id="applyBatchReasonInner" type="button" class="px-3 py-2 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600 whitespace-nowrap">Terapkan</button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Ketik alasan dan klik "Terapkan" untuk menerapkan ke semua siswa terpilih.</p>
                </div>

                <!-- Batch time controls -->
                <div class="flex flex-col">
                    <label for="batch_time_inner" class="block text-sm font-medium text-gray-700 mb-1">Jam Terlambat Bersama untuk Siswa Terpilih</label>
                    <div class="flex gap-2">
                        <input id="batch_time_inner" type="time" 
                               class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <button id="applyBatchTimeInner" type="button" class="px-3 py-2 bg-green-500 text-white rounded-lg text-sm hover:bg-green-600 whitespace-nowrap">Terapkan</button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Pilih jam dan klik "Terapkan" untuk menerapkan ke semua siswa terpilih.</p>
                </div>
            </div>
        </div>
    `;

    let detailsHTML = batchHTML;
    selectedStudents.forEach((siswa, siswaId) => {
        detailsHTML += `
            <div class="bg-white rounded-lg border border-gray-200 p-4 mb-3">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-xs">
                            ${siswa.nama.substring(0, 2)}
                        </div>
                        <div class="ml-3">
                            <div class="text-sm font-medium text-gray-900">${siswa.nama}</div>
                            <div class="text-xs text-gray-500">NIS: ${siswa.nis} | ${siswa.kelas_nama}</div>
                        </div>
                    </div>
                    <button type="button" onclick="removeStudent('${siswaId}')" class="text-red-600 hover:text-red-800 text-sm p-1">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Terlambat *</label>
                        <input type="time" 
                               name="siswa_data[${siswaId}][jam_terlambat]" 
                               value="${siswa.jam_terlambat}"
                               onchange="updateStudentData('${siswaId}', 'jam_terlambat', this.value)"
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Terlambat *</label>
                        <input type="text" 
                               name="siswa_data[${siswaId}][alasan_terlambat]" 
                               value="${siswa.alasan_terlambat}"
                               onchange="updateStudentData('${siswaId}', 'alasan_terlambat', this.value)"
                               placeholder="Alasan siswa terlambat..."
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                    </div>
                </div>
                
                <input type="hidden" name="siswa_data[${siswaId}][siswa_id]" value="${siswaId}">
                <input type="hidden" name="siswa_data[${siswaId}][kelas_id]" value="${siswa.kelas_id}">
            </div>
        `;
    });

    selectedDetailsContainer.innerHTML = detailsHTML;

    // Attach batch controls
    const applyBatchInner = document.getElementById('applyBatchReasonInner');
    const batchReasonInner = document.getElementById('batch_reason_inner');
    const applyBatchTimeInner = document.getElementById('applyBatchTimeInner');
    const batchTimeInner = document.getElementById('batch_time_inner');
    
    // Batch reason handler
    if (applyBatchInner && batchReasonInner) {
        applyBatchInner.onclick = function() {
            const reason = batchReasonInner.value.trim();
            if (!reason) {
                alert('Masukkan alasan terlebih dahulu.');
                batchReasonInner.focus();
                return;
            }

            selectedStudents.forEach((siswa, siswaId) => {
                siswa.alasan_terlambat = reason;
                selectedStudents.set(siswaId, siswa);
                const input = document.querySelector(`input[name="siswa_data[${siswaId}][alasan_terlambat]"]`);
                if (input) input.value = reason;
            });
            
            alert('Alasan berhasil diterapkan ke semua siswa terpilih.');
        };
    }

    // Batch time handler
    if (applyBatchTimeInner && batchTimeInner) {
        applyBatchTimeInner.onclick = function() {
            const time = batchTimeInner.value;
            if (!time) {
                alert('Pilih jam terlebih dahulu.');
                batchTimeInner.focus();
                return;
            }

            selectedStudents.forEach((siswa, siswaId) => {
                siswa.jam_terlambat = time;
                selectedStudents.set(siswaId, siswa);
                const input = document.querySelector(`input[name="siswa_data[${siswaId}][jam_terlambat]"]`);
                if (input) input.value = time;
            });
            
            alert('Jam terlambat berhasil diterapkan ke semua siswa terpilih.');
        };
    }
};

function removeStudent(siswaId) {
    selectedStudents.delete(siswaId);
    
    // Update button in list
    const listItem = document.querySelector(`[data-siswa-id="${siswaId}"] .select-btn`);
    if (listItem) {
        listItem.textContent = 'Pilih';
        listItem.className = 'select-btn px-3 py-1 text-xs font-medium rounded-full transition-colors bg-green-100 text-green-700 hover:bg-green-200';
    }
    
    updateSelectedCount();
    updateSelectedDetails();
}

function updateStudentData(siswaId, field, value) {
    if (selectedStudents.has(siswaId)) {
        const studentData = selectedStudents.get(siswaId);
        studentData[field] = value;
        selectedStudents.set(siswaId, studentData);
    }
}

function updateSubmitText() {
    const submitText = document.getElementById('submitText');
    if (!submitText) return;
    
    const count = selectedStudents.size;
    
    if (count === 0) {
        submitText.textContent = 'Simpan Data Keterlambatan';
    } else if (count === 1) {
        submitText.textContent = 'Simpan 1 Siswa Terlambat';
    } else {
        submitText.textContent = `Simpan ${count} Siswa Terlambat`;
    }
}

// Clear All functionality
function clearAllSelected() {
    selectedStudents.clear();
    
    // Reset all buttons
    document.querySelectorAll('.select-btn').forEach(button => {
        button.textContent = 'Pilih';
        button.className = 'select-btn px-3 py-1 text-xs font-medium rounded-full transition-colors bg-green-100 text-green-700 hover:bg-green-200';
    });
    
    updateSelectedCount();
    updateSelectedDetails();
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize counters
    updateSelectedCount();
    updateSelectedDetails();
    updateSubmitText();

    // Set default time for batch time controls
    const now = new Date();
    const defaultTime = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
    const mainBatchTimeInput = document.getElementById('batch_time');
    if (mainBatchTimeInput) {
        mainBatchTimeInput.value = defaultTime;
    }

    // Date input is now using native HTML5 date picker - no custom setup needed
    
    // Search functionality
    const searchInput = document.getElementById('search_siswa');
    const clearSearchBtn = document.getElementById('clear-search');
    const filterKelas = document.getElementById('filter_kelas');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            
            // Show/hide clear button
            if (clearSearchBtn) {
                clearSearchBtn.classList.toggle('hidden', searchTerm === '');
            }
            
            filterStudents();
        });
    }
    
    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function() {
            if (searchInput) {
                searchInput.value = '';
                searchInput.focus();
                this.classList.add('hidden');
            }
            filterStudents();
        });
    }
    
    if (filterKelas) {
        filterKelas.addEventListener('change', function() {
            filterStudents();
        });
    }
    
    // Form validation
    const form = document.getElementById('keterlambatanForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (selectedStudents.size === 0) {
                e.preventDefault();
                alert('Pilih minimal satu siswa yang terlambat!');
                return false;
            }
            
            // Validate each selected student has required data
            let hasEmptyData = false;
            selectedStudents.forEach((siswa, siswaId) => {
                if (!siswa.jam_terlambat || !siswa.alasan_terlambat.trim()) {
                    hasEmptyData = true;
                }
            });
            
            if (hasEmptyData) {
                e.preventDefault();
                alert('Lengkapi jam terlambat dan alasan untuk semua siswa yang dipilih!');
                return false;
            }
            
            // Confirm submission
            const count = selectedStudents.size;
            const confirmMessage = count === 1 
                ? 'Apakah Anda yakin ingin menyimpan data keterlambatan untuk 1 siswa?'
                : `Apakah Anda yakin ingin menyimpan data keterlambatan untuk ${count} siswa?`;
                
            if (!confirm(confirmMessage)) {
                e.preventDefault();
                return false;
            }
        });
    }

    // Main batch controls event handlers
    const mainApplyBatchReason = document.getElementById('applyBatchReason');
    const mainBatchReason = document.getElementById('batch_reason');
    const mainApplyBatchTime = document.getElementById('applyBatchTime');
    const mainBatchTime = document.getElementById('batch_time');

    // Main batch reason handler
    if (mainApplyBatchReason && mainBatchReason) {
        mainApplyBatchReason.addEventListener('click', function() {
            if (selectedStudents.size === 0) {
                alert('Pilih siswa terlebih dahulu.');
                return;
            }

            const reason = mainBatchReason.value.trim();
            if (!reason) {
                alert('Masukkan alasan terlebih dahulu.');
                mainBatchReason.focus();
                return;
            }

            selectedStudents.forEach((siswa, siswaId) => {
                siswa.alasan_terlambat = reason;
                selectedStudents.set(siswaId, siswa);
            });
            
            updateSelectedDetails(); // Update the display
            alert('Alasan berhasil diterapkan ke semua siswa terpilih.');
        });
    }

    // Main batch time handler
    if (mainApplyBatchTime && mainBatchTime) {
        mainApplyBatchTime.addEventListener('click', function() {
            if (selectedStudents.size === 0) {
                alert('Pilih siswa terlebih dahulu.');
                return;
            }

            const time = mainBatchTime.value;
            if (!time) {
                alert('Pilih jam terlebih dahulu.');
                mainBatchTime.focus();
                return;
            }

            selectedStudents.forEach((siswa, siswaId) => {
                siswa.jam_terlambat = time;
                selectedStudents.set(siswaId, siswa);
            });
            
            updateSelectedDetails(); // Update the display
            alert('Jam terlambat berhasil diterapkan ke semua siswa terpilih.');
        });
    }
});

// Global functions untuk onclick handlers dan updates
function selectStudent(siswa, button) {
    const siswaId = siswa.id.toString();
    
    if (selectedStudents.has(siswaId)) {
        // Remove student
        selectedStudents.delete(siswaId);
        button.textContent = 'Pilih';
        button.className = 'select-btn px-3 py-1 text-xs font-medium rounded-full transition-colors bg-green-100 text-green-700 hover:bg-green-200';
    } else {
        // Add student with default values
        const now = new Date();
        const defaultTime = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
        
        selectedStudents.set(siswaId, {
            ...siswa,
            jam_terlambat: defaultTime,
            alasan_terlambat: ''
        });
        
        button.textContent = 'Hapus';
        button.className = 'select-btn px-3 py-1 text-xs font-medium rounded-full transition-colors bg-red-100 text-red-700 hover:bg-red-200';
    }
    
    updateSelectedCount();
    updateSelectedDetails();
    updateSubmitText();
}

function updateSelectedCount() {
    const count = selectedStudents.size;
    const selectedCount = document.getElementById('selected-count');
    if (selectedCount) {
        selectedCount.textContent = count + ' dipilih';
    }
}

function updateSelectedDetails() {
    const selectedDetailsContainer = document.getElementById('selected-students-details');
    if (!selectedDetailsContainer) return;
    
    if (selectedStudents.size === 0) {
        selectedDetailsContainer.innerHTML = '<div id="no-students-selected" class="text-center text-gray-500 py-4 sm:py-8"><i class="fas fa-user-plus text-2xl sm:text-3xl mb-2"></i><p class="text-sm sm:text-base">Pilih siswa dari daftar di atas untuk mengisi detail keterlambatan</p></div>';
        return;
    }

    // Batch controls
    let batchHTML = `
        <div id="batch-controls-inner" class="mb-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <div class="flex items-start gap-3">
                <div class="flex items-center mt-1">
                    <input id="use_batch_reason_inner" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded" />
                </div>
                <div class="flex-1">
                    <label for="batch_reason_inner" class="block text-sm font-medium text-gray-700">Alasan Bersama untuk Siswa Terpilih</label>
                    <div class="mt-1 flex gap-2">
                        <input id="batch_reason_inner" type="text" placeholder="Masukkan alasan yang akan diterapkan ke semua siswa terpilih..." 
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button id="applyBatchReasonInner" type="button" class="px-3 py-2 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600">Terapkan</button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Ketik alasan dan klik "Terapkan" untuk menerapkan ke semua siswa terpilih.</p>
                </div>
            </div>
        </div>
    `;

    let detailsHTML = batchHTML;
    selectedStudents.forEach((siswa, siswaId) => {
        detailsHTML += `
            <div class="bg-white rounded-lg border border-gray-200 p-2 sm:p-4 mb-3">
                <div class="flex items-start sm:items-center justify-between mb-2 sm:mb-3 gap-2">
                    <div class="flex items-center min-w-0 flex-1">
                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-xs">
                            ${siswa.nama.substring(0, 2)}
                        </div>
                        <div class="ml-3 min-w-0 flex-1">
                            <div class="text-sm font-medium text-gray-900">${siswa.nama}</div>
                            <div class="text-xs text-gray-500">NIS: ${siswa.nis} | ${siswa.kelas_nama}</div>
                        </div>
                    </div>
                    <button type="button" onclick="removeStudent('${siswaId}')" class="text-red-600 hover:text-red-800 text-sm p-1">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Terlambat *</label>
                        <input type="time" 
                               name="siswa_data[${siswaId}][jam_terlambat]" 
                               value="${siswa.jam_terlambat}"
                               onchange="updateStudentData('${siswaId}', 'jam_terlambat', this.value)"
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Terlambat *</label>
                        <input type="text" 
                               name="siswa_data[${siswaId}][alasan_terlambat]" 
                               value="${siswa.alasan_terlambat}"
                               onchange="updateStudentData('${siswaId}', 'alasan_terlambat', this.value)"
                               placeholder="Alasan siswa terlambat..."
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                    </div>
                </div>
                
                <!-- Hidden inputs for siswa data -->
                <input type="hidden" name="siswa_data[${siswaId}][siswa_id]" value="${siswaId}">
                <input type="hidden" name="siswa_data[${siswaId}][kelas_id]" value="${siswa.kelas_id}">
            </div>
        `;
    });

    selectedDetailsContainer.innerHTML = detailsHTML;

    // Attach batch control handlers AFTER DOM is updated
    const applyBatchInner = document.getElementById('applyBatchReasonInner');
    const batchReasonInner = document.getElementById('batch_reason_inner');
    
    if (applyBatchInner && batchReasonInner) {
        applyBatchInner.onclick = function() {
            const reason = (batchReasonInner.value || '').trim();
            if (!reason) {
                alert('Masukkan alasan bersama terlebih dahulu.');
                batchReasonInner.focus();
                return;
            }

            selectedStudents.forEach((siswa, siswaId) => {
                siswa.alasan_terlambat = reason;
                selectedStudents.set(siswaId, siswa);
                // Update corresponding input if exists
                const input = document.querySelector(`input[name="siswa_data[${siswaId}][alasan_terlambat]"]`);
                if (input) input.value = reason;
            });
            
            alert(`Alasan "${reason}" telah diterapkan ke ${selectedStudents.size} siswa.`);
        };
    }
}

function removeStudent(siswaId) {
    selectedStudents.delete(siswaId);
    
    // Update button in list
    const listItem = document.querySelector(`[data-siswa-id="${siswaId}"] .select-btn`);
    if (listItem) {
        listItem.textContent = 'Pilih';
        listItem.className = 'select-btn px-3 py-1 text-xs font-medium rounded-full transition-colors bg-green-100 text-green-700 hover:bg-green-200';
    }
    
    updateSelectedCount();
    updateSelectedDetails();
    updateSubmitText();
}

function updateStudentData(siswaId, field, value) {
    if (selectedStudents.has(siswaId)) {
        const studentData = selectedStudents.get(siswaId);
        studentData[field] = value;
        selectedStudents.set(siswaId, studentData);
    }
}

function clearAllSelected() {
    selectedStudents.clear();
    
    // Reset all buttons
    document.querySelectorAll('.select-btn').forEach(button => {
        button.textContent = 'Pilih';
        button.className = 'select-btn px-3 py-1 text-xs font-medium rounded-full transition-colors bg-green-100 text-green-700 hover:bg-green-200';
    });
    
    updateSelectedCount();
    updateSelectedDetails();
    updateSubmitText();
}

function updateSubmitText() {
    const submitText = document.getElementById('submitText');
    if (!submitText) return;
    
    const count = selectedStudents.size;
    
    if (count === 0) {
        submitText.textContent = 'Simpan Data Keterlambatan';
    } else if (count === 1) {
        submitText.textContent = 'Simpan 1 Siswa Terlambat';
    } else {
        submitText.textContent = `Simpan ${count} Siswa Terlambat`;
    }
}

// Fallback initialization if DOMContentLoaded doesn't fire
setTimeout(function() {
    if (!window.keterlambatanInitialized) {
        console.warn('DOMContentLoaded may not have fired, trying direct initialization...');
        // Try to initialize directly
    }
}, 2000);
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kesiswaan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views\kesiswaan\keterlambatan\create.blade.php ENDPATH**/ ?>