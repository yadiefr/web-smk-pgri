

<?php $__env->startSection('title', 'Detail Siswa - ' . $siswa->nama_lengkap); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <a href="<?php echo e(route('kesiswaan.siswa.index')); ?>" 
                   class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Daftar Siswa
                </a>
            </div>
            
            <div class="flex items-center space-x-3">
                <div class="flex items-center space-x-2">
                    <?php if($siswa->status_siswa == 'aktif'): ?>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>
                            Aktif
                        </span>
                    <?php elseif($siswa->status_siswa == 'nonaktif'): ?>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                            <i class="fas fa-times-circle mr-1"></i>
                            Nonaktif
                        </span>
                    <?php elseif($siswa->status_siswa == 'mutasi'): ?>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            <i class="fas fa-exchange-alt mr-1"></i>
                            Mutasi
                        </span>
                    <?php elseif($siswa->status_siswa == 'lulus'): ?>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                            <i class="fas fa-graduation-cap mr-1"></i>
                            Lulus
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-8 text-white">
            <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
                <div class="flex-shrink-0">
                    <?php if($siswa->foto): ?>
                        <img src="<?php echo e(asset('storage/siswa/' . $siswa->foto)); ?>" 
                             alt="<?php echo e($siswa->nama_lengkap); ?>" 
                             class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                    <?php else: ?>
                        <div class="w-24 h-24 rounded-full bg-white bg-opacity-20 flex items-center justify-center border-4 border-white shadow-lg">
                            <i class="fas fa-user text-white text-3xl"></i>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="text-center md:text-left flex-1">
                    <h1 class="text-3xl font-bold mb-2"><?php echo e($siswa->nama_lengkap); ?></h1>
                    <div class="flex flex-col md:flex-row md:items-center md:space-x-6 space-y-1 md:space-y-0 text-blue-100">
                        <div class="flex items-center justify-center md:justify-start">
                            <i class="fas fa-id-card mr-2"></i>
                            <span>NIS: <?php echo e($siswa->nis ?? '-'); ?></span>
                        </div>
                        <div class="flex items-center justify-center md:justify-start">
                            <i class="fas fa-hashtag mr-2"></i>
                            <span>NISN: <?php echo e($siswa->nisn ?? '-'); ?></span>
                        </div>
                        <?php if($siswa->kelas): ?>
                            <div class="flex items-center justify-center md:justify-start">
                                <i class="fas fa-graduation-cap mr-2"></i>
                                <span><?php echo e($siswa->kelas->nama_kelas); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Information -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Personal Information -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-user mr-3 text-blue-600"></i>
                        Informasi Personal
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg"><?php echo e($siswa->nama_lengkap ?? '-'); ?></p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                                <?php if($siswa->jenis_kelamin == 'L'): ?>
                                    <i class="fas fa-mars text-blue-500 mr-1"></i> Laki-laki
                                <?php elseif($siswa->jenis_kelamin == 'P'): ?>
                                    <i class="fas fa-venus text-pink-500 mr-1"></i> Perempuan
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg"><?php echo e($siswa->tempat_lahir ?? '-'); ?></p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                                <?php if($siswa->tanggal_lahir): ?>
                                    <?php echo e(\Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y')); ?>

                                    <span class="text-sm text-gray-500 ml-2">
                                        (<?php echo e(\Carbon\Carbon::parse($siswa->tanggal_lahir)->age); ?> tahun)
                                    </span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg"><?php echo e($siswa->agama ?? '-'); ?></p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                                <?php if($siswa->no_hp): ?>
                                    <a href="tel:<?php echo e($siswa->no_hp); ?>" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-phone mr-1"></i>
                                        <?php echo e($siswa->no_hp); ?>

                                    </a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </p>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg"><?php echo e($siswa->alamat ?? '-'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Academic Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-graduation-cap mr-3 text-green-600"></i>
                        Informasi Akademik
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg"><?php echo e($siswa->nis ?? '-'); ?></p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg"><?php echo e($siswa->nisn ?? '-'); ?></p>
                        </div>
                        
                        <?php if($siswa->kelas): ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg"><?php echo e($siswa->kelas->nama_kelas); ?></p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                                <?php echo e($siswa->kelas->jurusan->nama_jurusan ?? '-'); ?>

                            </p>
                        </div>
                        <?php endif; ?>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Masuk</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg"><?php echo e($siswa->tahun_masuk ?? '-'); ?></p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Siswa</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                                <?php if($siswa->status_siswa == 'aktif'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Aktif
                                    </span>
                                <?php elseif($siswa->status_siswa == 'nonaktif'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Nonaktif
                                    </span>
                                <?php elseif($siswa->status_siswa == 'mutasi'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-exchange-alt mr-1"></i>
                                        Mutasi
                                    </span>
                                <?php elseif($siswa->status_siswa == 'lulus'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <i class="fas fa-graduation-cap mr-1"></i>
                                        Lulus
                                    </span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Parent Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-users mr-3 text-purple-600"></i>
                        Informasi Orang Tua/Wali
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg"><?php echo e($siswa->nama_ayah ?? '-'); ?></p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ayah</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg"><?php echo e($siswa->pekerjaan_ayah ?? '-'); ?></p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg"><?php echo e($siswa->nama_ibu ?? '-'); ?></p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ibu</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg"><?php echo e($siswa->pekerjaan_ibu ?? '-'); ?></p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. HP Wali</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                                <?php if($siswa->no_hp_wali): ?>
                                    <a href="tel:<?php echo e($siswa->no_hp_wali); ?>" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-phone mr-1"></i>
                                        <?php echo e($siswa->no_hp_wali); ?>

                                    </a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Side Information -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-line mr-3 text-indigo-600"></i>
                        Statistik Singkat
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                            <span class="text-sm font-medium text-gray-700">Lama Bersekolah</span>
                        </div>
                        <span class="text-sm font-bold text-blue-600">
                            <?php if($siswa->tahun_masuk): ?>
                                <?php echo e(date('Y') - $siswa->tahun_masuk); ?> tahun
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-user-clock text-green-600 mr-2"></i>
                            <span class="text-sm font-medium text-gray-700">Umur</span>
                        </div>
                        <span class="text-sm font-bold text-green-600">
                            <?php if($siswa->tanggal_lahir): ?>
                                <?php echo e(\Carbon\Carbon::parse($siswa->tanggal_lahir)->age); ?> tahun
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Recent Attendance -->
            <?php if($siswa->absensi && $siswa->absensi->count() > 0): ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-clock mr-3 text-orange-600"></i>
                        Absensi Terbaru
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <?php $__currentLoopData = $siswa->absensi->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $absen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <?php if($absen->status == 'hadir'): ?>
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    <?php elseif($absen->status == 'sakit'): ?>
                                        <i class="fas fa-user-injured text-yellow-500 mr-2"></i>
                                    <?php elseif($absen->status == 'izin'): ?>
                                        <i class="fas fa-user-clock text-blue-500 mr-2"></i>
                                    <?php else: ?>
                                        <i class="fas fa-user-times text-red-500 mr-2"></i>
                                    <?php endif; ?>
                                    <span class="text-sm font-medium text-gray-700">
                                        <?php echo e(\Carbon\Carbon::parse($absen->tanggal)->format('d/m/Y')); ?>

                                    </span>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full 
                                    <?php if($absen->status == 'hadir'): ?> bg-green-100 text-green-800
                                    <?php elseif($absen->status == 'sakit'): ?> bg-yellow-100 text-yellow-800  
                                    <?php elseif($absen->status == 'izin'): ?> bg-blue-100 text-blue-800
                                    <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                    <?php echo e(ucfirst($absen->status)); ?>

                                </span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    .print-break {
        page-break-after: always;
    }
    
    body {
        background: white !important;
    }
    
    .bg-gradient-to-r {
        background: #3B82F6 !important;
        color: white !important;
    }
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.kesiswaan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views\kesiswaan\siswa\show.blade.php ENDPATH**/ ?>