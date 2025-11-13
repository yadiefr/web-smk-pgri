<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API untuk mendapatkan daftar siswa dalam kelas
Route::get('/kelas/{id}/siswa', function($id) {
    return \App\Models\Siswa::where('kelas_id', $id)
        ->where('status', 'aktif')
        ->orderBy('nama_lengkap')
        ->get(['id', 'nis', 'nama_lengkap as nama', 'status']);
});

// API untuk mendapatkan kelas berdasarkan tahun masuk
Route::get('/tahun-masuk/{year}/kelas', function($year) {
    // Get kelas that actually have students from the specified year
    $kelasIds = \App\Models\Siswa::where('tahun_masuk', $year)
        ->where('status', 'aktif')
        ->distinct()
        ->pluck('kelas_id');

    $kelas = \App\Models\Kelas::whereIn('id', $kelasIds)
        ->where('is_active', true)
        ->with('jurusan')
        ->orderBy('nama_kelas')
        ->get(['id', 'nama_kelas', 'tingkat', 'jurusan_id']);

    return $kelas;
});

// API untuk mendapatkan siswa berdasarkan tahun masuk
Route::get('/tahun-masuk/{year}/siswa', function($year) {
    return \App\Models\Siswa::where('tahun_masuk', $year)
        ->where('status', 'aktif')
        ->with('kelas')
        ->orderBy('nama_lengkap')
        ->get(['id', 'nis', 'nama_lengkap as nama', 'kelas_id']);
});

// API untuk mendapatkan siswa berdasarkan tahun masuk dan kelas
Route::get('/tahun-masuk/{year}/kelas/{kelasId}/siswa', function($year, $kelasId) {
    return \App\Models\Siswa::where('tahun_masuk', $year)
        ->where('kelas_id', $kelasId)
        ->where('status', 'aktif')
        ->orderBy('nama_lengkap')
        ->get(['id', 'nis', 'nama_lengkap as nama']);
});

// API untuk mendapatkan foto-foto dalam galeri
Route::get('/galeri/{id}/photos', function($id) {
    $galeri = \App\Models\Galeri::findOrFail($id);
    $photos = \App\Models\GaleriFoto::where('galeri_id', $id)
        ->orderBy('is_thumbnail', 'desc')
        ->orderBy('id', 'asc')
        ->get(['foto', 'is_thumbnail']);
    
    // Tambahkan URL foto untuk setiap item menggunakan helper asset_url
    $photos = $photos->map(function($photo) {
        return [
            'foto' => $photo->foto,
            'is_thumbnail' => $photo->is_thumbnail,
            'foto_url' => asset_url($photo->foto, 'galeri')
        ];
    });
    
    return response()->json($photos);
});

// API for SPA Assign Subjects
Route::prefix('admin')->middleware(['web', 'auth'])->group(function () {
    Route::get('guru/{guru}/assign-subjects-data', [App\Http\Controllers\Admin\GuruController::class, 'getAssignSubjectsData'])->name('api.guru.assign-subjects-data');
    Route::post('guru/{guru}/store-subject-assignment', [App\Http\Controllers\Admin\GuruController::class, 'storeSubjectAssignment'])->name('api.guru.store-subject-assignment');
    Route::delete('guru/{guru}/remove-subject-assignment/{jadwal}', [App\Http\Controllers\Admin\GuruController::class, 'removeSubjectAssignment'])->name('api.guru.remove-subject-assignment');
});
