<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TagihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all siswa
        $siswa = \App\Models\Siswa::with('kelas')->get();

        if ($siswa->isEmpty()) {
            $this->command->info('No students found. Please seed siswa data first.');

            return;
        }

        $jenisTagihan = [
            ['nama' => 'SPP', 'nominal' => 350000],
            ['nama' => 'Uang Gedung', 'nominal' => 500000],
            ['nama' => 'Uang Kegiatan', 'nominal' => 150000],
            ['nama' => 'Uang Seragam', 'nominal' => 200000],
            ['nama' => 'Uang Buku', 'nominal' => 300000],
            ['nama' => 'Uang Praktek', 'nominal' => 250000],
        ];

        $bulan = ['2024-07', '2024-08', '2024-09', '2024-10', '2024-11'];

        foreach ($siswa as $student) {
            // Create SPP for each month
            foreach ($bulan as $periode) {
                $jatuhTempo = \Carbon\Carbon::createFromFormat('Y-m', $periode)->addMonth()->day(10);

                // Determine status
                $status = 'belum_bayar';
                if ($jatuhTempo->isPast()) {
                    $status = rand(1, 10) > 3 ? 'lunas' : 'terlambat'; // 70% chance lunas
                }

                \App\Models\Tagihan::create([
                    'nama_tagihan' => 'SPP '.\Carbon\Carbon::createFromFormat('Y-m', $periode)->format('F Y'),
                    'keterangan' => 'Sumbangan Pembinaan Pendidikan bulan '.\Carbon\Carbon::createFromFormat('Y-m', $periode)->format('F Y'),
                    'nominal' => 350000,
                    'periode' => $periode,
                    'tanggal_jatuh_tempo' => $jatuhTempo,
                    'kelas_id' => $student->kelas_id,
                    'siswa_id' => $student->id,
                    'status_pembayaran' => $status,
                    'created_at' => \Carbon\Carbon::createFromFormat('Y-m', $periode)->subDays(15),
                    'updated_at' => \Carbon\Carbon::createFromFormat('Y-m', $periode)->subDays(15),
                ]);
            }

            // Create some other bills randomly
            if (rand(1, 10) > 7) { // 30% chance
                $randomTagihan = $jenisTagihan[array_rand($jenisTagihan)];
                $jatuhTempo = now()->addDays(rand(5, 30));

                \App\Models\Tagihan::create([
                    'nama_tagihan' => $randomTagihan['nama'],
                    'keterangan' => 'Pembayaran '.$randomTagihan['nama'].' tahun ajaran 2024/2025',
                    'nominal' => $randomTagihan['nominal'],
                    'periode' => now()->format('Y-m'),
                    'tanggal_jatuh_tempo' => $jatuhTempo,
                    'kelas_id' => $student->kelas_id,
                    'siswa_id' => $student->id,
                    'status_pembayaran' => 'belum_bayar',
                    'created_at' => now()->subDays(rand(1, 10)),
                    'updated_at' => now()->subDays(rand(1, 10)),
                ]);
            }
        }

        $this->command->info('Tagihan seeder completed successfully!');
    }
}
