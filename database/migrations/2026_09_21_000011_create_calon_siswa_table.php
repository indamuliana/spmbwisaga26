<?php

use App\Enums\StatusKelulusan;
use App\Enums\StatusPendaftaran;
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
        Schema::create('calon_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('nisn', 10)->nullable()->unique();
            $table->string('nik_siswa', 16)->nullable()->unique();
            $table->string('nama_lengkap', 150);
            $table->string('asal_sekolah', 150);
            $table->foreignId('program_id')->nullable()->constrained('program')->nullOnDelete();
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusan')->nullOnDelete();

            // Step 3: Data Diri Siswa & Wilayah
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat_detail')->nullable();
            $table->foreignId('provinsi_id')->nullable()->constrained('wilayah')->nullOnDelete();
            $table->foreignId('kota_kab_id')->nullable()->constrained('wilayah')->nullOnDelete();
            $table->foreignId('kecamatan_id')->nullable()->constrained('wilayah')->nullOnDelete();
            $table->foreignId('desa_id')->nullable()->constrained('wilayah')->nullOnDelete();

            // Step 4: Data Orang Tua
            $table->string('nama_ayah', 150)->nullable();
            $table->string('pekerjaan_ayah', 100)->nullable();
            $table->decimal('penghasilan_ayah', 12, 2)->default(0)->nullable();
            $table->string('nama_ibu', 150)->nullable();
            $table->string('pekerjaan_ibu', 100)->nullable();
            $table->decimal('penghasilan_ibu', 12, 2)->default(0)->nullable();
            $table->unsignedTinyInteger('jumlah_tanggungan')->default(1)->nullable();

            // Kontak (Otomatis dinormalisasi format 628...)
            $table->string('hp_siswa', 20)->nullable();
            $table->string('hp_ayah', 20)->nullable();
            $table->string('hp_ibu', 20)->nullable();

            // Step 5: Akademik (Matriks Nilai Raport) & Prestasi
            $table->json('nilai_raport')->nullable();
            $table->json('prestasi')->nullable();
            $table->decimal('rata_rata_raport', 5, 2)->nullable();

            // Step 2: Bukti Pembayaran Seleksi
            $table->string('bukti_bayar_seleksi')->nullable();
            $table->string('catatan_bayar')->nullable();

            // Referensi Promosi
            $table->string('referensi_promotor', 100)->nullable();
            $table->string('detail_promotor', 150)->nullable();

            // Tahap Akhir: Daftar Ulang & Loker Berkas
            $table->decimal('nominal_kesanggupan_awal', 12, 2)->nullable();
            $table->json('berkas_susulan')->nullable();

            // State Machine Enums
            $table->enum('status_pendaftaran', array_column(StatusPendaftaran::cases(), 'value'))
                  ->default(StatusPendaftaran::REGISTER->value)
                  ->index();

            $table->enum('status_kelulusan', array_column(StatusKelulusan::cases(), 'value'))
                  ->default(StatusKelulusan::PENDING->value)
                  ->index();

            $table->timestamps();

            $table->index(['program_id', 'jurusan_id', 'status_pendaftaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calon_siswa');
    }
};
