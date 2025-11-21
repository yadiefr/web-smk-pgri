

<?php $__env->startSection('title', 'Edit Data Keterlambatan'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="<?php echo e(route('kesiswaan.keterlambatan.show', $keterlambatan->id)); ?>" 
               class="text-gray-600 hover:text-gray-800 transition-colors">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Data Keterlambatan</h1>
                <p class="text-gray-600 mt-1">Perbarui informasi keterlambatan siswa</p>
            </div>
        </div>
        
        <!-- Current Students Info Preview -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="mb-3">
                <h3 class="text-lg font-semibold text-blue-900 mb-2">Data Keterlambatan Saat Ini</h3>
                <p class="text-blue-700">Tanggal: <?php echo e($keterlambatan->tanggal->format('d/m/Y')); ?> | Kelas: <?php echo e($keterlambatan->kelas->nama_kelas); ?></p>
            </div>
            <div class="flex items-center">
                <div class="flex-shrink-0 h-12 w-12">
                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold">
                        <?php echo e(substr($keterlambatan->siswa->nama_lengkap, 0, 2)); ?>

                    </div>
                </div>
                <div class="ml-4">
                    <h4 class="text-base font-semibold text-blue-900"><?php echo e($keterlambatan->siswa->nama_lengkap); ?></h4>
                    <p class="text-blue-700 text-sm">NIS: <?php echo e($keterlambatan->siswa->nis); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="<?php echo e(route('kesiswaan.keterlambatan.update', $keterlambatan->id)); ?>" method="POST" id="editKeterlambatanForm">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tanggal -->
                <div class="md:col-span-2">
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           name="tanggal" 
                           id="tanggal"
                           value="<?php echo e(old('tanggal', $keterlambatan->tanggal->format('Y-m-d'))); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['tanggal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
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

                <!-- Kelas Selection -->
                <div>
                    <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Kelas <span class="text-red-500">*</span>
                    </label>
                    <select name="kelas_id" 
                            id="kelas_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['kelas_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            required>
                        <option value="">Pilih Kelas</option>
                        <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k->id); ?>" <?php echo e(old('kelas_id', $keterlambatan->kelas_id) == $k->id ? 'selected' : ''); ?>>
                                <?php echo e($k->nama_kelas); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['kelas_id'];
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

                <!-- Multiple Siswa Selection -->
                <div class="md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Siswa Terlambat <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-2" id="siswaContainer">
                        <!-- Current siswa will be populated here -->
                        <div class="siswa-item flex items-center gap-2 p-3 border border-gray-200 rounded-lg bg-gray-50">
                            <select name="siswa_ids[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent siswa-select" required>
                                <option value="">Pilih Siswa</option>
                                <?php $__currentLoopData = $siswaList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($s->id); ?>" <?php echo e($s->id == $keterlambatan->siswa_id ? 'selected' : ''); ?>>
                                        <?php echo e($s->nama_lengkap); ?> (<?php echo e($s->nis); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <button type="button" class="remove-siswa px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" style="display: none;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="button" id="addSiswa" class="inline-flex items-center gap-2 px-4 py-2 text-sm bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                            <i class="fas fa-plus"></i>
                            Tambah Siswa
                        </button>
                    </div>
                    <?php $__errorArgs = ['siswa_ids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <?php $__errorArgs = ['siswa_ids.*'];
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

                <!-- Jam Terlambat -->
                <div>
                    <label for="jam_terlambat" class="block text-sm font-medium text-gray-700 mb-2">
                        Jam Terlambat <span class="text-red-500">*</span>
                    </label>
                    <input type="time" 
                           name="jam_terlambat" 
                           id="jam_terlambat"
                           value="<?php echo e(old('jam_terlambat', $keterlambatan->jam_terlambat_format)); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['jam_terlambat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           required>
                    <?php $__errorArgs = ['jam_terlambat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <p class="text-sm text-gray-500 mt-1">Jam saat siswa tiba di sekolah</p>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
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
                        <option value="">Pilih Status</option>
                        <option value="belum_ditindak" <?php echo e(old('status', $keterlambatan->status) == 'belum_ditindak' ? 'selected' : ''); ?>>
                            Belum Ditindak
                        </option>
                        <option value="sudah_ditindak" <?php echo e(old('status', $keterlambatan->status) == 'sudah_ditindak' || old('status', $keterlambatan->status) == 'selesai' ? 'selected' : ''); ?>>
                            Sudah Ditindak
                        </option>
                    </select>
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

                <!-- Alasan Terlambat -->
                <div class="md:col-span-2">
                    <label for="alasan_terlambat" class="block text-sm font-medium text-gray-700 mb-2">
                        Alasan Terlambat <span class="text-red-500">*</span>
                    </label>
                    <textarea name="alasan_terlambat" 
                              id="alasan_terlambat"
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['alasan_terlambat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                              placeholder="Jelaskan alasan siswa terlambat..."
                              required><?php echo e(old('alasan_terlambat', $keterlambatan->alasan_terlambat)); ?></textarea>
                    <?php $__errorArgs = ['alasan_terlambat'];
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

                <!-- Sanksi -->
                <div class="md:col-span-2">
                    <label for="sanksi" class="block text-sm font-medium text-gray-700 mb-2">
                        Sanksi/Tindakan
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
                              placeholder="Sanksi atau tindakan yang diberikan (opsional)..."><?php echo e(old('sanksi', $keterlambatan->sanksi)); ?></textarea>
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

                <!-- Catatan Petugas -->
                <div class="md:col-span-2">
                    <label for="catatan_petugas" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan Petugas
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
                              placeholder="Catatan tambahan petugas (opsional)..."><?php echo e(old('catatan_petugas', $keterlambatan->catatan_petugas)); ?></textarea>
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
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                <a href="<?php echo e(route('kesiswaan.keterlambatan.show', $keterlambatan->id)); ?>" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Perbarui Data
                </button>
            </div>
        </form>
    </div>

    <!-- Additional Info -->
    <div class="mt-6 bg-gray-50 rounded-xl p-4 border border-gray-200">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
            </div>
            <div class="ml-3">
                <h4 class="text-sm font-medium text-gray-800 mb-1">Informasi Perubahan</h4>
                <div class="text-sm text-gray-600 space-y-1">
                    <p>• Data siswa dan kelas tidak dapat diubah untuk menjaga integritas data</p>
                    <p>• Perubahan akan otomatis mencatat waktu pembaruan</p>
                    <p>• Pastikan informasi yang dimasukkan sudah benar sebelum menyimpan</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editKeterlambatanForm');
    const kelasSelect = document.getElementById('kelas_id');
    const siswaContainer = document.getElementById('siswaContainer');
    const addSiswaBtn = document.getElementById('addSiswa');
    let siswaOptions = <?php echo json_encode($siswaList->toArray(), 15, 512) ?>;
    
    // Function to update siswa options based on selected kelas
    function updateSiswaOptions(kelasId = null) {
        const siswaSelects = document.querySelectorAll('.siswa-select');
        siswaSelects.forEach(select => {
            const currentValue = select.value;
            select.innerHTML = '<option value="">Pilih Siswa</option>';
            
            siswaOptions.forEach(siswa => {
                if (!kelasId || siswa.kelas_id == kelasId) {
                    const option = document.createElement('option');
                    option.value = siswa.id;
                    option.textContent = `${siswa.nama_lengkap} (${siswa.nis})`;
                    if (siswa.id == currentValue) {
                        option.selected = true;
                    }
                    select.appendChild(option);
                }
            });
        });
        
        updateRemoveButtons();
    }
    
    // Function to update remove button visibility
    function updateRemoveButtons() {
        const siswaItems = document.querySelectorAll('.siswa-item');
        siswaItems.forEach((item, index) => {
            const removeBtn = item.querySelector('.remove-siswa');
            if (siswaItems.length > 1) {
                removeBtn.style.display = 'block';
            } else {
                removeBtn.style.display = 'none';
            }
        });
    }
    
    // Function to create new siswa item
    function createSiswaItem() {
        const newItem = document.createElement('div');
        newItem.className = 'siswa-item flex items-center gap-2 p-3 border border-gray-200 rounded-lg bg-white';
        
        const kelasId = kelasSelect.value;
        let optionsHTML = '<option value="">Pilih Siswa</option>';
        
        siswaOptions.forEach(siswa => {
            if (!kelasId || siswa.kelas_id == kelasId) {
                optionsHTML += `<option value="${siswa.id}">${siswa.nama_lengkap} (${siswa.nis})</option>`;
            }
        });
        
        newItem.innerHTML = `
            <select name="siswa_ids[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent siswa-select" required>
                ${optionsHTML}
            </select>
            <button type="button" class="remove-siswa px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        // Add remove event listener
        newItem.querySelector('.remove-siswa').addEventListener('click', function() {
            newItem.remove();
            updateRemoveButtons();
            validateSiswaSelection();
        });
        
        // Add change event listener for validation
        newItem.querySelector('.siswa-select').addEventListener('change', validateSiswaSelection);
        
        return newItem;
    }
    
    // Function to validate siswa selection (no duplicates)
    function validateSiswaSelection() {
        const selectedValues = [];
        const siswaSelects = document.querySelectorAll('.siswa-select');
        let hasDuplicates = false;
        
        siswaSelects.forEach(select => {
            if (select.value) {
                if (selectedValues.includes(select.value)) {
                    hasDuplicates = true;
                    select.classList.add('border-red-500');
                } else {
                    selectedValues.push(select.value);
                    select.classList.remove('border-red-500');
                }
            } else {
                select.classList.remove('border-red-500');
            }
        });
        
        // Show/hide duplicate warning
        let warningElement = document.getElementById('duplicate-warning');
        if (hasDuplicates) {
            if (!warningElement) {
                warningElement = document.createElement('p');
                warningElement.id = 'duplicate-warning';
                warningElement.className = 'text-red-500 text-sm mt-1';
                warningElement.textContent = 'Tidak boleh memilih siswa yang sama!';
                siswaContainer.parentNode.appendChild(warningElement);
            }
        } else if (warningElement) {
            warningElement.remove();
        }
        
        return !hasDuplicates;
    }
    
    // Event listeners
    kelasSelect.addEventListener('change', function() {
        updateSiswaOptions(this.value);
    });
    
    addSiswaBtn.addEventListener('click', function() {
        const newItem = createSiswaItem();
        siswaContainer.appendChild(newItem);
        updateRemoveButtons();
    });
    
    // Add event listeners to existing remove buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-siswa')) {
            e.target.closest('.siswa-item').remove();
            updateRemoveButtons();
            validateSiswaSelection();
        }
    });
    
    // Add event listeners to existing siswa selects
    document.querySelectorAll('.siswa-select').forEach(select => {
        select.addEventListener('change', validateSiswaSelection);
    });
    
    // Form submission validation
    form.addEventListener('submit', function(e) {
        if (!validateSiswaSelection()) {
            e.preventDefault();
            alert('Harap perbaiki kesalahan pada pemilihan siswa sebelum menyimpan.');
            return;
        }
        
        const siswaSelects = document.querySelectorAll('.siswa-select');
        let hasSelectedSiswa = false;
        
        siswaSelects.forEach(select => {
            if (select.value) {
                hasSelectedSiswa = true;
            }
        });
        
        if (!hasSelectedSiswa) {
            e.preventDefault();
            alert('Minimal harus memilih satu siswa!');
            return;
        }
        
        const confirmEdit = confirm('Apakah Anda yakin ingin memperbarui data keterlambatan ini?');
        if (!confirmEdit) {
            e.preventDefault();
        }
    });
    
    // Initialize
    updateRemoveButtons();
    updateSiswaOptions(kelasSelect.value);
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kesiswaan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views\kesiswaan\keterlambatan\edit.blade.php ENDPATH**/ ?>