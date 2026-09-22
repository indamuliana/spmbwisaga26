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
        Schema::table('calon_siswa', function (Blueprint $table) {
            $table->string('no_kk', 16)->nullable()->after('nik_siswa');
            $table->string('kewarganegaraan')->nullable()->after('tanggal_lahir');
            $table->string('agama')->default('Islam')->after('kewarganegaraan');
            $table->string('kode_pos', 5)->nullable()->after('alamat_detail');
            $table->string('status_tempat_tinggal')->nullable()->after('desa_id');
            $table->string('transportasi')->nullable()->after('status_tempat_tinggal');
            $table->string('jarak_ke_sekolah')->nullable()->after('transportasi');
            $table->integer('waktu_tempuh')->nullable()->after('jarak_ke_sekolah');
            $table->integer('tinggi_badan')->nullable()->after('waktu_tempuh');
            $table->integer('berat_badan')->nullable()->after('tinggi_badan');
            $table->string('golongan_darah')->nullable()->after('berat_badan');
            $table->string('hobi')->nullable()->after('golongan_darah');
            $table->string('cita_cita')->nullable()->after('hobi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            $table->dropColumn([
                'no_kk',
                'kewarganegaraan',
                'agama',
                'kode_pos',
                'status_tempat_tinggal',
                'transportasi',
                'jarak_ke_sekolah',
                'waktu_tempuh',
                'tinggi_badan',
                'berat_badan',
                'golongan_darah',
                'hobi',
                'cita_cita',
            ]);
        });
    }
};
