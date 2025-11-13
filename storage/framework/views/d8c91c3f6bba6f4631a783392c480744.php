

<?php $__env->startSection('page-title', 'Tunggakan Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-exclamation-triangle text-red-600 mr-3"></i>
                Tunggakan Pembayaran
            </h1>
            <p class="text-gray-600 mt-1">Monitoring dan tindak lanjut tunggakan pembayaran siswa</p>
        </div>
        
        <div class="mt-4 md:mt-0 flex space-x-3">
            <button class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200 shadow-sm">
                <i class="fas fa-bell mr-2"></i>
                Kirim Peringatan
            </button>
            <button class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>
                Export Tunggakan
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-r from-red-500 to-red-600 p-6 rounded-xl text-white shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-red-100">Total Tunggakan</h3>
                    <p class="text-2xl font-bold mt-1"><?php echo e($tunggakan->total() ?? 0); ?></p>
                </div>
                <div class="w-12 h-12 bg-red-400/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6 rounded-xl text-white shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-orange-100">Nominal Tunggakan</h3>
                    <p class="text-2xl font-bold mt-1">Rp <?php echo e(number_format(($tunggakan->sum('nominal') ?? 0), 0, ',', '.')); ?></p>
                </div>
                <div class="w-12 h-12 bg-orange-400/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-6 rounded-xl text-white shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-yellow-100">Terlambat 30+ Hari</h3>
                    <p class="text-2xl font-bold mt-1"><?php echo e($tunggakan->where('tanggal_jatuh_tempo', '<', now()->subDays(30))->count() ?? 0); ?></p>
                </div>
                <div class="w-12 h-12 bg-yellow-400/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 rounded-xl text-white shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-purple-100">Butuh Tindakan</h3>
                    <p class="text-2xl font-bold mt-1"><?php echo e($tunggakan->where('tanggal_jatuh_tempo', '<', now()->subDays(60))->count() ?? 0); ?></p>
                </div>
                <div class="w-12 h-12 bg-purple-400/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-bullhorn text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Priority Alert -->
    <?php if($tunggakan->where('tanggal_jatuh_tempo', '<', now()->subDays(60))->count() > 0): ?>
    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Perhatian! Tunggakan Kritis</h3>
                <div class="mt-2 text-sm text-red-700">
                    <p>Ada <strong><?php echo e($tunggakan->where('tanggal_jatuh_tempo', '<', now()->subDays(60))->count()); ?></strong> siswa dengan tunggakan lebih dari 60 hari. Segera lakukan tindakan follow up.</p>
                </div>
                <div class="mt-4">
                    <div class="flex space-x-2">
                        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition-colors duration-200">
                            <i class="fas fa-phone mr-2"></i>
                            Hubungi Orang Tua
                        </button>
                        <button class="bg-red-100 hover:bg-red-200 text-red-800 px-4 py-2 rounded-lg text-sm transition-colors duration-200">
                            <i class="fas fa-envelope mr-2"></i>
                            Kirim Surat Peringatan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Filter & Search -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Siswa</label>
                <div class="relative">
                    <input type="text" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" placeholder="Nama siswa atau NIS...">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    <option value="">Semua Kelas</option>
                    <option value="X TKR 1">X TKR 1</option>
                    <option value="X TKR 2">X TKR 2</option>
                    <option value="XI TKR 1">XI TKR 1</option>
                    <option value="XII TKR 1">XII TKR 1</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lama Tunggakan</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    <option value="">Semua Periode</option>
                    <option value="7">1 Minggu</option>
                    <option value="30">1 Bulan</option>
                    <option value="60">2 Bulan</option>
                    <option value="90">3 Bulan+</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Tunggakan</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    <option value="">Semua Jumlah</option>
                    <option value="low">&lt; Rp 500.000</option>
                    <option value="medium">Rp 500.000 - 1.000.000</option>
                    <option value="high">&gt; Rp 1.000.000</option>
                </select>
            </div>
        </div>
        
        <div class="mt-4 flex justify-end space-x-2">
            <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
                <i class="fas fa-redo mr-2"></i>
                Reset Filter
            </button>
            <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200">
                <i class="fas fa-search mr-2"></i>
                Cari Data
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Tunggakan</h2>
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <span>Menampilkan <?php echo e($tunggakan->firstItem() ?? 0); ?> - <?php echo e($tunggakan->lastItem() ?? 0); ?> dari <?php echo e($tunggakan->total() ?? 0); ?> data</span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tagihan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nominal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lama Tunggakan</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $tunggakan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo e(($tunggakan->currentPage() - 1) * $tunggakan->perPage() + $loop->iteration); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-red-400 to-red-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">
                                        <?php echo e(substr($item->siswa->nama ?? 'S', 0, 1)); ?>

                                    </span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($item->siswa->nama ?? 'Nama Siswa'); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($item->siswa->nis ?? '12345678'); ?> • <?php echo e($item->kelas->nama_kelas ?? 'X TKR 1'); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($item->nama_tagihan ?? 'SPP Bulan September'); ?></div>
                            <div class="text-sm text-gray-500"><?php echo e($item->periode ?? '2024-09'); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-600">
                            Rp <?php echo e(number_format($item->nominal ?? 350000, 0, ',', '.')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo e(\Carbon\Carbon::parse($item->tanggal_jatuh_tempo ?? now()->subDays(30))->format('d/m/Y')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php
                                $jatuhTempo = \Carbon\Carbon::parse($item->tanggal_jatuh_tempo ?? now()->subDays(30));
                                $lamaHari = $jatuhTempo->diffInDays(now());
                                
                                if ($lamaHari < 7) {
                                    $badgeClass = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                                    $priority = 'Rendah';
                                } elseif ($lamaHari < 30) {
                                    $badgeClass = 'bg-orange-100 text-orange-800 border-orange-200';
                                    $priority = 'Sedang';
                                } elseif ($lamaHari < 60) {
                                    $badgeClass = 'bg-red-100 text-red-800 border-red-200';
                                    $priority = 'Tinggi';
                                } else {
                                    $badgeClass = 'bg-purple-100 text-purple-800 border-purple-200';
                                    $priority = 'Kritis';
                                }
                            ?>
                            
                            <div class="space-y-1">
                                <div class="text-sm font-semibold text-red-600"><?php echo e($lamaHari); ?> hari</div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium border <?php echo e($badgeClass); ?>">
                                    <?php echo e($priority); ?>

                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <button class="text-green-600 hover:text-green-800 p-1.5 rounded-lg hover:bg-green-50 transition-colors" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-blue-600 hover:text-blue-800 p-1.5 rounded-lg hover:bg-blue-50 transition-colors" title="Kirim Peringatan">
                                    <i class="fas fa-bell"></i>
                                </button>
                                <button class="text-purple-600 hover:text-purple-800 p-1.5 rounded-lg hover:bg-purple-50 transition-colors" title="Hubungi Ortu">
                                    <i class="fas fa-phone"></i>
                                </button>
                                <button class="text-orange-600 hover:text-orange-800 p-1.5 rounded-lg hover:bg-orange-50 transition-colors" title="Buat Reminder">
                                    <i class="fas fa-calendar-plus"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-check-circle text-2xl text-green-500"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada tunggakan!</h3>
                                <p class="text-gray-500 mb-4">Semua pembayaran siswa sudah lunas atau belum jatuh tempo</p>
                                <div class="flex space-x-2">
                                    <a href="<?php echo e(route('tata-usaha.keuangan.tagihan')); ?>" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                                        <i class="fas fa-file-invoice mr-2"></i>
                                        Lihat Semua Tagihan
                                    </a>
                                    <a href="<?php echo e(route('tata-usaha.keuangan.pembayaran')); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                        <i class="fas fa-credit-card mr-2"></i>
                                        Riwayat Pembayaran
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if($tunggakan->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-200">
            <?php echo e($tunggakan->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Auto refresh untuk update status tunggakan
    setInterval(function() {
        // Update timer atau status jika diperlukan
    }, 60000);

    // Notification system untuk peringatan kritis
    document.addEventListener('DOMContentLoaded', function() {
        const kritisCount = <?php echo e($tunggakan->where('tanggal_jatuh_tempo', '<', now()->subDays(60))->count() ?? 0); ?>;
        
        if (kritisCount > 0) {
            // Show browser notification if permitted
            if (Notification.permission === 'granted') {
                new Notification(`Peringatan Tunggakan Kritis!`, {
                    body: `${kritisCount} siswa memiliki tunggakan lebih dari 60 hari`,
                    icon: '/favicon.ico'
                });
            }
        }
    });

    // Request notification permission
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission();
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.tata_usaha', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views\tata_usaha\keuangan\tunggakan.blade.php ENDPATH**/ ?>