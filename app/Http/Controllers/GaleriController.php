<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\GaleriFoto;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->get('kategori', 'all');
        $search = $request->get('search', '');

        $galeri = Galeri::with('foto') // Load all photos untuk count yang benar
            ->when($search, function ($query, $search) {
                return $query->where('judul', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->when($kategori !== 'all', function ($query) use ($kategori) {
                return $query->where('kategori', $kategori);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Get available categories
        $kategoris = Galeri::select('kategori')
            ->distinct()
            ->whereNotNull('kategori')
            ->pluck('kategori');

        return view('galeri.index', compact('galeri', 'kategoris', 'kategori', 'search'));
    }

    public function show($id)
    {
        $galeri = Galeri::with('foto')->findOrFail($id);

        return view('galeri.show', compact('galeri'));
    }

    public function getPhotos($id)
    {
        $galeri = Galeri::findOrFail($id);
        $photos = GaleriFoto::where('galeri_id', $id)->get();

        // Transform data untuk menambahkan URL yang benar
        $photosWithUrl = $photos->map(function ($photo) {
            return [
                'id' => $photo->id,
                'foto' => $photo->foto,
                'foto_url' => asset_url($photo->foto, 'galeri'),
                'is_thumbnail' => $photo->is_thumbnail,
                'created_at' => $photo->created_at,
            ];
        });

        return response()->json($photosWithUrl);
    }
}
