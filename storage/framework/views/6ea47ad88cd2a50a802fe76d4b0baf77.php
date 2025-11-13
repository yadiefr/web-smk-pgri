

<?php $__env->startSection('page-header'); ?>
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan Keuangan</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Analisis dan monitoring laporan keuangan siswa secara komprehensif</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="<?php echo e(route('tata-usaha.index')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200 border border-gray-300 dark:border-gray-600">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
            <a href="<?php echo e(route('tata-usaha.export', ['tahun_ajaran' => $tahunAjaran, 'kelas_id' => $kelasId])); ?>" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                <i class="fas fa-file-excel mr-2"></i>
                Export Excel
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Filter Section -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
    <div class="flex items-center mb-6">
        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl mr-4">
            <i class="fas fa-filter text-blue-600 dark:text-blue-400 text-xl"></i>
        </div>
        <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Filter Laporan</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Pilih kriteria untuk menampilkan laporan yang diinginkan</p>
        </div>
    </div>
    
    <form action="<?php echo e(route('tata-usaha.laporan')); ?>" method="GET" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 items-end">
        <div>
            <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tahun Ajaran</label>
            <div class="relative">
                <select id="tahun_ajaran" name="tahun_ajaran" class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-gray-100">
                    <?php for($i = date('Y') - 3; $i <= date('Y'); $i++): ?>
                        <option value="<?php echo e($i); ?>" <?php echo e($tahunAjaran == $i ? 'selected' : ''); ?>><?php echo e($i); ?>/<?php echo e($i + 1); ?></option>
                    <?php endfor; ?>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
        </div>

        <div>
            <label for="kelas_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kelas</label>
            <div class="relative">
                <select id="kelas_id" name="kelas_id" class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-gray-100">
                    <option value="">Semua Kelas</option>
                    <?php $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($kelas->id); ?>" <?php echo e($kelasId == $kelas->id ? 'selected' : ''); ?>><?php echo e($kelas->nama_kelas); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
        </div>

        <div>
            <label for="periode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Periode</label>
            <div class="relative">
                <select id="periode" name="periode" class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-gray-100">
                    <option value="">Semua Periode</option>
                    <option value="bulan_ini">Bulan Ini</option>
                    <option value="3_bulan">3 Bulan Terakhir</option>
                    <option value="semester">Semester Ini</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
        </div>

        <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 font-medium">
            <i class="fas fa-search mr-2"></i>
            Filter Data
        </button>
    </form>
</div>

<!-- Statistics Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Tagihan Keseluruhan -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-file-invoice-dollar text-2xl"></i>
                </div>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold">Rp <?php echo e(number_format($tunggakanPerKelas->sum('total_tagihan') ?? 0, 0, ',', '.')); ?></p>
                <p class="text-blue-100 text-sm">Total Tagihan</p>
            </div>
        </div>
    </div>

    <!-- Total Terbayar -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold">Rp <?php echo e(number_format($tunggakanPerKelas->sum('total_bayar') ?? 0, 0, ',', '.')); ?></p>
                <p class="text-green-100 text-sm">Total Terbayar</p>
            </div>
        </div>
    </div>

    <!-- Total Tunggakan -->
    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-exclamation-triangle text-2xl"></i>
                </div>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold">Rp <?php echo e(number_format($tunggakanPerKelas->sum('tunggakan') ?? 0, 0, ',', '.')); ?></p>
                <p class="text-red-100 text-sm">Total Tunggakan</p>
            </div>
        </div>
    </div>

    <!-- Persentase Lunas -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-percentage text-2xl"></i>
                </div>
            </div>
            <div class="text-right">
                <?php
                    $totalTagihan = $tunggakanPerKelas->sum('total_tagihan');
                    $totalBayar = $tunggakanPerKelas->sum('total_bayar');
                    $persentaseLunas = $totalTagihan > 0 ? round(($totalBayar / $totalTagihan) * 100, 1) : 0;
                ?>
                <p class="text-3xl font-bold"><?php echo e($persentaseLunas); ?>%</p>
                <p class="text-purple-100 text-sm">Persentase Lunas</p>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Per Class -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-xl mr-4">
                <i class="fas fa-chart-pie text-purple-600 dark:text-purple-400 text-xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Statistik Pembayaran per Kelas</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Breakdown pembayaran berdasarkan kelas</p>
            </div>
        </div>
        <div class="text-sm text-gray-500 dark:text-gray-400">
            <i class="fas fa-calendar mr-1"></i>
            Tahun Ajaran <?php echo e($tahunAjaran); ?>/<?php echo e($tahunAjaran + 1); ?>

        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Tagihan</th>
                    <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Bayar</th>
                    <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tunggakan</th>
                    <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Progress</th>
                    <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                <?php $__empty_1 = true; $__currentLoopData = $tunggakanPerKelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-graduation-cap text-white"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100"><?php echo e($kelas); ?></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($data['jumlah_siswa'] ?? 0); ?> siswa</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 text-right font-medium">
                        Rp <?php echo e(number_format($data['total_tagihan'], 0, ',', '.')); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 dark:text-green-400 text-right font-semibold">
                        Rp <?php echo e(number_format($data['total_bayar'], 0, ',', '.')); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 dark:text-red-400 text-right font-semibold">
                        Rp <?php echo e(number_format($data['tunggakan'], 0, ',', '.')); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center justify-center">
                            <div class="w-32 bg-gray-200 dark:bg-gray-700 rounded-full h-3 mr-3">
                                <div class="bg-gradient-to-r from-green-500 to-green-600 h-3 rounded-full transition-all duration-500" 
                                     style="width: <?php echo e($data['persentase_bayar']); ?>%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 min-w-[3rem]"><?php echo e($data['persentase_bayar']); ?>%</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <?php if($data['persentase_bayar'] >= 90): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                <i class="fas fa-check-circle mr-1"></i>
                                Excellent
                            </span>
                        <?php elseif($data['persentase_bayar'] >= 70): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                <i class="fas fa-thumbs-up mr-1"></i>
                                Good
                            </span>
                        <?php elseif($data['persentase_bayar'] >= 50): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Fair
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                <i class="fas fa-times-circle mr-1"></i>
                                Poor
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-chart-pie text-4xl text-gray-300 dark:text-gray-600 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tidak Ada Data</h3>
                            <p class="text-gray-500 dark:text-gray-400">Tidak ada data statistik per kelas untuk periode yang dipilih</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Detailed Payment Data -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-xl mr-4">
                <i class="fas fa-table text-green-600 dark:text-green-400 text-xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Data Pembayaran Detail <?php echo e($kelasId ? '- ' . ($kelasList->firstWhere('id', $kelasId)->nama_kelas ?? '') : 'Semua Kelas'); ?>

                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Rincian transaksi pembayaran siswa</p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <button class="inline-flex items-center px-3 py-2 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                <i class="fas fa-print mr-2"></i>
                Print
            </button>
        </div>
    </div>
    
    <?php if($pembayaranPerKelas->isNotEmpty()): ?>
        <?php $__currentLoopData = $pembayaranPerKelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas => $pembayaran): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mb-10 last:mb-0">
                <div class="flex items-center justify-between bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50 px-6 py-4 rounded-lg mb-6 border border-gray-200 dark:border-gray-600">
                    <div class="flex items-center">
                        <div class="h-12 w-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-graduation-cap text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Kelas: <?php echo e($kelas); ?></h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($pembayaran->count()); ?> transaksi pembayaran</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-bold text-green-600 dark:text-green-400">
                            Rp <?php echo e(number_format($totalPerKelas[$kelas] ?? 0, 0, ',', '.')); ?>

                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Total Pembayaran</div>
                    </div>
                </div>
                
                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Siswa</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">NIS</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Keterangan</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <?php $__empty_1 = true; $__currentLoopData = $pembayaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
                                        <?php echo e(\Carbon\Carbon::parse($item->tanggal)->format('d M Y')); ?>

                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-white text-xs"></i>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            <?php echo e($item->siswa->nama_lengkap ?? 'Tidak ada data'); ?>

                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 font-mono">
                                    <?php echo e($item->siswa->nis ?? 'Tidak ada data'); ?>

                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                    <div class="max-w-xs">
                                        <?php echo e($item->keterangan); ?>

                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                    <div class="font-semibold text-green-600 dark:text-green-400 text-lg">
                                        Rp <?php echo e(number_format($item->jumlah, 0, ',', '.')); ?>

                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        <?php echo e($item->status); ?>

                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-receipt text-4xl text-gray-300 dark:text-gray-600 mb-4"></i>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tidak Ada Data Pembayaran</h3>
                                        <p class="text-gray-500 dark:text-gray-400">Belum ada transaksi pembayaran untuk kelas ini</p>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div class="text-center py-16">
            <div class="flex flex-col items-center">
                <i class="fas fa-search text-8xl text-gray-300 dark:text-gray-600 mb-6"></i>
                <h3 class="text-2xl font-medium text-gray-900 dark:text-white mb-4">Tidak Ada Data</h3>
                <p class="text-gray-500 dark:text-gray-400 text-lg mb-2">Tidak ada data pembayaran untuk periode yang dipilih.</p>
                <p class="text-gray-500 dark:text-gray-400">Silakan coba dengan filter yang berbeda atau hubungi administrator.</p>
                <div class="mt-6">
                    <button onclick="window.location.reload()" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Refresh Data
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh every 5 minutes
    setTimeout(function() {
        window.location.reload();
    }, 300000);
    
    // Add loading state to filter form
    document.querySelector('form').addEventListener('submit', function() {
        const button = this.querySelector('button[type="submit"]');
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memuat Data...';
        button.disabled = true;
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.tata_usaha', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views\tata_usaha\laporan.blade.php ENDPATH**/ ?>