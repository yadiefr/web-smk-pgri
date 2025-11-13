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
        Schema::create('jenis_pelanggarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggaran');
            $table->text('deskripsi')->nullable();
            $table->enum('kategori', ['ringan', 'sedang', 'berat']);
            $table->integer('poin_pelanggaran')->default(1);
            $table->text('sanksi_default')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['kategori', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_pelanggarans');
    }
};
