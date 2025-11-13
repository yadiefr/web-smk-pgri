<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <?php
        $isProduction = !in_array(request()->getHost(), ['127.0.0.1', 'localhost']);
        $currentDomain = request()->getHost();
        $forceHttps = $isProduction && !request()->isSecure();
    ?>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, shrink-to-fit=no, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title><?php echo e(setting('site_title')); ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo e(setting('site_description', setting('nama_sekolah', 'Sekolah') . ' menyediakan pendidikan berkualitas dengan fasilitas modern dan tenaga pengajar profesional')); ?>">
    <meta name="keywords" content="<?php echo e(setting('site_keywords', 'smk, sekolah kejuruan, cikampek, pendidikan, teknologi')); ?>">
    <meta name="author" content="<?php echo e(setting('nama_sekolah', 'SMK PGRI CIKAMPEK')); ?>">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo e(setting('site_title', 'SMK PGRI CIKAMPEK')); ?>">
    <meta property="og:description" content="<?php echo e(setting('site_description', 'Pendidikan Berkualitas untuk Masa Depan')); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(url('/')); ?>">
    <?php if(setting('logo_sekolah')): ?>
    <meta property="og:image" content="<?php echo e(setting_with_cache_bust('logo_sekolah', null, true)); ?>">
    <?php endif; ?>
    
    <!-- Favicon -->
    <?php if(setting('site_favicon')): ?>
    <link rel="icon" type="image/x-icon" href="<?php echo e(setting_with_cache_bust('site_favicon', null, true)); ?>">
    <?php else: ?>
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">
    <?php endif; ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;700&family=Bebas+Neue&display=swap" rel="stylesheet">
    <?php if($isProduction): ?>
        <link href="<?php echo e(asset('css/unified-welcome.css')); ?>?v=<?php echo e(filemtime(public_path('css/unified-welcome.css'))); ?>" rel="stylesheet">
    <?php else: ?>
        <link href="<?php echo e(asset('css/unified-welcome.css')); ?>" rel="stylesheet">
    <?php endif; ?>
    
    <!-- External JavaScript -->
    <?php if($isProduction): ?>
        <script src="<?php echo e(asset('js/welcome.js')); ?>?v=<?php echo e(filemtime(public_path('js/welcome.js'))); ?>" defer></script>
    <?php else: ?>
        <script src="<?php echo e(asset('js/welcome.js')); ?>" defer></script>
    <?php endif; ?>
    
    <!-- Environment Detection Script -->
    <script>
        // Pass PHP variables to external JavaScript
        window.isProduction = <?php echo json_encode($isProduction, 15, 512) ?>;
        window.currentDomain = <?php echo json_encode($currentDomain, 15, 512) ?>;
        window.whatsappNumber = <?php echo json_encode(setting('whatsapp_number', '08123456789'), 512) ?>;
        window.schoolName = <?php echo json_encode(setting('nama_sekolah', 'sekolah'), 512) ?>;
    </script>
    
    <!-- CSS telah dipindahkan ke unified-welcome.css -->
    
    <!-- Vite Assets -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    
    <!-- Mobile Menu and Interactive Functions - Moved to external JS -->

</head>
<body class="pattern-bg text-white overflow-x-hidden">
    <!-- Animated Background -->
    <ul class="animated-bg">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
      
    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass py-3 md:py-5 mobile-consistent-padding shadow-md">
        <div class="flex justify-between items-center" style="margin: 0; padding: 0 1rem; width: 100%; max-width: 1280px; margin-left: auto; margin-right: auto;">
            <!-- Logo and Brand -->
            <div class="flex items-center space-x-2 py-1">
                <?php if(setting('logo_sekolah')): ?>
                    <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg flex items-center justify-center overflow-hidden">
                        <img src="<?php echo e(setting_with_cache_bust('logo_sekolah', null, true)); ?>" alt="<?php echo e(setting('nama_sekolah', 'SMK PGRI CIKAMPEK')); ?>" class="w-full h-full object-contain">
                    </div>
                <?php else: ?>
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-cyan-400 to-pink-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-lg md:text-xl"></i>
                    </div>
                <?php endif; ?>
                <span class="bebas text-xl md:text-2xl font-bold md:tracking-wider"><?php echo e(strtoupper(setting('nama_sekolah', 'SMK PGRI CIKAMPEK'))); ?></span>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-4 lg:space-x-6 items-center">
                <a href="#home" class="hover:text-cyan-400 transition-all duration-300 hover:scale-105 text-sm lg:text-base py-2 px-2 font-medium">BERANDA</a>
                <a href="#about" class="hover:text-cyan-400 transition-all duration-300 hover:scale-105 text-sm lg:text-base py-2 px-2 font-medium">KEUNGGULAN</a>
                <a href="#programs" class="hover:text-cyan-400 transition-all duration-300 hover:scale-105 text-sm lg:text-base py-2 px-2 font-medium">PROGRAM</a>
                <a href="<?php echo e(route('berita.index')); ?>" class="hover:text-cyan-400 transition-all duration-300 hover:scale-105 text-sm lg:text-base py-2 px-2 font-medium">BERITA</a>
                <a href="<?php echo e(route('galeri.index')); ?>" class="hover:text-cyan-400 transition-all duration-300 hover:scale-105 text-sm lg:text-base py-2 px-2 font-medium">GALERI</a>
                <a href="/login" class="bg-gradient-to-r from-cyan-400 to-pink-500 px-6 py-2 rounded-full font-semibold hover:scale-105 transition-all duration-300 text-sm text-white ml-4 shadow-md">LOGIN</a>
            </div>
            
            <!-- Mobile Action Buttons -->
            <div class="md:hidden flex items-center space-x-3 ml-auto">
                <!-- Login Button (Always Visible) -->
                <a href="/login" class="bg-gradient-to-r from-cyan-400 to-pink-500 px-3 py-2 rounded-full font-semibold hover:scale-105 transition-all duration-300 text-xs text-white shadow-md" style="
                    color: white !important; 
                    text-decoration: none !important;
                    background: linear-gradient(135deg, #06b6d4, #ec4899) !important;
                    border: none !important;
                    font-weight: 600 !important;
                    text-shadow: 0 1px 2px rgba(0,0,0,0.5) !important;
                    min-width: 50px !important;
                    text-align: center !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                ">
                    LOGIN
                </a>
                
                <!-- Mobile Menu Button -->
                <button type="button" id="mobile-menu-btn" style="
                    position: relative;
                    z-index: 50;
                    background: rgba(6, 182, 212, 0.1);
                    border: 2px solid rgba(6, 182, 212, 0.5);
                    border-radius: 8px;
                    padding: 8px;
                    cursor: pointer;
                    min-width: 40px;
                    min-height: 40px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    transition: all 0.3s ease;
                    backdrop-filter: blur(10px);
                    -webkit-tap-highlight-color: transparent;
                ">
                    <i class="fas fa-bars text-lg" style="pointer-events: none; user-select: none;"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" style="
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: rgba(15, 23, 42, 0.98);
            backdrop-filter: blur(12px);
            border-top: 1px solid rgba(6, 182, 212, 0.3);
            transform: translateY(-100%);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 40;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        " class="md:hidden">
            <div class="py-6 px-6 space-y-2">
                <a href="#home" class="block py-3 px-4 rounded-lg hover:bg-cyan-400/10 hover:text-cyan-400 transition-all duration-300 text-white font-medium border-l-2 border-transparent hover:border-cyan-400">
                    <i class="fas fa-home mr-3 text-cyan-400"></i>BERANDA
                </a>
                <a href="#about" class="block py-3 px-4 rounded-lg hover:bg-cyan-400/10 hover:text-cyan-400 transition-all duration-300 text-white font-medium border-l-2 border-transparent hover:border-cyan-400">
                    <i class="fas fa-star mr-3 text-cyan-400"></i>KEUNGGULAN
                </a>
                <a href="#programs" class="block py-3 px-4 rounded-lg hover:bg-cyan-400/10 hover:text-cyan-400 transition-all duration-300 text-white font-medium border-l-2 border-transparent hover:border-cyan-400">
                    <i class="fas fa-graduation-cap mr-3 text-cyan-400"></i>PROGRAM
                </a>
                <a href="<?php echo e(route('berita.index')); ?>" class="block py-3 px-4 rounded-lg hover:bg-cyan-400/10 hover:text-cyan-400 transition-all duration-300 text-white font-medium border-l-2 border-transparent hover:border-cyan-400">
                    <i class="fas fa-newspaper mr-3 text-cyan-400"></i>BERITA
                </a>
                <a href="<?php echo e(route('galeri.index')); ?>" class="block py-3 px-4 rounded-lg hover:bg-cyan-400/10 hover:text-cyan-400 transition-all duration-300 text-white font-medium border-l-2 border-transparent hover:border-cyan-400">
                    <i class="fas fa-images mr-3 text-cyan-400"></i>GALERI
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <?php
        $activeBanner = \App\Models\HeroBanner::where('is_active', true)->latest()->first();
        $activeBackground = \App\Models\HeroBackground::where('is_active', true)->latest()->first();
        $heroStyle = '';
        
        // Background terpisah dari banner dengan optimasi scroll
        if($activeBackground && $activeBackground->image) {
            $heroStyle .= 'background-image: url(' . $activeBackground->image_url . ') !important;';
            $heroStyle .= 'background-size: cover !important;';
            $heroStyle .= 'background-position: center center !important;';
            $heroStyle .= 'background-repeat: no-repeat !important;';
            $heroStyle .= 'background-attachment: scroll !important;'; // Prevent stuttering
            $heroStyle .= 'position: relative !important;';
            // Add performance optimizations
            $heroStyle .= 'transform: translate3d(0, 0, 0) !important;';
            $heroStyle .= 'will-change: auto !important;';
            $heroStyle .= 'backface-visibility: hidden !important;';
        }
    ?>
    <section id="home" class="min-h-screen md:min-h-screen h-screen flex items-center justify-center relative overflow-hidden" style="padding-top: 80px; padding-bottom: 80px; <?php echo e($heroStyle); ?>">
        <?php if($activeBackground && $activeBackground->image): ?>
            <!-- Background Overlay for Better Text Readability -->
            <div class="absolute inset-0 bg-black/40 z-0"></div>
        <?php endif; ?>
        <div class="mobile-consistent-padding relative z-10" style="width: 100%; padding-top: 3rem;">
            <div class="flex justify-center items-start min-h-full">
                <?php if($activeBanner): ?>
                    <!-- Content Only - No Image -->
                    <div class="space-y-4 text-center" data-aos="fade-up" data-aos-duration="1000">
                        <div class="space-y-2">
                            <p class="text-cyan-400 bebas text-6xl tracking-wider"><?php echo e(strtoupper(setting('nama_sekolah', 'SMK PGRI CIKAMPEK'))); ?></p>
                            <h1 class="bebas text-7xl md:text-8xl leading-none">
                                <span class="gradient-text"><?php echo str_replace(['<br>', '<br/>', '<br />'], '</span><br><span class="gradient-text">', $activeBanner->title); ?></span>
                            </h1>
                        </div>
                        
                        <p class="text-gray-300 text-sm md:text-lg max-w-md mx-auto"><?php echo e($activeBanner->description); ?></p>
                        
                        <div class="flex flex-wrap gap-2 md:gap-4 justify-center">
                            <a href="<?php echo e($activeBanner->button_url); ?>" class="group relative px-8 py-4 bg-transparent border-2 border-cyan-400 rounded-lg overflow-hidden">
                                <span class="relative z-10 flex items-center">
                                    <i class="fas fa-rocket mr-2"></i>
                                    <?php echo e($activeBanner->button_text); ?>

                                </span>
                                <div class="absolute inset-0 bg-cyan-400 transform translate-x-full group-hover:translate-x-0 transition-transform duration-300"></div>
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Content Only - No Image -->
                    <div class="space-y-4 text-center" data-aos="fade-up" data-aos-duration="1000" style="margin-top: 2rem;">
                        <div class="space-y-2">
                            <h1 class="bebas text-5xl md:text-6xl leading-none hero-title-bold">
                                <span class="gradient-text">Siapkan Masa Depanmu di</span><br>
                                <span class="hero-school-name"><?php echo e(strtoupper(setting('nama_sekolah'))); ?></span>
                            </h1>
                        </div>
                        
                        <p class="text-gray-300 text-lg max-w-md mx-auto hero-description">
                            <?php echo e(setting('alamat_sekolah', 'Membentuk generasi visioner dengan pendidikan berbasis teknologi, kreativitas, dan karakter unggul.')); ?>

                        </p>
                        
                        <div class="flex flex-wrap gap-4 justify-center">
                            <a href="<?php echo e(route('ppdb.register')); ?>" class="group relative px-8 py-4 bg-transparent border-2 border-cyan-400 rounded-lg overflow-hidden">
                                <span class="relative z-10 flex items-center">
                                    <i class="fas fa-user-plus mr-2"></i>
                                    DAFTAR SEKARANG
                                </span>
                                <div class="absolute inset-0 bg-cyan-400 transform translate-x-full group-hover:translate-x-0 transition-transform duration-300"></div>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 relative">
        <!-- Animated Background -->
        <div class="absolute inset-0 pattern-bg">
            <ul class="animated-bg">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
            <div class="absolute inset-0 bg-gradient-to-br from-dark-bg/80 via-purple-900/15 to-dark-bg/80" style="z-index: 1;"></div>
        </div>

        <div class="mobile-consistent-padding relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <div class="text-electric-pink font-bold tracking-widest mb-4 uppercase">KEUNGGULAN KAMI</div>
                <h2 class="bebas text-5xl md:text-6xl gradient-text mb-6">MENGAPA <?php echo e(strtoupper(setting('nama_sekolah', 'SMK PGRI CIKAMPEK'))); ?>?</h2>
                <p class="text-white/80 text-lg max-w-3xl mx-auto">Pilih kami sebagai partner terbaik dalam mempersiapkan masa depan yang cerah dengan keunggulan yang telah terbukti.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <!-- Kurikulum Berbasis Industri -->
                <div class="col-span-1" data-aos="fade-up" data-aos-delay="100">
                    <div class="glass p-6 h-full">
                        <div class="h-32 mb-6 flex items-center justify-center bg-gradient-to-br from-cyan-400 to-blue-500 rounded-xl">
                            <i class="fas fa-graduation-cap text-white text-5xl"></i>
                        </div>
                        <h4 class="text-white text-xl font-bold mb-4">Kurikulum Berbasis Industri</h4>
                        <p class="text-white/80 mb-6 leading-relaxed">Kurikulum kami dirancang bersama partner industri teknologi terkemuka untuk memastikan relevansi dengan kebutuhan dunia kerja.</p>
                        <ul class="text-white/70 space-y-2">
                            <li class="flex items-center"><i class="fas fa-check text-neon-blue mr-2"></i>Materi Sesuai Industri</li>
                            <li class="flex items-center"><i class="fas fa-check text-neon-blue mr-2"></i>Praktek Kerja Lapangan</li>
                            <li class="flex items-center"><i class="fas fa-check text-neon-blue mr-2"></i>Sertifikasi Profesi</li>
                        </ul>
                    </div>
                </div>

                <!-- Teknologi Terkini -->
                <div class="col-span-1" data-aos="fade-up" data-aos-delay="200">
                    <div class="glass p-6 h-full">
                        <div class="h-32 mb-6 flex items-center justify-center bg-gradient-to-br from-pink-500 to-purple-500 rounded-xl">
                            <i class="fas fa-laptop-code text-white text-5xl"></i>
                        </div>
                        <h4 class="text-white text-xl font-bold mb-4">Teknologi Terkini</h4>
                        <p class="text-white/80 mb-6 leading-relaxed">Fasilitas teknologi modern untuk mendukung pembelajaran digital dan inovatif dengan peralatan canggih terdepan.</p>
                        <ul class="text-white/70 space-y-2">
                            <li class="flex items-center"><i class="fas fa-check text-electric-pink mr-2"></i>Lab Komputer Modern</li>
                            <li class="flex items-center"><i class="fas fa-check text-electric-pink mr-2"></i>Software Terbaru</li>
                            <li class="flex items-center"><i class="fas fa-check text-electric-pink mr-2"></i>Internet High Speed</li>
                        </ul>
                    </div>
                </div>

                <!-- Kerjasama Industri -->
                <div class="col-span-1" data-aos="fade-up" data-aos-delay="300">
                    <div class="glass p-6 h-full">
                        <div class="h-32 mb-6 flex items-center justify-center bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl">
                            <i class="fas fa-handshake text-white text-5xl"></i>
                        </div>
                        <h4 class="text-white text-xl font-bold mb-4">Kerjasama Industri</h4>
                        <p class="text-white/80 mb-6 leading-relaxed">Kemitraan dengan perusahaan teknologi terkemuka untuk program magang dan rekrutmen lulusan terbaik.</p>
                        <ul class="text-white/70 space-y-2">
                            <li class="flex items-center"><i class="fas fa-check text-yellow-400 mr-2"></i>Program Magang</li>
                            <li class="flex items-center"><i class="fas fa-check text-yellow-400 mr-2"></i>Job Placement</li>
                            <li class="flex items-center"><i class="fas fa-check text-yellow-400 mr-2"></i>Industry Mentoring</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Facilities Section -->
    <section class="facilities py-20 relative">
        <!-- Animated Background -->
        <div class="absolute inset-0 pattern-bg">
            <ul class="animated-bg">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
            <div class="absolute inset-0 bg-dark-bg/70" style="z-index: 1;"></div>
        </div>

        <div class="mobile-consistent-padding relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <div class="text-neon-blue font-bold tracking-widest mb-4 uppercase">FASILITAS UNGGULAN</div>
                <h2 class="bebas text-5xl md:text-6xl gradient-text mb-6">Fasilitas untuk Pembelajaran Optimal</h2>
                <p class="text-white/80 text-lg max-w-2xl mx-auto">Dilengkapi dengan fasilitas terdepan untuk mendukung proses pembelajaran yang efektif dan menyenangkan.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <!-- Fasilitas RPL -->
                <div class="col-span-1" data-aos="fade-up" data-aos-delay="100">
                    <div class="glass p-6 h-full">
                        <div class="h-32 mb-6 flex items-center justify-center bg-gradient-to-br from-neon-blue to-vibrant-purple rounded-xl">
                            <i class="fas fa-laptop-code text-white text-5xl"></i>
                        </div>
                        <h4 class="text-white text-xl font-bold mb-4">Lab Komputer & RPL</h4>
                        <p class="text-white/80 mb-6 leading-relaxed">Laboratorium komputer lengkap untuk pembelajaran programming, web development, dan rekayasa perangkat lunak.</p>
                        <ul class="text-white/70 space-y-2">
                            <li class="flex items-center"><i class="fas fa-check text-neon-blue mr-2"></i>40 Unit PC Spek Tinggi</li>
                            <li class="flex items-center"><i class="fas fa-check text-neon-blue mr-2"></i>IDE & Development Tools</li>
                            <li class="flex items-center"><i class="fas fa-check text-neon-blue mr-2"></i>Server & Database Systems</li>
                            <li class="flex items-center"><i class="fas fa-check text-neon-blue mr-2"></i>Software Testing Environment</li>
                        </ul>
                    </div>
                </div>

                <!-- Fasilitas TKR -->
                <div class="col-span-1" data-aos="fade-up" data-aos-delay="200">
                    <div class="glass p-6 h-full">
                        <div class="h-32 mb-6 flex items-center justify-center bg-gradient-to-br from-electric-pink to-vibrant-purple rounded-xl">
                            <i class="fas fa-car text-white text-5xl"></i>
                        </div>
                        <h4 class="text-white text-xl font-bold mb-4">Bengkel Otomotif (TKR)</h4>
                        <p class="text-white/80 mb-6 leading-relaxed">Bengkel otomotif standar industri untuk praktik perawatan dan perbaikan kendaraan ringan.</p>
                        <ul class="text-white/70 space-y-2">
                            <li class="flex items-center"><i class="fas fa-check text-electric-pink mr-2"></i>Mobil Praktik & Engine Stand</li>
                            <li class="flex items-center"><i class="fas fa-check text-electric-pink mr-2"></i>Alat Diagnostik EFI</li>
                            <li class="flex items-center"><i class="fas fa-check text-electric-pink mr-2"></i>Peralatan Tune Up & Overhaul</li>
                            <li class="flex items-center"><i class="fas fa-check text-electric-pink mr-2"></i>Lift Hidrolik & Tools Set</li>
                        </ul>
                    </div>
                </div>

                <!-- Fasilitas TMI -->
                <div class="col-span-1" data-aos="fade-up" data-aos-delay="300">
                    <div class="glass p-6 h-full">
                        <div class="h-32 mb-6 flex items-center justify-center bg-gradient-to-br from-vibrant-purple to-neon-blue rounded-xl">
                            <i class="fas fa-industry text-white text-5xl"></i>
                        </div>
                        <h4 class="text-white text-xl font-bold mb-4">Bengkel Mesin (TMI)</h4>
                        <p class="text-white/80 mb-6 leading-relaxed">Bengkel teknik mekanik industri untuk praktik mesin bubut, frais, CNC, dan perawatan mesin pabrik.</p>
                        <ul class="text-white/70 space-y-2">
                            <li class="flex items-center"><i class="fas fa-check text-vibrant-purple mr-2"></i>Mesin Bubut & Frais Konvensional</li>
                            <li class="flex items-center"><i class="fas fa-check text-vibrant-purple mr-2"></i>CNC Programming & Machining</li>
                            <li class="flex items-center"><i class="fas fa-check text-vibrant-purple mr-2"></i>Welding Equipment Set</li>
                            <li class="flex items-center"><i class="fas fa-check text-vibrant-purple mr-2"></i>Precision Measurement Tools</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="programs py-20 relative" id="programs">
        <!-- Animated Background -->
        <div class="absolute inset-0 pattern-bg">
            <ul class="animated-bg">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
            <div class="absolute inset-0 bg-gradient-to-br from-dark-bg/80 via-dark-bg/80 to-purple-900/15" style="z-index: 1;"></div>
        </div>

        <div class="mobile-consistent-padding relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <div class="text-electric-pink font-bold tracking-widest mb-4 uppercase">PROGRAM KEAHLIAN</div>
                <h2 class="bebas text-5xl md:text-6xl gradient-text mb-6">Program Unggulan Kami</h2>
                <p class="text-white/80 text-lg max-w-2xl mx-auto">Pilih jurusan yang sesuai dengan minat dan bakatmu untuk mempersiapkan karir di masa depan.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8 items-stretch">
                <?php $__currentLoopData = $jurusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="program-card-modern" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 100); ?>">
                    <div class="glass">
                        <!-- Program Image/Icon -->
                        <div class="program-image-container relative">
                            <?php if(file_exists(public_path('images/jurusan/'.$jur->kode_jurusan.'.jpg'))): ?>
                                <img src="<?php echo e(asset('images/jurusan/'.$jur->kode_jurusan.'.jpg')); ?>" class="program-image-modern" alt="<?php echo e($jur->nama_jurusan); ?>">
                                <div class="absolute inset-0 bg-gradient-to-t from-dark-bg/90 via-transparent to-transparent"></div>
                            <?php else: ?>
                                <div class="program-icon-fallback">
                                    <?php switch($jur->kode_jurusan):
                                        case ('RPL'): ?>
                                            <i class="fas fa-laptop-code text-6xl text-neon-blue"></i>
                                            <?php break; ?>
                                        <?php case ('TKR'): ?>
                                            <i class="fas fa-car text-6xl text-electric-pink"></i>
                                            <?php break; ?>
                                        <?php case ('TMI'): ?>
                                            <i class="fas fa-industry text-6xl text-vibrant-purple"></i>
                                            <?php break; ?>
                                        <?php default: ?>
                                            <i class="fas fa-microchip text-6xl text-neon-blue"></i>
                                    <?php endswitch; ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Overlay dengan program code -->
                            <div class="program-overlay">
                                <span class="program-code"><?php echo e($jur->kode_jurusan); ?></span>
                            </div>
                        </div>
                        
                        <!-- Program Content -->
                        <div class="program-content-modern p-6">
                            <h3 class="program-title-modern text-white text-xl font-bold mb-3"><?php echo e($jur->nama_jurusan); ?></h3>
                            <p class="program-description-modern text-white/70 mb-6 leading-relaxed"><?php echo e(Str::limit($jur->deskripsi, 120)); ?></p>
                            
                            <!-- Action Button -->
                            <a href="<?php echo e(url('jurusan/'.$jur->id)); ?>" class="program-link-modern group">
                                <span class="flex items-center justify-between">
                                    <span>Pelajari Lebih Lanjut</span>
                                    <i class="fas fa-arrow-right transition-transform group-hover:translate-x-2"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>  
    
    <!-- News Section -->
    <section class="news py-20 relative" id="news">
        <!-- Animated Background -->
        <div class="absolute inset-0 pattern-bg">
            <ul class="animated-bg">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
            <div class="absolute inset-0 bg-gradient-to-br from-dark-bg/80 via-purple-900/8 to-dark-bg/80" style="z-index: 1;"></div>
        </div>

        <div class="mobile-consistent-padding relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <div class="text-vibrant-purple font-bold tracking-widest mb-4 uppercase">BERITA & PENGUMUMAN</div>
                <h2 class="bebas text-5xl md:text-6xl gradient-text mb-6">Informasi Terbaru</h2>
            </div>
            
            <!-- Filter Buttons -->
            <div class="news-filter-container flex justify-center gap-1 mb-12 overflow-x-auto" data-aos="fade-up" id="news-filters" style="flex-wrap: nowrap !important; padding: 0 0.5rem;">
                <button class="news-filter-btn-modern active flex-shrink-0" data-filter="all" style="white-space: nowrap; background: linear-gradient(135deg, #7c3aed, #ec4899) !important; color: white !important; padding: 8px 14px !important; border-radius: 20px !important; border: 1px solid rgba(255,255,255,0.4) !important; font-weight: 600 !important; font-size: 0.75rem !important;">Semua</button>
                <button class="news-filter-btn-modern flex-shrink-0" data-filter="berita" style="white-space: nowrap; background: linear-gradient(135deg, rgba(124,58,237,0.8), rgba(236,72,153,0.8)) !important; color: white !important; padding: 8px 14px !important; border-radius: 20px !important; border: 1px solid rgba(255,255,255,0.4) !important; font-weight: 600 !important; font-size: 0.75rem !important;">Berita</button>
                <button class="news-filter-btn-modern flex-shrink-0" data-filter="pengumuman" style="white-space: nowrap; background: linear-gradient(135deg, rgba(124,58,237,0.8), rgba(236,72,153,0.8)) !important; color: white !important; padding: 8px 14px !important; border-radius: 20px !important; border: 1px solid rgba(255,255,255,0.4) !important; font-weight: 600 !important; font-size: 0.75rem !important;">Pengumuman</button>
                <button class="news-filter-btn-modern flex-shrink-0" data-filter="kegiatan" style="white-space: nowrap; background: linear-gradient(135deg, rgba(124,58,237,0.8), rgba(236,72,153,0.8)) !important; color: white !important; padding: 8px 14px !important; border-radius: 20px !important; border: 1px solid rgba(255,255,255,0.4) !important; font-weight: 600 !important; font-size: 0.75rem !important;">Kegiatan</button>
            </div>
            
            <!-- News Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                <?php $__currentLoopData = $pengumuman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="news-card-modern" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 100); ?>" data-category="pengumuman">
                    <div class="glass card-3d overflow-hidden h-full">
                        <!-- News Image -->
                        <div class="news-image-container relative">
                            <?php if($p->lampiran): ?>
                                <img src="<?php echo e(asset('storage/' . $p->lampiran)); ?>" alt="<?php echo e($p->judul); ?>" class="news-image-modern">
                                <div class="absolute inset-0 bg-gradient-to-t from-dark-bg/90 via-transparent to-transparent"></div>
                            <?php else: ?>
                                <div class="news-placeholder">
                                    <i class="fas fa-bullhorn text-4xl text-vibrant-purple"></i>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Category Badge -->
                            <div class="news-category-badge pengumuman">
                                <i class="fas fa-bullhorn mr-2"></i>Pengumuman
                            </div>
                        </div>
                        
                        <!-- News Content -->
                        <div class="news-content-modern p-6">
                            <div class="news-date-modern mb-3">
                                <i class="fas fa-calendar-alt mr-2 text-neon-blue"></i>
                                <span><?php echo e($p->tanggal_mulai->format('d M Y')); ?></span>
                            </div>
                            <h3 class="news-title-modern text-white text-lg font-bold mb-3 line-clamp-2"><?php echo e($p->judul); ?></h3>
                            <p class="news-description-modern text-white/70 mb-4 line-clamp-3"><?php echo e(Str::limit($p->isi, 100)); ?></p>
                            
                            <!-- Action Button -->
                            <a href="<?php echo e(url('pengumuman/'.$p->id)); ?>" class="news-link-modern group">
                                <span class="flex items-center justify-between">
                                    <span>Baca Selengkapnya</span>
                                    <i class="fas fa-arrow-right transition-transform group-hover:translate-x-2"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php $__currentLoopData = $berita; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="news-card-modern" data-aos="fade-up" data-aos-delay="<?php echo e(($loop->index + count($pengumuman)) * 100); ?>" data-category="berita">
                    <div class="glass card-3d overflow-hidden h-full">
                        <!-- News Image -->
                        <div class="news-image-container relative">
                            <?php if($b->foto): ?>
                                <img src="<?php echo e(asset('storage/' . $b->foto)); ?>" alt="<?php echo e($b->judul); ?>" class="news-image-modern">
                                <div class="absolute inset-0 bg-gradient-to-t from-dark-bg/90 via-transparent to-transparent"></div>
                            <?php else: ?>
                                <div class="news-placeholder">
                                    <i class="fas fa-newspaper text-4xl text-electric-pink"></i>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Category Badge -->
                            <div class="news-category-badge berita">
                                <i class="fas fa-newspaper mr-2"></i>Berita
                            </div>
                        </div>
                        
                        <!-- News Content -->
                        <div class="news-content-modern p-6">
                            <div class="news-date-modern mb-3">
                                <i class="fas fa-calendar-alt mr-2 text-neon-blue"></i>
                                <span><?php echo e($b->created_at->format('d M Y')); ?></span>
                            </div>
                            <h3 class="news-title-modern text-white text-lg font-bold mb-3 line-clamp-2"><?php echo e($b->judul); ?></h3>
                            <p class="news-description-modern text-white/70 mb-4 line-clamp-3"><?php echo e(Str::limit($b->isi, 100)); ?></p>
                            
                            <!-- Action Button -->
                            <a href="<?php echo e(url('berita/'.$b->id)); ?>" class="news-link-modern group">
                                <span class="flex items-center justify-between">
                                    <span>Baca Selengkapnya</span>
                                    <i class="fas fa-arrow-right transition-transform group-hover:translate-x-2"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <!-- View All Button -->
            <?php if($berita && $berita->count() > 0): ?>
            <div class="text-center" data-aos="fade-up">
                <a href="<?php echo e(route('berita.index')); ?>" class="cta-button-modern group">
                    <div class="flex items-center">
                        <div class="cta-icon-modern">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div class="cta-content-modern">
                            <div class="cta-title-modern">Lihat Semua Berita</div>
                            <div class="cta-subtitle-modern">Berita dan informasi terbaru</div>
                        </div>
                        <div class="cta-arrow-modern">
                            <i class="fas fa-arrow-right transition-transform group-hover:translate-x-2"></i>
                        </div>
                    </div>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery py-20 relative" id="gallery">
        <!-- Animated Background -->
        <div class="absolute inset-0 pattern-bg">
            <ul class="animated-bg">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
            <div class="absolute inset-0 bg-gradient-to-br from-purple-900/15 via-dark-bg/80 to-dark-bg/80" style="z-index: 1;"></div>
        </div>

        <div class="mobile-consistent-padding relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <div class="text-neon-blue font-bold tracking-widest mb-4 uppercase">GALERI KAMI</div>
                <h2 class="bebas text-5xl md:text-6xl gradient-text mb-6">Momen & Fasilitas</h2>
            </div>
            
            <!-- Filter Buttons -->
            <div class="gallery-filter-container flex justify-center gap-1 mb-12 overflow-x-auto" data-aos="fade-up" id="gallery-filters" style="flex-wrap: nowrap !important; padding: 0 0.5rem;">
                <button class="gallery-filter-btn-modern active flex-shrink-0" data-filter="all" style="white-space: nowrap; background: linear-gradient(135deg, #00d4ff, #3b82f6) !important; color: white !important; padding: 8px 12px !important; border-radius: 20px !important; border: 1px solid rgba(255,255,255,0.4) !important; font-weight: 600 !important; font-size: 0.75rem !important;">Semua</button>
                <button class="gallery-filter-btn-modern flex-shrink-0" data-filter="facilities" style="white-space: nowrap; background: linear-gradient(135deg, rgba(0,212,255,0.8), rgba(59,130,246,0.8)) !important; color: white !important; padding: 8px 12px !important; border-radius: 20px !important; border: 1px solid rgba(255,255,255,0.4) !important; font-weight: 600 !important; font-size: 0.75rem !important;">Fasilitas</button>
                <button class="gallery-filter-btn-modern flex-shrink-0" data-filter="activities" style="white-space: nowrap; background: linear-gradient(135deg, rgba(0,212,255,0.8), rgba(59,130,246,0.8)) !important; color: white !important; padding: 8px 12px !important; border-radius: 20px !important; border: 1px solid rgba(255,255,255,0.4) !important; font-weight: 600 !important; font-size: 0.75rem !important;">Kegiatan</button>
                <button class="gallery-filter-btn-modern flex-shrink-0" data-filter="competitions" style="white-space: nowrap; background: linear-gradient(135deg, rgba(0,212,255,0.8), rgba(59,130,246,0.8)) !important; color: white !important; padding: 8px 12px !important; border-radius: 20px !important; border: 1px solid rgba(255,255,255,0.4) !important; font-weight: 600 !important; font-size: 0.75rem !important;">Kompetisi</button>
                <button class="gallery-filter-btn-modern flex-shrink-0" data-filter="campus" style="white-space: nowrap; background: linear-gradient(135deg, rgba(0,212,255,0.8), rgba(59,130,246,0.8)) !important; color: white !important; padding: 8px 12px !important; border-radius: 20px !important; border: 1px solid rgba(255,255,255,0.4) !important; font-weight: 600 !important; font-size: 0.75rem !important;">Sekolah</button>
            </div>
            
            <!-- Gallery Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-3 mb-8" data-aos="fade-up">
                <?php $__empty_1 = true; $__currentLoopData = $galeri->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="gallery-item-modern" data-category="<?php echo e($item->kategori); ?>">
                    <div class="glass gallery-card-3d overflow-hidden">
                        <!-- Gallery Image -->
                        <div class="gallery-image-container relative">
                            <?php if($item->gambar): ?>
                                <img src="<?php echo e(asset_url($item->gambar)); ?>" alt="<?php echo e($item->judul); ?>" class="gallery-image-modern">
                            <?php else: ?>
                                <div class="gallery-placeholder">
                                    <i class="fas fa-images text-4xl text-neon-blue"></i>
                                    <span class="text-white/60 mt-2">Tidak ada foto</span>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Overlay -->
                            <div class="gallery-overlay-modern">
                                <div class="gallery-info-modern">
                                    <h3 class="text-white font-bold mb-2"><?php echo e($item->judul); ?></h3>
                                    <p class="text-white/80 text-sm mb-4"><?php echo e(Str::limit($item->deskripsi, 60)); ?></p>
                                    <a href="<?php echo e(route('galeri.show', $item->id)); ?>" class="gallery-view-btn-modern">
                                        <i class="fas fa-images mr-2"></i>Lihat Galeri
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-4 text-center py-16">
                    <div class="glass p-8">
                        <i class="fas fa-images text-6xl text-neon-blue mb-4"></i>
                        <div class="text-white text-lg">Belum ada foto di galeri</div>
                        <p class="text-white/60 mt-2">Galeri akan segera diperbarui dengan koleksi foto terbaru</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- View All Button -->
            <?php if($galeri && $galeri->count() > 0): ?>
            <div class="text-center" data-aos="fade-up">
                <a href="<?php echo e(route('galeri.index')); ?>" class="cta-button-modern group">
                    <div class="flex items-center">
                        <div class="cta-icon-modern">
                            <i class="fas fa-images"></i>
                        </div>
                        <div class="cta-content-modern">
                            <div class="cta-title-modern">Lihat Semua Galeri</div>
                            <div class="cta-subtitle-modern"><?php echo e($galeri->count()); ?> koleksi foto tersedia</div>
                        </div>
                        <div class="cta-arrow-modern">
                            <i class="fas fa-arrow-right transition-transform group-hover:translate-x-2"></i>
                        </div>
                    </div>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Quick Info Cards Section -->
    <section class="quick-info py-20 relative overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0 pattern-bg">
            <ul class="animated-bg">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
            <div class="absolute inset-0 bg-gradient-to-br from-electric-pink via-vibrant-purple to-neon-blue" style="z-index: 1;"></div>
            <div class="absolute inset-0 bg-dark-bg/60" style="z-index: 2;"></div>
        </div>

        <div class="mobile-consistent-padding relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <div class="text-white/90 font-bold tracking-widest mb-4 uppercase">INFORMASI CEPAT</div>
                <h2 class="bebas text-5xl md:text-6xl text-white mb-6 neon-glow">Hubungi Kami</h2>
                <p class="text-white/90 text-lg max-w-2xl mx-auto">Dapatkan informasi lengkap tentang pendaftaran dan program keahlian kami.</p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6" id="hubungi-kami-grid">
                <!-- Jam Operasional -->
                <div class="info-card-modern" data-aos="fade-up" data-aos-delay="100">
                    <div class="glass card-3d p-4 lg:p-6 text-center h-full flex flex-col justify-center">
                        <div class="info-icon-modern mb-3 lg:mb-4">
                            <i class="fas fa-clock text-3xl lg:text-4xl text-yellow-400"></i>
                        </div>
                        <h4 class="text-white text-sm lg:text-lg font-bold mb-2 lg:mb-3">Jam Operasional</h4>
                        <div class="text-white/90 space-y-1 text-xs lg:text-sm">
                            <div class="font-semibold">Senin - Jumat:</div>
                            <div class="text-neon-blue">07:00 - 16:00</div>
                            <div class="font-semibold mt-2">Sabtu:</div>
                            <div class="text-neon-blue">07:00 - 12:00</div>
                        </div>
                    </div>
                </div>

                <!-- Kontak -->
                <div class="info-card-modern" data-aos="fade-up" data-aos-delay="200">
                    <div class="glass card-3d p-4 lg:p-6 text-center h-full flex flex-col justify-center">
                        <div class="info-icon-modern mb-3 lg:mb-4">
                            <i class="fas fa-phone text-3xl lg:text-4xl text-green-400"></i>
                        </div>
                        <h4 class="text-white text-sm lg:text-lg font-bold mb-2 lg:mb-3">Kontak Kami</h4>
                        <div class="text-white/90 space-y-1 text-xs lg:text-sm">
                            <div class="flex items-center justify-center">
                                <i class="fas fa-phone mr-2 text-neon-blue text-sm"></i>
                                <span class="truncate"><?php echo e(setting('telepon_sekolah', '(0264) 123456')); ?></span>
                            </div>
                            <div class="flex items-center justify-center break-all">
                                <i class="fas fa-envelope mr-2 text-neon-blue text-sm"></i>
                                <span class="truncate"><?php echo e(substr(setting('email_sekolah', 'info@smkpgricikampek.sch.id'), 0, 20)); ?>...</span>
                            </div>
                            <div class="flex items-center justify-center">
                                <i class="fab fa-whatsapp mr-2 text-neon-blue text-sm"></i>
                                <span class="truncate"><?php echo e(setting('whatsapp_number', '089650011916')); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lokasi -->
                <div class="info-card-modern" data-aos="fade-up" data-aos-delay="300">
                    <div class="glass card-3d p-4 lg:p-6 text-center h-full flex flex-col justify-center">
                        <div class="info-icon-modern mb-3 lg:mb-4">
                            <i class="fas fa-map-marker-alt text-3xl lg:text-4xl text-red-400"></i>
                        </div>
                        <h4 class="text-white text-sm lg:text-lg font-bold mb-2 lg:mb-3">Lokasi</h4>
                        <div class="text-white/90 mb-2 lg:mb-4 text-xs lg:text-sm leading-relaxed">
                            <?php echo e(Str::limit(setting('alamat_sekolah', 'Jl. Raya Cikampek No. 123, Cikampek, Karawang, Jawa Barat'), 60)); ?>

                        </div>
                        <a href="https://maps.app.goo.gl/dGWc88VSu6Pog29j7" target="_blank" class="location-link-modern text-xs lg:text-sm px-3 lg:px-4 py-1 lg:py-2">
                            <i class="fas fa-external-link-alt mr-1 md:mr-2 text-xs md:text-sm"></i>Maps
                        </a>
                    </div>
                </div>

                <!-- Pendaftaran -->
                <div class="info-card-modern" data-aos="fade-up" data-aos-delay="400">
                    <div class="glass card-3d p-4 lg:p-6 text-center h-full flex flex-col justify-center">
                        <div class="info-icon-modern mb-3 lg:mb-4">
                            <i class="fas fa-user-plus text-3xl lg:text-4xl text-cyan-400"></i>
                        </div>
                        <h4 class="text-white text-sm lg:text-lg font-bold mb-2 lg:mb-3">Pendaftaran</h4>
                        <div class="text-white/90 mb-2 lg:mb-4 space-y-1 text-xs lg:text-sm">
                            <div class="font-semibold text-neon-blue">PPDB 2025/2026</div>
                            <div>Gel 1: Mar - Mei</div>
                            <div>Gel 2: Jun - Jul</div>
                        </div>
                        <a href="<?php echo e(route('ppdb.register')); ?>" class="register-btn-modern text-xs lg:text-sm px-3 lg:px-6 py-1 lg:py-2">
                            Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-modern relative overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-br from-dark-bg via-purple-900/30 to-dark-bg"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
            <ul class="animated-bg opacity-30">
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>

        <div class="mobile-consistent-padding relative z-10">
            <!-- Main Footer Content -->
            <div class="footer-main-modern py-8" data-aos="fade-up">
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <!-- School Info -->
                    <div class="footer-info-modern lg:col-span-2">
                        <a href="<?php echo e(url('/')); ?>" class="footer-logo-modern mb-4 inline-flex items-center">
                            <img src="<?php echo e(setting('logo_sekolah') ? asset('storage/' . setting('logo_sekolah')) : asset('images/default-logo.png')); ?>" alt="Logo" class="h-12 w-12 mr-3">
                            <span class="footer-logo-text"><?php echo e(setting('nama_sekolah', 'SMK PGRI CIKAMPEK')); ?></span>
                        </a>
                        
                        <p class="footer-description-modern">
                            <?php echo e(setting('site_description', 'Mempersiapkan generasi muda untuk menjadi talenta digital berkualitas yang siap menghadapi tantangan industri teknologi masa depan.')); ?>

                        </p>
                        
                        <!-- Contact Info -->
                        <div class="footer-contact-modern">
                            <?php if(setting('alamat_sekolah')): ?>
                            <div class="contact-item-modern">
                                <div class="contact-icon-modern">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <span><?php echo e(setting('alamat_sekolah')); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if(setting('telepon_sekolah')): ?>
                            <div class="contact-item-modern">
                                <div class="contact-icon-modern">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <span><?php echo e(setting('telepon_sekolah')); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if(setting('email_sekolah')): ?>
                            <div class="contact-item-modern">
                                <div class="contact-icon-modern">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <span><?php echo e(setting('email_sekolah')); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="footer-bottom-modern py-8 border-t border-white/10">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    
                    <!-- Social Media -->
                    <div class="footer-social-modern" data-aos="fade-up" data-aos-delay="100">
                        <div class="footer-social-title">Ikuti Kami</div>
                        <div class="social-links-modern">
                            <?php if(setting('facebook_url')): ?>
                            <a href="<?php echo e(setting('facebook_url')); ?>" class="social-link-modern facebook" target="_blank" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if(setting('instagram_url')): ?>
                            <a href="<?php echo e(setting('instagram_url')); ?>" class="social-link-modern instagram" target="_blank" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if(setting('youtube_url')): ?>
                            <a href="<?php echo e(setting('youtube_url')); ?>" class="social-link-modern youtube" target="_blank" aria-label="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if(setting('whatsapp_number')): ?>
                            <a href="https://wa.me/<?php echo e(setting('whatsapp_number')); ?>" class="social-link-modern whatsapp" target="_blank" aria-label="WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Copyright -->
                    <div class="footer-copyright-modern text-center md:text-right" data-aos="fade-up" data-aos-delay="200">
                        <div class="copyright-text">
                            &copy; <?php echo e(date('Y')); ?> <?php echo e(setting('nama_sekolah', 'SMK PGRI CIKAMPEK')); ?>

                        </div>
                        <div class="made-with">
                            Made with <span class="heart">❤️</span> by Yaddddddddddddddddddddd
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer Glow Effect -->
        <div class="footer-glow-effect"></div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/<?php echo e(setting('whatsapp_number', '08123456789')); ?>?text=<?php echo e(urlencode('Halo, saya ingin bertanya tentang ' . setting('nama_sekolah', 'sekolah'))); ?>"
       class="whatsapp-float"
       target="_blank"
       aria-label="Chat WhatsApp"
       style="position: fixed; bottom: 80px; right: 8px; background: #25d366; color: white; width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; z-index: 1000; box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4); transition: all 0.3s ease; text-decoration: none;">
        <i class="fab fa-whatsapp"></i>
    </a>

<!-- Custom script for mobile layout fixes -->
<script>
    // Function to set the hero section height correctly on mobile
    function setHeroHeight() {
        const heroSection = document.getElementById('home');
        if (heroSection && window.innerWidth < 768) {
            // Get viewport height
            const vh = window.innerHeight;
            // Set the hero section height to exactly viewport height
            heroSection.style.height = vh + 'px';
            heroSection.style.maxHeight = vh + 'px';
            heroSection.style.overflow = 'hidden';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Set hero height on page load and resize
        setHeroHeight();
        window.addEventListener('resize', setHeroHeight);
        window.addEventListener('orientationchange', setHeroHeight);
        
        // Also run after a short delay to ensure it works after all content loads
        setTimeout(setHeroHeight, 500);
        // Function to ensure "Hubungi Kami" section has proper 2x2 grid on mobile
        function setupHubungiKamiGrid() {
            const hubungiKamiGrid = document.getElementById('hubungi-kami-grid');
            
            if (hubungiKamiGrid) {
                
                // Force grid layout for all screen sizes
                hubungiKamiGrid.style.display = 'grid';
                hubungiKamiGrid.style.gridTemplateColumns = 'repeat(2, 1fr)';
                hubungiKamiGrid.style.gridTemplateRows = 'repeat(2, auto)';
                hubungiKamiGrid.style.gap = '0.75rem';
                hubungiKamiGrid.style.width = '100%';
                <!-- Hubungi Kami Grid Setup - Moved to external JS -->
    
</body>
</html><?php /**PATH C:\wamp64\www\website-smk3\resources\views/welcome.blade.php ENDPATH**/ ?>