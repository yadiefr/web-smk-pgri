<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard Guru - SMK PGRI CIKAMPEK')</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Guru Layout CSS - Main layout styles moved to separate file for better maintainability -->
    <link href="{{ asset('css/guru-layout.css') }}?v={{ time() }}" rel="stylesheet">

    <!-- Tailwind CSS (Production Build) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Error Handler (Manages browser console errors) -->
    <script src="{{ asset('js/error-handler.js') }}"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Guru Layout JavaScript - Layout stabilizer and Alpine.js data moved to separate file -->
    <script src="{{ asset('js/guru-layout.js') }}?v={{ time() }}"></script>
    
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100 text-gray-800 antialiased sidebar-expanded" x-data="sidebarData" data-vite-loaded="true">
    <!-- Flash Messages -->
    @if(session('success'))
    <div class="fixed top-4 right-4 z-50 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-md rounded-r-md" role="alert" x-data="{show: true}" x-show="show" x-init="setTimeout(() => show = false, 5000)">
        <div class="flex items-center">
            <span class="material-symbols-outlined mr-2">check_circle</span>
            <p>{{ session('success') }}</p>
            <button @click="show = false" class="ml-4 text-green-800 hover:text-green-900">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
    </div>
    @endif
    
    @if(session('error'))
    <div class="fixed top-4 right-4 z-50 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 shadow-md rounded-r-md" role="alert" x-data="{show: true}" x-show="show" x-init="setTimeout(() => show = false, 5000)">
        <div class="flex items-center">
            <span class="material-symbols-outlined mr-2">error</span>
            <p>{{ session('error') }}</p>
            <button @click="show = false" class="ml-4 text-red-800 hover:text-red-900">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
    </div>
    @endif

    <div class="min-h-screen bg-gray-100 flex">
        <!-- Sidebar -->
        <div x-cloak class="relative flex-shrink-0">
            <!-- Overlay untuk mobile ketika sidebar dibuka -->
            <div class="fixed inset-0 z-20 transition-opacity ease-linear duration-100" 
                :class="{'opacity-100 block': sidebarOpen && window.innerWidth < 1024 && isMobile, 'opacity-0 hidden': !sidebarOpen || window.innerWidth >= 1024}"
                @click="sidebarOpen = false">
                <div class="absolute inset-0 bg-gray-900 backdrop-blur-sm opacity-60"></div>
            </div>
            
            <!-- Sidebar -->
            <aside class="fixed top-16 left-0 z-30 w-64 bg-white shadow-lg h-[calc(100vh-4rem)] lg:pt-0 lg:top-16 lg:h-[calc(100%-4rem)] lg:sidebar-desktop lg:translate-x-0" 
                :class="{ 'translate-x-0': sidebarOpen && window.innerWidth < 1024, '-translate-x-full': !sidebarOpen && window.innerWidth < 1024 }"
                style="transition: transform 0.2s ease;">

                <!-- Sidebar Content -->
                <div class="overflow-y-auto h-full lg:h-full scrollbar-thin scrollbar-thumb-blue-200 scrollbar-track-gray-50">
                    <nav class="p-3 pt-2">
                        <ul class="space-y-0.5">
                            <li>
                                <a href="{{ route('guru.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('guru.dashboard') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group' }}">
                                    <i class="fas fa-tachometer-alt {{ request()->routeIs('guru.dashboard') ? '' : 'text-gray-600 group-hover:text-blue-600' }}"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            
                            <li class="pt-2">
                                <div class="text-xs uppercase text-gray-500 font-semibold px-3 py-2">Akademik</div>
                            </li>
                            <li>
                                <a href="{{ route('guru.jadwal.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('guru.jadwal*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group' }}">
                                    <i class="fas fa-calendar {{ request()->routeIs('guru.jadwal*') ? '' : 'text-gray-600 group-hover:text-blue-600' }}"></i>
                                    <span>Jadwal Mengajar</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('guru.nilai.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('guru.nilai*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group' }}">
                                    <i class="fas fa-star {{ request()->routeIs('guru.nilai*') ? '' : 'text-gray-600 group-hover:text-blue-600' }}"></i>
                                    <span>Nilai Siswa</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('guru.absensi.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('guru.absensi*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group' }}">
                                    <i class="fas fa-clipboard-check {{ request()->routeIs('guru.absensi*') ? '' : 'text-gray-600 group-hover:text-blue-600' }}"></i>
                                    <span>Absensi</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('guru.siswa.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('guru.siswa*') && !request()->routeIs('guru.wali-kelas*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group' }}">
                                    <i class="fas fa-user-graduate {{ request()->routeIs('guru.siswa*') && !request()->routeIs('guru.wali-kelas*') ? '' : 'text-gray-600 group-hover:text-blue-600' }}"></i>
                                    <span>Data Siswa</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('guru.kelas.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('guru.kelas*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group' }}">
                                    <i class="fas fa-users {{ request()->routeIs('guru.kelas*') ? '' : 'text-gray-600 group-hover:text-blue-600' }}"></i>
                                    <span>Daftar Kelas</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('guru.materi.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('guru.materi*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group' }}">
                                    <i class="fas fa-book {{ request()->routeIs('guru.materi*') ? '' : 'text-gray-600 group-hover:text-blue-600' }}"></i>
                                    <span>Materi & Tugas</span>
                                </a>
                            </li>
                                    
                            @if(Auth::guard('guru')->check() && Auth::guard('guru')->user()->is_wali_kelas)
                            <li>
                                <a href="{{ route('guru.wali-kelas.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('guru.wali-kelas*') ? 'bg-gradient-to-r from-purple-500 to-purple-600 text-white font-medium shadow-sm' : 'hover:bg-purple-50 transition-all duration-300 group' }}">
                                    <i class="fas fa-chalkboard-teacher {{ request()->routeIs('guru.wali-kelas*') ? '' : 'text-purple-600 group-hover:text-purple-700' }}"></i>
                                    <span class="flex items-center">
                                        Wali Kelas
                                        <span class="ml-2 px-2 py-0.5 text-xs bg-purple-100 text-purple-800 rounded-full">Khusus</span>
                                    </span>
                                </a>
                            </li>
                            @endif

                            <li class="pt-2">
                                <div class="text-xs uppercase text-gray-500 font-semibold px-3 py-2">Lainnya</div>
                            </li>
                            <li>
                                <a href="{{ route('guru.pengumuman.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('guru.pengumuman*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group' }}">
                                    <i class="fas fa-bullhorn {{ request()->routeIs('guru.pengumuman*') ? '' : 'text-gray-600 group-hover:text-blue-600' }}"></i>
                                    <span>Pengumuman</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('guru.profile.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('guru.profile.*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium shadow-sm' : 'hover:bg-gray-50 transition-all duration-300 group' }}">
                                    <i class="fas fa-user-circle {{ request()->routeIs('guru.profile.*') ? '' : 'text-gray-600 group-hover:text-blue-600' }}"></i>
                                    <span>Profil Saya</span>
                                </a>
                            </li>
                        </ul>
                        
                        <div class="mt-8 p-4 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-100 hover:shadow-md transition-all">
                            <div class="flex items-center justify-center text-blue-500 mb-3">
                                <i class="fas fa-headset text-xl"></i>
                            </div>
                            <p class="text-sm text-center text-gray-700">Butuh bantuan? Hubungi administrator</p>
                            <a href="{{ route('guru.dashboard') }}" class="block w-full mt-2 bg-gradient-to-r from-blue-500 to-blue-600 border border-blue-200 rounded-lg py-2 text-center text-sm text-white hover:shadow-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300">
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
            <header class="bg-white shadow-md z-40 fixed top-0 left-0 w-full h-16">
                <div class="px-2 sm:px-4 lg:px-6 py-2 flex justify-between items-center h-full">
                    <div class="flex items-center flex-1 min-w-0">
                        <!-- Sidebar Toggle Button with Animation -->
                        <button @click="toggleSidebar()" type="button" class="text-gray-700 hover:text-blue-600 focus:outline-none mr-2 sm:mr-3 transition-colors duration-200 ease-in-out flex items-center justify-center h-8 w-8 sm:h-9 sm:w-9 rounded-lg z-50 flex-shrink-0" 
                        :class="{'bg-blue-50': sidebarOpen}">
                            <svg class="h-5 w-5 sm:h-6 sm:w-6 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" 
                            :class="{'text-blue-600 rotate-90': sidebarOpen, 'text-gray-700': !sidebarOpen}">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </button>
                        
                        <!-- School Logo and Name -->
                        <div class="flex items-center min-w-0 flex-1">
                            <h1 class="text-sm sm:text-base lg:text-lg font-bold text-gray-800 truncate">
                                <span class="hidden sm:inline">SMK PGRI CIKAMPEK</span>
                                <span class="sm:hidden">SMK PGRI</span>
                            </h1>
                        </div>
                        
                        <!-- Date Display -->
                        <div class="hidden lg:flex items-center ml-4 space-x-1 bg-blue-50 px-3 py-1.5 rounded-lg flex-shrink-0">
                            <i class="fas fa-calendar-alt text-blue-600"></i>
                            <span class="ml-2 text-sm font-medium text-gray-700">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
                        </div>
                        
                        <!-- Mobile Date Display -->
                        <div class="lg:hidden flex items-center ml-2 text-xs sm:text-sm text-gray-600 flex-shrink-0">
                            <i class="fas fa-calendar-day text-blue-600 mr-1"></i>
                            <span class="hidden xs:inline">{{ now()->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2 sm:space-x-4 flex-shrink-0">

                        <!-- User Menu Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-1 sm:space-x-2 focus:outline-none p-1" id="user-menu-button">
                                <div class="hidden md:block">
                                    <div class="flex flex-col items-end">
                                        <span class="text-xs sm:text-sm font-medium text-gray-800 truncate max-w-16 sm:max-w-24 lg:max-w-none">{{ auth()->user()->name ?? 'Guru' }}</span>
                                        <span class="text-xs text-blue-600 font-medium">Guru</span>
                                    </div>
                                </div>
                                <div class="h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 rounded-full ring-1 sm:ring-2 ring-blue-500 p-0.5 bg-white overflow-hidden flex-shrink-0">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b82f6&color=ffffff" 
                                        class="h-full w-full rounded-full object-cover"
                                        alt="{{ auth()->user()->name }}">
                                </div>
                                <i class="fas fa-chevron-down text-xs text-gray-500 hidden md:block"></i>
                            </button>
                              <!-- User Dropdown Menu -->
                            <div x-show="open" x-cloak
                                @click.away="open = false" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 sm:w-56 bg-white rounded-xl shadow-lg z-50 py-2 border border-gray-100"
                                :class="window.innerWidth < 480 ? 'right-0 w-44' : 'right-0 w-56'">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-xs text-gray-500">Selamat {{ now()->format('H') < 12 ? 'Pagi' : (now()->format('H') < 15 ? 'Siang' : (now()->format('H') < 18 ? 'Sore' : 'Malam')) }},</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name ?? 'Guru' }}</p>
                                </div>
                                <a href="{{ route('guru.profile.index') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 group">
                                    <i class="fas fa-user-circle mr-2 text-blue-500 group-hover:text-blue-600"></i> Profil Saya
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>                                
                                <form method="POST" action="/guru/logout">
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
            <main class="flex-1 overflow-x-hidden overflow-y-visible bg-gray-100 p-2 sm:p-3 lg:p-6 mt-16 transition-all duration-300 ease-in-out min-h-screen"
                :class="{ 'ml-0 w-full': !sidebarOpen || window.innerWidth < 1024, 'lg:ml-64': sidebarOpen && window.innerWidth >= 1024 }">
                <div class="main-content-container transition-all duration-300 origin-right rounded-lg sm:rounded-xl shadow-sm w-full max-w-full overflow-hidden">
                    @hasSection('content')
                        @yield('content')
                    @else
                        @yield('main-content')
                    @endif
                </div>
            </main>
        </div>    </div>

    @stack('scripts')
</body>
</html>
