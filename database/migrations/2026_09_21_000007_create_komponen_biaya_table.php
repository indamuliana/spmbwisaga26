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
        Schema::create('komponen_biaya', function (Blueprint $table) {
            $table->id();
            $table->string('nama_biaya', 100);
            $table->foreignId('program_id')
                  ->nullable()
                  ->constrained('program')
                  ->nullOnDelete();
            $table->foreignId('jurusan_id')
                  ->nullable()
                  ->constrained('jurusan')
                  ->nullOnDelete();
            $table->decimal('nominal', 12, 2);
            $table->boolean('is_active')->default(true);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index(['program_id', 'jurusan_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komponen_biaya');
    }
};
