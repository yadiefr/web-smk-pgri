<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiswaKeterlambatan;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class KeterlambatanSimpleSeeder extends Seeder
{
    public function run()
    {
        try {
            // Ambil data siswa dan petugas
            $siswa = Siswa::with('kelas')->take(50)->get();
            $petugas = DB::table('admin_users')->first();
            
            if ($siswa->isEmpty()) {
                $this->command->error('Tidak ada data siswa!');
                return;
            }
            
            if (!$petugas) {
                $this->command->error('Tidak ada admin users!');
                return;
            }
            
            $this->command->info("Siswa ditemukan: {$siswa->count()}");
            $this->command->info("Petugas ID: {$petugas->id}");
            
            $alasanTerlambat = [
                'Bangun kesiangan',
                'Terlambat bus',
                'Macet di jalan',
                'Hujan deras',
                'Kendaraan mogok'
            ];
            
            $created = 0;
            
            // Buat data untuk semua hari di September 2025
            for ($day = 1; $day <= 30; $day++) {
                $tanggal = Carbon::create(2025, 9, $day);
                
                // Skip weekend
                if ($tanggal->isWeekend()) {
                    continue;
                }
                
                $this->command->info("Membuat data untuk: " . $tanggal->format('Y-m-d'));
                
                // 3-8 siswa per hari
                $jumlahSiswa = rand(3, 8);
                $siswaTerpilih = $siswa->random(min($jumlahSiswa, $siswa->count()));
                
                foreach ($siswaTerpilih as $s) {
                    try {
                        $data = [
                            'siswa_id' => $s->id,
                            'kelas_id' => $s->kelas_id,
                            'tanggal' => $tanggal->format('Y-m-d'),
                            'jam_terlambat' => sprintf('%02d:%02d:00', 0, rand(15, 45)),
                            'alasan_terlambat' => $alasanTerlambat[array_rand($alasanTerlambat)],
                            'status' => 'belum_ditindak',
                            'sanksi' => 'Teguran lisan',
                            'petugas_id' => $petugas->id,
                            'catatan_petugas' => 'Diberi peringatan',
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                        
                        SiswaKeterlambatan::create($data);
                        $created++;
                        
                    } catch (\Exception $e) {
                        $this->command->error("Error creating record: " . $e->getMessage());
                    }
                }
            }
            
            $this->command->info("Berhasil membuat {$created} data keterlambatan.");
            
        } catch (\Exception $e) {
            $this->command->error("Error in seeder: " . $e->getMessage());
        }
    }
}