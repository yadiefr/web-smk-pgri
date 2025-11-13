<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswa_keterlambatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_terlambat');
            $table->text('alasan_terlambat');
            $table->enum('status', ['belum_ditindak', 'sudah_ditindak', 'selesai'])->default('belum_ditindak');
            $table->text('sanksi')->nullable();
            $table->foreignId('petugas_id')->constrained('admin_users')->onDelete('cascade'); // Petugas kesiswaan yang mencatat
            $table->text('catatan_petugas')->nullable();
            $table->timestamps();

            // Index untuk performa query
            $table->index(['tanggal', 'siswa_id']);
            $table->index(['tanggal', 'kelas_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_keterlambatan');
    }
};
