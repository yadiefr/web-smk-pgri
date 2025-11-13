<?php

namespace App\Http\Controllers\TataUsaha\Master;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with(['jurusan', 'waliKelas'])
            ->orderBy('nama_kelas')
            ->paginate(20);

        return view('tata_usaha.master.kelas.index', compact('kelas'));
    }

    public function create()
    {
        $jurusan = Jurusan::orderBy('nama_jurusan')->get();
        $guru = Guru::where('status', 'aktif')->orderBy('nama_guru')->get();

        return view('tata_usaha.master.kelas.create', compact('jurusan', 'guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas',
            'jurusan_id' => 'required|exists:jurusan,id',
            'tingkat' => 'required|in:X,XI,XII',
            'wali_kelas_id' => 'nullable|exists:guru,id',
            'kapasitas' => 'required|integer|min:1',
            'tahun_ajaran' => 'required|string',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        Kelas::create($request->all());

        return redirect()->route('tata-usaha.master.kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function show(Kelas $kelas)
    {
        $kelas->load(['jurusan', 'waliKelas', 'siswa']);

        return view('tata_usaha.master.kelas.show', compact('kelas'));
    }

    public function edit(Kelas $kelas)
    {
        $jurusan = Jurusan::orderBy('nama_jurusan')->get();
        $guru = Guru::where('status', 'aktif')->orderBy('nama_guru')->get();

        return view('tata_usaha.master.kelas.edit', compact('kelas', 'jurusan', 'guru'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas,'.$kelas->id,
            'jurusan_id' => 'required|exists:jurusan,id',
            'tingkat' => 'required|in:X,XI,XII',
            'wali_kelas_id' => 'nullable|exists:guru,id',
            'kapasitas' => 'required|integer|min:1',
            'tahun_ajaran' => 'required|string',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $kelas->update($request->all());

        return redirect()->route('tata-usaha.master.kelas.index')
            ->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas)
    {
        // Check if kelas has students
        if ($kelas->siswa()->count() > 0) {
            return redirect()->route('tata-usaha.master.kelas.index')
                ->with('error', 'Kelas tidak dapat dihapus karena masih memiliki siswa.');
        }

        $kelas->delete();

        return redirect()->route('tata-usaha.master.kelas.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }
}
