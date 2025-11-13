<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $__env->yieldContent('title', 'Tata Usaha - SMK PGRI CIKAMPEK'); ?></title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Browser compatibility fixes -->
    <link href="<?php echo e(asset('css/compatibility-fixes.css')); ?>" rel="stylesheet">
    
    <!-- Admin Fallback CSS untuk memastikan basic styling selalu ada -->
    <link href="<?php echo e(asset('css/admin-fallback.css')); ?>?v=<?php echo e(time()); ?>" rel="stylesheet">
        
    <!-- Vite Assets -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <!-- Force Tailwind CDN for immediate styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        if (window.tailwind) {
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            'outfit': ['Outfit', 'sans-serif'],
                            'sans': ['Outfit', 'sans-serif']
                        }
                    }
                }
            };
        }
    </script>

    <!-- Custom CSS -->
    <style>
        [x-cloak] { display: none !important; }
        
        /* Font settings for the entire tata usaha page */
        html, body {
            font-family: 'Outfit', sans-serif;
        }
        
        /* Ensure all text elements inherit the Outfit font */
        h1, h2, h3, h4, h5, h6, p, span, a, button, input, select, textarea, div, table {
            font-family: 'Outfit', sans-serif;
        }
        
        /* Heading styles */
        h1 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
        }
        
        h2, h3 {
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
        }
        
        h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
            font-weight: 500;
        }
        
        /* Button and interactive elements */
        button, a, .btn {
            font-family: 'Outfit', sans-serif;
            font-weight: 500;
        }
        
        /* Text paragraphs */
        p, div, span {
            font-family: 'Outfit', sans-serif;
            font-weight: 400;
        }
        
        /* Font class utilities */
        .font-outfit {
            font-family: 'Outfit', sans-serif;
        }
        
        .text-base {
            font-size: 1rem;
            font-family: 'Outfit', sans-serif;
        }

        @media (min-width: 1024px) {
            .sidebar-desktop {
                position: fixed !important;
                height: calc(100% - 4rem) !important;
                top: 4rem !important;
                z-index: 20;
                width: 16rem;
                background-color: white;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            main {
                transition: all 0.3s ease;
                width: 100%;
            }
            
            main.ml-0 {
                margin-left: 0;
                width: 100%;
            }
            
            main.lg\:ml-64 {
                margin-left: 16rem;
                width: calc(100% - 16rem);
            }
            
            @media (max-width: 1023px) {
                main {
                    margin-left: 0 !important;
                    width: 100% !important;
                }
            }
        }
        
        /* Mobile sidebar */
        @media (max-width: 1023px) {
            .sidebar-mobile {
                position: fixed !important;
                top: 4rem !important;
                height: calc(100vh - 4rem) !important;
                overflow-y: auto !important;
                z-index: 30;
                width: 16rem;
            }
        }
        
        /* Animation */
        @keyframes wave {
            0% { transform: rotate(0deg); }
            10% { transform: rotate(14deg); }
            20% { transform: rotate(-8deg); }
            30% { transform: rotate(14deg); }
            40% { transform: rotate(-4deg); }
            50% { transform: rotate(10deg); }
            60% { transform: rotate(0deg); }
            100% { transform: rotate(0deg); }
        }
        .animate-wave {
            animation: wave 2s ease-in-out infinite;
            transform-origin: 70% 70%;
            display: inline-block;
        }

        /* Sidebar animations untuk konsistensi dengan admin */
        .sidebar-slide-in {
            animation: slideIn 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        
        .sidebar-slide-out {
            animation: slideOut 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        
        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }
        
        @keyframes slideOut {
            from { transform: translateX(0); }
            to { transform: translateX(-100%); }
        }
    </style>
    
    <!-- Sidebar functionality script (sama seperti admin) -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('sidebarData', () => ({
                sidebarOpen: window.innerWidth >= 1024, // Sidebar terbuka secara default di desktop
                
                init() {
                    this.handleResize()
                    window.addEventListener('resize', () => this.handleResize())
                    
                    // Watch for sidebar changes and update layout
                    this.$watch('sidebarOpen', () => this.updateLayout())
                },
                
                toggleSidebar() {
                    this.sidebarOpen = !this.sidebarOpen
                },
                
                handleResize() {
                    const isMobile = window.innerWidth < 1024
                    if (isMobile && this.sidebarOpen) {
                        // On mobile, close sidebar when resizing
                        this.sidebarOpen = false
                    } else if (!isMobile) {
                        // On desktop, ensure sidebar is open
                        this.sidebarOpen = true
                    }
                },
                
                updateLayout() {
                    const mainContent = document.querySelector('main')
                    const isMobile = window.innerWidth < 1024
                    
                    // Update the main content width explicitly - only for desktop
                    if (mainContent && !isMobile) {
                        if (this.sidebarOpen) {
                            mainContent.classList.remove('ml-0')
                            mainContent.classList.add('lg:ml-64')
                        } else {
                            mainContent.classList.add('ml-0')
                            mainContent.classList.remove('lg:ml-64')
                        }
                    }
                    
                    // Add a class to body to prevent scrolling when sidebar is open on mobile
                    if (isMobile) {
                        if (this.sidebarOpen) {
                            document.body.classList.add('overflow-hidden')
                        } else {
                            setTimeout(() => {
                                document.body.classList.remove('overflow-hidden')
                            }, 300) // Wait for transition to complete before re-enabling scroll
                        }
                    }
                    
                    // Document body class for layout adjustments
                    if (this.sidebarOpen) {
                        document.body.classList.add('sidebar-expanded')
                        document.body.classList.remove('sidebar-collapsed')
                    } else {
                        document.body.classList.add('sidebar-collapsed')
                        document.body.classList.remove('sidebar-expanded')
                    }
                }
            }))
        })
        
        // Live Clock Functions
        function updateClock() {
            const now = new Date();
            const time = now.toLocaleTimeString('id-ID', {
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            const timeShort = now.toLocaleTimeString('id-ID', {
                hour12: false,
                hour: '2-digit',
                minute: '2-digit'
            });
            
            const clockElement = document.getElementById('header-clock');
            const clockMobileElement = document.getElementById('header-clock-mobile');
            
            if (clockElement) clockElement.textContent = time;
            if (clockMobileElement) clockMobileElement.textContent = timeShort;
        }
        
        // Update clock every second
        setInterval(updateClock, 1000);
        document.addEventListener('DOMContentLoaded', updateClock);
    </script>
</head>

<body class="bg-gray-100 text-gray-800 antialiased sidebar-expanded font-outfit" x-data="sidebarData">
    <!-- Flash Messages -->
    <?php if(session('success')): ?>
    <div class="fixed top-20 right-4 z-50 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-md rounded-r-md" role="alert" x-data="{show: true}" x-show="show" x-init="setTimeout(() => show = false, 5000)">
        <div class="flex items-center">
            <span class="material-symbols-outlined mr-2">check_circle</span>
            <p><?php echo e(session('success')); ?></p>
            <button @click="show = false" class="ml-4 text-green-800 hover:text-green-900">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="fixed top-20 right-4 z-50 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 shadow-md rounded-r-md" role="alert" x-data="{show: true}" x-show="show" x-init="setTimeout(() => show = false, 5000)">
        <div class="flex items-center">
            <span class="material-symbols-outlined mr-2">error</span>
            <p><?php echo e(session('error')); ?></p>
            <button @click="show = false" class="ml-4 text-red-800 hover:text-red-900">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
    </div>
    <?php endif; ?>

    <div class="min-h-screen bg-gray-100 flex">
        <!-- Sidebar -->
        <div x-cloak class="relative flex-shrink-0">
            <!-- Overlay untuk mobile ketika sidebar dibuka -->
            <div class="fixed inset-0 z-20 transition-opacity ease-linear duration-300" 
                :class="{'opacity-100 block': sidebarOpen && window.innerWidth < 1024, 'opacity-0 hidden': !sidebarOpen || window.innerWidth >= 1024}"
                @click="sidebarOpen = false">
                <div class="absolute inset-0 bg-gray-900 backdrop-blur-sm opacity-60"></div>
            </div>

            <!-- Sidebar -->
            <aside class="fixed top-0 left-0 z-30 w-64 bg-white shadow-lg transform transition-all duration-300 ease-in-out h-full pt-16 lg:pt-0 lg:top-16 lg:h-[calc(100%-4rem)] lg:sidebar-desktop" 
                :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen, 'sidebar-slide-in': sidebarOpen, 'sidebar-slide-out': !sidebarOpen}">

                <!-- Sidebar Content -->
                <div class="overflow-y-auto h-full lg:h-full scrollbar-thin scrollbar-thumb-green-200 scrollbar-track-gray-50">
                    <nav class="p-3 pt-2">
                        <ul class="space-y-0.5">
                            <li>
                                <a href="<?php echo e(route('tata-usaha.index')); ?>" class="flex items-center space-x-3 p-3 rounded-lg <?php echo e(request()->routeIs('tata-usaha.index') ? 'bg-gradient-to-r from-green-500 to-green-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group'); ?>">
                                    <i class="fas fa-home <?php echo e(request()->routeIs('tata-usaha.index') ? '' : 'text-gray-600 group-hover:text-green-600'); ?>"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            
                            <li class="pt-2">
                                <div class="text-xs uppercase text-gray-500 font-semibold px-3 py-2">Manajemen Siswa</div>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(route('tata-usaha.siswa.index')); ?>" class="flex items-center space-x-3 p-3 rounded-lg <?php echo e(request()->routeIs('tata-usaha.siswa.*') ? 'bg-gradient-to-r from-green-500 to-green-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group'); ?>">
                                    <i class="fas fa-users <?php echo e(request()->routeIs('tata-usaha.siswa.*') ? '' : 'text-gray-600 group-hover:text-green-600'); ?>"></i>
                                    <span>Data Siswa</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(route('tata-usaha.siswa.create')); ?>" class="flex items-center space-x-3 p-3 rounded-lg ml-6 hover:bg-gray-50 transition-all duration-300 group">
                                    <i class="fas fa-user-plus text-gray-500 group-hover:text-green-600"></i>
                                    <span class="text-sm">Tambah Siswa</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(route('tata-usaha.siswa.mutasi')); ?>" class="flex items-center space-x-3 p-3 rounded-lg ml-6 hover:bg-gray-50 transition-all duration-300 group">
                                    <i class="fas fa-exchange-alt text-gray-500 group-hover:text-green-600"></i>
                                    <span class="text-sm">Mutasi Siswa</span>
                                </a>
                            </li>
                            
                            <li class="pt-2">
                                <div class="text-xs uppercase text-gray-500 font-semibold px-3 py-2">Keuangan</div>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(route('tata-usaha.keuangan.pembayaran')); ?>" class="flex items-center space-x-3 p-3 rounded-lg <?php echo e(request()->routeIs('tata-usaha.keuangan.pembayaran') ? 'bg-gradient-to-r from-green-500 to-green-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group'); ?>">
                                    <i class="fas fa-credit-card <?php echo e(request()->routeIs('tata-usaha.keuangan.pembayaran') ? '' : 'text-gray-600 group-hover:text-green-600'); ?>"></i>
                                    <span>Pembayaran</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(route('tata-usaha.keuangan.tagihan')); ?>" class="flex items-center space-x-3 p-3 rounded-lg ml-6 hover:bg-gray-50 transition-all duration-300 group">
                                    <i class="fas fa-file-invoice text-gray-500 group-hover:text-green-600"></i>
                                    <span class="text-sm">Tagihan</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(route('tata-usaha.keuangan.tunggakan')); ?>" class="flex items-center space-x-3 p-3 rounded-lg ml-6 hover:bg-gray-50 transition-all duration-300 group">
                                    <i class="fas fa-exclamation-triangle text-gray-500 group-hover:text-green-600"></i>
                                    <span class="text-sm">Tunggakan</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(route('tata-usaha.laporan')); ?>" class="flex items-center space-x-3 p-3 rounded-lg ml-6 <?php echo e(request()->routeIs('tata-usaha.laporan') ? 'bg-gradient-to-r from-green-500 to-green-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group'); ?>">
                                    <i class="fas fa-chart-bar <?php echo e(request()->routeIs('tata-usaha.laporan') ? '' : 'text-gray-500 group-hover:text-green-600'); ?>"></i>
                                    <span class="text-sm">Laporan</span>
                                </a>
                            </li>
                            
                            <li class="pt-2">
                                <div class="text-xs uppercase text-gray-500 font-semibold px-3 py-2">Administrasi</div>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(route('tata-usaha.administrasi.surat')); ?>" class="flex items-center space-x-3 p-3 rounded-lg ml-6 hover:bg-gray-50 transition-all duration-300 group">
                                    <i class="fas fa-envelope text-gray-500 group-hover:text-green-600"></i>
                                    <span class="text-sm">Surat Menyurat</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(route('tata-usaha.administrasi.dokumen')); ?>" class="flex items-center space-x-3 p-3 rounded-lg ml-6 hover:bg-gray-50 transition-all duration-300 group">
                                    <i class="fas fa-folder text-gray-500 group-hover:text-green-600"></i>
                                    <span class="text-sm">Dokumen</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(route('tata-usaha.administrasi.arsip')); ?>" class="flex items-center space-x-3 p-3 rounded-lg ml-6 hover:bg-gray-50 transition-all duration-300 group">
                                    <i class="fas fa-archive text-gray-500 group-hover:text-green-600"></i>
                                    <span class="text-sm">Arsip</span>
                                </a>
                            </li>
                            
                            <li class="pt-2">
                                <div class="text-xs uppercase text-gray-500 font-semibold px-3 py-2">Data Master</div>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(route('tata-usaha.inventaris.index')); ?>" class="flex items-center space-x-3 p-3 rounded-lg <?php echo e(request()->routeIs('tata-usaha.inventaris.*') ? 'bg-gradient-to-r from-green-500 to-green-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group'); ?>">
                                    <i class="fas fa-boxes <?php echo e(request()->routeIs('tata-usaha.inventaris.*') ? '' : 'text-gray-600 group-hover:text-green-600'); ?>"></i>
                                    <span>Inventaris</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(route('tata-usaha.guru.index')); ?>" class="flex items-center space-x-3 p-3 rounded-lg <?php echo e(request()->routeIs('tata-usaha.guru.*') ? 'bg-gradient-to-r from-green-500 to-green-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group'); ?>">
                                    <i class="fas fa-chalkboard-teacher <?php echo e(request()->routeIs('tata-usaha.guru.*') ? '' : 'text-gray-600 group-hover:text-green-600'); ?>"></i>
                                    <span>Data Guru</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(route('tata-usaha.master.kelas')); ?>" class="flex items-center space-x-3 p-3 rounded-lg ml-6 hover:bg-gray-50 transition-all duration-300 group">
                                    <i class="fas fa-door-open text-gray-500 group-hover:text-green-600"></i>
                                    <span class="text-sm">Kelas</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(route('tata-usaha.master.jurusan')); ?>" class="flex items-center space-x-3 p-3 rounded-lg ml-6 hover:bg-gray-50 transition-all duration-300 group">
                                    <i class="fas fa-graduation-cap text-gray-500 group-hover:text-green-600"></i>
                                    <span class="text-sm">Jurusan</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(route('tata-usaha.master.tahun-ajaran')); ?>" class="flex items-center space-x-3 p-3 rounded-lg ml-6 hover:bg-gray-50 transition-all duration-300 group">
                                    <i class="fas fa-calendar-alt text-gray-500 group-hover:text-green-600"></i>
                                    <span class="text-sm">Tahun Ajaran</span>
                                </a>
                            </li>
                            
                            <li class="pt-2">
                                <div class="text-xs uppercase text-gray-500 font-semibold px-3 py-2">Sistem</div>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(route('tata-usaha.settings')); ?>" class="flex items-center space-x-3 p-3 rounded-lg <?php echo e(request()->routeIs('tata-usaha.settings') ? 'bg-gradient-to-r from-green-500 to-green-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group'); ?>">
                                    <i class="fas fa-cog <?php echo e(request()->routeIs('tata-usaha.settings') ? '' : 'text-gray-600 group-hover:text-green-600'); ?>"></i>
                                    <span>Pengaturan</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(route('tata-usaha.help')); ?>" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-all duration-300 group">
                                    <i class="fas fa-question-circle text-gray-600 group-hover:text-green-600"></i>
                                    <span>Bantuan</span>
                                </a>
                            </li>
                        </ul>
                        
                        <!-- Support Card -->
                        <div class="mt-6 p-4 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border border-green-100 hover:shadow-md transition-all">
                            <div class="flex items-center justify-center text-green-500 mb-3">
                                <i class="fas fa-headset text-xl"></i>
                            </div>
                            <p class="text-sm text-center text-gray-700">Butuh bantuan? Hubungi tim support kami</p>
                            <a href="<?php echo e(route('tata-usaha.help')); ?>" class="block w-full mt-2 bg-gradient-to-r from-green-500 to-green-600 border border-green-200 rounded-lg py-2 text-center text-sm text-white hover:shadow-lg hover:from-green-600 hover:to-green-700 transition-all duration-300">
                                Bantuan
                            </a>
                        </div>
                    </nav>
                </div>
            </aside>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col w-full h-full flex-grow">
            <!-- Top Navigation -->
            <header class="bg-white shadow-md z-50 fixed top-0 left-0 w-full h-16 transition-all duration-300 ease-in-out">
                <div class="px-6 py-3 flex justify-between items-center h-full">
                    <div class="flex items-center">
                        <!-- Sidebar Toggle Button -->
                        <button @click="sidebarOpen = !sidebarOpen" type="button" 
                                class="text-gray-700 hover:text-green-600 focus:outline-none mr-4 transition-all duration-300 ease-in-out flex items-center justify-center h-9 w-9 rounded-lg z-50" 
                                :class="{'bg-green-50': sidebarOpen}">
                            <svg class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" 
                                 :class="{'text-green-600 rotate-90': sidebarOpen, 'text-gray-700': !sidebarOpen}">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </button>
                        
                        <!-- Mobile Menu Button -->
                        <button @click="sidebarOpen = !sidebarOpen" type="button" 
                            class="fixed bottom-6 right-6 lg:hidden bg-green-600 hover:bg-green-700 text-white p-3.5 rounded-full shadow-lg z-50 flex items-center justify-center transition-all duration-300 transform hover:scale-110"
                            style="box-shadow: 0 4px 15px rgba(34, 197, 94, 0.35);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                :class="{'hidden': sidebarOpen}">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                :class="{'hidden': !sidebarOpen}">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        
                        <!-- School Logo and Name -->
                        <div class="flex items-center">
                            <h1 class="text-lg font-bold text-gray-800 hidden sm:block">
                                SMK PGRI CIKAMPEK - Tata Usaha
                            </h1>
                            <h1 class="text-lg font-bold text-gray-800 sm:hidden">
                                Tata Usaha
                            </h1>
                        </div>
                        
                        <!-- Date and Time Display -->
                        <div class="hidden md:flex items-center ml-6 space-x-3">
                            <!-- Live Clock -->
                            <div class="bg-gradient-to-r from-gray-800 to-gray-700 text-white px-3 py-1.5 rounded-lg font-mono flex items-center shadow-sm">
                                <i class="fas fa-clock mr-2 text-green-400"></i>
                                <span id="header-clock" class="tracking-wider">00:00:00</span>
                            </div>
                            
                            <!-- Date Display -->
                            <div class="bg-green-50 px-3 py-1.5 rounded-lg flex items-center">
                                <i class="fas fa-calendar-alt text-green-600"></i>
                                <span class="ml-2 text-sm font-medium text-gray-700"><?php echo e(now()->isoFormat('dddd, D MMMM Y')); ?></span>
                            </div>
                        </div>
                        
                        <!-- Mobile Date Display -->
                        <div class="md:hidden flex items-center ml-4 space-x-2">
                            <div class="bg-gray-800 text-white px-2 py-1 rounded font-mono text-sm flex items-center">
                                <span id="header-clock-mobile" class="tracking-wider">00:00</span>
                            </div>
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-calendar-day text-green-600 mr-1"></i>
                                <span><?php echo e(now()->format('d/m/Y')); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Breadcrumb -->
                        <div class="hidden sm:flex items-center text-sm px-3 py-1.5 bg-gray-50 rounded-lg">
                            <a href="<?php echo e(route('tata-usaha.index')); ?>" class="text-green-600 font-medium">Dashboard</a>
                            <?php if(!request()->routeIs('tata-usaha.index')): ?>
                            <span class="mx-2 text-gray-400">/</span>
                            <span class="text-gray-600">
                                <?php if(request()->segment(2)): ?>
                                    <?php echo e(ucfirst(request()->segment(2))); ?>

                                <?php endif; ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Divider -->
                        <div class="h-8 w-0.5 bg-gray-200 hidden sm:block"></div>

                        <!-- User Menu Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none" id="user-menu-button">
                                <div class="hidden sm:block">
                                    <div class="flex flex-col items-end">
                                        <span class="text-sm font-medium text-gray-800"><?php echo e(Auth::user()->name ?? 'Tata Usaha'); ?></span>
                                        <span class="text-xs text-green-600 font-medium">Tata Usaha</span>
                                    </div>
                                </div>
                                <div class="h-10 w-10 rounded-full ring-2 ring-green-500 p-0.5 bg-white overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name=<?php echo e(Auth::user()->name ?? 'Tata Usaha'); ?>&background=22c55e&color=ffffff" 
                                        alt="User Avatar" class="h-full w-full rounded-full object-cover"/>
                                </div>
                                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                            </button>
                            
                            <!-- User Dropdown Menu -->
                            <div x-show="open" 
                                @click.away="open = false" 
                                x-transition:enter="transition ease-out duration-100" 
                                x-transition:enter-start="transform opacity-0 scale-95" 
                                x-transition:enter-end="transform opacity-100 scale-100" 
                                x-transition:leave="transition ease-in duration-75" 
                                x-transition:leave-start="transform opacity-100 scale-100" 
                                x-transition:leave-end="transform opacity-0 scale-95" 
                                class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg z-50 py-2 border border-gray-100">
                                <!-- User Menu Items -->
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-xs text-gray-500">Selamat <?php echo e(now()->format('H') < 12 ? 'Pagi' : (now()->format('H') < 15 ? 'Siang' : (now()->format('H') < 18 ? 'Sore' : 'Malam'))); ?>,</p>
                                    <p class="text-sm font-semibold text-gray-800"><?php echo e(Auth::user()->name ?? 'Tata Usaha'); ?></p>
                                </div>
                                <a href="<?php echo e(route('tata-usaha.settings')); ?>" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 group">
                                    <i class="fas fa-user-circle mr-2 text-green-500 group-hover:text-green-600"></i> Profil Saya
                                </a>
                                <a href="<?php echo e(route('tata-usaha.settings')); ?>" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 group">
                                    <i class="fas fa-cog mr-2 text-green-500 group-hover:text-green-600"></i> Pengaturan
                                </a>
                                <a href="<?php echo e(route('tata-usaha.help')); ?>" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 group">
                                    <i class="fas fa-question-circle mr-2 text-green-500 group-hover:text-green-600"></i> Bantuan
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="block w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 group">
                                        <i class="fas fa-sign-out-alt mr-2 group-hover:text-red-700"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main :class="sidebarOpen ? 'lg:ml-64' : 'ml-0'" 
                  class="flex-1 pt-20 pb-8 px-6 transition-all duration-300 ease-in-out bg-gray-50 min-h-screen">
                
                <!-- Page Header -->
                <?php if (! empty(trim($__env->yieldContent('page-header')))): ?>
                <div class="mb-8">
                    <?php echo $__env->yieldContent('page-header'); ?>
                </div>
                <?php endif; ?>
                
                <!-- Flash Messages -->
                <?php if(session('success')): ?>
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center" 
                     x-data="{ show: true }" 
                     x-show="show" 
                     x-transition:enter="transition ease-out duration-300" 
                     x-transition:enter-start="opacity-0 transform scale-90" 
                     x-transition:enter-end="opacity-100 transform scale-100">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span><?php echo e(session('success')); ?></span>
                    <button @click="show = false" class="ml-auto text-green-700 hover:text-green-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg flex items-center" 
                     x-data="{ show: true }" 
                     x-show="show" 
                     x-transition:enter="transition ease-out duration-300" 
                     x-transition:enter-start="opacity-0 transform scale-90" 
                     x-transition:enter-end="opacity-100 transform scale-100">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span><?php echo e(session('error')); ?></span>
                    <button @click="show = false" class="ml-auto text-red-700 hover:text-red-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <?php endif; ?>
                
                <!-- Page Content -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 min-h-96">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
<?php /**PATH C:\wamp64\www\website-smk3\resources\views\layouts\tata_usaha.blade.php ENDPATH**/ ?>