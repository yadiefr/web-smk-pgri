<?php

namespace App\Http\Controllers\TataUsaha;

use App\Http\Controllers\Controller;

class HelpController extends Controller
{
    public function index()
    {
        // Help documentation and FAQ for tata usaha
        $helpSections = [
            [
                'title' => 'Panduan Umum',
                'icon' => 'fas fa-book',
                'items' => [
                    'Cara menggunakan sistem',
                    'Navigasi dashboard',
                    'Pengaturan profil',
                ],
            ],
            [
                'title' => 'Manajemen Siswa',
                'icon' => 'fas fa-users',
                'items' => [
                    'Mendaftarkan siswa baru',
                    'Mengedit data siswa',
                    'Proses mutasi siswa',
                    'Mengelola kelas siswa',
                ],
            ],
            [
                'title' => 'Keuangan',
                'icon' => 'fas fa-money-bill-wave',
                'items' => [
                    'Membuat tagihan',
                    'Mencatat pembayaran',
                    'Laporan keuangan',
                    'Mengelola tunggakan',
                ],
            ],
            [
                'title' => 'Administrasi',
                'icon' => 'fas fa-file-alt',
                'items' => [
                    'Pembuatan surat',
                    'Pengelolaan dokumen',
                    'Sistem arsip',
                ],
            ],
            [
                'title' => 'Master Data',
                'icon' => 'fas fa-database',
                'items' => [
                    'Manajemen kelas',
                    'Data jurusan',
                    'Mata pelajaran',
                    'Tahun ajaran',
                ],
            ],
        ];

        $faq = [
            [
                'question' => 'Bagaimana cara menambahkan siswa baru?',
                'answer' => 'Masuk ke menu Siswa > Tambah Siswa, lengkapi form data siswa, dan klik simpan.',
            ],
            [
                'question' => 'Bagaimana cara memproses mutasi siswa?',
                'answer' => 'Pilih siswa yang akan dimutasi, klik tombol Mutasi, pilih jenis mutasi, dan lengkapi form yang diperlukan.',
            ],
            [
                'question' => 'Bagaimana cara membuat laporan keuangan?',
                'answer' => 'Masuk ke menu Keuangan > Laporan, pilih periode dan filter yang diinginkan, kemudian klik generate laporan.',
            ],
            [
                'question' => 'Bagaimana cara mengubah password?',
                'answer' => 'Masuk ke menu Settings > Keamanan, masukkan password lama dan password baru, kemudian simpan.',
            ],
        ];

        return view('tata_usaha.help.index', compact('helpSections', 'faq'));
    }
}
