<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard Kesiswaan - SMK PGRI CIKAMPEK')</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        
        html, body {
            font-family: 'Outfit', sans-serif;
        }
        
        h1, h2, h3, h4, h5, h6, p, span, a, button, input, select, textarea, div, table {
            font-family: 'Outfit', sans-serif;
        }
    </style>
    
    @yield('styles')
</head>
<body class="bg-gray-100 text-gray-800 antialiased" x-data="{ sidebarOpen: false }">
    <!-- Flash Messages -->
    @if(session('success'))
    <div class="fixed top-4 right-4 z-50 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-md rounded-r-md" 
         x-data="{show: true}" x-show="show" x-init="setTimeout(() => show = false, 5000)">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <p>{{ session('success') }}</p>
            <button @click="show = false" class="ml-4 text-green-800 hover:text-green-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="fixed top-4 right-4 z-50 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 shadow-md rounded-r-md" 
         x-data="{show: true}" x-show="show" x-init="setTimeout(() => show = false, 5000)">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            <p>{{ session('error') }}</p>
            <button @click="show = false" class="ml-4 text-red-800 hover:text-red-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    <div class="min-h-screen bg-gray-100 flex">
        <!-- Sidebar -->
        <div x-cloak class="relative flex-shrink-0">
            <!-- Overlay untuk mobile -->
            <div class="fixed inset-0 z-20 transition-opacity ease-linear duration-300" 
                :class="{'opacity-100 block': sidebarOpen && window.innerWidth < 1024, 'opacity-0 hidden': !sidebarOpen || window.innerWidth >= 1024}"
                @click="sidebarOpen = false">
                <div class="absolute inset-0 bg-gray-900 backdrop-blur-sm opacity-60"></div>
            </div>

            <!-- Sidebar -->
            <aside class="fixed top-0 left-0 z-30 w-64 bg-white shadow-lg transform transition-all duration-300 ease-in-out h-full pt-16 lg:pt-0 lg:top-16 lg:h-[calc(100%-4rem)]" 
                :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">

                <!-- Sidebar Content -->
                <div class="overflow-y-auto h-full">
                    <nav class="p-3 pt-2">
                        <ul class="space-y-0.5">
                            <li>
                                <a href="{{ route('kesiswaan.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('kesiswaan.dashboard') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group' }}">
                                    <i class="fas fa-tachometer-alt {{ request()->routeIs('kesiswaan.dashboard') ? '' : 'text-gray-600 group-hover:text-blue-600' }}"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            
                            <li class="pt-2">
                                <div class="text-xs uppercase text-gray-500 font-semibold px-3 py-2">Manajemen Siswa</div>
                            </li>
                            
                            <li>
                                <a href="{{ route('kesiswaan.siswa.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('kesiswaan.siswa.*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group' }}">
                                    <i class="fas fa-user-graduate {{ request()->routeIs('kesiswaan.siswa.*') ? '' : 'text-gray-600 group-hover:text-blue-600' }}"></i>
                                    <span>Data Siswa</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('kesiswaan.absensi.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('kesiswaan.absensi.*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group' }}">
                                    <i class="fas fa-clipboard-check {{ request()->routeIs('kesiswaan.absensi.*') ? '' : 'text-gray-600 group-hover:text-blue-600' }}"></i>
                                    <span>Kehadiran</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('kesiswaan.keterlambatan.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('kesiswaan.keterlambatan.*') ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group' }}">
                                    <i class="fas fa-clock {{ request()->routeIs('kesiswaan.keterlambatan.*') ? '' : 'text-gray-600 group-hover:text-orange-600' }}"></i>
                                    <span>Keterlambatan</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('kesiswaan.kegiatan.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('kesiswaan.kegiatan.*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group' }}">
                                    <i class="fas fa-calendar-alt {{ request()->routeIs('kesiswaan.kegiatan.*') ? '' : 'text-gray-600 group-hover:text-blue-600' }}"></i>
                                    <span>Kegiatan Siswa</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('kesiswaan.pelanggaran.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('kesiswaan.pelanggaran.*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group' }}">
                                    <i class="fas fa-exclamation-triangle {{ request()->routeIs('kesiswaan.pelanggaran.*') ? '' : 'text-gray-600 group-hover:text-blue-600' }}"></i>
                                    <span>Pelanggaran</span>
                                </a>
                            </li>
                            
                            <li class="pt-2">
                                <div class="text-xs uppercase text-gray-500 font-semibold px-3 py-2">Laporan & Statistik</div>
                            </li>
                            
                            <li>
                                <a href="{{ route('kesiswaan.laporan.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('kesiswaan.laporan.*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group' }}">
                                    <i class="fas fa-chart-bar {{ request()->routeIs('kesiswaan.laporan.*') ? '' : 'text-gray-600 group-hover:text-blue-600' }}"></i>
                                    <span>Laporan</span>
                                </a>
                            </li>
                        </ul>
                        
                        <div class="mt-8 p-4 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-100">
                            <div class="flex items-center justify-center text-blue-500 mb-3">
                                <i class="fas fa-graduation-cap text-xl"></i>
                            </div>
                            <p class="text-sm text-center text-gray-700">Dashboard Kesiswaan SMK PGRI Cikampek</p>
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
                        <!-- Sidebar Toggle Button with Animation -->
                        <button @click="sidebarOpen = !sidebarOpen" type="button" class="text-gray-700 hover:text-blue-600 focus:outline-none mr-4 transition-all duration-300 ease-in-out flex items-center justify-center h-9 w-9 rounded-lg z-50" 
                        :class="{'bg-blue-50': sidebarOpen}">
                            <svg class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" 
                            :class="{'text-blue-600 rotate-90': sidebarOpen, 'text-gray-700': !sidebarOpen}">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </button>
                        

                        
                        <!-- School Logo and Name -->
                        <div class="flex items-center">
                            <h1 class="text-lg font-bold text-gray-800 hidden sm:block">
                                SMK PGRI CIKAMPEK
                            </h1>
                            <h1 class="text-lg font-bold text-gray-800 sm:hidden">
                                SMK PGRI
                            </h1>
                        </div>
                        
                        <!-- Date and Time Display -->
                        <div class="hidden md:flex items-center ml-6 space-x-3">
                            <!-- Live Clock -->
                            <div class="bg-gradient-to-r from-gray-800 to-gray-700 text-white px-3 py-1.5 rounded-lg font-mono flex items-center shadow-sm">
                                <i class="fas fa-clock mr-2 text-blue-400"></i>
                                <span id="header-clock" class="tracking-wider">00:00:00</span>
                            </div>
                            
                            <!-- Date Display -->
                            <div class="bg-blue-50 px-3 py-1.5 rounded-lg flex items-center">
                                <i class="fas fa-calendar-alt text-blue-600"></i>
                                <span class="ml-2 text-sm font-medium text-gray-700">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
                            </div>
                        </div>
                        
                        <!-- Mobile Date Display -->
                        <div class="md:hidden flex items-center ml-4 space-x-2">
                            <div class="bg-gray-800 text-white px-2 py-1 rounded font-mono text-sm flex items-center">
                                <span id="header-clock-mobile" class="tracking-wider">00:00</span>
                            </div>
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-calendar-day text-blue-600 mr-1"></i>
                                <span>{{ now()->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Breadcrumb (Hidden on small screens) -->
                        <div class="hidden sm:flex items-center text-sm px-3 py-1.5 bg-gray-50 rounded-lg">
                            <a href="{{ route('kesiswaan.dashboard') }}" class="text-blue-600 font-medium">Kesiswaan</a>
                            @if(!request()->routeIs('kesiswaan.dashboard'))
                            <span class="mx-2 text-gray-400">/</span>
                            <span class="text-gray-600">
                                @if(request()->segment(2))
                                    {{ ucfirst(request()->segment(2)) }}
                                @endif
                            </span>
                            @endif
                        </div>
                        
                        <!-- Divider -->
                        <div class="h-8 w-0.5 bg-gray-200 hidden sm:block"></div>

                        <!-- User Menu Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none" id="user-menu-button">
                                <div class="hidden sm:block">
                                    <div class="flex flex-col items-end">
                                        <span class="text-sm font-medium text-gray-800">{{ Auth::user()->name ?? 'Kesiswaan' }}</span>
                                        <span class="text-xs text-blue-600 font-medium">Kesiswaan</span>
                                    </div>
                                </div>
                                <div class="h-10 w-10 rounded-full ring-2 ring-blue-500 p-0.5 bg-white overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Kesiswaan' }}&background=3b82f6&color=ffffff" 
                                        alt="Kesiswaan Avatar" class="h-full w-full rounded-full object-cover"/>
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
                                    <p class="text-xs text-gray-500">Selamat {{ now()->format('H') < 12 ? 'Pagi' : (now()->format('H') < 15 ? 'Siang' : (now()->format('H') < 18 ? 'Sore' : 'Malam')) }},</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'Kesiswaan' }}</p>
                                </div>
                                <a href="{{ route('kesiswaan.profile.index') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 group">
                                    <i class="fas fa-user-circle mr-2 text-blue-500 group-hover:text-blue-600"></i> Profil Saya
                                </a>
                                <a href="{{ route('kesiswaan.dashboard') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 group">
                                    <i class="fas fa-tachometer-alt mr-2 text-blue-500 group-hover:text-blue-600"></i> Dashboard
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 group">
                                        <i class="fas fa-sign-out-alt mr-2 group-hover:text-red-700"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-visible bg-gray-100 p-2 mt-16">
                <div class="w-full">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Header Live Clock -->
    <script>
        // Live clock functionality
        function updateHeaderClock() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            
            // Update desktop clock
            const headerClock = document.getElementById('header-clock');
            if (headerClock) {
                headerClock.textContent = `${hours}:${minutes}:${seconds}`;
            }
            
            // Update mobile clock (without seconds to save space)
            const mobileHeaderClock = document.getElementById('header-clock-mobile');
            if (mobileHeaderClock) {
                mobileHeaderClock.textContent = `${hours}:${minutes}`;
            }
        }
        
        // Update clock every second
        setInterval(updateHeaderClock, 1000);
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', updateHeaderClock);
    </script>

    @stack('scripts')
</body>
</html>
