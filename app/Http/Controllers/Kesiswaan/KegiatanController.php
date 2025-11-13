<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index()
    {
        // Placeholder untuk kegiatan siswa
        $kegiatan = collect([]);
        
        return view('kesiswaan.kegiatan.index', compact('kegiatan'));
    }

    public function create()
    {
        return view('kesiswaan.kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'peserta' => 'required|string'
        ]);

        // Implementasi create kegiatan
        
        return redirect()->route('kesiswaan.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan');
    }

    public function show($id)
    {
        // Implementasi show kegiatan
        return view('kesiswaan.kegiatan.show');
    }

    public function edit($id)
    {
        // Implementasi edit kegiatan
        return view('kesiswaan.kegiatan.edit');
    }

    public function update(Request $request, $id)
    {
        // Implementasi update kegiatan
        
        return redirect()->route('kesiswaan.kegiatan.show', $id)
            ->with('success', 'Kegiatan berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Implementasi delete kegiatan
        
        return redirect()->route('kesiswaan.kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus');
    }
}
