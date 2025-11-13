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
        Schema::create('pelanggarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
            $table->foreignId('jenis_pelanggaran_id')->constrained('jenis_pelanggarans')->onDelete('cascade');
            $table->foreignId('guru_id')->nullable()->constrained()->onDelete('set null');
            $table->date('tanggal_pelanggaran');
            $table->time('jam_pelanggaran')->nullable();
            $table->text('deskripsi_kejadian');
            $table->text('sanksi_diberikan');
            $table->date('tanggal_selesai_sanksi')->nullable();
            $table->enum('status_sanksi', ['belum_selesai', 'sedang_proses', 'selesai'])->default('belum_selesai');
            $table->text('catatan_tambahan')->nullable();
            $table->string('bukti_foto')->nullable();
            $table->boolean('sudah_dihubungi_ortu')->default(false);
            $table->timestamp('tanggal_hubungi_ortu')->nullable();
            $table->text('respon_ortu')->nullable();
            $table->enum('tingkat_urgensi', ['rendah', 'sedang', 'tinggi', 'sangat_tinggi'])->default('sedang');
            $table->timestamps();
            
            $table->index(['siswa_id', 'tanggal_pelanggaran']);
            $table->index(['status_sanksi', 'tanggal_pelanggaran']);
            $table->index(['tingkat_urgensi', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggarans');
    }
};
