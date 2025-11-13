

<?php $__env->startSection('title', 'Laporan Keterlambatan'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-4">
                <a href="<?php echo e(route('kesiswaan.keterlambatan.index')); ?>" 
                   class="text-gray-600 hover:text-gray-800 transition-colors">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Laporan Keterlambatan</h1>
                    <p class="text-gray-600 mt-1">Analisis dan statistik keterlambatan siswa</p>
                </div>
            </div>
            <div class="flex gap-3">
                <button onclick="window.print()" 
                        class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-4 py-2 rounded-lg hover:from-gray-600 hover:to-gray-700 transition-all duration-300 flex items-center gap-2 shadow-sm">
                    <i class="fas fa-print"></i>
                    <span>Print</span>
                </button>
                <a href="<?php echo e(route('kesiswaan.keterlambatan.create')); ?>" 
                   class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 flex items-center gap-2 shadow-sm">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Data</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Laporan</h3>
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="<?php echo e(request('tanggal_mulai')); ?>" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" value="<?php echo e(request('tanggal_akhir')); ?>" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                <select name="kelas_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Kelas</option>
                    <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($kelas->id); ?>"><?php echo e($kelas->nama_kelas); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="belum_ditindak" <?php echo e(request('status') == 'belum_ditindak' ? 'selected' : ''); ?>>Belum Ditindak</option>
                    <option value="sudah_ditindak" <?php echo e(request('status') == 'sudah_ditindak' ? 'selected' : ''); ?>>Sudah Ditindak</option>
                    <option value="selesai" <?php echo e(request('status') == 'selesai' ? 'selected' : ''); ?>>Selesai</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors flex items-center gap-2">
                    <i class="fas fa-search"></i>
                    Filter
                </button>
                <a href="<?php echo e(route('kesiswaan.keterlambatan.laporan')); ?>" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-undo"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Statistics Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Total Keterlambatan</h3>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($statistik['total'] ?? 0); ?></p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-users text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Belum Ditindak</h3>
                    <p class="text-2xl font-bold text-red-600"><?php echo e($statistik['belum_ditindak'] ?? 0); ?></p>
                </div>
                <div class="p-3 bg-red-100 rounded-full">
                    <i class="fas fa-exclamation-circle text-red-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Sudah Ditindak</h3>
                    <p class="text-2xl font-bold text-yellow-600"><?php echo e($statistik['sudah_ditindak'] ?? 0); ?></p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Selesai</h3>
                    <p class="text-2xl font-bold text-green-600"><?php echo e($statistik['selesai'] ?? 0); ?></p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Keterlambatan per Kelas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Keterlambatan per Kelas</h3>
            <?php if(count($keterlambatan_per_kelas) > 0): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $keterlambatan_per_kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                                <span class="text-sm font-medium text-gray-700"><?php echo e($item->kelas_nama); ?></span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-24 bg-gray-200 rounded-full h-2 mr-3">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: <?php echo e($statistik['total'] > 0 ? ($item->total / $statistik['total']) * 100 : 0); ?>%"></div>
                                </div>
                                <span class="text-sm font-semibold text-gray-900 w-8 text-right"><?php echo e($item->total); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-chart-bar text-3xl mb-2"></i>
                    <p>Belum ada data untuk ditampilkan</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Trend Keterlambatan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Trend Keterlambatan (7 Hari Terakhir)</h3>
            <?php if(count($trend_harian) > 0): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $trend_harian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-orange-500 rounded-full mr-3"></div>
                                <span class="text-sm font-medium text-gray-700"><?php echo e(\Carbon\Carbon::parse($item->tanggal)->format('d/m/Y')); ?></span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-24 bg-gray-200 rounded-full h-2 mr-3">
                                    <?php
                                        $max_daily = collect($trend_harian)->max('total');
                                        $percentage = $max_daily > 0 ? ($item->total / $max_daily) * 100 : 0;
                                    ?>
                                    <div class="bg-orange-500 h-2 rounded-full" style="width: <?php echo e($percentage); ?>%"></div>
                                </div>
                                <span class="text-sm font-semibold text-gray-900 w-8 text-right"><?php echo e($item->total); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-chart-line text-3xl mb-2"></i>
                    <p>Belum ada data untuk ditampilkan</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Top Siswa Terlambat -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Siswa dengan Keterlambatan Terbanyak</h3>
        <?php if(count($siswa_terlambat_terbanyak) > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Ranking</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Nama Siswa</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Kelas</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Total Keterlambatan</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Status Terakhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $__currentLoopData = $siswa_terlambat_terbanyak; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex items-center">
                                        <?php if($index == 0): ?>
                                            <i class="fas fa-trophy text-yellow-500 text-lg"></i>
                                        <?php elseif($index == 1): ?>
                                            <i class="fas fa-medal text-gray-400 text-lg"></i>
                                        <?php elseif($index == 2): ?>
                                            <i class="fas fa-award text-orange-500 text-lg"></i>
                                        <?php else: ?>
                                            <span class="w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center text-xs font-semibold"><?php echo e($index + 1); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-xs">
                                                <?php echo e(substr($item->siswa_nama, 0, 2)); ?>

                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900"><?php echo e($item->siswa_nama); ?></div>
                                            <div class="text-sm text-gray-500"><?php echo e($item->siswa_nis); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900"><?php echo e($item->kelas_nama); ?></td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <?php echo e($item->total); ?> kali
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <?php if($item->status_terakhir == 'belum_ditindak'): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Belum Ditindak
                                        </span>
                                    <?php elseif($item->status_terakhir == 'sudah_ditindak'): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Sudah Ditindak
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Selesai
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-users text-3xl mb-2"></i>
                <p>Belum ada data untuk ditampilkan</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Summary Information -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Periode</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="flex items-center mb-2">
                    <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                    <span class="font-medium text-gray-700">Periode Laporan</span>
                </div>
                <p class="text-gray-900">
                    <?php if(request('tanggal_mulai') && request('tanggal_akhir')): ?>
                        <?php echo e(\Carbon\Carbon::parse(request('tanggal_mulai'))->format('d/m/Y')); ?> - <?php echo e(\Carbon\Carbon::parse(request('tanggal_akhir'))->format('d/m/Y')); ?>

                    <?php else: ?>
                        Semua Data
                    <?php endif; ?>
                </p>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="flex items-center mb-2">
                    <i class="fas fa-school text-green-500 mr-2"></i>
                    <span class="font-medium text-gray-700">Filter Kelas</span>
                </div>
                <p class="text-gray-900">
                    <?php if(request('kelas_id')): ?>
                        <?php echo e($kelas->where('id', request('kelas_id'))->first()->nama_kelas ?? 'Tidak ditemukan'); ?>

                    <?php else: ?>
                        Semua Kelas
                    <?php endif; ?>
                </p>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="flex items-center mb-2">
                    <i class="fas fa-clock text-orange-500 mr-2"></i>
                    <span class="font-medium text-gray-700">Laporan Dibuat</span>
                </div>
                <p class="text-gray-900"><?php echo e(now()->format('d/m/Y H:i')); ?></p>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
@media print {
    .no-print { display: none !important; }
    body { -webkit-print-color-adjust: exact; }
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kesiswaan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views\kesiswaan\keterlambatan\laporan.blade.php ENDPATH**/ ?>