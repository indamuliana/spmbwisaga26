<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            $table->date('tanggal_transfer_seleksi')->nullable()->after('catatan_bayar');
            $table->string('nama_rekening_pengirim')->nullable()->after('tanggal_transfer_seleksi');
            $table->decimal('nominal_transfer_seleksi', 12, 2)->nullable()->after('nama_rekening_pengirim');
            $table->text('keterangan_tolak_bayar')->nullable()->after('nominal_transfer_seleksi');
        });
    }

    public function down(): void
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_transfer_seleksi',
                'nama_rekening_pengirim',
                'nominal_transfer_seleksi',
                'keterangan_tolak_bayar'
            ]);
        });
    }
};
