<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\JenisPelanggaran;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PelanggaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggaran::with(['siswa', 'jenisPelanggaran', 'guru']);

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            })->orWhereHas('jenisPelanggaran', function($q) use ($search) {
                $q->where('nama_pelanggaran', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kelas
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas);
            });
        }

        // Filter berdasarkan kategori pelanggaran
        if ($request->filled('kategori')) {
            $query->whereHas('jenisPelanggaran', function($q) use ($request) {
                $q->where('kategori', $request->kategori);
            });
        }

        // Filter berdasarkan status sanksi
        if ($request->filled('status')) {
            $query->where('status_sanksi', $request->status);
        }

        // Filter berdasarkan tingkat urgensi
        if ($request->filled('urgensi')) {
            $query->where('tingkat_urgensi', $request->urgensi);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal_pelanggaran', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal_pelanggaran', '<=', $request->tanggal_sampai);
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        if ($sortBy === 'siswa') {
            $query->join('siswa', 'pelanggarans.siswa_id', '=', 'siswa.id')
                  ->orderBy('siswa.nama_lengkap', $sortDirection)
                  ->select('pelanggarans.*');
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $pelanggarans = $query->paginate(15)->withQueryString();

        // Data untuk filter
        $kelas = \App\Models\Kelas::orderBy('nama_kelas')->get();
        $jenisPelanggaran = JenisPelanggaran::active()->get();

        // Statistik
        $stats = [
            'total' => Pelanggaran::count(),
            'hari_ini' => Pelanggaran::hariIni()->count(),
            'bulan_ini' => Pelanggaran::bulanIni()->count(),
            'belum_selesai' => Pelanggaran::statusSanksi('belum_selesai')->count(),
            'sangat_tinggi' => Pelanggaran::tingkatUrgensi('sangat_tinggi')->count(),
        ];

        return view('kesiswaan.pelanggaran.index', compact(
            'pelanggarans', 'kelas', 'jenisPelanggaran', 'stats'
        ));
    }

    public function create()
    {
        $siswa = Siswa::with('kelas')->orderBy('nama_lengkap')->get();
        $jenisPelanggaran = JenisPelanggaran::active()->get();
        $guru = Guru::where('is_active', true)->orderBy('nama')->get();

        // Prepare data for JavaScript
        $siswaData = $siswa->map(function($s) {
            return [
                'id' => $s->id,
                'nama' => $s->nama_lengkap,
                'nis' => $s->nis,
                'kelas' => optional($s->kelas)->nama_kelas ?? ''
            ];
        })->toArray();

        $guruData = $guru->map(function($g) {
            return [
                'id' => $g->id,
                'nama' => $g->nama
            ];
        })->toArray();

        return view('kesiswaan.pelanggaran.create', compact(
            'siswa', 'jenisPelanggaran', 'guru', 'siswaData', 'guruData'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_data' => 'required|array|min:1',
            'siswa_data.*.siswa_id' => 'required|exists:siswa,id',
            'siswa_data.*.jam_pelanggaran' => 'nullable|date_format:H:i',
            'siswa_data.*.alasan_detail' => 'nullable|string|max:500',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggarans,id',
            'guru_id' => 'nullable|exists:guru,id',
            'tanggal_pelanggaran' => 'required|date|before_or_equal:today',
            'deskripsi_kejadian' => 'required|string|min:10',
            'sanksi_diberikan' => 'required|string',
            'tanggal_selesai_sanksi' => 'nullable|date|after:tanggal_pelanggaran',
            'tingkat_urgensi' => 'required|in:rendah,sedang,tinggi,sangat_tinggi',
            'catatan_tambahan' => 'nullable|string',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'sudah_dihubungi_ortu' => 'boolean',
            'respon_ortu' => 'nullable|string'
        ], [
            'siswa_data.required' => 'Minimal pilih 1 siswa',
            'siswa_data.min' => 'Minimal pilih 1 siswa',
            'jenis_pelanggaran_id.required' => 'Jenis pelanggaran harus dipilih',
            'tanggal_pelanggaran.required' => 'Tanggal pelanggaran harus diisi',
            'tanggal_pelanggaran.before_or_equal' => 'Tanggal pelanggaran tidak boleh melebihi hari ini',
            'deskripsi_kejadian.required' => 'Deskripsi kejadian harus diisi',
            'deskripsi_kejadian.min' => 'Deskripsi kejadian minimal 10 karakter',
            'sanksi_diberikan.required' => 'Sanksi yang diberikan harus diisi',
            'bukti_foto.image' => 'File harus berupa gambar',
            'bukti_foto.max' => 'Ukuran file maksimal 2MB'
        ]);

        $commonData = $request->except(['siswa_data', 'bukti_foto']);
        
        // Upload bukti foto jika ada
        $buktiFotoPath = null;
        if ($request->hasFile('bukti_foto')) {
            $file = $request->file('bukti_foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $buktiFotoPath = $file->storeAs('pelanggaran', $filename, 'public');
        }

        $createdCount = 0;
        $siswaNames = [];

        // Loop untuk setiap siswa yang dipilih
        foreach ($request->siswa_data as $siswaData) {
            $pelanggaranData = array_merge($commonData, [
                'siswa_id' => $siswaData['siswa_id'],
                'jam_pelanggaran' => $siswaData['jam_pelanggaran'] ?? $request->jam_pelanggaran,
                'bukti_foto' => $buktiFotoPath,
                'status_sanksi' => 'belum_selesai',
                'catatan_tambahan' => ($commonData['catatan_tambahan'] ?? '') . 
                                    (!empty($siswaData['alasan_detail']) ? "\n\nDetail: " . $siswaData['alasan_detail'] : '')
            ]);

            // Set tanggal hubungi ortu jika sudah dihubungi
            if ($request->sudah_dihubungi_ortu) {
                $pelanggaranData['tanggal_hubungi_ortu'] = now();
            }

            Pelanggaran::create($pelanggaranData);
            $createdCount++;
            $siswaNames[] = $siswaData['nama'] ?? 'Siswa #' . $siswaData['siswa_id'];
        }

        $successMessage = "Berhasil menambahkan {$createdCount} data pelanggaran untuk siswa: " . implode(', ', $siswaNames);

        return redirect()->route('kesiswaan.pelanggaran.index')
            ->with('success', $successMessage);
    }

    public function show(Pelanggaran $pelanggaran)
    {
        $pelanggaran->load(['siswa.kelas.jurusan', 'jenisPelanggaran', 'guru']);
        
        return view('kesiswaan.pelanggaran.show', compact('pelanggaran'));
    }

    public function edit(Pelanggaran $pelanggaran)
    {
        $siswa = Siswa::with('kelas')->orderBy('nama_lengkap')->get();
        $jenisPelanggaran = JenisPelanggaran::active()->get();
        $guru = Guru::where('is_active', true)->orderBy('nama')->get();

        return view('kesiswaan.pelanggaran.edit', compact(
            'pelanggaran', 'siswa', 'jenisPelanggaran', 'guru'
        ));
    }

    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggarans,id',
            'guru_id' => 'nullable|exists:guru,id',
            'tanggal_pelanggaran' => 'required|date|before_or_equal:today',
            'jam_pelanggaran' => 'nullable|date_format:H:i',
            'deskripsi_kejadian' => 'required|string|min:10',
            'sanksi_diberikan' => 'required|string',
            'tanggal_selesai_sanksi' => 'nullable|date|after:tanggal_pelanggaran',
            'status_sanksi' => 'required|in:belum_selesai,sedang_proses,selesai',
            'tingkat_urgensi' => 'required|in:rendah,sedang,tinggi,sangat_tinggi',
            'catatan_tambahan' => 'nullable|string',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'sudah_dihubungi_ortu' => 'boolean',
            'respon_ortu' => 'nullable|string'
        ]);

        $data = $request->except(['bukti_foto']);

        // Upload bukti foto jika ada
        if ($request->hasFile('bukti_foto')) {
            // Hapus foto lama jika ada
            if ($pelanggaran->bukti_foto) {
                Storage::disk('public')->delete($pelanggaran->bukti_foto);
            }

            $file = $request->file('bukti_foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('pelanggaran', $filename, 'public');
            $data['bukti_foto'] = $path;
        }

        // Set tanggal hubungi ortu jika baru dihubungi
        if ($request->sudah_dihubungi_ortu && !$pelanggaran->sudah_dihubungi_ortu) {
            $data['tanggal_hubungi_ortu'] = now();
        } elseif (!$request->sudah_dihubungi_ortu) {
            $data['tanggal_hubungi_ortu'] = null;
        }

        $pelanggaran->update($data);

        return redirect()->route('kesiswaan.pelanggaran.show', $pelanggaran)
            ->with('success', 'Data pelanggaran berhasil diperbarui');
    }

    public function destroy(Pelanggaran $pelanggaran)
    {
        // Hapus bukti foto jika ada
        if ($pelanggaran->bukti_foto) {
            Storage::disk('public')->delete($pelanggaran->bukti_foto);
        }

        $pelanggaran->delete();

        return redirect()->route('kesiswaan.pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil dihapus');
    }

    /**
     * Update status sanksi
     */
    public function updateStatus(Request $request, Pelanggaran $pelanggaran)
    {
        $request->validate([
            'status_sanksi' => 'required|in:belum_selesai,sedang_proses,selesai',
            'tanggal_selesai_sanksi' => 'nullable|date',
            'catatan_tambahan' => 'nullable|string'
        ]);

        $pelanggaran->update($request->only([
            'status_sanksi',
            'tanggal_selesai_sanksi',
            'catatan_tambahan'
        ]));

        return back()->with('success', 'Status sanksi berhasil diperbarui');
    }

    /**
     * Export pelanggaran ke Excel
     */
    public function export(Request $request)
    {
        // TODO: Implementasi export Excel
        return back()->with('info', 'Fitur export sedang dalam pengembangan');
    }

    /**
     * Get statistik dashboard
     */
    public function statistik()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $thisYear = Carbon::now()->startOfYear();

        $stats = [
            'total_pelanggaran' => Pelanggaran::count(),
            'pelanggaran_hari_ini' => Pelanggaran::whereDate('created_at', $today)->count(),
            'pelanggaran_bulan_ini' => Pelanggaran::where('created_at', '>=', $thisMonth)->count(),
            'pelanggaran_tahun_ini' => Pelanggaran::where('created_at', '>=', $thisYear)->count(),
            
            'sanksi_belum_selesai' => Pelanggaran::where('status_sanksi', 'belum_selesai')->count(),
            'sanksi_sedang_proses' => Pelanggaran::where('status_sanksi', 'sedang_proses')->count(),
            'sanksi_selesai' => Pelanggaran::where('status_sanksi', 'selesai')->count(),
            
            'urgensi_sangat_tinggi' => Pelanggaran::where('tingkat_urgensi', 'sangat_tinggi')->count(),
            'urgensi_tinggi' => Pelanggaran::where('tingkat_urgensi', 'tinggi')->count(),
            
            'belum_hubungi_ortu' => Pelanggaran::where('sudah_dihubungi_ortu', false)->count(),
        ];

        // Pelanggaran per kategori
        $pelanggaranPerKategori = JenisPelanggaran::withCount('pelanggarans')
            ->orderBy('pelanggarans_count', 'desc')
            ->get();

        return response()->json([
            'stats' => $stats,
            'pelanggaran_per_kategori' => $pelanggaranPerKategori
        ]);
    }
}
