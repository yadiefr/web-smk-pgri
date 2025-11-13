<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with(['kelas', 'kelas.jurusan']);

        // Filter berdasarkan kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter berdasarkan jurusan
        if ($request->filled('jurusan_id')) {
            $query->whereHas('kelas', function ($q) use ($request) {
                $q->where('jurusan_id', $request->jurusan_id);
            });
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status_siswa', $request->status);
        }

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        // Mengurutkan berdasarkan nama kelas kemudian nama siswa, tampilkan semua tanpa pagination
        $siswa = $query->join('kelas', 'siswa.kelas_id', '=', 'kelas.id')
                      ->orderBy('kelas.nama_kelas', 'asc')
                      ->orderBy('siswa.nama_lengkap', 'asc')
                      ->select('siswa.*')
                      ->get();
        
        // Data untuk filter dropdown
        $kelas = Kelas::with('jurusan')->orderBy('nama_kelas')->get();
        $jurusan = Jurusan::orderBy('nama_jurusan')->get();

        return view('kesiswaan.siswa.index', compact('siswa', 'kelas', 'jurusan'));
    }

    public function show(Siswa $siswa)
    {
        $siswa->load(['kelas', 'kelas.jurusan', 'absensi' => function ($query) {
            $query->latest()->take(10);
        }]);

        return view('kesiswaan.siswa.show', compact('siswa'));
    }

    public function mutasi(Siswa $siswa)
    {
        $kelas = Kelas::with('jurusan')->orderBy('nama_kelas')->get();
        
        return view('kesiswaan.siswa.mutasi', compact('siswa', 'kelas'));
    }

    public function prosesMutasi(Request $request, Siswa $siswa)
    {
        $request->validate([
            'kelas_id_baru' => 'required|exists:kelas,id',
            'tanggal_mutasi' => 'required|date',
            'alasan_mutasi' => 'required|string|max:500',
            'status_siswa' => 'required|in:aktif,nonaktif,mutasi,lulus'
        ]);

        // Simpan data mutasi lama
        $kelaslama = $siswa->kelas;
        
        // Update siswa
        $siswa->update([
            'kelas_id' => $request->kelas_id_baru,
            'status_siswa' => $request->status_siswa
        ]);

        // Log mutasi (bisa dibuat model terpisah jika diperlukan)
        // MutasiSiswa::create([...])

        return redirect()->route('kesiswaan.siswa.show', $siswa)
            ->with('success', 'Mutasi siswa berhasil diproses');
    }

    public function create()
    {
        $kelas = Kelas::with('jurusan')->orderBy('nama_kelas')->get();
        
        return view('kesiswaan.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nis' => 'required|string|max:20|unique:siswa,nis',
            'nisn' => 'required|string|max:20|unique:siswa,nisn',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'status_siswa' => 'required|in:aktif,nonaktif'
        ]);

        Siswa::create($request->all());

        return redirect()->route('kesiswaan.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::with('jurusan')->orderBy('nama_kelas')->get();
        
        return view('kesiswaan.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nis' => 'required|string|max:20|unique:siswa,nis,' . $siswa->id,
            'nisn' => 'required|string|max:20|unique:siswa,nisn,' . $siswa->id,
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'status_siswa' => 'required|in:aktif,nonaktif,mutasi,lulus'
        ]);

        $siswa->update($request->all());

        return redirect()->route('kesiswaan.siswa.show', $siswa)
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()->route('kesiswaan.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }
}
