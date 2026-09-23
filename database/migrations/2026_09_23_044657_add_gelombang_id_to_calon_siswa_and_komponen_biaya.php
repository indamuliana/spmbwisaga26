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
            $table->foreignId('gelombang_id')->nullable()->constrained('gelombang')->nullOnDelete();
        });

        Schema::table('komponen_biaya', function (Blueprint $table) {
            $table->foreignId('gelombang_id')->nullable()->constrained('gelombang')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calon_siswa_and_komponen_biaya', function (Blueprint $table) {
            //
        });
    }
};
