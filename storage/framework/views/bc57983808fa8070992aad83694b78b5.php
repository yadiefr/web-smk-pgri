

<?php $__env->startSection('title', 'Detail Keterlambatan'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="<?php echo e(route('kesiswaan.keterlambatan.index')); ?>" 
                   class="text-gray-600 hover:text-gray-800 transition-colors">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Detail Keterlambatan</h1>
                    <p class="text-gray-600 mt-1">Informasi lengkap data keterlambatan siswa</p>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="<?php echo e(route('kesiswaan.keterlambatan.edit', $keterlambatan->id)); ?>" 
                   class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white px-4 py-2 rounded-lg hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300 flex items-center gap-2 shadow-sm">
                    <i class="fas fa-edit"></i>
                    <span>Edit</span>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info Card -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0 h-16 w-16">
                    <div class="h-16 w-16 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-xl">
                        <?php echo e(substr($keterlambatan->siswa->nama_lengkap, 0, 2)); ?>

                    </div>
                </div>
                <div class="ml-4">
                    <h2 class="text-xl font-bold text-gray-900"><?php echo e($keterlambatan->siswa->nama_lengkap); ?></h2>
                    <p class="text-gray-600">NIS: <?php echo e($keterlambatan->siswa->nis); ?></p>
                    <p class="text-gray-600">Kelas: <?php echo e($keterlambatan->kelas->nama_kelas); ?></p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Tanggal</label>
                    <div class="flex items-center text-gray-900">
                        <i class="fas fa-calendar text-gray-400 mr-2"></i>
                        <?php echo e($keterlambatan->tanggal->format('d F Y')); ?>

                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Jam Terlambat</label>
                    <div class="flex items-center text-gray-900">
                        <i class="fas fa-clock text-orange-500 mr-2"></i>
                        <span class="font-semibold"><?php echo e($keterlambatan->jam_terlambat_format); ?></span>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-500 mb-2">Status</label>
                    <div class="flex items-center">
                        <?php if($keterlambatan->status == 'belum_ditindak'): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                Belum Ditindak
                            </span>
                        <?php elseif($keterlambatan->status == 'sudah_ditindak'): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-1"></i>
                                Sudah Ditindak
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Selesai
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan</h3>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600">Total Keterlambatan Bulan Ini</span>
                    <span class="font-semibold text-orange-600"><?php echo e($statistikSiswa['bulan_ini'] ?? 0); ?></span>
                </div>
                
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600">Total Keterlambatan Keseluruhan</span>
                    <span class="font-semibold text-red-600"><?php echo e($statistikSiswa['total'] ?? 0); ?></span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm text-gray-600">Dicatat Oleh</span>
                    <span class="font-semibold text-gray-900"><?php echo e($keterlambatan->petugas->name ?? 'System'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Section -->
    <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Alasan Terlambat -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-comment-alt text-orange-500 mr-2"></i>
                Alasan Terlambat
            </h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-800"><?php echo e($keterlambatan->alasan_terlambat ?: 'Tidak ada alasan yang dicatat'); ?></p>
            </div>
        </div>

        <!-- Sanksi -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-gavel text-red-500 mr-2"></i>
                Sanksi/Tindakan
            </h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <?php if($keterlambatan->sanksi): ?>
                    <p class="text-gray-800"><?php echo e($keterlambatan->sanksi); ?></p>
                <?php else: ?>
                    <p class="text-gray-500 italic">Belum ada sanksi yang diberikan</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Catatan Petugas -->
    <?php if($keterlambatan->catatan_petugas): ?>
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-sticky-note text-blue-500 mr-2"></i>
            Catatan Petugas
        </h3>
        <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-400">
            <p class="text-gray-800"><?php echo e($keterlambatan->catatan_petugas); ?></p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Metadata -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-info-circle text-gray-500 mr-2"></i>
            Informasi Sistem
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
                <span class="text-gray-500">Dibuat pada:</span>
                <p class="font-medium text-gray-900"><?php echo e($keterlambatan->created_at->format('d/m/Y H:i')); ?></p>
            </div>
            <div>
                <span class="text-gray-500">Terakhir diperbarui:</span>
                <p class="font-medium text-gray-900"><?php echo e($keterlambatan->updated_at->format('d/m/Y H:i')); ?></p>
            </div>
            <div>
                <span class="text-gray-500">ID Record:</span>
                <p class="font-medium text-gray-900">#<?php echo e($keterlambatan->id); ?></p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-6 flex justify-between">
        <a href="<?php echo e(route('kesiswaan.keterlambatan.index')); ?>" 
           class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Daftar
        </a>
        
        <div class="flex gap-3">
            <a href="<?php echo e(route('kesiswaan.keterlambatan.edit', $keterlambatan->id)); ?>" 
               class="px-6 py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-lg hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300 flex items-center gap-2">
                <i class="fas fa-edit"></i>
                Edit Data
            </a>
            
            <button onclick="confirmDelete()" 
                    class="px-6 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-300 flex items-center gap-2">
                <i class="fas fa-trash"></i>
                Hapus
            </button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-sm mx-4">
        <div class="flex items-center mb-4">
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-medium text-gray-900">Hapus Data</h3>
            </div>
        </div>
        <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menghapus data keterlambatan ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex justify-end space-x-3">
            <button onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                Batal
            </button>
            <form action="<?php echo e(route('kesiswaan.keterlambatan.destroy', $keterlambatan->id)); ?>" method="POST" class="inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function confirmDelete() {
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kesiswaan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views\kesiswaan\keterlambatan\show.blade.php ENDPATH**/ ?>