<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiswaKeterlambatan;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Carbon\Carbon;

class KeterlambatanSeeder extends Seeder
{
    public function run()
    {
        // Ambil lebih banyak siswa untuk variasi data
        $siswa = Siswa::with('kelas')->limit(50)->get();
        $kelas = Kelas::all();
        
        // Coba ambil dari admin_users dulu, kalau tidak ada baru dari users
        $petugas = \DB::table('admin_users')->first();
        if (!$petugas) {
            $petugas = User::first();
        }
        
        if ($siswa->isEmpty()) {
            $this->command->info('Tidak ada data siswa. Silakan buat data siswa terlebih dahulu.');
            return;
        }

        // Buat data keterlambatan untuk seluruh bulan September 2025
        $tanggalMulai = Carbon::create(2025, 9, 1); // 1 September 2025
        $tanggalSelesai = Carbon::create(2025, 9, 30); // 30 September 2025
        
        $alasanTerlambat = [
            'Bangun kesiangan',
            'Terlambat bus',
            'Macet di jalan',
            'Hujan deras',
            'Kendaraan mogok',
            'Lupa ada pelajaran pagi',
            'Mengantar adik sekolah',
            'Antri di warung makan',
            'Motor tidak bisa hidup',
            'Kehabisan bensin',
            'Ban bocor',
            'Menunggu ojek online',
            'Terlambat bangun karena sakit',
            'Ada urusan keluarga mendadak',
            'Jalan ditutup karena ada acara',
            'Kebanjiran di perumahan',
            'Salah naik angkot',
            'Lupa bawa kunci motor',
            'Mengantar orang tua ke rumah sakit',
            'Macet parah karena kecelakaan'
        ];
        
        $keterangan = [
            'Sudah diberi peringatan lisan',
            'Diminta mengumpulkan surat izin orang tua',
            'Akan dipanggil orang tua jika terulang lagi',
            'Diberi sanksi membersihkan kelas setelah pulang',
            'Diminta datang lebih pagi besok hari',
            'Sudah ketiga kalinya bulan ini, akan diberi sanksi',
            'Diberi teguran dan diminta tidak mengulangi',
            'Orang tua sudah dihubungi via telepon',
            'Diminta membuat surat pernyataan',
            'Sanksi piket kelas selama seminggu',
            null, // Tidak ada keterangan khusus
            null,
            null,
            'Alasan dapat diterima, hanya diberi peringatan',
            'Sudah sering terlambat, perlu perhatian khusus'
        ];

        $created = 0;
        
        // Generate data untuk setiap hari dalam rentang tanggal (termasuk weekend untuk variasi)
        $currentDate = $tanggalMulai->copy();
        
        while ($currentDate <= $tanggalSelesai) {
            // Skip weekend (Sabtu dan Minggu) karena tidak ada sekolah
            if ($currentDate->isWeekend()) {
                $currentDate->addDay();
                continue;
            }
            
            $this->command->info("Generating data untuk tanggal: " . $currentDate->format('Y-m-d'));
            
            // Random 2-8 siswa terlambat per hari (lebih banyak untuk variasi)
            $jumlahTerlambat = rand(2, 8);
            $siswaTerpilih = $siswa->random(min($jumlahTerlambat, $siswa->count()));
            
            foreach ($siswaTerpilih as $s) {
                // Cek duplikat
                $exists = SiswaKeterlambatan::where('siswa_id', $s->id)
                    ->whereDate('tanggal', $currentDate->format('Y-m-d'))
                    ->exists();
                
                if (!$exists) {
                    SiswaKeterlambatan::create([
                        'siswa_id' => $s->id,
                        'kelas_id' => $s->kelas_id,
                        'tanggal' => $currentDate->format('Y-m-d'),
                        'jam_terlambat' => sprintf('%02d:%02d:00', rand(0, 1), rand(10, 59)), // Format time: 00:10:00 - 01:59:00
                        'alasan_terlambat' => $alasanTerlambat[array_rand($alasanTerlambat)],
                        'status' => ['belum_ditindak', 'sudah_ditindak', 'selesai'][array_rand(['belum_ditindak', 'sudah_ditindak', 'selesai'])],
                        'sanksi' => [
                            'Teguran lisan',
                            'Membersihkan kelas setelah pulang',
                            'Piket kelas selama 3 hari',
                            'Surat peringatan tertulis',
                            'Panggilan orang tua',
                            'Hafalan surat pendek',
                            'Datang lebih pagi selama seminggu',
                            'Membuat esai tentang kedisiplinan',
                            'Tidak ada sanksi (alasan darurat)',
                            'Counseling dengan guru BK'
                        ][array_rand([
                            'Teguran lisan',
                            'Membersihkan kelas setelah pulang',
                            'Piket kelas selama 3 hari',
                            'Surat peringatan tertulis',
                            'Panggilan orang tua',
                            'Hafalan surat pendek',
                            'Datang lebih pagi selama seminggu',
                            'Membuat esai tentang kedisiplinan',
                            'Tidak ada sanksi (alasan darurat)',
                            'Counseling dengan guru BK'
                        ])],
                        'petugas_id' => $petugas->id,
                        'catatan_petugas' => $keterangan[array_rand($keterangan)],
                        'created_at' => $currentDate->copy()->setTime(rand(7, 8), rand(0, 59)),
                        'updated_at' => $currentDate->copy()->setTime(rand(7, 8), rand(0, 59))
                    ]);
                    
                    $created++;
                }
            }
            
            // Pindah ke hari berikutnya
            $currentDate->addDay();
        }
        
        $this->command->info("Berhasil membuat {$created} data keterlambatan dummy.");
    }
}