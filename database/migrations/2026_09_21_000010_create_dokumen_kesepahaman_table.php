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
        Schema::create('dokumen_kesepahaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')
                  ->nullable()
                  ->constrained('program')
                  ->cascadeOnDelete();
            $table->text('butir_pernyataan');
            $table->unsignedInteger('urutan')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['program_id', 'urutan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_kesepahaman');
    }
};
