

<?php $__env->startSection('title', 'Kegiatan Siswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-calendar-alt mr-3 text-blue-600"></i>
                    Kegiatan Siswa
                </h1>
                <p class="text-gray-600 mt-1">Kelola kegiatan dan agenda siswa</p>
            </div>
            
            <div class="flex items-center space-x-3">
                <a href="<?php echo e(route('kesiswaan.kegiatan.create')); ?>" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Kegiatan
                </a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="text-center">
            <i class="fas fa-calendar-alt text-6xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Kegiatan Siswa</h3>
            <p class="text-gray-600 mb-6">Fitur kegiatan siswa sedang dalam pengembangan</p>
            <div class="space-y-2 text-sm text-gray-500">
                <p>Fitur yang akan tersedia:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li>Manajemen kegiatan ekstrakurikuler</li>
                    <li>Penjadwalan acara sekolah</li>
                    <li>Monitoring partisipasi siswa</li>
                    <li>Laporan kegiatan</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kesiswaan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views\kesiswaan\kegiatan\index.blade.php ENDPATH**/ ?>