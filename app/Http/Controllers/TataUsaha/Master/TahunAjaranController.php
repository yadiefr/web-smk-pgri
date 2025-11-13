<?php

namespace App\Http\Controllers\TataUsaha\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        // Placeholder - assuming there's a TahunAjaran model
        $tahunAjaran = collect([
            (object) ['id' => 1, 'tahun_ajaran' => '2024/2025', 'status' => 'aktif'],
            (object) ['id' => 2, 'tahun_ajaran' => '2023/2024', 'status' => 'tidak_aktif'],
        ]);

        return view('tata_usaha.master.tahun-ajaran.index', compact('tahunAjaran'));
    }

    public function create()
    {
        return view('tata_usaha.master.tahun-ajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        // Placeholder - would create TahunAjaran record
        return redirect()->route('tata-usaha.master.tahun-ajaran.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function show($id)
    {
        // Placeholder for showing tahun ajaran details
        return view('tata_usaha.master.tahun-ajaran.show', compact('id'));
    }

    public function edit($id)
    {
        // Placeholder for editing tahun ajaran
        return view('tata_usaha.master.tahun-ajaran.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        // Placeholder - would update TahunAjaran record
        return redirect()->route('tata-usaha.master.tahun-ajaran.index')
            ->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Placeholder - would delete TahunAjaran record
        return redirect()->route('tata-usaha.master.tahun-ajaran.index')
            ->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}
