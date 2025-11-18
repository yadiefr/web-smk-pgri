

<?php $__env->startSection('page-header'); ?>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Edit Batch Keterlambatan</h1>
            <p class="mt-1 text-sm text-gray-600">Edit data keterlambatan untuk <?php echo e($batchData['jumlah_siswa']); ?> siswa pada <?php echo e(\Carbon\Carbon::parse($batchData['tanggal'])->format('d/m/Y')); ?></p>
        </div>
        <div class="mt-3 sm:mt-0">
            <a href="<?php echo e(route('kesiswaan.keterlambatan.index')); ?>" 
               class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <form action="<?php echo e(route('kesiswaan.keterlambatan.updateBatch', [$batchData['tanggal'], $batchData['petugas_id'], $batchData['created_at']])); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <!-- Batch Information -->
        <div class="p-4 sm:p-6 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Batch</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Tanggal -->
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           id="tanggal" 
                           name="tanggal" 
                           value="<?php echo e($batchData['tanggal']); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           required>
                    <?php $__errorArgs = ['tanggal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Status Batch -->
                <div>
                    <label for="status_batch" class="block text-sm font-medium text-gray-700 mb-2">
                        Status Batch <span class="text-red-500">*</span>
                    </label>
                    <select id="status_batch" 
                            name="status_batch" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required>
                        <option value="belum_ditindak" <?php echo e($batchData['status_umum'] == 'belum_ditindak' ? 'selected' : ''); ?>>Belum Ditindak</option>
                        <option value="sudah_ditindak" <?php echo e($batchData['status_umum'] == 'sudah_ditindak' ? 'selected' : ''); ?>>Sudah Ditindak</option>
                        <option value="selesai" <?php echo e($batchData['status_umum'] == 'selesai' ? 'selected' : ''); ?>>Selesai</option>
                    </select>
                    <?php $__errorArgs = ['status_batch'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Jumlah Siswa (Read only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Siswa</label>
                    <div class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-gray-700">
                        <?php echo e($batchData['jumlah_siswa']); ?> siswa
                    </div>
                </div>
            </div>

            <!-- Catatan Batch -->
            <div class="mt-4">
                <label for="catatan_batch" class="block text-sm font-medium text-gray-700 mb-2">
                    Catatan Batch (Opsional)
                </label>
                <textarea id="catatan_batch" 
                          name="catatan_batch" 
                          rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                          placeholder="Catatan umum untuk batch keterlambatan ini..."><?php echo e(old('catatan_batch', $keterlambatanBatch->first()->catatan_petugas ?? '')); ?></textarea>
                <?php $__errorArgs = ['catatan_batch'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Sanksi Batch -->
            <div class="mt-4">
                <label for="sanksi_batch" class="block text-sm font-medium text-gray-700 mb-2">
                    Sanksi Batch (Opsional)
                </label>
                <textarea id="sanksi_batch" 
                          name="sanksi_batch" 
                          rows="2" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                          placeholder="Sanksi yang diberikan untuk batch ini..."><?php echo e(old('sanksi_batch', $keterlambatanBatch->first()->sanksi ?? '')); ?></textarea>
                <?php $__errorArgs = ['sanksi_batch'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <!-- Add Student Section -->
        <div class="p-4 sm:p-6 border-b border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Tambah Siswa ke Batch</h3>
            </div>
            
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <button type="button" id="addSiswaBtn" class="w-full flex items-center justify-center gap-2 px-4 py-3 text-sm bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors border-2 border-dashed border-green-300 hover:border-green-400">
                    <i class="fas fa-plus"></i>
                    Tambah Siswa Baru ke Batch Keterlambatan
                </button>
                <p class="text-xs text-green-700 mt-2 text-center">Klik tombol di atas untuk menambahkan siswa baru yang terlambat pada tanggal yang sama</p>
            </div>
        </div>

        <!-- Students List -->
        <div class="p-4 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Daftar Siswa Terlambat</h3>
            </div>
            
            <div class="space-y-4" id="siswaContainer">
                <?php $__currentLoopData = $keterlambatanBatch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keterlambatan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 siswa-item" data-siswa-id="<?php echo e($keterlambatan->id); ?>">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-sm mr-3">
                                <?php echo e(substr($keterlambatan->siswa->nama_lengkap, 0, 2)); ?>

                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900"><?php echo e($keterlambatan->siswa->nama_lengkap); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($keterlambatan->siswa->nis); ?> • <?php echo e($keterlambatan->kelas->nama_kelas); ?></div>
                            </div>
                        </div>
                        <button type="button" class="remove-siswa text-red-600 hover:bg-red-50 p-2 rounded-lg transition-colors" title="Hapus siswa dari batch">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <!-- Jam Terlambat -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                Jam Terlambat <span class="text-red-500">*</span>
                            </label>
                            <input type="time" 
                                   name="siswa[<?php echo e($keterlambatan->id); ?>][jam_terlambat]" 
                                   value="<?php echo e(old('siswa.'.$keterlambatan->id.'.jam_terlambat', $keterlambatan->jam_terlambat_format)); ?>"
                                   class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="siswa[<?php echo e($keterlambatan->id); ?>][status]" 
                                    class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="belum_ditindak" <?php echo e(old('siswa.'.$keterlambatan->id.'.status', $keterlambatan->status) == 'belum_ditindak' ? 'selected' : ''); ?>>Belum Ditindak</option>
                                <option value="sudah_ditindak" <?php echo e(old('siswa.'.$keterlambatan->id.'.status', $keterlambatan->status) == 'sudah_ditindak' ? 'selected' : ''); ?>>Sudah Ditindak</option>
                                <option value="selesai" <?php echo e(old('siswa.'.$keterlambatan->id.'.status', $keterlambatan->status) == 'selesai' ? 'selected' : ''); ?>>Selesai</option>
                            </select>
                        </div>

                        <!-- Alasan Terlambat -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                Alasan Terlambat <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="siswa[<?php echo e($keterlambatan->id); ?>][alasan_terlambat]" 
                                   value="<?php echo e(old('siswa.'.$keterlambatan->id.'.alasan_terlambat', $keterlambatan->alasan_terlambat)); ?>"
                                   class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Alasan keterlambatan..."
                                   required>
                        </div>
                    </div>

                    <!-- Sanksi Individual -->
                    <div class="mt-3">
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            Sanksi Individual (Opsional)
                        </label>
                        <input type="text" 
                               name="siswa[<?php echo e($keterlambatan->id); ?>][sanksi]" 
                               value="<?php echo e(old('siswa.'.$keterlambatan->id.'.sanksi', $keterlambatan->sanksi)); ?>"
                               class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Sanksi khusus untuk siswa ini...">
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="px-4 py-3 sm:px-6 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row-reverse gap-2">
            <button type="submit" 
                    class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <i class="fas fa-save mr-2"></i>
                Simpan Perubahan
            </button>
            <a href="<?php echo e(route('kesiswaan.keterlambatan.index')); ?>" 
               class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <i class="fas fa-times mr-2"></i>
                Batal
            </a>
        </div>
    </form>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const siswaContainer = document.getElementById('siswaContainer');
    const addSiswaBtn = document.getElementById('addSiswaBtn');
    const siswaOptions = <?php echo json_encode($siswaList->toArray(), 15, 512) ?>;
    let newSiswaCounter = 0;

    // Auto update all student status when batch status changes
    document.getElementById('status_batch').addEventListener('change', function() {
        const batchStatus = this.value;
        const studentSelects = document.querySelectorAll('select[name*="[status]"]');
        
        studentSelects.forEach(select => {
            select.value = batchStatus;
        });
    });

    // Function to create new siswa item for adding to batch
    function createNewSiswaItem() {
        newSiswaCounter++;
        const newId = 'new_' + newSiswaCounter;
        
        let siswaSelectOptions = '<option value="">Pilih Siswa</option>';
        siswaOptions.forEach(siswa => {
            // Check if siswa is already in batch
            const existingItems = document.querySelectorAll('.siswa-item');
            let alreadySelected = false;
            existingItems.forEach(item => {
                const select = item.querySelector('select[name*="[siswa_id]"]');
                if (select && select.value == siswa.id) {
                    alreadySelected = true;
                }
            });
            
            if (!alreadySelected) {
                siswaSelectOptions += `<option value="${siswa.id}">${siswa.nama_lengkap} (${siswa.nis}) - ${siswa.kelas ? siswa.kelas.nama_kelas : 'Tidak ada kelas'}</option>`;
            }
        });

        const newItem = document.createElement('div');
        newItem.className = 'bg-gray-50 rounded-lg p-4 border border-gray-200 siswa-item new-siswa';
        newItem.setAttribute('data-siswa-id', newId);
        
        newItem.innerHTML = `
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-semibold text-sm mr-3">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">Siswa Baru</div>
                        <div class="text-xs text-gray-500">Pilih siswa dari dropdown</div>
                    </div>
                </div>
                <button type="button" class="remove-siswa text-red-600 hover:bg-red-50 p-2 rounded-lg transition-colors" title="Hapus siswa dari batch">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Siswa Selection for new item -->
            <div class="mb-3">
                <label class="block text-xs font-medium text-gray-700 mb-1">
                    Pilih Siswa <span class="text-red-500">*</span>
                </label>
                <select name="new_siswa[${newId}][siswa_id]" 
                        class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 siswa-select"
                        required>
                    ${siswaSelectOptions}
                </select>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <!-- Jam Terlambat -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">
                        Jam Terlambat <span class="text-red-500">*</span>
                    </label>
                    <input type="time" 
                           name="new_siswa[${newId}][jam_terlambat]" 
                           class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="new_siswa[${newId}][status]" 
                            class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        <option value="belum_ditindak">Belum Ditindak</option>
                        <option value="sudah_ditindak">Sudah Ditindak</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <!-- Alasan Terlambat -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium text-gray-700 mb-1">
                        Alasan Terlambat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="new_siswa[${newId}][alasan_terlambat]" 
                           class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Alasan keterlambatan..."
                           required>
                </div>
            </div>

            <!-- Sanksi Individual -->
            <div class="mt-3">
                <label class="block text-xs font-medium text-gray-700 mb-1">
                    Sanksi Individual (Opsional)
                </label>
                <input type="text" 
                       name="new_siswa[${newId}][sanksi]" 
                       class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Sanksi khusus untuk siswa ini...">
            </div>
        `;

        return newItem;
    }

    // Update siswa info when selecting from dropdown
    function updateSiswaInfo(selectElement) {
        const siswaId = selectElement.value;
        const siswaItem = selectElement.closest('.siswa-item');
        const siswaData = siswaOptions.find(s => s.id == siswaId);
        
        if (siswaData) {
            const avatarDiv = siswaItem.querySelector('.h-10.w-10');
            const nameDiv = siswaItem.querySelector('.text-sm.font-medium');
            const infoDiv = siswaItem.querySelector('.text-xs.text-gray-500');
            
            avatarDiv.innerHTML = siswaData.nama_lengkap.substring(0, 2).toUpperCase();
            avatarDiv.className = 'h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-sm mr-3';
            nameDiv.textContent = siswaData.nama_lengkap;
            infoDiv.textContent = `${siswaData.nis} • ${siswaData.kelas ? siswaData.kelas.nama_kelas : 'Tidak ada kelas'}`;
        }
    }

    // Add new siswa button event
    addSiswaBtn.addEventListener('click', function() {
        const newItem = createNewSiswaItem();
        // Insert at the beginning of siswaContainer instead of at the end
        siswaContainer.insertBefore(newItem, siswaContainer.firstChild);
        
        // Add event listeners for the new item
        const removeBtn = newItem.querySelector('.remove-siswa');
        removeBtn.addEventListener('click', function() {
            newItem.remove();
            updateSiswaCount();
        });

        const siswaSelect = newItem.querySelector('.siswa-select');
        siswaSelect.addEventListener('change', function() {
            updateSiswaInfo(this);
        });

        updateSiswaCount();
        
        // Scroll to the new item
        newItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });

    // Remove siswa event (for all items)
    siswaContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-siswa')) {
            const siswaItem = e.target.closest('.siswa-item');
            const siswaItems = siswaContainer.querySelectorAll('.siswa-item');
            
            if (siswaItems.length > 1) {
                siswaItem.remove();
                updateSiswaCount();
            } else {
                alert('Minimal harus ada satu siswa dalam batch!');
            }
        }
    });

    // Function to update siswa count display
    function updateSiswaCount() {
        const siswaItems = siswaContainer.querySelectorAll('.siswa-item');
        const countDisplay = document.querySelector('.bg-gray-50 .text-gray-700');
        if (countDisplay) {
            countDisplay.textContent = `${siswaItems.length} siswa`;
        }
    }

    // Validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('input[required], select[required]');
        let hasError = false;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('border-red-500');
                hasError = true;
            } else {
                field.classList.remove('border-red-500');
            }
        });
        
        // Check for duplicate siswa selection in new items
        const siswaSelects = this.querySelectorAll('select[name*="[siswa_id]"]');
        const selectedValues = [];
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
            }
        });
        
        if (hasError) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi!');
            return false;
        }
        
        if (hasDuplicates) {
            e.preventDefault();
            alert('Tidak boleh memilih siswa yang sama dalam satu batch!');
            return false;
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kesiswaan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views/kesiswaan/keterlambatan/edit_batch.blade.php ENDPATH**/ ?>