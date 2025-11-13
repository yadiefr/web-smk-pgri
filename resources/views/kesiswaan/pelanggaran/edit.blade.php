@extends('layouts.kesiswaan')

@section('title', 'Edit Pelanggaran - ' . $pelanggaran->siswa->nama_lengkap)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-edit mr-3 text-yellow-600"></i>
                    Edit Pelanggaran Siswa
                </h1>
                <p class="text-gray-600 mt-1">Ubah informasi pelanggaran dan sanksi yang diberikan</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('kesiswaan.pelanggaran.show', $pelanggaran) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-eye mr-2"></i>
                    Lihat Detail
                </a>
                <a href="{{ route('kesiswaan.pelanggaran.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Status Current -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
            <i class="fas fa-info-circle mr-2 text-blue-600"></i>
            Status Saat Ini
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $pelanggaran->getStatusBadgeColor() }}">
                    <i class="fas fa-circle mr-1 text-xs"></i>
                    {{ ucfirst($pelanggaran->status) }}
                </span>
                <p class="text-xs text-gray-500 mt-1">Status</p>
            </div>
            <div class="text-center">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $pelanggaran->getUrgencyBadgeColor() }}">
                    <i class="fas fa-exclamation-triangle mr-1 text-xs"></i>
                    {{ ucwords(str_replace('_', ' ', $pelanggaran->tingkat_urgensi)) }}
                </span>
                <p class="text-xs text-gray-500 mt-1">Urgensi</p>
            </div>
            <div class="text-center">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $pelanggaran->jenisPelanggaran->getBadgeColor() }}">
                    {{ $pelanggaran->jenisPelanggaran->poin_pelanggaran }} Poin
                </span>
                <p class="text-xs text-gray-500 mt-1">Poin Pelanggaran</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('kesiswaan.pelanggaran.update', $pelanggaran) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Informasi Dasar -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Informasi Dasar
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Pilih Siswa -->
                    <div>
                        <label for="siswa_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Siswa <span class="text-red-500">*</span>
                        </label>
                        <select name="siswa_id" id="siswa_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 @error('siswa_id') border-red-500 @enderror">
                            <option value="">Pilih Siswa</option>
                            @foreach($siswa as $s)
                                <option value="{{ $s->id }}" {{ (old('siswa_id', $pelanggaran->siswa_id) == $s->id) ? 'selected' : '' }}>
                                    {{ $s->nama_lengkap }} - {{ $s->nis }} ({{ $s->kelas->nama_kelas ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                        @error('siswa_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Pelanggaran -->
                    <div>
                        <label for="jenis_pelanggaran_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Pelanggaran <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_pelanggaran_id" id="jenis_pelanggaran_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 @error('jenis_pelanggaran_id') border-red-500 @enderror">
                            <option value="">Pilih Jenis Pelanggaran</option>
                            @foreach($jenisPelanggaran->groupBy('kategori') as $kategori => $jenisGroup)
                                <optgroup label="{{ ucfirst($kategori) }}">
                                    @foreach($jenisGroup as $jenis)
                                        <option value="{{ $jenis->id }}" 
                                                data-sanksi="{{ $jenis->sanksi_default }}"
                                                data-poin="{{ $jenis->poin_pelanggaran }}"
                                                {{ (old('jenis_pelanggaran_id', $pelanggaran->jenis_pelanggaran_id) == $jenis->id) ? 'selected' : '' }}>
                                            {{ $jenis->nama_pelanggaran }} ({{ $jenis->poin_pelanggaran }} poin)
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('jenis_pelanggaran_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Pelanggaran -->
                    <div>
                        <label for="tanggal_pelanggaran" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Pelanggaran <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_pelanggaran" id="tanggal_pelanggaran" 
                               value="{{ old('tanggal_pelanggaran', $pelanggaran->tanggal_pelanggaran) }}" required
                               max="{{ date('Y-m-d') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 @error('tanggal_pelanggaran') border-red-500 @enderror">
                        @error('tanggal_pelanggaran')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jam Pelanggaran -->
                    <div>
                        <label for="jam_pelanggaran" class="block text-sm font-medium text-gray-700 mb-2">
                            Jam Pelanggaran
                        </label>
                        <input type="time" name="jam_pelanggaran" id="jam_pelanggaran" 
                               value="{{ old('jam_pelanggaran', $pelanggaran->jam_pelanggaran) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 @error('jam_pelanggaran') border-red-500 @enderror">
                        @error('jam_pelanggaran')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pelapor -->
                    <div>
                        <label for="guru_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Dilaporkan oleh (Guru)
                        </label>
                        <select name="guru_id" id="guru_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 @error('guru_id') border-red-500 @enderror">
                            <option value="">Pilih Guru</option>
                            @foreach($guru as $g)
                                <option value="{{ $g->id }}" {{ (old('guru_id', $pelanggaran->guru_id) == $g->id) ? 'selected' : '' }}>
                                    {{ $g->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('guru_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tingkat Urgensi -->
                    <div>
                        <label for="tingkat_urgensi" class="block text-sm font-medium text-gray-700 mb-2">
                            Tingkat Urgensi <span class="text-red-500">*</span>
                        </label>
                        <select name="tingkat_urgensi" id="tingkat_urgensi" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 @error('tingkat_urgensi') border-red-500 @enderror">
                            <option value="">Pilih Tingkat Urgensi</option>
                            <option value="rendah" {{ (old('tingkat_urgensi', $pelanggaran->tingkat_urgensi) == 'rendah') ? 'selected' : '' }}>Rendah</option>
                            <option value="sedang" {{ (old('tingkat_urgensi', $pelanggaran->tingkat_urgensi) == 'sedang') ? 'selected' : '' }}>Sedang</option>
                            <option value="tinggi" {{ (old('tingkat_urgensi', $pelanggaran->tingkat_urgensi) == 'tinggi') ? 'selected' : '' }}>Tinggi</option>
                            <option value="sangat_tinggi" {{ (old('tingkat_urgensi', $pelanggaran->tingkat_urgensi) == 'sangat_tinggi') ? 'selected' : '' }}>Sangat Tinggi</option>
                        </select>
                        @error('tingkat_urgensi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 @error('status') border-red-500 @enderror">
                            <option value="aktif" {{ (old('status', $pelanggaran->status) == 'aktif') ? 'selected' : '' }}>Aktif</option>
                            <option value="selesai" {{ (old('status', $pelanggaran->status) == 'selesai') ? 'selected' : '' }}>Selesai</option>
                            <option value="banding" {{ (old('status', $pelanggaran->status) == 'banding') ? 'selected' : '' }}>Banding</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Detail Kejadian -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-file-alt mr-2 text-green-600"></i>
                    Detail Kejadian
                </h3>

                <div class="space-y-4">
                    <!-- Deskripsi Kejadian -->
                    <div>
                        <label for="deskripsi_kejadian" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Kejadian <span class="text-red-500">*</span>
                        </label>
                        <textarea name="deskripsi_kejadian" id="deskripsi_kejadian" rows="4" required
                                  placeholder="Jelaskan secara detail pelanggaran yang terjadi, kapan, dimana, dan bagaimana kejadiannya..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 resize-none @error('deskripsi_kejadian') border-red-500 @enderror">{{ old('deskripsi_kejadian', $pelanggaran->deskripsi_kejadian) }}</textarea>
                        @error('deskripsi_kejadian')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bukti Foto -->
                    <div>
                        <label for="bukti_foto" class="block text-sm font-medium text-gray-700 mb-2">
                            Bukti Foto
                        </label>
                        
                        @if($pelanggaran->bukti_foto)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                            <div class="inline-block relative">
                                <img src="{{ Storage::url($pelanggaran->bukti_foto) }}" 
                                     alt="Bukti Pelanggaran" 
                                     class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                                <div class="mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="hapus_foto" value="1" class="form-checkbox">
                                        <span class="ml-2 text-sm text-red-600">Hapus foto ini</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <input type="file" name="bukti_foto" id="bukti_foto" 
                               accept="image/jpeg,image/png,image/jpg"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 @error('bukti_foto') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maksimal 2MB. Biarkan kosong jika tidak ingin mengubah foto.</p>
                        @error('bukti_foto')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sanksi dan Tindak Lanjut -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-gavel mr-2 text-orange-600"></i>
                    Sanksi dan Tindak Lanjut
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Sanksi Diberikan -->
                    <div class="md:col-span-2">
                        <label for="sanksi_diberikan" class="block text-sm font-medium text-gray-700 mb-2">
                            Sanksi yang Diberikan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="sanksi_diberikan" id="sanksi_diberikan" rows="3" required
                                  placeholder="Contoh: Teguran tertulis, pembersihan lingkungan sekolah selama 3 hari, panggilan orang tua..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 resize-none @error('sanksi_diberikan') border-red-500 @enderror">{{ old('sanksi_diberikan', $pelanggaran->sanksi_diberikan) }}</textarea>
                        @error('sanksi_diberikan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Selesai Sanksi -->
                    <div>
                        <label for="tanggal_selesai_sanksi" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Selesai Sanksi
                        </label>
                        <input type="date" name="tanggal_selesai_sanksi" id="tanggal_selesai_sanksi" 
                               value="{{ old('tanggal_selesai_sanksi', $pelanggaran->tanggal_selesai_sanksi) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 @error('tanggal_selesai_sanksi') border-red-500 @enderror">
                        @error('tanggal_selesai_sanksi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catatan Tambahan -->
                    <div>
                        <label for="catatan_tambahan" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Tambahan
                        </label>
                        <textarea name="catatan_tambahan" id="catatan_tambahan" rows="3"
                                  placeholder="Catatan khusus tentang pelanggaran atau sanksi..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 resize-none @error('catatan_tambahan') border-red-500 @enderror">{{ old('catatan_tambahan', $pelanggaran->catatan_tambahan) }}</textarea>
                        @error('catatan_tambahan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Komunikasi dengan Orang Tua -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-phone mr-2 text-purple-600"></i>
                    Komunikasi dengan Orang Tua
                </h3>

                <div class="space-y-4">
                    <!-- Sudah Dihubungi Orang Tua -->
                    <div class="flex items-center">
                        <input type="checkbox" name="sudah_dihubungi_ortu" id="sudah_dihubungi_ortu" value="1"
                               {{ old('sudah_dihubungi_ortu', $pelanggaran->sudah_dihubungi_ortu) ? 'checked' : '' }}
                               class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                        <label for="sudah_dihubungi_ortu" class="ml-2 block text-sm text-gray-900">
                            Sudah menghubungi orang tua/wali siswa
                        </label>
                    </div>

                    <!-- Respon Orang Tua -->
                    <div id="respon_ortu_container" {{ !old('sudah_dihubungi_ortu', $pelanggaran->sudah_dihubungi_ortu) ? 'style=display:none;' : '' }}>
                        <label for="respon_ortu" class="block text-sm font-medium text-gray-700 mb-2">
                            Respon Orang Tua
                        </label>
                        <textarea name="respon_ortu" id="respon_ortu" rows="3"
                                  placeholder="Jelaskan respon orang tua terhadap pelanggaran anaknya..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 resize-none @error('respon_ortu') border-red-500 @enderror">{{ old('respon_ortu', $pelanggaran->respon_ortu) }}</textarea>
                        @error('respon_ortu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-yellow-600 text-white font-medium rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Update Pelanggaran
                </button>
                <a href="{{ route('kesiswaan.pelanggaran.show', $pelanggaran) }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    <i class="fas fa-eye mr-2"></i>
                    Lihat Detail
                </a>
                <a href="{{ route('kesiswaan.pelanggaran.index') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-fill sanksi berdasarkan jenis pelanggaran (hanya jika kosong)
    const jenisPelanggaranSelect = document.getElementById('jenis_pelanggaran_id');
    const sanksiTextarea = document.getElementById('sanksi_diberikan');
    
    jenisPelanggaranSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.dataset.sanksi && sanksiTextarea.value.trim() === '') {
            sanksiTextarea.value = selectedOption.dataset.sanksi;
        }
    });

    // Toggle respon orang tua
    const hubungiOrtuCheckbox = document.getElementById('sudah_dihubungi_ortu');
    const responOrtuContainer = document.getElementById('respon_ortu_container');
    
    hubungiOrtuCheckbox.addEventListener('change', function() {
        if (this.checked) {
            responOrtuContainer.style.display = 'block';
        } else {
            responOrtuContainer.style.display = 'none';
            document.getElementById('respon_ortu').value = '';
        }
    });

    // Set minimum date for tanggal selesai sanksi
    const tanggalPelanggaranInput = document.getElementById('tanggal_pelanggaran');
    const tanggalSelesaiSanksiInput = document.getElementById('tanggal_selesai_sanksi');
    
    tanggalPelanggaranInput.addEventListener('change', function() {
        tanggalSelesaiSanksiInput.min = this.value;
    });

    // Set initial min date
    if (tanggalPelanggaranInput.value) {
        tanggalSelesaiSanksiInput.min = tanggalPelanggaranInput.value;
    }
});
</script>
@endpush