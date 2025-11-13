<?php

namespace App\Http\Controllers\TataUsaha\Master;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::withCount('siswa')
            ->orderBy('nama_jurusan')
            ->paginate(20);

        return view('tata_usaha.master.jurusan.index', compact('jurusan'));
    }

    public function create()
    {
        return view('tata_usaha.master.jurusan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255|unique:jurusan',
            'kode_jurusan' => 'required|string|max:10|unique:jurusan',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        Jurusan::create($request->all());

        return redirect()->route('tata-usaha.master.jurusan.index')
            ->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function show(Jurusan $jurusan)
    {
        $jurusan->load(['siswa', 'kelas']);

        return view('tata_usaha.master.jurusan.show', compact('jurusan'));
    }

    public function edit(Jurusan $jurusan)
    {
        return view('tata_usaha.master.jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255|unique:jurusan,nama_jurusan,'.$jurusan->id,
            'kode_jurusan' => 'required|string|max:10|unique:jurusan,kode_jurusan,'.$jurusan->id,
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $jurusan->update($request->all());

        return redirect()->route('tata-usaha.master.jurusan.index')
            ->with('success', 'Data jurusan berhasil diperbarui.');
    }

    public function destroy(Jurusan $jurusan)
    {
        // Check if jurusan has students or classes
        if ($jurusan->siswa()->count() > 0 || $jurusan->kelas()->count() > 0) {
            return redirect()->route('tata-usaha.master.jurusan.index')
                ->with('error', 'Jurusan tidak dapat dihapus karena masih memiliki siswa atau kelas.');
        }

        $jurusan->delete();

        return redirect()->route('tata-usaha.master.jurusan.index')
            ->with('success', 'Jurusan berhasil dihapus.');
    }
}
