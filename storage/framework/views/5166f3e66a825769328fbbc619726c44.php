

<?php $__env->startSection('title', 'Data Keterlambatan Siswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Data Keterlambatan Siswa</h1>
                <p class="text-gray-600 mt-1">Kelola data siswa yang terlambat apel pagi</p>
            </div>
            <div class="flex gap-3">
                <a href="<?php echo e(route('kesiswaan.keterlambatan.rekap')); ?>" class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-300 flex items-center gap-2 shadow-sm">
                    <i class="fas fa-file-excel"></i>
                    <span>Rekap dan Export</span>
                </a>
                <a href="<?php echo e(route('kesiswaan.keterlambatan.create')); ?>" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 flex items-center gap-2 shadow-sm">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Data</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-3 sm:p-4 mb-4 border border-gray-100">
        <form method="GET" class="flex flex-wrap items-center gap-2 sm:gap-3">
            <input type="date" name="tanggal_mulai" value="<?php echo e(request('tanggal_mulai')); ?>" 
                   placeholder="Tanggal Mulai"
                   class="flex-1 min-w-[120px] px-2 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            
            <input type="date" name="tanggal_akhir" value="<?php echo e(request('tanggal_akhir')); ?>" 
                   placeholder="Tanggal Akhir"
                   class="flex-1 min-w-[120px] px-2 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            
            <select name="kelas_id" class="flex-1 min-w-[100px] px-2 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                <option value="">Semua Kelas</option>
                <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($k->id); ?>" <?php echo e(request('kelas_id') == $k->id ? 'selected' : ''); ?>><?php echo e($k->nama_kelas); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            
            <div class="flex gap-1 sm:gap-2">
                <button type="submit" class="bg-blue-500 text-white px-3 py-1.5 rounded-lg hover:bg-blue-600 transition-colors flex items-center gap-1 text-sm">
                    <i class="fas fa-search text-xs"></i>
                    <span class="hidden sm:inline">Filter</span>
                </button>
                <a href="<?php echo e(route('kesiswaan.keterlambatan.index')); ?>" class="bg-gray-500 text-white px-2.5 py-1.5 rounded-lg hover:bg-gray-600 transition-colors flex items-center justify-center">
                    <i class="fas fa-undo text-xs"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Filter Info -->
    <?php if($filterInfo['is_default_filter']): ?>
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4 rounded-r-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-400"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    <strong>Menampilkan data 3 bulan terakhir</strong> 
                    (<?php echo e(\Carbon\Carbon::parse($filterInfo['tanggal_mulai'])->format('d M Y')); ?> - <?php echo e(\Carbon\Carbon::parse($filterInfo['tanggal_akhir'])->format('d M Y')); ?>)
                    <br>
                    <span class="text-xs">Gunakan filter tanggal di atas untuk melihat periode lain</span>
                </p>
            </div>
        </div>
    </div>
    <?php elseif(request('tanggal_mulai') || request('tanggal_akhir')): ?>
    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4 rounded-r-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-filter text-green-400"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700">
                    <strong>Filter aktif:</strong> 
                    <?php if(request('tanggal_mulai') && request('tanggal_akhir')): ?>
                        <?php echo e(\Carbon\Carbon::parse(request('tanggal_mulai'))->format('d M Y')); ?> - <?php echo e(\Carbon\Carbon::parse(request('tanggal_akhir'))->format('d M Y')); ?>

                    <?php elseif(request('tanggal_mulai')): ?>
                        Dari <?php echo e(\Carbon\Carbon::parse(request('tanggal_mulai'))->format('d M Y')); ?>

                    <?php elseif(request('tanggal_akhir')): ?>
                        Sampai <?php echo e(\Carbon\Carbon::parse(request('tanggal_akhir'))->format('d M Y')); ?>

                    <?php endif; ?>
                    <?php if(request('kelas_id')): ?>
                        | Kelas: <?php echo e($kelas->where('id', request('kelas_id'))->first()->nama_kelas ?? 'N/A'); ?>

                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-3 sm:p-6 border-b border-gray-100">
            <h3 class="text-base sm:text-lg font-semibold text-gray-800">Daftar Keterlambatan</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-2 py-2 sm:px-6 sm:py-4 text-center text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-2 py-2 sm:px-6 sm:py-4 text-center text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-2 py-2 sm:px-6 sm:py-4 text-center text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-2 py-2 sm:px-6 sm:py-4 text-center text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-2 py-2 sm:px-6 sm:py-4 text-center text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $keterlambatanBatch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 py-2 sm:px-6 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 text-center">
                                <?php echo e($loop->iteration); ?>

                            </td>
                            <td class="px-2 py-2 sm:px-6 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="font-medium"><?php echo e($batch->tanggal->format('d/m/Y')); ?></span>
                                    <span class="text-xs text-gray-500 hidden sm:block"><?php echo e($batch->created_at->format('H:i')); ?></span>
                                </div>
                            </td>
                            <td class="px-2 py-2 sm:px-6 sm:py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2 py-0.5 sm:px-3 sm:py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-users text-xs mr-1 hidden sm:inline"></i>
                                    <?php echo e($batch->jumlah_siswa); ?>

                                    <span class="hidden sm:inline ml-1">siswa</span>
                                </span>
                            </td>
                            <td class="px-2 py-2 sm:px-6 sm:py-4 whitespace-nowrap text-center">
                                <?php if($batch->status_umum == 'belum_ditindak'): ?>
                                    <span class="inline-flex items-center px-2 py-1 sm:px-2.5 sm:py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <span class="block sm:hidden">Belum</span>
                                        <span class="hidden sm:inline">Belum Ditindak</span>
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2 py-1 sm:px-2.5 sm:py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="block sm:hidden">Sudah</span>
                                        <span class="hidden sm:inline">Sudah Ditindak</span>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-2 py-2 sm:px-6 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-center">
                                <div class="flex items-center justify-center space-x-1 sm:space-x-2">
                                    <button onclick="toggleBatchDetail(<?php echo e($loop->iteration); ?>)" 
                                            class="text-blue-600 hover:text-blue-900 transition-colors p-1" 
                                            title="Detail">
                                        <i class="fas fa-chevron-down text-xs" id="toggle-icon-<?php echo e($loop->iteration); ?>"></i>
                                    </button>
                                    <a href="<?php echo e(route('kesiswaan.keterlambatan.editBatch', [$batch->tanggal->format('Y-m-d'), $batch->petugas->id ?? 'null', $batch->created_at->format('Y-m-d H:i:s')])); ?>" 
                                       class="text-indigo-600 hover:text-indigo-900 transition-colors p-1" 
                                       title="Edit">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <button onclick="confirmDeleteBatch('<?php echo e($batch->tanggal->format('Y-m-d')); ?>', '<?php echo e($batch->petugas->id ?? 'null'); ?>', '<?php echo e($batch->created_at->format('Y-m-d H:i:s')); ?>')" 
                                            class="text-red-600 hover:text-red-900 transition-colors p-1" 
                                            title="Hapus">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Detail Siswa Row (Hidden by default) -->
                        <tr id="batch-detail-<?php echo e($loop->iteration); ?>" class="hidden bg-blue-50">
                            <td colspan="5" class="px-2 py-2 sm:px-6 sm:py-4">
                                <div class="space-y-2">
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">Detail Siswa (<?php echo e($batch->jumlah_siswa); ?> orang):</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 sm:gap-4">
                                        <?php $__currentLoopData = $batch->siswa_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $siswa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="bg-white rounded-lg p-2 sm:p-3 border border-blue-200">
                                            <div class="flex items-center justify-between mb-1 sm:mb-2">
                                                <div class="flex items-center flex-1 min-w-0">
                                                    <div class="h-6 w-6 sm:h-8 sm:w-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-xs mr-2 flex-shrink-0">
                                                        <?php echo e(substr($siswa['nama'], 0, 2)); ?>

                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <div class="text-xs sm:text-sm font-medium text-gray-900 truncate"><?php echo e($siswa['nama']); ?></div>
                                                        <div class="text-xs text-gray-500"><?php echo e($siswa['nis']); ?> • <?php echo e($siswa['kelas']); ?></div>
                                                    </div>
                                                </div>
                                                <div class="text-right flex-shrink-0 ml-2">
                                                    <div class="text-xs font-medium text-orange-600"><?php echo e($siswa['jam_terlambat']); ?></div>
                                                    <a href="<?php echo e(route('kesiswaan.keterlambatan.show', $siswa['id'])); ?>" 
                                                       class="text-xs text-blue-600 hover:text-blue-800">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="text-xs text-gray-600 truncate" title="<?php echo e($siswa['alasan_terlambat']); ?>">
                                                <?php echo e($siswa['alasan_terlambat']); ?>

                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-2 py-6 sm:px-6 sm:py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-clock text-2xl sm:text-4xl text-gray-300 mb-2 sm:mb-4"></i>
                                    <p class="text-sm sm:text-lg font-medium mb-1 sm:mb-2">Belum Ada Data Keterlambatan</p>
                                    <p class="text-xs sm:text-sm">Data keterlambatan siswa akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination dihapus - menampilkan semua data -->
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
            <form id="deleteForm" method="POST" class="inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteBatchModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md mx-4 shadow-xl">
        <div class="flex items-center mb-4">
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus Batch</h3>
                <p class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
        </div>
        <div class="mb-6">
            <p class="text-sm text-gray-700">Apakah Anda yakin ingin menghapus seluruh batch keterlambatan ini? Semua data siswa dalam batch ini akan dihapus.</p>
        </div>
        <div class="flex justify-end space-x-3">
            <button onclick="closeDeleteBatchModal()" 
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Batal
            </button>
            <form id="deleteBatchForm" method="POST" class="inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                    Hapus Batch
                </button>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function confirmDelete(id) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    form.action = `<?php echo e(route('kesiswaan.keterlambatan.index')); ?>/${id}`;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function toggleBatchDetail(batchIndex) {
    const detailRow = document.getElementById('batch-detail-' + batchIndex);
    const toggleIcon = document.getElementById('toggle-icon-' + batchIndex);
    
    if (detailRow.classList.contains('hidden')) {
        detailRow.classList.remove('hidden');
        toggleIcon.classList.remove('fa-chevron-down');
        toggleIcon.classList.add('fa-chevron-up');
    } else {
        detailRow.classList.add('hidden');
        toggleIcon.classList.remove('fa-chevron-up');
        toggleIcon.classList.add('fa-chevron-down');
    }
}

function confirmDeleteBatch(tanggal, petugasId, createdAt) {
    const modal = document.getElementById('deleteBatchModal');
    const form = document.getElementById('deleteBatchForm');
    
    // Set action URL untuk delete batch
    const baseUrl = '<?php echo e(url("kesiswaan/keterlambatan")); ?>';
    form.action = `${baseUrl}/batch/${tanggal}/${petugasId}/${encodeURIComponent(createdAt)}`;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteBatchModal() {
    const modal = document.getElementById('deleteBatchModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('deleteBatchModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteBatchModal();
            }
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kesiswaan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views/kesiswaan/keterlambatan/index.blade.php ENDPATH**/ ?>