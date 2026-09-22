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
        Schema::create('wilayah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('wilayah')
                  ->cascadeOnDelete();
            $table->enum('level', ['provinsi', 'kota_kab', 'kecamatan', 'desa'])->index();
            $table->string('kode', 20)->nullable()->index();
            $table->string('nama', 100);
            $table->timestamps();

            // Composite index for fast cascading lookups
            $table->index(['parent_id', 'level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wilayah');
    }
};
