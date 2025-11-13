

<?php $__env->startSection('title', 'Data Keterlambatan Siswa - ' . $kelas->nama_kelas); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Data Keterlambatan Siswa</h1>
                <p class="text-gray-600 mt-1">Kelola data siswa yang terlambat - Kelas <?php echo e($kelas->nama_kelas); ?></p>
            </div>
            <div class="flex gap-3">
                <a href="<?php echo e(route('guru.wali-kelas.keterlambatan.rekap')); ?>" class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-300 flex items-center gap-2 shadow-sm">
                    <i class="fas fa-file-excel"></i>
                    <span>Export</span>
                </a>
                <a href="<?php echo e(route('guru.wali-kelas.dashboard')); ?>" class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-4 py-2 rounded-lg hover:from-gray-600 hover:to-gray-700 transition-all duration-300 flex items-center gap-2 shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                    <span>Dashboard</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-4 rounded-xl shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-90">Hari Ini</h3>
                    <p class="text-2xl font-bold"><?php echo e($keterlambatanHariIni); ?></p>
                    <p class="text-xs opacity-75">Keterlambatan</p>
                </div>
                <div class="bg-red-400 bg-opacity-30 p-3 rounded-full">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white p-4 rounded-xl shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-90">Bulan Ini</h3>
                    <p class="text-2xl font-bold"><?php echo e($totalKeterlambatan); ?></p>
                    <p class="text-xs opacity-75">Total Keterlambatan</p>
                </div>
                <div class="bg-orange-400 bg-opacity-30 p-3 rounded-full">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-4 rounded-xl shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-90">Siswa Terlambat</h3>
                    <p class="text-2xl font-bold"><?php echo e($siswaTerlambatBulanIni); ?></p>
                    <p class="text-xs opacity-75">Bulan Ini</p>
                </div>
                <div class="bg-yellow-400 bg-opacity-30 p-3 rounded-full">
                    <i class="fas fa-users text-xl"></i>
                </div>
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
            
            <select name="status" class="flex-1 min-w-[100px] px-2 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                <option value="">Semua Status</option>
                <option value="belum_ditindak" <?php echo e(request('status') == 'belum_ditindak' ? 'selected' : ''); ?>>Belum Di Tindak</option>
                <option value="sudah_ditindak" <?php echo e(request('status') == 'sudah_ditindak' ? 'selected' : ''); ?>>Sudah Di Tindak</option>
            </select>
            
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                   placeholder="Cari siswa..."
                   class="flex-1 min-w-[150px] px-2 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            
            <div class="flex gap-1 sm:gap-2">
                <button type="submit" class="bg-blue-500 text-white px-3 py-1.5 rounded-lg hover:bg-blue-600 transition-colors flex items-center gap-1 text-sm">
                    <i class="fas fa-search text-xs"></i>
                    <span class="hidden sm:inline">Filter</span>
                </button>
                <a href="<?php echo e(route('guru.wali-kelas.keterlambatan.index')); ?>" class="bg-gray-500 text-white px-2.5 py-1.5 rounded-lg hover:bg-gray-600 transition-colors flex items-center justify-center">
                    <i class="fas fa-undo text-xs"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Keterlambatan</h3>
            <p class="text-gray-600 text-sm">Total: <?php echo e($keterlambatan->total()); ?> data keterlambatan</p>
        </div>

        <?php if($keterlambatan->count() > 0): ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Terlambat</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Petugas</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $keterlambatan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-900"><?php echo e(($keterlambatan->currentPage() - 1) * $keterlambatan->perPage() + $loop->iteration); ?></td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            <?php echo e(\Carbon\Carbon::parse($item->tanggal)->format('d M Y')); ?>

                        </td>
                        <td class="px-4 py-3">
                            <div>
                                <div class="text-sm font-medium text-gray-900"><?php echo e($item->siswa->nama_lengkap); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($item->siswa->nis); ?></div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900"><?php echo e($item->jam_terlambat); ?></td>
                        <td class="px-4 py-3 text-sm text-gray-900"><?php echo e($item->alasan_terlambat ?? '-'); ?></td>
                        <td class="px-4 py-3 text-center">
                            <?php if($item->status == 'belum_ditindak'): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Belum Di Tindak
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Sudah Di Tindak
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900">
                            <?php echo e($item->petugas->nama ?? 'Sistem'); ?>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-4 py-3 border-t border-gray-100">
            <?php echo e($keterlambatan->links()); ?>

        </div>
        <?php else: ?>
        <div class="text-center py-8">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-clock text-4xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data keterlambatan</h3>
            <p class="text-gray-600">Belum ada data keterlambatan untuk kelas <?php echo e($kelas->nama_kelas); ?>.</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.guru', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views\guru\wali-kelas\keterlambatan\index.blade.php ENDPATH**/ ?>