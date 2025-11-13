<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Pendaftaran;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PendaftaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:pendaftar')->except(['landing', 'check', 'checkStatus', 'success']);
    }

    public function landing()
    {
        // Redirect to dashboard if already logged in
        if (Auth::guard('pendaftar')->check()) {
            return redirect()->route('pendaftar.dashboard');
        }

        // Cek apakah PPDB sedang dibuka
        $is_ppdb_open = Settings::getValue('is_ppdb_open', 'false') === 'true';
        $ppdb_start_date = Settings::getValue('ppdb_start_date');
        $ppdb_end_date = Settings::getValue('ppdb_end_date');
        $ppdb_year = Settings::getValue('ppdb_year', date('Y').'/'.((int)date('Y')+1));
        
        // Jika PPDB ditutup, tampilkan pesan
        if (!$is_ppdb_open) {
            return view('ppdb.closed');
        }

        return view('ppdb.landing', compact('ppdb_year', 'ppdb_start_date', 'ppdb_end_date'));
    }

    public function index()
    {
        // Cek apakah PPDB sedang dibuka
        $is_ppdb_open = Settings::getValue('is_ppdb_open', 'false') === 'true';
        $ppdb_start_date = Settings::getValue('ppdb_start_date');
        $ppdb_end_date = Settings::getValue('ppdb_end_date');
        $ppdb_year = Settings::getValue('ppdb_year', date('Y').'/'.((int)date('Y')+1));
        
        // Jika PPDB ditutup, tampilkan pesan
        if (!$is_ppdb_open) {
            return view('ppdb.closed');
        }

        // Pastikan user sudah login
        $pendaftaran = Auth::guard('pendaftar')->user();
        
        // Jika sudah punya nomor pendaftaran, redirect ke dashboard
        if ($pendaftaran && $pendaftaran->nomor_pendaftaran) {
            return redirect()->route('pendaftar.dashboard');
        }
        
        // Ambil daftar jurusan untuk dropdown
        $jurusan = Jurusan::all();
        
        return view('ppdb.form', compact('jurusan', 'ppdb_year', 'ppdb_start_date', 'ppdb_end_date'));
    }

    public function showForm()
    {
        return $this->index();
    }

    public function store(Request $request)
    {
        // Validasi data pendaftaran
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',            
            'nisn' => [
                'nullable',
                'string',
                'max:20',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value) {
                        $currentUser = Auth::guard('pendaftar')->user();
                        $exists = Pendaftaran::whereRaw('LOWER(nisn) = ?', [strtolower($value)])
                                            ->where('id', '!=', $currentUser->id)
                                            ->exists();
                        if ($exists) {
                            $fail('NISN ini sudah terdaftar oleh orang lain.');
                        }
                    }
                }
            ],
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'asal_sekolah' => 'nullable|string|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'telepon_orangtua' => 'nullable|string|max:20',
            'alamat_orangtua' => 'nullable|string',
            'pilihan_jurusan_1' => 'nullable|exists:jurusan,id'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Start the transaction
        DB::beginTransaction();
        
        try {
            // Ambil data pendaftaran user yang sedang login
            $pendaftaran = Auth::guard('pendaftar')->user();
            
            // Generate nomor pendaftaran jika belum ada
            if (!$pendaftaran->nomor_pendaftaran) {
                $nomor_pendaftaran = Pendaftaran::generateNomorPendaftaran();
                \Log::info('Nomor pendaftaran generated: ' . $nomor_pendaftaran);
            } else {
                $nomor_pendaftaran = $pendaftaran->nomor_pendaftaran;
            }

            // Get validated data
            $nama_lengkap = $request->nama_lengkap;
            $jenis_kelamin = $request->jenis_kelamin;
            $nisn = $request->nisn;
            $tempat_lahir = $request->tempat_lahir;
            $tanggal_lahir = $request->tanggal_lahir;
            $agama = $request->agama;
            $alamat = $request->alamat;
            $telepon = $request->telepon;
            $asal_sekolah = $request->asal_sekolah;
            $nama_ayah = $request->nama_ayah;
            $nama_ibu = $request->nama_ibu;
            
            // Get first jurusan if not selected
            if (empty($request->pilihan_jurusan_1)) {
                $jurusan = Jurusan::first();
                if (!$jurusan) {
                    throw new \Exception('Tidak ada jurusan yang tersedia');
                }
                $pilihan_jurusan_1 = $jurusan->id;
                \Log::info('Using default jurusan: ' . $jurusan->id);
            } else {
                $pilihan_jurusan_1 = $request->pilihan_jurusan_1;
            }
            
            // Update data pendaftaran yang sudah ada
            $pendaftaran->nomor_pendaftaran = $nomor_pendaftaran;
            $pendaftaran->nama_lengkap = $nama_lengkap;
            $pendaftaran->jenis_kelamin = $jenis_kelamin;
            $pendaftaran->nisn = $nisn;
            $pendaftaran->tempat_lahir = $tempat_lahir;
            $pendaftaran->tanggal_lahir = $tanggal_lahir;
            $pendaftaran->agama = $agama;
            $pendaftaran->alamat = $alamat;
            $pendaftaran->telepon = $telepon;
            $pendaftaran->email = $request->email;
            $pendaftaran->asal_sekolah = $asal_sekolah;
            $pendaftaran->nama_ayah = $nama_ayah;
            $pendaftaran->nama_ibu = $nama_ibu;
            $pendaftaran->pekerjaan_ayah = $request->pekerjaan_ayah;
            $pendaftaran->pekerjaan_ibu = $request->pekerjaan_ibu;
            $pendaftaran->telepon_orangtua = $request->telepon_orangtua;
            $pendaftaran->alamat_orangtua = $request->alamat_orangtua;
            $pendaftaran->pilihan_jurusan_1 = $pilihan_jurusan_1;
            $pendaftaran->tanggal_pendaftaran = now();
            $pendaftaran->tahun_ajaran = Settings::getValue('ppdb_year', date('Y').'/'.((int)date('Y')+1));
            $pendaftaran->status = 'menunggu';
            $pendaftaran->user_id = null; // Tidak diperlukan lagi

            try {
                $pendaftaran->save();
                \Log::info('Pendaftaran saved successfully. ID: ' . $pendaftaran->id);
            } catch (\Exception $e) {
                \Log::error('Error saving pendaftaran: ' . $e->getMessage());
                throw $e;
            }
            
            DB::commit();
            \Log::info('Transaction committed successfully');
            
            return redirect()
                ->route('pendaftar.dashboard')
                ->with('success', 'Data pendaftaran berhasil disimpan! Nomor pendaftaran: ' . $nomor_pendaftaran);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error in pendaftaran store: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    public function success($nomor_pendaftaran)
    {
        $pendaftaran = Pendaftaran::where('nomor_pendaftaran', $nomor_pendaftaran)->first();
        
        if (!$pendaftaran) {
            return redirect()->route('pendaftaran.index')->with('error', 'Nomor pendaftaran tidak ditemukan.');
        }
        
        return view('ppdb.success', compact('pendaftaran'));
    }
    
    public function check()
    {
        if (Auth::guard('pendaftar')->check()) {
            $pendaftaran = Auth::guard('pendaftar')->user();
            if ($pendaftaran) {
                return view('ppdb.result', compact('pendaftaran'));
            }
        }
        
        return view('ppdb.check');
    }
    
    public function checkStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_pendaftaran' => 'required|string',
            'nisn' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pendaftaran = Pendaftaran::where('nomor_pendaftaran', $request->nomor_pendaftaran)
                                 ->where('nisn', $request->nisn)
                                 ->first();

        if (!$pendaftaran) {
            return redirect()->back()
                ->with('error', 'Data tidak ditemukan. Pastikan nomor pendaftaran dan NISN sudah benar.')
                ->withInput();
        }

        return view('ppdb.result', compact('pendaftaran'));
    }

    public function status()
    {
        if (Auth::guard('pendaftar')->check()) {
            $pendaftaran = Auth::guard('pendaftar')->user();
            if (!$pendaftaran) {
                return redirect()->route('pendaftaran.index')
                              ->with('error', 'Anda belum melakukan pendaftaran.');
            }
            
            return view('ppdb.status', compact('pendaftaran'));
        }
        
        return redirect()->route('pendaftar.login');
    }

    public function print($nomor, $nisn)
    {
        $pendaftaran = Pendaftaran::where('nomor_pendaftaran', $nomor)
                                 ->where('nisn', $nisn)
                                 ->first();

        if (!$pendaftaran) {
            abort(404, 'Data pendaftaran tidak ditemukan.');
        }

        return view('ppdb.print', compact('pendaftaran'));
    }

    public function edit()
    {
        // Get PPDB settings
        $is_ppdb_open = Settings::getValue('is_ppdb_open', 'false') === 'true';

        // If PPDB is closed, redirect back with error
        if (!$is_ppdb_open) {
            return redirect()->route('pendaftar.dashboard')
                ->with('error', 'PPDB sudah ditutup. Data tidak dapat diubah.');
        }

        // Ambil data pendaftaran user yang login
        $pendaftaran = Auth::guard('pendaftar')->user();
        if (!$pendaftaran) {
            return redirect()->route('pendaftaran.form')
                ->with('error', 'Anda belum melakukan pendaftaran.');
        }

        // Ambil daftar jurusan untuk dropdown
        $jurusan = Jurusan::all();
        
        return view('ppdb.edit', compact('pendaftaran', 'jurusan'));
    }

    public function update(Request $request)
    {
        // Validasi data pendaftaran (sama seperti store tapi dengan unique ignore untuk NISN)
        $currentUser = Auth::guard('pendaftar')->user();
        
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nisn' => [
                'required',
                'string',
                'max:20',
                Rule::unique('pendaftaran', 'nisn')->ignore($currentUser->id)
            ],
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'asal_sekolah' => 'required|string|max:255',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'telepon_orangtua' => 'nullable|string|max:20',
            'alamat_orangtua' => 'nullable|string',
            'pilihan_jurusan_1' => 'required|exists:jurusan,id'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Start the transaction
        DB::beginTransaction();
        
        try {
            $pendaftaran = Auth::guard('pendaftar')->user();
            if (!$pendaftaran) {
                throw new \Exception('Pendaftaran tidak ditemukan');
            }

            // Update data pendaftaran
            $pendaftaran->nama_lengkap = $request->nama_lengkap;
            $pendaftaran->jenis_kelamin = $request->jenis_kelamin;
            $pendaftaran->nisn = $request->nisn;
            $pendaftaran->tempat_lahir = $request->tempat_lahir;
            $pendaftaran->tanggal_lahir = $request->tanggal_lahir;
            $pendaftaran->agama = $request->agama;
            $pendaftaran->alamat = $request->alamat;
            $pendaftaran->telepon = $request->telepon;
            $pendaftaran->email = $request->email;
            $pendaftaran->asal_sekolah = $request->asal_sekolah;
            $pendaftaran->nama_ayah = $request->nama_ayah;
            $pendaftaran->nama_ibu = $request->nama_ibu;
            $pendaftaran->pekerjaan_ayah = $request->pekerjaan_ayah;
            $pendaftaran->pekerjaan_ibu = $request->pekerjaan_ibu;
            $pendaftaran->telepon_orangtua = $request->telepon_orangtua;
            $pendaftaran->alamat_orangtua = $request->alamat_orangtua;
            $pendaftaran->pilihan_jurusan_1 = $request->pilihan_jurusan_1;
            $pendaftaran->save();
            
            DB::commit();
            \Log::info('Pendaftaran updated successfully. ID: ' . $pendaftaran->id);

            return redirect()
                ->route('pendaftar.dashboard')
                ->with('success', 'Data pendaftaran berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error in pendaftaran update: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function dashboard()
    {
        // Get the logged in user's registration data
        $pendaftaran = Auth::guard('pendaftar')->user();
        
        // If no registration exists, redirect to registration form
        if (!$pendaftaran) {
            return redirect()->route('pendaftaran.form')
                ->with('error', 'Anda belum melakukan pendaftaran.');
        }
        
        // Get PPDB period info
        $ppdb_year = Settings::getValue('ppdb_year', date('Y').'/'.((int)date('Y')+1));
        
        $nextStep = null;
        if ($pendaftaran->status === 'menunggu') {
            $nextStep = 'Menunggu verifikasi admin';
        } elseif ($pendaftaran->status === 'diterima') {
            $nextStep = 'Selamat! Anda diterima. Lakukan daftar ulang.';
        } elseif ($pendaftaran->status === 'ditolak') {
            $nextStep = 'Mohon maaf, pendaftaran Anda ditolak.';
        } elseif ($pendaftaran->status === 'cadangan') {
            $nextStep = 'Anda masuk dalam daftar cadangan.';
        }
        
        return view('ppdb.dashboard', compact('pendaftaran', 'nextStep', 'ppdb_year'));
    }
}