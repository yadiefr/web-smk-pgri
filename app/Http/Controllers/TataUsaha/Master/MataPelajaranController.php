<?php

namespace App\Http\Controllers\TataUsaha\Master;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mataPelajaran = MataPelajaran::withCount(['guru'])
            ->orderBy('nama_pelajaran')
            ->paginate(20);

        return view('tata_usaha.master.mata-pelajaran.index', compact('mataPelajaran'));
    }

    public function create()
    {
        return view('tata_usaha.master.mata-pelajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelajaran' => 'required|string|max:255',
            'kode_pelajaran' => 'required|string|max:10|unique:mata_pelajaran',
            'kkm' => 'required|numeric|min:0|max:100',
            'jenis' => 'required|in:wajib,pilihan,muatan_lokal',
            'tingkat' => 'required|array',
            'tingkat.*' => 'in:X,XI,XII',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $data = $request->all();
        $data['tingkat'] = json_encode($request->tingkat);

        MataPelajaran::create($data);

        return redirect()->route('tata-usaha.master.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function show(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->load(['guru']);

        return view('tata_usaha.master.mata-pelajaran.show', compact('mataPelajaran'));
    }

    public function edit(MataPelajaran $mataPelajaran)
    {
        return view('tata_usaha.master.mata-pelajaran.edit', compact('mataPelajaran'));
    }

    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $request->validate([
            'nama_pelajaran' => 'required|string|max:255',
            'kode_pelajaran' => 'required|string|max:10|unique:mata_pelajaran,kode_pelajaran,'.$mataPelajaran->id,
            'kkm' => 'required|numeric|min:0|max:100',
            'jenis' => 'required|in:wajib,pilihan,muatan_lokal',
            'tingkat' => 'required|array',
            'tingkat.*' => 'in:X,XI,XII',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $data = $request->all();
        $data['tingkat'] = json_encode($request->tingkat);

        $mataPelajaran->update($data);

        return redirect()->route('tata-usaha.master.mata-pelajaran.index')
            ->with('success', 'Data mata pelajaran berhasil diperbarui.');
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        // Check if mata pelajaran has teachers assigned
        if ($mataPelajaran->guru()->count() > 0) {
            return redirect()->route('tata-usaha.master.mata-pelajaran.index')
                ->with('error', 'Mata pelajaran tidak dapat dihapus karena masih memiliki guru yang mengajar.');
        }

        $mataPelajaran->delete();

        return redirect()->route('tata-usaha.master.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
