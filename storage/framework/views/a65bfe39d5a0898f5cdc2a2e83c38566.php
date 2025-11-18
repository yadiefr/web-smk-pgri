

<?php $__env->startSection('title', 'Laporan'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-chart-bar mr-3 text-blue-600"></i>
                Laporan
            </h1>
            <p class="text-gray-600 mt-1">Generate dan export berbagai laporan kesiswaan</p>
        </div>
    </div>

    <!-- Laporan Menu -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Laporan Absensi -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-clipboard-check text-green-600 text-2xl"></i>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Laporan Absensi</h3>
            <p class="text-gray-600 mb-4">Generate laporan kehadiran siswa berdasarkan periode tertentu</p>
            <a href="<?php echo e(route('kesiswaan.laporan.absensi')); ?>" 
               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-eye mr-2"></i>
                Lihat Laporan
            </a>
        </div>

        <!-- Laporan Kegiatan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-calendar-alt text-purple-600 text-2xl"></i>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Laporan Kegiatan</h3>
            <p class="text-gray-600 mb-4">Rekap kegiatan dan partisipasi siswa dalam berbagai acara</p>
            <a href="<?php echo e(route('kesiswaan.laporan.kegiatan')); ?>" 
               class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-eye mr-2"></i>
                Lihat Laporan
            </a>
        </div>

        <!-- Laporan Pelanggaran -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-red-100 rounded-full">
                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Laporan Pelanggaran</h3>
            <p class="text-gray-600 mb-4">Data pelanggaran dan sanksi yang diberikan kepada siswa</p>
            <a href="<?php echo e(route('kesiswaan.laporan.pelanggaran')); ?>" 
               class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                <i class="fas fa-eye mr-2"></i>
                Lihat Laporan
            </a>
        </div>
    </div>

    <!-- Quick Export -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-download mr-2 text-blue-600"></i>
            Export Cepat
        </h3>
        
        <form method="GET" action="<?php echo e(route('kesiswaan.laporan.export')); ?>" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="jenis" class="block text-sm font-medium text-gray-700 mb-1">Jenis Laporan</label>
                    <select name="jenis" id="jenis" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="absensi">Laporan Absensi</option>
                        <option value="kegiatan">Laporan Kegiatan</option>
                        <option value="pelanggaran">Laporan Pelanggaran</option>
                    </select>
                </div>
                
                <div>
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" 
                           name="tanggal_mulai" 
                           id="tanggal_mulai"
                           value="<?php echo e(now()->startOfMonth()->format('Y-m-d')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                    <input type="date" 
                           name="tanggal_selesai" 
                           id="tanggal_selesai"
                           value="<?php echo e(now()->endOfMonth()->format('Y-m-d')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="format" class="block text-sm font-medium text-gray-700 mb-1">Format</label>
                    <select name="format" id="format" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="excel">Excel (.xlsx)</option>
                        <option value="pdf">PDF (.pdf)</option>
                    </select>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-download mr-2"></i>
                    Export Laporan
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kesiswaan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views/kesiswaan/laporan/index.blade.php ENDPATH**/ ?>