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
            // Domisili (RT & RW)
            $table->string('rt', 3)->nullable()->after('alamat_detail');
            $table->string('rw', 3)->nullable()->after('rt');

            // Kependudukan & Kelahiran tambahan
            $table->unsignedTinyInteger('anak_ke')->nullable()->after('no_kk');
            $table->unsignedTinyInteger('dari_bersaudara')->nullable()->after('anak_ke');

            // Data Ayah tambahan
            $table->enum('status_ayah', ['Hidup', 'Wafat'])->default('Hidup')->nullable()->after('nama_ayah');
            $table->string('nik_ayah', 16)->nullable()->after('status_ayah');
            $table->smallInteger('tahun_lahir_ayah')->unsigned()->nullable()->after('nik_ayah');
            $table->string('pendidikan_ayah', 50)->nullable()->after('tahun_lahir_ayah');

            // Data Ibu tambahan
            $table->enum('status_ibu', ['Hidup', 'Wafat'])->default('Hidup')->nullable()->after('nama_ibu');
            $table->string('nik_ibu', 16)->nullable()->after('status_ibu');
            $table->smallInteger('tahun_lahir_ibu')->unsigned()->nullable()->after('nik_ibu');
            $table->string('pendidikan_ibu', 50)->nullable()->after('tahun_lahir_ibu');

            // Data Wali (opsional)
            $table->string('nama_wali', 150)->nullable()->after('hp_ibu');
            $table->enum('status_wali', ['Hidup', 'Wafat'])->default('Hidup')->nullable()->after('nama_wali');
            $table->string('nik_wali', 16)->nullable()->after('status_wali');
            $table->smallInteger('tahun_lahir_wali')->unsigned()->nullable()->after('nik_wali');
            $table->string('pendidikan_wali', 50)->nullable()->after('tahun_lahir_wali');
            $table->string('pekerjaan_wali', 100)->nullable()->after('pendidikan_wali');
            $table->decimal('penghasilan_wali', 12, 2)->default(0)->nullable()->after('pekerjaan_wali');
            $table->string('hp_wali', 20)->nullable()->after('penghasilan_wali');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            $table->dropColumn([
                'rt',
                'rw',
                'anak_ke',
                'dari_bersaudara',
                'status_ayah',
                'nik_ayah',
                'tahun_lahir_ayah',
                'pendidikan_ayah',
                'status_ibu',
                'nik_ibu',
                'tahun_lahir_ibu',
                'pendidikan_ibu',
                'nama_wali',
                'status_wali',
                'nik_wali',
                'tahun_lahir_wali',
                'pendidikan_wali',
                'pekerjaan_wali',
                'penghasilan_wali',
                'hp_wali',
            ]);
        });
    }
};
