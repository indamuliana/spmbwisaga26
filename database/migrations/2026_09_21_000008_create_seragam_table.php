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
        Schema::create('seragam', function (Blueprint $table) {
            $table->id();
            $table->string('nama_item', 100);
            $table->enum('kategori_gender', ['L', 'P', 'unisex'])->default('unisex')->index();
            $table->boolean('wajib_sekolah')->default(true);
            $table->decimal('harga', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seragam');
    }
};
