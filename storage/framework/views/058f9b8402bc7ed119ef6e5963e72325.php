

<?php $__env->startSection('title', 'Dashboard Kesiswaan'); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full px-3 py-4">
    <!-- Header with stats -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-blue-100">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-graduation-cap text-blue-500 mr-3"></i> Dashboard Kesiswaan
                </h1>
                <p class="text-gray-600 mt-1">Sistem manajemen data kesiswaan SMK PGRI Cikampek</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500"><?php echo e(now()->locale('id')->isoFormat('dddd, D MMMM Y')); ?></div>
                <div class="text-xs text-blue-600 mt-1">
                    <i class="fas fa-clock mr-1"></i><?php echo e(now()->format('H:i')); ?> WIB
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Siswa</p>
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e(number_format($totalSiswa)); ?></h3>
                </div>
                <div class="bg-white p-3 rounded-lg shadow-sm">
                    <i class="fas fa-users text-blue-500 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Kelas</p>
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e(number_format($totalKelas)); ?></h3>
                </div>
                <div class="bg-white p-3 rounded-lg shadow-sm">
                    <i class="fas fa-school text-green-500 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-4 border border-emerald-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Siswa Aktif</p>
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e(number_format($siswaAktif)); ?></h3>
                </div>
                <div class="bg-white p-3 rounded-lg shadow-sm">
                    <i class="fas fa-user-check text-emerald-500 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-4 border border-red-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Siswa Nonaktif</p>
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e(number_format($siswaNonaktif)); ?></h3>
                </div>
                <div class="bg-white p-3 rounded-lg shadow-sm">
                    <i class="fas fa-user-times text-red-500 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Data -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Attendance Statistics -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-chart-pie mr-2 text-blue-500"></i>Statistik Kehadiran Bulan Ini
                </h3>
            </div>
            <div class="p-6">
                <?php if(!empty($absensiStats)): ?>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $absensiStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 rounded-full mr-3 
                                        <?php echo e($status == 'hadir' ? 'bg-green-500' : ''); ?>

                                        <?php echo e($status == 'izin' ? 'bg-yellow-500' : ''); ?>

                                        <?php echo e($status == 'sakit' ? 'bg-blue-500' : ''); ?>

                                        <?php echo e($status == 'alpa' ? 'bg-red-500' : ''); ?>"></div>
                                    <span class="text-gray-700 capitalize"><?php echo e($status); ?></span>
                                </div>
                                <span class="font-semibold text-gray-900"><?php echo e(number_format($total)); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <i class="fas fa-chart-pie text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500">Belum ada data absensi bulan ini</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Class Statistics -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-school mr-2 text-blue-500"></i>Statistik per Kelas
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-3 max-h-64 overflow-y-auto">
                    <?php $__empty_1 = true; $__currentLoopData = $kelasStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <span class="font-medium text-gray-900"><?php echo e($kelas->nama_kelas); ?></span>
                                <?php if($kelas->jurusan): ?>
                                    <span class="text-sm text-gray-500">- <?php echo e($kelas->jurusan->nama_jurusan ?? ''); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="text-right">
                                <span class="text-lg font-bold text-blue-600"><?php echo e($kelas->siswa_count); ?></span>
                                <span class="text-sm text-gray-500 block">siswa</span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-8">
                            <i class="fas fa-school text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-500">Belum ada data kelas</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-clock mr-2 text-blue-500"></i>Aktivitas Terkini
            </h3>
        </div>
        <div class="p-6">
            <?php $__empty_1 = true; $__currentLoopData = $recentAbsensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $absensi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4
                            <?php echo e($absensi->status == 'hadir' ? 'bg-green-100 text-green-600' : ''); ?>

                            <?php echo e($absensi->status == 'izin' ? 'bg-yellow-100 text-yellow-600' : ''); ?>

                            <?php echo e($absensi->status == 'sakit' ? 'bg-blue-100 text-blue-600' : ''); ?>

                            <?php echo e($absensi->status == 'alpa' ? 'bg-red-100 text-red-600' : ''); ?>">
                            <i class="fas 
                                <?php echo e($absensi->status == 'hadir' ? 'fa-check' : ''); ?>

                                <?php echo e($absensi->status == 'izin' ? 'fa-info' : ''); ?>

                                <?php echo e($absensi->status == 'sakit' ? 'fa-plus' : ''); ?>

                                <?php echo e($absensi->status == 'alpa' ? 'fa-times' : ''); ?>"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900"><?php echo e($absensi->siswa->nama_lengkap ?? 'Nama tidak tersedia'); ?></p>
                            <p class="text-sm text-gray-500">
                                <?php echo e($absensi->kelas->nama_kelas ?? 'Kelas tidak tersedia'); ?> • 
                                <span class="capitalize"><?php echo e($absensi->status); ?></span>
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900"><?php echo e($absensi->tanggal ? \Carbon\Carbon::parse($absensi->tanggal)->format('d/m/Y') : '-'); ?></p>
                        <p class="text-xs text-gray-500"><?php echo e($absensi->created_at ? $absensi->created_at->diffForHumans() : '-'); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-8">
                    <i class="fas fa-clock text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-500">Belum ada aktivitas terkini</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-bolt mr-2 text-blue-500"></i>Aksi Cepat
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="<?php echo e(route('kesiswaan.siswa.index')); ?>" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <i class="fas fa-user-graduate text-blue-500 text-lg mr-3"></i>
                    <div>
                        <p class="font-medium text-blue-900 text-sm">Lihat Data Siswa</p>
                        <p class="text-xs text-blue-600">Kelola data siswa</p>
                    </div>
                </a>
                
                <a href="<?php echo e(route('kesiswaan.absensi.index')); ?>" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <i class="fas fa-clipboard-check text-green-500 text-lg mr-3"></i>
                    <div>
                        <p class="font-medium text-green-900 text-sm">Rekap Absensi</p>
                        <p class="text-xs text-green-600">Lihat kehadiran siswa</p>
                    </div>
                </a>
                
                <a href="<?php echo e(route('kesiswaan.kegiatan.index')); ?>" class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <i class="fas fa-calendar-alt text-purple-500 text-lg mr-3"></i>
                    <div>
                        <p class="font-medium text-purple-900 text-sm">Kegiatan Siswa</p>
                        <p class="text-xs text-purple-600">Kelola kegiatan</p>
                    </div>
                </a>
                
                <a href="<?php echo e(route('kesiswaan.laporan.index')); ?>" class="flex items-center p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <i class="fas fa-chart-bar text-orange-500 text-lg mr-3"></i>
                    <div>
                        <p class="font-medium text-orange-900 text-sm">Laporan</p>
                        <p class="text-xs text-orange-600">Buat laporan</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kesiswaan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views\kesiswaan\dashboard.blade.php ENDPATH**/ ?>