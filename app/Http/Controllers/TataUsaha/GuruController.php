<?php

namespace App\Http\Controllers\TataUsaha;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::with('mataPelajaran')
            ->orderBy('nama_guru')
            ->paginate(20);

        return view('tata_usaha.guru.index', compact('guru'));
    }

    public function create()
    {
        $mataPelajaran = MataPelajaran::orderBy('nama_pelajaran')->get();

        return view('tata_usaha.guru.create', compact('mataPelajaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'nip' => 'nullable|string|unique:guru',
            'email' => 'nullable|email|unique:guru',
            'no_telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $guru = Guru::create($request->all());

        return redirect()->route('tata-usaha.guru.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function show(Guru $guru)
    {
        $guru->load(['mataPelajaran', 'jadwal']);

        return view('tata_usaha.guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        $mataPelajaran = MataPelajaran::orderBy('nama_pelajaran')->get();

        return view('tata_usaha.guru.edit', compact('guru', 'mataPelajaran'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'nip' => 'nullable|string|unique:guru,nip,'.$guru->id,
            'email' => 'nullable|email|unique:guru,email,'.$guru->id,
            'no_telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $guru->update($request->all());

        return redirect()->route('tata-usaha.guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();

        return redirect()->route('tata-usaha.guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }
}
