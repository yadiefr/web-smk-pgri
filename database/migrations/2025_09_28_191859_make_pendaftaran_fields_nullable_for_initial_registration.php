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
        Schema::table('pendaftaran', function (Blueprint $table) {
            // Make fields nullable that are not required during initial registration
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->change();
            $table->string('tempat_lahir')->nullable()->change();
            $table->date('tanggal_lahir')->nullable()->change();
            $table->string('agama')->nullable()->change();
            $table->text('alamat')->nullable()->change();
            $table->string('telepon', 20)->nullable()->change();
            $table->string('asal_sekolah')->nullable()->change();
            $table->string('nama_ayah')->nullable()->change();
            $table->string('nama_ibu')->nullable()->change();
            $table->unsignedBigInteger('pilihan_jurusan_1')->nullable()->change();
            $table->datetime('tanggal_pendaftaran')->nullable()->change();
            $table->string('tahun_ajaran')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            // Revert fields back to not nullable (original state)
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable(false)->change();
            $table->string('tempat_lahir')->nullable(false)->change();
            $table->date('tanggal_lahir')->nullable(false)->change();
            $table->string('agama')->nullable(false)->change();
            $table->text('alamat')->nullable(false)->change();
            $table->string('telepon', 20)->nullable(false)->change();
            $table->string('asal_sekolah')->nullable(false)->change();
            $table->string('nama_ayah')->nullable(false)->change();
            $table->string('nama_ibu')->nullable(false)->change();
            $table->unsignedBigInteger('pilihan_jurusan_1')->nullable(false)->change();
            $table->datetime('tanggal_pendaftaran')->nullable(false)->change();
            $table->string('tahun_ajaran')->nullable(false)->change();
        });
    }
};
