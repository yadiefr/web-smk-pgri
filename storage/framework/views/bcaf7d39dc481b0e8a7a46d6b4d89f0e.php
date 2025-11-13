

<?php $__env->startSection('title', 'PPDB SMK PGRI CIKAMPEK'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    
    <!-- Countdown Timer Section (if PPDB is open) -->
    <?php if(($is_ppdb_open ?? true) && isset($periode_pendaftaran)): ?>
    <div class="bg-gradient-to-r from-red-500 to-pink-600 text-white py-4 sticky top-0 z-40 shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-center space-y-2 md:space-y-0 md:space-x-6">
                <div class="flex items-center">
                    <i class="fas fa-clock mr-2 text-xl"></i>
                    <span class="font-semibold text-lg">Pendaftaran Berakhir Dalam:</span>
                </div>
                <div class="flex space-x-4" id="countdown-timer">
                    <div class="text-center bg-white bg-opacity-20 rounded-lg px-3 py-2">
                        <div class="text-2xl font-bold" id="countdown-days">00</div>
                        <div class="text-xs">Hari</div>
                    </div>
                    <div class="text-center bg-white bg-opacity-20 rounded-lg px-3 py-2">
                        <div class="text-2xl font-bold" id="countdown-hours">00</div>
                        <div class="text-xs">Jam</div>
                    </div>
                    <div class="text-center bg-white bg-opacity-20 rounded-lg px-3 py-2">
                        <div class="text-2xl font-bold" id="countdown-minutes">00</div>
                        <div class="text-xs">Menit</div>
                    </div>
                    <div class="text-center bg-white bg-opacity-20 rounded-lg px-3 py-2">
                        <div class="text-2xl font-bold" id="countdown-seconds">00</div>
                        <div class="text-xs">Detik</div>
                    </div>
                </div>
                <a href="<?php echo e(route('ppdb.register')); ?>" 
                   class="bg-white text-red-600 font-bold py-2 px-6 rounded-full hover:bg-gray-100 transition-all duration-300 pulse-glow">
                    <i class="fas fa-user-plus mr-2"></i>
                    Daftar Sekarang!
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
        <div class="container mx-auto px-4 py-16">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    Penerimaan Peserta Didik Baru
                </h1>
                <h2 class="text-2xl md:text-3xl font-semibold mb-6">
                    SMK PGRI CIKAMPEK
                </h2>
                <p class="text-xl mb-8 max-w-3xl mx-auto leading-relaxed">
                    Tahun Ajaran <?php echo e($tahun_ajaran ?? date('Y') . '/' . (date('Y') + 1)); ?>

                </p>
                
                <?php if($is_ppdb_open ?? true): ?>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="<?php echo e(route('ppdb.register')); ?>" 
                           class="bg-white text-blue-600 font-bold py-4 px-8 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            <i class="fas fa-user-plus mr-2"></i>
                            Daftar Sekarang
                        </a>
                        <a href="<?php echo e(route('ppdb.check')); ?>" 
                           class="bg-transparent border-2 border-white text-white font-bold py-4 px-8 rounded-lg hover:bg-white hover:text-blue-600 transition-all duration-300">
                            <i class="fas fa-search mr-2"></i>
                            Cek Status Pendaftaran
                        </a>
                    </div>
                <?php else: ?>
                    <div class="bg-red-500 bg-opacity-20 border border-red-300 rounded-lg p-6 max-w-2xl mx-auto">
                        <h3 class="text-xl font-bold mb-2">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            Pendaftaran Ditutup
                        </h3>
                        <p class="text-lg">
                            Mohon maaf, periode pendaftaran PPDB telah berakhir.
                        </p>
                        <a href="<?php echo e(route('ppdb.check')); ?>" 
                           class="mt-4 inline-block bg-white text-blue-600 font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            <i class="fas fa-search mr-2"></i>
                            Cek Status Pendaftaran
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Status Pendaftaran -->
    <?php if(isset($periode_pendaftaran)): ?>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">
                <i class="fas fa-calendar-alt mr-2 text-blue-600"></i>
                Periode Pendaftaran
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="text-center">
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Tanggal Mulai</h4>
                    <div class="bg-green-50 border-2 border-green-200 rounded-lg p-4">
                        <p class="text-2xl font-bold text-green-600">
                            <?php echo e(\Carbon\Carbon::parse($periode_pendaftaran['start'])->format('d F Y')); ?>

                        </p>
                    </div>
                </div>
                <div class="text-center">
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Tanggal Berakhir</h4>
                    <div class="bg-red-50 border-2 border-red-200 rounded-lg p-4">
                        <p class="text-2xl font-bold text-red-600">
                            <?php echo e(\Carbon\Carbon::parse($periode_pendaftaran['end'])->format('d F Y')); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Informasi Sekolah -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b">
                <h3 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-school mr-2 text-blue-600"></i>
                    Tentang SMK PGRI CIKAMPEK
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-xl font-semibold text-gray-800 mb-4">Visi Sekolah</h4>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            Menjadi SMK yang unggul dalam menghasilkan lulusan yang berkarakter, kompeten, dan siap bersaing di dunia kerja maupun melanjutkan ke jenjang pendidikan yang lebih tinggi.
                        </p>
                        
                        <h4 class="text-xl font-semibold text-gray-800 mb-4">Misi Sekolah</h4>
                        <ul class="text-gray-600 space-y-2">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                Menyelenggarakan pendidikan berkualitas dengan kurikulum yang relevan
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                Mengembangkan potensi siswa secara optimal
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                Menciptakan lingkungan belajar yang kondusif dan inovatif
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                Menjalin kerjasama dengan dunia usaha dan industri
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="text-xl font-semibold text-gray-800 mb-4">Keunggulan Sekolah</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <i class="fas fa-award text-blue-600 text-2xl mb-2"></i>
                                <h5 class="font-semibold text-gray-800 mb-1">Akreditasi A</h5>
                                <p class="text-sm text-gray-600">Terakreditasi A dari BAN-S/M</p>
                            </div>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <i class="fas fa-users text-green-600 text-2xl mb-2"></i>
                                <h5 class="font-semibold text-gray-800 mb-1">Tenaga Ahli</h5>
                                <p class="text-sm text-gray-600">Guru berpengalaman dan berkompeten</p>
                            </div>
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                                <i class="fas fa-laptop text-purple-600 text-2xl mb-2"></i>
                                <h5 class="font-semibold text-gray-800 mb-1">Fasilitas Modern</h5>
                                <p class="text-sm text-gray-600">Lab komputer dan peralatan terkini</p>
                            </div>
                            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                                <i class="fas fa-handshake text-orange-600 text-2xl mb-2"></i>
                                <h5 class="font-semibold text-gray-800 mb-1">Link & Match</h5>
                                <p class="text-sm text-gray-600">Kerjasama dengan industri</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jurusan yang Tersedia -->
    <?php if(isset($jurusan_tersedia) && count($jurusan_tersedia) > 0): ?>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b">
                <h3 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-graduation-cap mr-2 text-indigo-600"></i>
                    Program Keahlian yang Tersedia
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $jurusan_tersedia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jurusan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-all duration-300">
                        <div class="text-center mb-4">
                            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-cogs text-indigo-600 text-2xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-800 mb-2"><?php echo e($jurusan->nama); ?></h4>
                            <?php if($jurusan->deskripsi): ?>
                                <p class="text-gray-600 text-sm leading-relaxed"><?php echo e($jurusan->deskripsi); ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <?php if(isset($jurusan->kuota)): ?>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Kuota Tersedia:</span>
                                <span class="text-lg font-bold text-blue-600"><?php echo e($jurusan->kuota); ?> siswa</span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if(isset($jurusan->prospek_kerja) && count($jurusan->prospek_kerja) > 0): ?>
                        <div class="mt-4">
                            <h5 class="text-sm font-semibold text-gray-700 mb-2">Prospek Kerja:</h5>
                            <ul class="text-xs text-gray-600 space-y-1">
                                <?php $__currentLoopData = array_slice($jurusan->prospek_kerja, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prospek): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="flex items-start">
                                    <i class="fas fa-chevron-right text-indigo-400 mr-2 mt-1"></i>
                                    <?php echo e($prospek); ?>

                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Persyaratan Pendaftaran -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-green-50 to-teal-50 px-6 py-4 border-b">
                <h3 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-clipboard-list mr-2 text-green-600"></i>
                    Persyaratan Pendaftaran
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-xl font-semibold text-gray-800 mb-4">Syarat Umum</h4>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <span class="text-gray-700">Lulusan SMP/MTs atau sederajat</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <span class="text-gray-700">Berusia maksimal 21 tahun</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <span class="text-gray-700">Sehat jasmani dan rohani</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <span class="text-gray-700">Tidak buta warna (untuk jurusan tertentu)</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="text-xl font-semibold text-gray-800 mb-4">Dokumen yang Diperlukan</h4>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-file-alt text-blue-500 mr-3 mt-1"></i>
                                <span class="text-gray-700">Fotokopi Ijazah SMP/MTs (dilegalisir)</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-file-alt text-blue-500 mr-3 mt-1"></i>
                                <span class="text-gray-700">Fotokopi SKHUN SMP/MTs (dilegalisir)</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-file-alt text-blue-500 mr-3 mt-1"></i>
                                <span class="text-gray-700">Fotokopi Akta Kelahiran</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-file-alt text-blue-500 mr-3 mt-1"></i>
                                <span class="text-gray-700">Fotokopi KK (Kartu Keluarga)</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-image text-purple-500 mr-3 mt-1"></i>
                                <span class="text-gray-700">Pas foto 3x4 (6 lembar) background merah</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alur Pendaftaran -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-orange-50 to-red-50 px-6 py-4 border-b">
                <h3 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-route mr-2 text-orange-600"></i>
                    Alur Pendaftaran Online
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-blue-600">1</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Registrasi Online</h4>
                        <p class="text-gray-600 text-sm">Daftar akun dan isi formulir pendaftaran online</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-green-600">2</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Upload Dokumen</h4>
                        <p class="text-gray-600 text-sm">Upload dokumen persyaratan yang diperlukan</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-yellow-600">3</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Verifikasi</h4>
                        <p class="text-gray-600 text-sm">Menunggu verifikasi dari pihak sekolah</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-purple-600">4</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Pengumuman</h4>
                        <p class="text-gray-600 text-sm">Cek status kelulusan dan daftar ulang</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fasilitas Sekolah -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 border-b">
                <h3 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-building mr-2 text-emerald-600"></i>
                    Fasilitas Sekolah
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="text-center hover-lift bg-gradient-to-b from-white to-gray-50 p-6 rounded-lg border border-gray-100">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-laptop text-blue-600 text-3xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Lab Komputer</h4>
                        <p class="text-gray-600 text-sm">40 unit komputer modern dengan koneksi internet high-speed</p>
                    </div>
                    
                    <div class="text-center hover-lift bg-gradient-to-b from-white to-gray-50 p-6 rounded-lg border border-gray-100">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-flask text-green-600 text-3xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Lab Praktek</h4>
                        <p class="text-gray-600 text-sm">Laboratorium lengkap untuk setiap program keahlian</p>
                    </div>
                    
                    <div class="text-center hover-lift bg-gradient-to-b from-white to-gray-50 p-6 rounded-lg border border-gray-100">
                        <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-book text-yellow-600 text-3xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Perpustakaan</h4>
                        <p class="text-gray-600 text-sm">Koleksi lengkap buku dan e-book dengan ruang baca nyaman</p>
                    </div>
                    
                    <div class="text-center hover-lift bg-gradient-to-b from-white to-gray-50 p-6 rounded-lg border border-gray-100">
                        <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-futbol text-purple-600 text-3xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Lapangan Olahraga</h4>
                        <p class="text-gray-600 text-sm">Lapangan basket, voli, dan area olahraga lainnya</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                    <div class="flex items-center bg-gray-50 p-4 rounded-lg">
                        <i class="fas fa-wifi text-blue-600 text-2xl mr-4"></i>
                        <div>
                            <h5 class="font-semibold text-gray-800">WiFi Gratis</h5>
                            <p class="text-sm text-gray-600">Akses internet di seluruh area sekolah</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center bg-gray-50 p-4 rounded-lg">
                        <i class="fas fa-utensils text-green-600 text-2xl mr-4"></i>
                        <div>
                            <h5 class="font-semibold text-gray-800">Kantin Sehat</h5>
                            <p class="text-sm text-gray-600">Makanan bergizi dengan harga terjangkau</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center bg-gray-50 p-4 rounded-lg">
                        <i class="fas fa-parking text-purple-600 text-2xl mr-4"></i>
                        <div>
                            <h5 class="font-semibold text-gray-800">Area Parkir</h5>
                            <p class="text-sm text-gray-600">Parkir luas dan aman untuk siswa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Prestasi Sekolah -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 px-6 py-4 border-b">
                <h3 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-trophy mr-2 text-yellow-600"></i>
                    Prestasi & Pencapaian
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-gradient-to-br from-gold-50 to-yellow-50 border border-yellow-200 rounded-lg p-6 hover-lift">
                        <div class="text-center mb-4">
                            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-medal text-yellow-600 text-2xl"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800 mb-2">Juara 1 LKS Provinsi</h4>
                            <p class="text-gray-600 text-sm">Lomba Kompetensi Siswa Tingkat Provinsi Jawa Barat 2024</p>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-silver-50 to-gray-50 border border-gray-200 rounded-lg p-6 hover-lift">
                        <div class="text-center mb-4">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-award text-gray-600 text-2xl"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800 mb-2">Juara 2 O2SN</h4>
                            <p class="text-gray-600 text-sm">Olimpiade Olahraga Siswa Nasional Cabang Futsal 2024</p>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-bronze-50 to-orange-50 border border-orange-200 rounded-lg p-6 hover-lift">
                        <div class="text-center mb-4">
                            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-star text-orange-600 text-2xl"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800 mb-2">Juara 3 Festival Seni</h4>
                            <p class="text-gray-600 text-sm">Festival Seni Budaya Tingkat Kabupaten Karawang 2024</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h4 class="text-xl font-semibold text-gray-800 mb-4 text-center">Tingkat Kelulusan & Penyerapan Kerja</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-4xl font-bold text-blue-600 mb-2">98%</div>
                            <p class="text-gray-700 font-medium">Tingkat Kelulusan</p>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-green-600 mb-2">85%</div>
                            <p class="text-gray-700 font-medium">Langsung Bekerja</p>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-purple-600 mb-2">15%</div>
                            <p class="text-gray-700 font-medium">Melanjutkan Kuliah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Program Beasiswa -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 px-6 py-4 border-b">
                <h3 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-graduation-cap mr-2 text-indigo-600"></i>
                    Program Beasiswa
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6">
                        <h4 class="text-xl font-semibold text-gray-800 mb-4">
                            <i class="fas fa-star-of-life text-blue-600 mr-2"></i>
                            Beasiswa Prestasi Akademik
                        </h4>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                Untuk siswa dengan nilai UN minimal 85
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                Potongan SPP hingga 50%
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                Berlaku selama 3 tahun dengan syarat mempertahankan prestasi
                            </li>
                        </ul>
                    </div>
                    
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-lg p-6">
                        <h4 class="text-xl font-semibold text-gray-800 mb-4">
                            <i class="fas fa-heart text-green-600 mr-2"></i>
                            Beasiswa Ekonomi Lemah
                        </h4>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                Untuk keluarga kurang mampu (surat keterangan RT/RW)
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                Bebas SPP atau potongan hingga 75%
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                Bantuan seragam dan perlengkapan sekolah
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-yellow-600 text-xl mr-3 mt-1"></i>
                        <div>
                            <h5 class="font-semibold text-gray-800 mb-1">Informasi Penting</h5>
                            <p class="text-gray-600 text-sm">Pendaftaran beasiswa dapat dilakukan bersamaan dengan pendaftaran PPDB. Dokumen lengkap harus diserahkan saat daftar ulang.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimoni Alumni -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-pink-50 to-rose-50 px-6 py-4 border-b">
                <h3 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-quote-left mr-2 text-pink-600"></i>
                    Testimoni Alumni
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-lg p-6 hover-lift">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Andi Pratama</h4>
                                <p class="text-sm text-gray-600">Alumni 2022 - Teknik Komputer</p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm italic">"Pendidikan di SMK PGRI Cikampek sangat berkualitas. Sekarang saya bekerja sebagai IT Support di perusahaan multinasional. Terima kasih guru-guru yang sudah membimbing!"</p>
                        <div class="mt-3">
                            <p class="text-xs text-blue-600 font-medium">Sekarang: IT Support PT. Astra International</p>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-lg p-6 hover-lift">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-green-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Siti Nurhaliza</h4>
                                <p class="text-sm text-gray-600">Alumni 2021 - Administrasi Perkantoran</p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm italic">"Fasilitas lengkap dan metode pembelajaran yang modern membantu saya mengembangkan skill. Sekarang saya bekerja di bank sebagai customer service."</p>
                        <div class="mt-3">
                            <p class="text-xs text-green-600 font-medium">Sekarang: Customer Service Bank Mandiri</p>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-lg p-6 hover-lift">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-purple-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Budi Santoso</h4>
                                <p class="text-sm text-gray-600">Alumni 2020 - Akuntansi</p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm italic">"Pengalaman PKL di SMK PGRI Cikampek membuat saya siap terjun ke dunia kerja. Pembelajaran praktis dan teori seimbang."</p>
                        <div class="mt-3">
                            <p class="text-xs text-purple-600 font-medium">Sekarang: Staff Accounting PT. Indofood</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ (Frequently Asked Questions) -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-cyan-50 to-teal-50 px-6 py-4 border-b">
                <h3 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-question-circle mr-2 text-cyan-600"></i>
                    Pertanyaan yang Sering Diajukan (FAQ)
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="border border-gray-200 rounded-lg">
                        <button class="faq-button w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition-colors flex justify-between items-center" onclick="toggleFaq('faq1')">
                            <span class="font-semibold text-gray-800">Kapan pendaftaran PPDB dibuka?</span>
                            <i class="fas fa-chevron-down text-gray-600 transform transition-transform faq-icon" id="icon-faq1"></i>
                        </button>
                        <div class="faq-content hidden px-6 py-4 bg-white" id="faq1">
                            <p class="text-gray-600">Pendaftaran PPDB biasanya dibuka pada bulan Juni hingga Juli. Untuk tahun ajaran <?php echo e($tahun_ajaran ?? '2024/2025'); ?>, pendaftaran akan dibuka sesuai kalender akademik yang telah ditetapkan. Pantau terus website resmi sekolah untuk informasi terbaru.</p>
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg">
                        <button class="faq-button w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition-colors flex justify-between items-center" onclick="toggleFaq('faq2')">
                            <span class="font-semibold text-gray-800">Berapa biaya masuk SMK PGRI Cikampek?</span>
                            <i class="fas fa-chevron-down text-gray-600 transform transition-transform faq-icon" id="icon-faq2"></i>
                        </button>
                        <div class="faq-content hidden px-6 py-4 bg-white" id="faq2">
                            <p class="text-gray-600 mb-3">Biaya pendidikan di SMK PGRI Cikampek sangat terjangkau:</p>
                            <ul class="text-gray-600 space-y-1 ml-4">
                                <li>• SPP bulanan: Rp 150.000 - Rp 200.000 (tergantung jurusan)</li>
                                <li>• Uang pangkal: Rp 500.000</li>
                                <li>• Seragam dan buku: Rp 800.000</li>
                                <li>• Tersedia program beasiswa untuk siswa berprestasi dan kurang mampu</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg">
                        <button class="faq-button w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition-colors flex justify-between items-center" onclick="toggleFaq('faq3')">
                            <span class="font-semibold text-gray-800">Apakah ada tes masuk?</span>
                            <i class="fas fa-chevron-down text-gray-600 transform transition-transform faq-icon" id="icon-faq3"></i>
                        </button>
                        <div class="faq-content hidden px-6 py-4 bg-white" id="faq3">
                            <p class="text-gray-600">Tidak ada tes tertulis khusus. Seleksi dilakukan berdasarkan nilai rapor semester 1-5 SMP dan wawancara ringan untuk mengetahui minat dan bakat siswa terhadap program keahlian yang dipilih.</p>
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg">
                        <button class="faq-button w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition-colors flex justify-between items-center" onclick="toggleFaq('faq4')">
                            <span class="font-semibold text-gray-800">Bagaimana jika berkas pendaftaran tidak lengkap?</span>
                            <i class="fas fa-chevron-down text-gray-600 transform transition-transform faq-icon" id="icon-faq4"></i>
                        </button>
                        <div class="faq-content hidden px-6 py-4 bg-white" id="faq4">
                            <p class="text-gray-600">Berkas yang belum lengkap masih bisa dilengkapi maksimal 2 minggu setelah pendaftaran ditutup. Namun, kami sangat menyarankan untuk melengkapi semua berkas sejak awal agar proses verifikasi lebih cepat.</p>
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg">
                        <button class="faq-button w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition-colors flex justify-between items-center" onclick="toggleFaq('faq5')">
                            <span class="font-semibold text-gray-800">Apakah lulusan SMK bisa kuliah?</span>
                            <i class="fas fa-chevron-down text-gray-600 transform transition-transform faq-icon" id="icon-faq5"></i>
                        </button>
                        <div class="faq-content hidden px-6 py-4 bg-white" id="faq5">
                            <p class="text-gray-600">Tentu saja! Lulusan SMK memiliki kesempatan yang sama untuk melanjutkan ke perguruan tinggi melalui berbagai jalur seperti SNMPTN, SBMPTN, atau ujian mandiri. Bahkan banyak PT yang memberikan jalur khusus untuk lulusan SMK sesuai bidangnya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kontak Informasi -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-slate-50 px-6 py-4 border-b">
                <h3 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-phone mr-2 text-gray-600"></i>
                    Informasi Kontak
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-map-marker-alt text-blue-600 text-xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Alamat Sekolah</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Jl. Raya Cikampek<br>
                            Cikampek, Karawang<br>
                            Jawa Barat 41373
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-phone text-green-600 text-xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Telepon</h4>
                        <p class="text-gray-600 text-sm">
                            <a href="tel:+6281234567890" class="hover:text-green-600 transition-colors">
                                +62 812-3456-7890
                            </a><br>
                            <a href="tel:+6281234567891" class="hover:text-green-600 transition-colors">
                                +62 812-3456-7891
                            </a>
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-envelope text-purple-600 text-xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Email</h4>
                        <p class="text-gray-600 text-sm">
                            <a href="mailto:ppdb@smkpgricikampek.sch.id" class="hover:text-purple-600 transition-colors">
                                ppdb@smkpgricikampek.sch.id
                            </a><br>
                            <a href="mailto:info@smkpgricikampek.sch.id" class="hover:text-purple-600 transition-colors">
                                info@smkpgricikampek.sch.id
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if($is_ppdb_open ?? true): ?>
<!-- Floating Action Button -->
<div class="fixed bottom-6 right-6 z-50">
    <a href="<?php echo e(route('ppdb.register')); ?>" 
       class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300 flex items-center">
        <i class="fas fa-user-plus mr-2"></i>
        Daftar PPDB
    </a>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
// Smooth scrolling untuk anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Animation on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-fade-in-up');
        }
    });
}, observerOptions);

// Observe all sections
document.querySelectorAll('.container > div').forEach(section => {
    observer.observe(section);
});

// FAQ Toggle Function
function toggleFaq(faqId) {
    const content = document.getElementById(faqId);
    const icon = document.getElementById('icon-' + faqId);
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.classList.add('rotate-180');
    } else {
        content.classList.add('hidden');
        icon.classList.remove('rotate-180');
    }
}

// Counter animation for statistics
function animateCounter(element, start, end, duration) {
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        const currentNumber = Math.floor(progress * (end - start) + start);
        element.innerHTML = currentNumber + '%';
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

// Animate counters when they come into view
const counterObserver = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const counters = entry.target.querySelectorAll('.counter');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                animateCounter(counter, 0, target, 2000);
            });
        }
    });
}, { threshold: 0.5 });

// Observe statistics section
const statsSection = document.querySelector('.bg-blue-50');
if (statsSection) {
    // Add counter classes to statistics
    const statNumbers = statsSection.querySelectorAll('.text-4xl');
    statNumbers.forEach((stat, index) => {
        stat.classList.add('counter');
        const values = ['98', '85', '15'];
        stat.setAttribute('data-target', values[index]);
    });
    counterObserver.observe(statsSection);
}

// Countdown Timer
<?php if(($is_ppdb_open ?? true) && isset($periode_pendaftaran)): ?>
function updateCountdown() {
    const endDate = new Date('<?php echo e($periode_pendaftaran["end"] ?? "2024-07-31"); ?> 23:59:59').getTime();
    const now = new Date().getTime();
    const timeLeft = endDate - now;
    
    if (timeLeft > 0) {
        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
        
        document.getElementById('countdown-days').textContent = days.toString().padStart(2, '0');
        document.getElementById('countdown-hours').textContent = hours.toString().padStart(2, '0');
        document.getElementById('countdown-minutes').textContent = minutes.toString().padStart(2, '0');
        document.getElementById('countdown-seconds').textContent = seconds.toString().padStart(2, '0');
    } else {
        // Time's up
        document.getElementById('countdown-timer').innerHTML = '<div class="text-xl font-bold">PENDAFTARAN DITUTUP</div>';
    }
}

// Update countdown every second
setInterval(updateCountdown, 1000);
updateCountdown(); // Initial call
<?php endif; ?>

// Lazy loading untuk gambar (jika ada)
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                observer.unobserve(img);
            }
        });
    });
    
    document.querySelectorAll('img[data-src]').forEach(function(img) {
        imageObserver.observe(img);
    });
}

// Smooth scroll untuk internal links
document.addEventListener('DOMContentLoaded', function() {
    // Auto-scroll to sections based on hash
    if (window.location.hash) {
        const target = document.querySelector(window.location.hash);
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
    
    // Add click tracking for buttons (analytics)
    document.querySelectorAll('a[href*="register"], a[href*="check"]').forEach(button => {
        button.addEventListener('click', function() {
            // Add analytics tracking here if needed
            console.log('Button clicked:', this.textContent.trim());
        });
    });
});
</script>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out forwards;
}

/* Custom hover effects */
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

/* FAQ Styling */
.faq-content {
    transition: all 0.3s ease;
}

.faq-icon {
    transition: transform 0.3s ease;
}

.faq-button:hover .faq-icon {
    color: #3B82F6;
}

/* Custom gradient backgrounds */
.from-gold-50 { --tw-gradient-from: #fffbeb; }
.to-yellow-50 { --tw-gradient-to: #fefce8; }
.from-silver-50 { --tw-gradient-from: #f8fafc; }
.from-bronze-50 { --tw-gradient-from: #fff7ed; }

/* Pulse animation for important elements */
@keyframes pulse-glow {
    0%, 100% { 
        opacity: 1;
        transform: scale(1);
    }
    50% { 
        opacity: 0.8;
        transform: scale(1.05);
    }
}

.pulse-glow {
    animation: pulse-glow 2s infinite;
}

/* Floating button enhanced animation */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.fixed.bottom-6.right-6 a {
    animation: float 3s ease-in-out infinite;
}

/* Card gradient effects */
.card-gradient {
    background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(249,250,251,1) 100%);
}

/* Statistics counter styling */
.counter {
    transition: all 0.3s ease;
}

/* Testimonial card enhancements */
.testimonial-card {
    background: linear-gradient(145deg, #ffffff 0%, #f9fafb 100%);
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
}

.testimonial-card:hover {
    border-color: #3b82f6;
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.1);
}

/* Responsive enhancements */
@media (max-width: 768px) {
    .fixed.bottom-6.right-6 a {
        padding: 12px 16px;
        font-size: 14px;
    }
    
    .text-4xl {
        font-size: 2.5rem;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views\ppdb\index.blade.php ENDPATH**/ ?>