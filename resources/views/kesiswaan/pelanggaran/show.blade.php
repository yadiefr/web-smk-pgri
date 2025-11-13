@extends('layouts.kesiswaan')

@section('title', 'Detail Pelanggaran - ' . $pelanggaran->siswa->nama_lengkap)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-eye mr-3 text-blue-600"></i>
                    Detail Pelanggaran
                </h1>
                <p class="text-gray-600 mt-1">Informasi lengkap pelanggaran siswa</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('kesiswaan.pelanggaran.edit', $pelanggaran) }}" 
                   class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('kesiswaan.pelanggaran.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Status dan Informasi Cepat -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="text-center">
                <div class="text-2xl mb-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $pelanggaran->getStatusBadgeColor() }}">
                        <i class="fas fa-circle mr-1 text-xs"></i>
                        {{ ucfirst($pelanggaran->status) }}
                    </span>
                </div>
                <p class="text-sm text-gray-600">Status Pelanggaran</p>
            </div>
        </div>

        <!-- Urgensi -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="text-center">
                <div class="text-2xl mb-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $pelanggaran->getUrgencyBadgeColor() }}">
                        <i class="fas fa-exclamation-triangle mr-1 text-xs"></i>
                        {{ ucwords(str_replace('_', ' ', $pelanggaran->tingkat_urgensi)) }}
                    </span>
                </div>
                <p class="text-sm text-gray-600">Tingkat Urgensi</p>
            </div>
        </div>

        <!-- Poin Pelanggaran -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-red-600 mb-2">
                    {{ $pelanggaran->jenisPelanggaran->poin_pelanggaran }}
                </div>
                <p class="text-sm text-gray-600">Poin Pelanggaran</p>
            </div>
        </div>

        <!-- Kategori -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="text-center">
                <div class="text-xl mb-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $pelanggaran->jenisPelanggaran->getBadgeColor() }}">
                        {{ ucfirst($pelanggaran->jenisPelanggaran->kategori) }}
                    </span>
                </div>
                <p class="text-sm text-gray-600">Kategori</p>
            </div>
        </div>
    </div>

    <!-- Informasi Siswa -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
            <i class="fas fa-user-graduate mr-2 text-blue-600"></i>
            Informasi Siswa
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Siswa</label>
                <p class="text-lg font-semibold text-gray-900">{{ $pelanggaran->siswa->nama_lengkap }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
                <p class="text-gray-900">{{ $pelanggaran->siswa->nis }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <p class="text-gray-900">{{ $pelanggaran->siswa->kelas->nama_kelas ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Detail Pelanggaran -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
            <i class="fas fa-exclamation-circle mr-2 text-red-600"></i>
            Detail Pelanggaran
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Pelanggaran</label>
                <p class="text-gray-900 font-medium">{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pelanggaran</label>
                <p class="text-gray-900">{{ $pelanggaran->tanggal_pelanggaran_formatted }}</p>
            </div>
            @if($pelanggaran->jam_pelanggaran)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Pelanggaran</label>
                <p class="text-gray-900">{{ $pelanggaran->jam_pelanggaran_formatted }}</p>
            </div>
            @endif
            @if($pelanggaran->guru)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dilaporkan oleh</label>
                <p class="text-gray-900">{{ $pelanggaran->guru->nama }}</p>
            </div>
            @endif
        </div>

        <!-- Deskripsi Kejadian -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Kejadian</label>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-900 whitespace-pre-line">{{ $pelanggaran->deskripsi_kejadian }}</p>
            </div>
        </div>

        <!-- Bukti Foto -->
        @if($pelanggaran->bukti_foto)
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Foto</label>
            <div class="inline-block">
                <img src="{{ Storage::url($pelanggaran->bukti_foto) }}" 
                     alt="Bukti Pelanggaran" 
                     class="max-w-md rounded-lg border border-gray-300 shadow-sm cursor-pointer hover:shadow-md transition-shadow"
                     onclick="openImageModal(this.src)">
            </div>
        </div>
        @endif
    </div>

    <!-- Sanksi dan Tindak Lanjut -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
            <i class="fas fa-gavel mr-2 text-orange-600"></i>
            Sanksi dan Tindak Lanjut
        </h3>
        
        <div class="space-y-4">
            <!-- Sanksi Diberikan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sanksi yang Diberikan</label>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-900 whitespace-pre-line">{{ $pelanggaran->sanksi_diberikan }}</p>
                </div>
            </div>

            <!-- Tanggal Selesai Sanksi -->
            @if($pelanggaran->tanggal_selesai_sanksi)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai Sanksi</label>
                    <p class="text-gray-900">{{ $pelanggaran->tanggal_selesai_sanksi_formatted }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Sanksi</label>
                    @if($pelanggaran->tanggal_selesai_sanksi < now()->format('Y-m-d'))
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>
                            Selesai
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-clock mr-1"></i>
                            Berlangsung
                        </span>
                    @endif
                </div>
            </div>
            @endif

            <!-- Catatan Tambahan -->
            @if($pelanggaran->catatan_tambahan)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Tambahan</label>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-900 whitespace-pre-line">{{ $pelanggaran->catatan_tambahan }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Komunikasi dengan Orang Tua -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
            <i class="fas fa-phone mr-2 text-purple-600"></i>
            Komunikasi dengan Orang Tua
        </h3>
        
        <div class="space-y-4">
            <div class="flex items-center">
                @if($pelanggaran->sudah_dihubungi_ortu)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-1"></i>
                        Sudah menghubungi orang tua
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <i class="fas fa-times-circle mr-1"></i>
                        Belum menghubungi orang tua
                    </span>
                @endif
            </div>

            @if($pelanggaran->respon_ortu)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Respon Orang Tua</label>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-900 whitespace-pre-line">{{ $pelanggaran->respon_ortu }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Informasi Sistem -->
    <div class="bg-gray-50 rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
            <i class="fas fa-info-circle mr-2 text-gray-600"></i>
            Informasi Sistem
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-600">
            <div>
                <label class="block font-medium text-gray-700 mb-1">Dibuat pada</label>
                <p>{{ $pelanggaran->created_at->format('d/m/Y H:i:s') }}</p>
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Terakhir diupdate</label>
                <p>{{ $pelanggaran->updated_at->format('d/m/Y H:i:s') }}</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4">
        <a href="{{ route('kesiswaan.pelanggaran.edit', $pelanggaran) }}" 
           class="inline-flex items-center justify-center px-6 py-3 bg-yellow-600 text-white font-medium rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-colors">
            <i class="fas fa-edit mr-2"></i>
            Edit Pelanggaran
        </a>
        
        @if($pelanggaran->status === 'aktif')
        <form action="{{ route('kesiswaan.pelanggaran.update', $pelanggaran) }}" method="POST" class="inline">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="selesai">
            <button type="submit" 
                    onclick="return confirm('Apakah Anda yakin ingin menandai pelanggaran ini sebagai selesai?')"
                    class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                <i class="fas fa-check mr-2"></i>
                Tandai Selesai
            </button>
        </form>
        @endif

        <form action="{{ route('kesiswaan.pelanggaran.destroy', $pelanggaran) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggaran ini? Tindakan ini tidak dapat dibatalkan.')"
                    class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                <i class="fas fa-trash mr-2"></i>
                Hapus Pelanggaran
            </button>
        </form>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <img id="modalImage" src="" alt="Bukti Pelanggaran" class="max-w-full max-h-full rounded-lg">
        <button onclick="closeImageModal()" 
                class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-75 transition-colors">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Close modal when clicking outside the image
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Close modal with escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endpush