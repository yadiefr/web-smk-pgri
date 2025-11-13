<?php

namespace App\Http\Controllers\TataUsaha;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with(['kelas', 'jurusan']);

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                    ->orWhere('nis', 'LIKE', "%{$search}%")
                    ->orWhere('nisn', 'LIKE', "%{$search}%");
            });
        }

        // Filter kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter jurusan
        if ($request->filled('jurusan_id')) {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $siswa = $query->orderBy('nama_lengkap')->paginate(20);

        // Data untuk filter dropdown
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $jurusan = Jurusan::orderBy('nama_jurusan')->get();

        return view('tata_usaha.siswa.index', compact('siswa', 'kelas', 'jurusan'));
    }

    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $jurusan = Jurusan::orderBy('nama_jurusan')->get();

        return view('tata_usaha.siswa.create', compact('kelas', 'jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nis' => 'nullable|string|unique:siswa',
            'nisn' => 'nullable|string|unique:siswa',
            'kelas_id' => 'required|exists:kelas,id',
            'jurusan_id' => 'required|exists:jurusan,id',
            'email' => 'nullable|email|unique:siswa',
            'no_telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'status' => 'required|in:aktif,tidak_aktif,lulus,pindah',
        ]);

        Siswa::create($request->all());

        return redirect()->route('tata-usaha.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show(Siswa $siswa)
    {
        $siswa->load(['kelas', 'jurusan', 'absensi', 'nilai']);

        return view('tata_usaha.siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $jurusan = Jurusan::orderBy('nama_jurusan')->get();

        return view('tata_usaha.siswa.edit', compact('siswa', 'kelas', 'jurusan'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nis' => 'nullable|string|unique:siswa,nis,'.$siswa->id,
            'nisn' => 'nullable|string|unique:siswa,nisn,'.$siswa->id,
            'kelas_id' => 'required|exists:kelas,id',
            'jurusan_id' => 'required|exists:jurusan,id',
            'email' => 'nullable|email|unique:siswa,email,'.$siswa->id,
            'no_telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'status' => 'required|in:aktif,tidak_aktif,lulus,pindah',
        ]);

        $siswa->update($request->all());

        return redirect()->route('tata-usaha.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()->route('tata-usaha.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    public function daftarMutasi()
    {
        // Halaman untuk melihat daftar mutasi siswa
        $mutasi = Siswa::whereNotNull('tanggal_mutasi')
            ->with(['kelas', 'jurusan'])
            ->orderBy('tanggal_mutasi', 'desc')
            ->paginate(20);

        return view('tata_usaha.siswa.daftar-mutasi', compact('mutasi'));
    }

    public function mutasi(Siswa $siswa)
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $jurusan = Jurusan::orderBy('nama_jurusan')->get();

        return view('tata_usaha.siswa.mutasi', compact('siswa', 'kelas', 'jurusan'));
    }

    public function prosesMusasi(Request $request, Siswa $siswa)
    {
        $request->validate([
            'jenis_mutasi' => 'required|in:pindah_kelas,pindah_jurusan,pindah_sekolah,keluar,lulus',
            'kelas_id' => 'required_if:jenis_mutasi,pindah_kelas,pindah_jurusan|exists:kelas,id',
            'jurusan_id' => 'required_if:jenis_mutasi,pindah_jurusan|exists:jurusan,id',
            'tanggal_mutasi' => 'required|date',
            'alasan' => 'required|string',
            'sekolah_tujuan' => 'required_if:jenis_mutasi,pindah_sekolah|string',
        ]);

        // Update status siswa dan data terkait mutasi
        $updateData = [
            'tanggal_mutasi' => $request->tanggal_mutasi,
            'alasan_mutasi' => $request->alasan,
        ];

        switch ($request->jenis_mutasi) {
            case 'pindah_kelas':
                $updateData['kelas_id'] = $request->kelas_id;
                $updateData['status'] = 'aktif';
                break;
            case 'pindah_jurusan':
                $updateData['kelas_id'] = $request->kelas_id;
                $updateData['jurusan_id'] = $request->jurusan_id;
                $updateData['status'] = 'aktif';
                break;
            case 'pindah_sekolah':
                $updateData['status'] = 'pindah';
                $updateData['sekolah_tujuan'] = $request->sekolah_tujuan;
                break;
            case 'keluar':
                $updateData['status'] = 'tidak_aktif';
                break;
            case 'lulus':
                $updateData['status'] = 'lulus';
                break;
        }

        $siswa->update($updateData);

        return redirect()->route('tata-usaha.siswa.index')
            ->with('success', 'Mutasi siswa berhasil diproses.');
    }
}
