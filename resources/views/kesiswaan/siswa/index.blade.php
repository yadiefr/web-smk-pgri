@extends('layouts.kesiswaan')

@section('title', 'Data Siswa')

@section('content')
<div class="space-y-6">
    <!-- Header dengan search dan filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-users mr-3 text-blue-600"></i>
                    Data Siswa
                </h1>
                <div class="flex items-center mt-1 space-x-4">
                    <p class="text-gray-600">Kelola data siswa sekolah</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <a href="{{ route('kesiswaan.siswa.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Siswa
                </a>
            </div>
        </div>
        
        <!-- Filter dan Search -->
        <form method="GET" class="mt-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                    <input type="text" 
                           name="search" 
                           id="search"
                           value="{{ request('search') }}"
                           placeholder="Nama, NIS, atau NISN"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="jurusan_id" class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                    <select name="jurusan_id" id="jurusan_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusan as $j)
                            <option value="{{ $j->id }}" {{ request('jurusan_id') == $j->id ? 'selected' : '' }}>
                                {{ $j->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="mutasi" {{ request('status') == 'mutasi' ? 'selected' : '' }}>Mutasi</option>
                        <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                    </select>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-search mr-2"></i>
                    Filter
                </button>
                <a href="{{ route('kesiswaan.siswa.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Tabel Data Siswa -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Info Total Data -->
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-700">
                    <span class="font-medium">{{ $siswa->count() }}</span> siswa ditampilkan
                    @if(request()->hasAny(['search', 'jurusan_id', 'kelas_id', 'status']))
                        <span class="text-blue-600 ml-2">
                            <i class="fas fa-filter mr-1"></i>
                            (Terfilter)
                        </span>
                    @endif
                </p>
                <p class="text-xs text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Data diurutkan berdasarkan kelas kemudian nama siswa
                </p>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Data Siswa
                            <i class="fas fa-sort-alpha-down text-blue-500 ml-1" title="Diurutkan berdasarkan nama"></i>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kelas
                            <i class="fas fa-sort-alpha-down text-blue-500 ml-1" title="Diurutkan berdasarkan kelas"></i>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php $currentKelas = null; @endphp
                    @forelse($siswa as $s)
                        @if($currentKelas != $s->kelas?->nama_kelas)
                            @php $currentKelas = $s->kelas?->nama_kelas; @endphp
                            <tr class="bg-blue-50 border-t-2 border-blue-200">
                                <td colspan="5" class="px-6 py-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>
                                            <span class="font-semibold text-blue-900">
                                                {{ $currentKelas ? $currentKelas : 'Belum Ada Kelas' }}
                                                @if($s->kelas && $s->kelas->jurusan)
                                                    - {{ $s->kelas->jurusan->nama_jurusan }}
                                                @endif
                                            </span>
                                        </div>
                                        <span class="text-sm text-blue-700 bg-blue-200 px-2 py-1 rounded-full">
                                            {{ $siswa->filter(function($siswa_item) use ($currentKelas) { 
                                                return $siswa_item->kelas?->nama_kelas == $currentKelas; 
                                            })->count() }} siswa
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endif
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($s->foto)
                                    <img src="{{ asset('storage/siswa/' . $s->foto) }}" alt="{{ $s->nama_lengkap }}" 
                                         class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <i class="fas fa-user text-gray-500"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $s->nama_lengkap }}</div>
                                <div class="text-sm text-gray-500">NIS: {{ $s->nis ?? '-' }}</div>
                                <div class="text-sm text-gray-500">NISN: {{ $s->nisn ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($s->kelas)
                                    <div class="text-sm font-medium text-gray-900">{{ $s->kelas->nama_kelas }}</div>
                                    @if($s->kelas->jurusan)
                                        <div class="text-sm text-gray-500">{{ $s->kelas->jurusan->nama_jurusan }}</div>
                                    @endif
                                @else
                                    <span class="text-sm text-gray-500">Belum ada kelas</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($s->status_siswa == 'aktif')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @elseif($s->status_siswa == 'nonaktif')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Nonaktif
                                    </span>
                                @elseif($s->status_siswa == 'mutasi')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Mutasi
                                    </span>
                                @elseif($s->status_siswa == 'lulus')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Lulus
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('kesiswaan.siswa.show', $s) }}" 
                                   class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors" 
                                   title="Lihat Detail">
                                    <i class="fas fa-eye mr-2"></i>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                                    <p class="text-gray-500 text-lg font-medium">Tidak ada data siswa</p>
                                    <p class="text-gray-400 mt-1">Tambahkan siswa baru atau ubah filter pencarian</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Siswa</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $siswa->count() }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Siswa Aktif</p>
                    <p class="text-2xl font-bold text-green-600">{{ $siswa->where('status_siswa', 'aktif')->count() }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-user-check text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Siswa Nonaktif</p>
                    <p class="text-2xl font-bold text-red-600">{{ $siswa->where('status_siswa', 'nonaktif')->count() }}</p>
                </div>
                <div class="p-3 bg-red-100 rounded-full">
                    <i class="fas fa-user-times text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Mutasi/Lulus</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $siswa->whereIn('status_siswa', ['mutasi', 'lulus'])->count() }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-exchange-alt text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
