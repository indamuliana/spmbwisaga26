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
        Schema::create('pesanan_seragam', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calon_siswa_id')->index();
            $table->foreignId('seragam_id')->constrained('seragam')->cascadeOnDelete();
            $table->enum('ukuran', ['S', 'M', 'L', 'XL', 'XXL']);
            $table->decimal('harga_saat_pesan', 12, 2);
            $table->timestamps();

            $table->index(['calon_siswa_id', 'seragam_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_seragam');
    }
};
