@extends('layouts.tata_usaha')

@section('page-header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Siswa</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Kelola data siswa, pembayaran, dan informasi akademik</p>
        </div>
        <div class="flex items-center space-x-3">
            <button class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Tambah Siswa
            </button>
            <button class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                <i class="fas fa-file-import mr-2"></i>
                Import Excel
            </button>
        </div>
    </div>
@endsection

@section('content')
<!-- Search and Filter -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
    <form method="GET" action="{{ route('tata-usaha.siswa.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cari Siswa</label>
            <div class="relative">
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Nama, NIS, atau NISN..." 
                       class="w-full px-4 py-3 pl-10 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-gray-100">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </div>
        
        <div>
            <label for="kelas_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kelas</label>
            <select id="kelas_id" 
                    name="kelas_id" 
                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-gray-100">
                <option value="">Semua Kelas</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
            <select id="status" 
                    name="status" 
                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-gray-100">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">&nbsp;</label>
            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                <i class="fas fa-filter mr-2"></i>
                Filter
            </button>
        </div>
    </form>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold">{{ $siswa->total() }}</p>
                <p class="text-blue-100 text-sm">Total Siswa</p>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-user-check text-2xl"></i>
                </div>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold">{{ $siswa->where('status', 'aktif')->count() }}</p>
                <p class="text-green-100 text-sm">Siswa Aktif</p>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-user-graduate text-2xl"></i>
                </div>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold">{{ $siswa->where('status', 'lulus')->count() }}</p>
                <p class="text-yellow-100 text-sm">Lulus</p>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-venus-mars text-2xl"></i>
                </div>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold">{{ $siswa->where('jenis_kelamin', 'L')->count() }}/{{ $siswa->where('jenis_kelamin', 'P')->count() }}</p>
                <p class="text-purple-100 text-sm">L/P</p>
            </div>
        </div>
    </div>
</div>

<!-- Students Table -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl mr-4">
                <i class="fas fa-table text-blue-600 dark:text-blue-400 text-xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Data Siswa</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Daftar lengkap siswa dan informasi terkait</p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <button class="inline-flex items-center px-3 py-2 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                <i class="fas fa-download mr-2"></i>
                Export
            </button>
            <button class="inline-flex items-center px-3 py-2 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                <i class="fas fa-print mr-2"></i>
                Print
            </button>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Siswa</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">NIS/NISN</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status Bayar</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($siswa as $index => $s)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mr-3 text-white font-semibold text-sm">
                                {{ strtoupper(substr($s->nama_lengkap, 0, 2)) }}
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $s->nama_lengkap }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $s->email ?? 'Email belum diisi' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-gray-100 font-mono">
                            <div>{{ $s->nis ?? '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $s->nisn ?? '-' }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                            {{ $s->kelas->nama_kelas ?? 'Belum ada kelas' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-900/30 text-gray-800 dark:text-gray-300">
                            <i class="fas fa-info-circle mr-1"></i>
                            Data belum tersedia
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @switch($s->status)
                            @case('aktif')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                    Aktif
                                </span>
                                @break
                            @case('tidak_aktif')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-900/30 text-gray-800 dark:text-gray-300">
                                    Tidak Aktif
                                </span>
                                @break
                            @case('lulus')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                    Lulus
                                </span>
                                @break
                            @case('pindah')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                                    Pindah
                                </span>
                                @break
                            @default
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-900/30 text-gray-800 dark:text-gray-300">
                                    {{ ucfirst($s->status) }}
                                </span>
                        @endswitch
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('tata-usaha.siswa.show', $s) }}" 
                               class="inline-flex items-center px-2 py-1 text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-md hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                                <i class="fas fa-eye mr-1"></i>
                                Detail
                            </a>
                            <a href="{{ route('tata-usaha.siswa.edit', $s) }}" 
                               class="inline-flex items-center px-2 py-1 text-xs bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-md hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                            <button onclick="confirmDelete('{{ route('tata-usaha.siswa.destroy', $s) }}')"
                                    class="inline-flex items-center px-2 py-1 text-xs bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-md hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors">
                                <i class="fas fa-trash mr-1"></i>
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-500">
                            <i class="fas fa-users text-6xl mb-4 text-gray-300"></i>
                            <h3 class="text-lg font-medium mb-2">Tidak ada data siswa</h3>
                            <p class="text-sm">Belum ada siswa yang terdaftar atau sesuai dengan filter.</p>
                            <a href="{{ route('tata-usaha.siswa.create') }}" 
                               class="mt-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Siswa Pertama
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
        <div class="text-sm text-gray-500 dark:text-gray-400">
            Menampilkan 1-10 dari 1,234 siswa
        </div>
        <div class="flex items-center space-x-2">
            <button class="px-3 py-2 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="px-3 py-2 text-sm bg-blue-600 text-white rounded-md">1</button>
            <button class="px-3 py-2 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">2</button>
            <button class="px-3 py-2 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">3</button>
            <span class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400">...</span>
            <button class="px-3 py-2 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">124</button>
            <button class="px-3 py-2 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>
@endsection
