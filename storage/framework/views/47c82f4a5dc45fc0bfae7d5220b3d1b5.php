

<?php $__env->startSection('title', 'Pelanggaran Siswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header & Stats -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-exclamation-triangle mr-3 text-red-600"></i>
                    Pelanggaran Siswa
                </h1>
                <p class="text-gray-600 mt-1">Kelola data pelanggaran dan sanksi siswa</p>
            </div>
            
            <div class="flex items-center space-x-3">
                <a href="<?php echo e(route('kesiswaan.pelanggaran.create')); ?>" 
                   class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Pelanggaran
                </a>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-6">
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-chart-bar text-blue-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-600 font-medium">Total</p>
                        <p class="text-xl font-bold text-blue-900"><?php echo e($stats['total']); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-calendar-day text-green-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-600 font-medium">Hari Ini</p>
                        <p class="text-xl font-bold text-green-900"><?php echo e($stats['hari_ini']); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fas fa-calendar-alt text-yellow-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-600 font-medium">Bulan Ini</p>
                        <p class="text-xl font-bold text-yellow-900"><?php echo e($stats['bulan_ini']); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                <div class="flex items-center">
                    <div class="p-2 bg-red-100 rounded-lg">
                        <i class="fas fa-exclamation-circle text-red-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-600 font-medium">Belum Selesai</p>
                        <p class="text-xl font-bold text-red-900"><?php echo e($stats['belum_selesai']); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-fire text-purple-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-purple-600 font-medium">Sangat Tinggi</p>
                        <p class="text-xl font-bold text-purple-900"><?php echo e($stats['sangat_tinggi']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Siswa/Pelanggaran</label>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                           placeholder="Nama siswa, NIS, atau jenis pelanggaran..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                </div>

                <!-- Filter Kelas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                    <select name="kelas" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">Semua Kelas</option>
                        <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k->id); ?>" <?php echo e(request('kelas') == $k->id ? 'selected' : ''); ?>>
                                <?php echo e($k->nama_kelas); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Filter Kategori -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select name="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">Semua Kategori</option>
                        <option value="ringan" <?php echo e(request('kategori') == 'ringan' ? 'selected' : ''); ?>>Ringan</option>
                        <option value="sedang" <?php echo e(request('kategori') == 'sedang' ? 'selected' : ''); ?>>Sedang</option>
                        <option value="berat" <?php echo e(request('kategori') == 'berat' ? 'selected' : ''); ?>>Berat</option>
                    </select>
                </div>

                <!-- Filter Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Sanksi</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">Semua Status</option>
                        <option value="belum_selesai" <?php echo e(request('status') == 'belum_selesai' ? 'selected' : ''); ?>>Belum Selesai</option>
                        <option value="sedang_proses" <?php echo e(request('status') == 'sedang_proses' ? 'selected' : ''); ?>>Sedang Proses</option>
                        <option value="selesai" <?php echo e(request('status') == 'selesai' ? 'selected' : ''); ?>>Selesai</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Filter Urgensi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tingkat Urgensi</label>
                    <select name="urgensi" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">Semua Urgensi</option>
                        <option value="rendah" <?php echo e(request('urgensi') == 'rendah' ? 'selected' : ''); ?>>Rendah</option>
                        <option value="sedang" <?php echo e(request('urgensi') == 'sedang' ? 'selected' : ''); ?>>Sedang</option>
                        <option value="tinggi" <?php echo e(request('urgensi') == 'tinggi' ? 'selected' : ''); ?>>Tinggi</option>
                        <option value="sangat_tinggi" <?php echo e(request('urgensi') == 'sangat_tinggi' ? 'selected' : ''); ?>>Sangat Tinggi</option>
                    </select>
                </div>

                <!-- Filter Tanggal Dari -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Dari</label>
                    <input type="date" name="tanggal_dari" value="<?php echo e(request('tanggal_dari')); ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                </div>

                <!-- Filter Tanggal Sampai -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai" value="<?php echo e(request('tanggal_sampai')); ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <i class="fas fa-search mr-2"></i>
                    Filter Data
                </button>
                <a href="<?php echo e(route('kesiswaan.pelanggaran.index')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Reset Filter
                </a>
                <button type="button" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-download mr-2"></i>
                    Export Excel
                </button>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-lg font-semibold text-gray-900">
                    Daftar Pelanggaran 
                    <span class="text-sm font-normal text-gray-500">(<?php echo e($pelanggarans->total()); ?> data)</span>
                </h3>
                
                <!-- Sorting -->
                <div class="flex items-center space-x-2">
                    <label class="text-sm text-gray-600">Urutkan:</label>
                    <select onchange="window.location.href=this.value" class="text-sm border border-gray-300 rounded px-2 py-1">
                        <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => 'desc'])); ?>" 
                                <?php echo e(request('sort') == 'created_at' && request('direction') == 'desc' ? 'selected' : ''); ?>>
                            Terbaru
                        </option>
                        <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'tanggal_pelanggaran', 'direction' => 'desc'])); ?>" 
                                <?php echo e(request('sort') == 'tanggal_pelanggaran' && request('direction') == 'desc' ? 'selected' : ''); ?>>
                            Tanggal Pelanggaran
                        </option>
                        <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'siswa', 'direction' => 'asc'])); ?>" 
                                <?php echo e(request('sort') == 'siswa' ? 'selected' : ''); ?>>
                            Nama Siswa A-Z
                        </option>
                        <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'tingkat_urgensi', 'direction' => 'desc'])); ?>" 
                                <?php echo e(request('sort') == 'tingkat_urgensi' ? 'selected' : ''); ?>>
                            Urgensi Tertinggi
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <?php if($pelanggarans->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urgensi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sanksi</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $pelanggarans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pelanggaran): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                                                <i class="fas fa-user text-red-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?php echo e($pelanggaran->siswa->nama_lengkap); ?></div>
                                            <div class="text-sm text-gray-500"><?php echo e($pelanggaran->siswa->nis); ?> - <?php echo e($pelanggaran->siswa->kelas->nama_kelas ?? 'N/A'); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($pelanggaran->jenisPelanggaran->nama_pelanggaran); ?></div>
                                    <div class="text-sm text-gray-500">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($pelanggaran->jenisPelanggaran->kategori_badge_color); ?>">
                                            <?php echo e(ucfirst($pelanggaran->jenisPelanggaran->kategori)); ?>

                                        </span>
                                        • <?php echo e($pelanggaran->jenisPelanggaran->poin_pelanggaran); ?> poin
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?php echo e($pelanggaran->tanggal_pelanggaran->format('d/m/Y')); ?></div>
                                    <?php if($pelanggaran->jam_pelanggaran): ?>
                                        <div class="text-sm text-gray-500"><?php echo e($pelanggaran->jam_pelanggaran); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($pelanggaran->status_badge_color); ?>">
                                        <?php echo e(str_replace('_', ' ', ucfirst($pelanggaran->status_sanksi))); ?>

                                    </span>
                                    <?php if($pelanggaran->tanggal_selesai_sanksi): ?>
                                        <div class="text-xs text-gray-500 mt-1">
                                            Selesai: <?php echo e($pelanggaran->tanggal_selesai_sanksi->format('d/m/Y')); ?>

                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($pelanggaran->urgensi_badge_color); ?>">
                                        <?php echo e(str_replace('_', ' ', ucwords($pelanggaran->tingkat_urgensi))); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs truncate"><?php echo e($pelanggaran->sanksi_diberikan); ?></div>
                                    <?php if(!$pelanggaran->sudah_dihubungi_ortu): ?>
                                        <div class="flex items-center mt-1">
                                            <i class="fas fa-exclamation-triangle text-yellow-500 text-xs mr-1"></i>
                                            <span class="text-xs text-yellow-600">Belum hubungi ortu</span>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="<?php echo e(route('kesiswaan.pelanggaran.show', $pelanggaran)); ?>" 
                                           class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('kesiswaan.pelanggaran.edit', $pelanggaran)); ?>" 
                                           class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="deletePelanggaran(<?php echo e($pelanggaran->id); ?>)" 
                                                class="text-red-600 hover:text-red-900" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                <?php echo e($pelanggarans->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-exclamation-triangle text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Data Pelanggaran</h3>
                <p class="text-gray-600 mb-4">
                    <?php if(request()->hasAny(['search', 'kelas', 'kategori', 'status', 'urgensi', 'tanggal_dari', 'tanggal_sampai'])): ?>
                        Tidak ditemukan data pelanggaran dengan filter yang dipilih.
                    <?php else: ?>
                        Belum ada data pelanggaran siswa yang tercatat.
                    <?php endif; ?>
                </p>
                <?php if(request()->hasAny(['search', 'kelas', 'kategori', 'status', 'urgensi', 'tanggal_dari', 'tanggal_sampai'])): ?>
                    <a href="<?php echo e(route('kesiswaan.pelanggaran.index')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Reset Filter
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('kesiswaan.pelanggaran.create')); ?>" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Pelanggaran Pertama
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Hapus Data Pelanggaran</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin menghapus data pelanggaran ini? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form id="deleteForm" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 mr-2">
                        Hapus
                    </button>
                </form>
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function deletePelanggaran(id) {
    document.getElementById('deleteForm').action = `/kesiswaan/pelanggaran/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.kesiswaan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views\kesiswaan\pelanggaran\index.blade.php ENDPATH**/ ?>