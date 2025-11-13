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
            if (!Schema::hasColumn('pendaftaran', 'whatsapp')) {
                $table->string('whatsapp', 20)->nullable()->after('telepon');
            }
            if (!Schema::hasColumn('pendaftaran', 'username')) {
                $table->string('username')->nullable()->after('nisn');
            }
            if (!Schema::hasColumn('pendaftaran', 'password')) {
                $table->string('password')->nullable()->after('username');
            }
            if (!Schema::hasColumn('pendaftaran', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('password');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            if (Schema::hasColumn('pendaftaran', 'whatsapp')) {
                $table->dropColumn('whatsapp');
            }
            if (Schema::hasColumn('pendaftaran', 'username')) {
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('pendaftaran', 'password')) {
                $table->dropColumn('password');
            }
            if (Schema::hasColumn('pendaftaran', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
