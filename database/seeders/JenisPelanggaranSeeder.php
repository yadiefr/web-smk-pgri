<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisPelanggaran;

class JenisPelanggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisPelanggaran = [
            // Pelanggaran Ringan
            [
                'nama_pelanggaran' => 'Terlambat Masuk Sekolah',
                'deskripsi' => 'Datang ke sekolah setelah bel masuk berbunyi',
                'kategori' => 'ringan',
                'poin_pelanggaran' => 1,
                'sanksi_default' => 'Teguran lisan dan catatan di buku pelanggaran',
            ],
            [
                'nama_pelanggaran' => 'Tidak Menggunakan Seragam Lengkap',
                'deskripsi' => 'Tidak memakai atribut seragam sekolah dengan lengkap dan rapi',
                'kategori' => 'ringan',
                'poin_pelanggaran' => 1,
                'sanksi_default' => 'Teguran dan peringatan untuk melengkapi seragam',
            ],
            [
                'nama_pelanggaran' => 'Tidak Membawa Perlengkapan Belajar',
                'deskripsi' => 'Tidak membawa buku, alat tulis, atau perlengkapan belajar yang diperlukan',
                'kategori' => 'ringan',
                'poin_pelanggaran' => 1,
                'sanksi_default' => 'Teguran dan tugas tambahan',
            ],
            [
                'nama_pelanggaran' => 'Tidak Mengerjakan PR/Tugas',
                'deskripsi' => 'Tidak menyelesaikan pekerjaan rumah atau tugas yang diberikan guru',
                'kategori' => 'ringan',
                'poin_pelanggaran' => 2,
                'sanksi_default' => 'Mengerjakan tugas di sekolah dan tugas tambahan',
            ],

            // Pelanggaran Sedang
            [
                'nama_pelanggaran' => 'Membolos/Tidak Masuk Tanpa Keterangan',
                'deskripsi' => 'Tidak hadir di sekolah tanpa pemberitahuan atau izin yang sah',
                'kategori' => 'sedang',
                'poin_pelanggaran' => 5,
                'sanksi_default' => 'Surat peringatan dan panggilan orang tua',
            ],
            [
                'nama_pelanggaran' => 'Mengganggu Ketertiban Kelas',
                'deskripsi' => 'Membuat keributan, berbicara keras, atau mengganggu proses pembelajaran',
                'kategori' => 'sedang',
                'poin_pelanggaran' => 3,
                'sanksi_default' => 'Diberi tugas khusus dan teguran tertulis',
            ],
            [
                'nama_pelanggaran' => 'Tidak Mengikuti Upacara/Kegiatan Sekolah',
                'deskripsi' => 'Tidak menghadiri upacara bendera atau kegiatan wajib sekolah lainnya',
                'kategori' => 'sedang',
                'poin_pelanggaran' => 3,
                'sanksi_default' => 'Pembersihan lingkungan sekolah dan surat peringatan',
            ],
            [
                'nama_pelanggaran' => 'Merokok di Lingkungan Sekolah',
                'deskripsi' => 'Kedapatan merokok di area sekolah atau saat jam sekolah',
                'kategori' => 'sedang',
                'poin_pelanggaran' => 7,
                'sanksi_default' => 'Surat peringatan, panggilan orang tua, dan skorsing 1 hari',
            ],

            // Pelanggaran Berat
            [
                'nama_pelanggaran' => 'Berkelahi/Tawuran',
                'deskripsi' => 'Terlibat perkelahian dengan sesama siswa baik di dalam maupun luar sekolah',
                'kategori' => 'berat',
                'poin_pelanggaran' => 15,
                'sanksi_default' => 'Skorsing 3 hari, surat peringatan keras, dan panggilan orang tua',
            ],
            [
                'nama_pelanggaran' => 'Membawa Barang Terlarang',
                'deskripsi' => 'Membawa senjata tajam, obat-obatan terlarang, atau barang berbahaya lainnya',
                'kategori' => 'berat',
                'poin_pelanggaran' => 20,
                'sanksi_default' => 'Skorsing 1 minggu dan evaluasi khusus dengan konselor',
            ],
            [
                'nama_pelanggaran' => 'Merusak Fasilitas Sekolah',
                'deskripsi' => 'Sengaja merusak atau menghilangkan fasilitas dan properti sekolah',
                'kategori' => 'berat',
                'poin_pelanggaran' => 10,
                'sanksi_default' => 'Ganti rugi dan skorsing 2 hari',
            ],
            [
                'nama_pelanggaran' => 'Tidak Sopan kepada Guru/Staff',
                'deskripsi' => 'Berkata kasar, tidak sopan, atau membantah guru dan staff sekolah',
                'kategori' => 'berat',
                'poin_pelanggaran' => 12,
                'sanksi_default' => 'Surat peringatan keras, panggilan orang tua, dan konseling',
            ],
            [
                'nama_pelanggaran' => 'Plagiarisme/Menyontek',
                'deskripsi' => 'Melakukan kecurangan dalam ujian, tugas, atau karya ilmiah',
                'kategori' => 'berat',
                'poin_pelanggaran' => 8,
                'sanksi_default' => 'Nilai tugas/ujian dibatalkan dan mengulang ujian',
            ],
        ];

        foreach ($jenisPelanggaran as $jenis) {
            JenisPelanggaran::create($jenis);
        }
    }
}
