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
        Schema::create('wawancara', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pewawancara_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('calon_siswa_id')->unique()->constrained('calon_siswa')->cascadeOnDelete();
            $table->dateTime('jadwal');
            $table->string('link_meet', 255)->nullable();
            $table->string('nilai_fisik_rambut', 7)->default('#1a1a1a'); // Hex color code
            $table->string('nilai_fisik_seragam', 7)->default('#ffffff'); // Hex color code
            $table->enum('kemampuan_quran', ['Iqro', 'Tahsin', 'Tahfidz'])->default('Iqro');
            $table->unsignedTinyInteger('jumlah_juz')->default(0);
            $table->text('catatan_rahasia')->nullable();
            $table->timestamps();

            $table->index(['pewawancara_id', 'jadwal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wawancara');
    }
};
