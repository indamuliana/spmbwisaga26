<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenKesepahaman extends Model
{
    use HasFactory;

    protected $table = 'dokumen_kesepahaman';

    protected $fillable = [
        'program_id',
        'butir_pernyataan',
        'urutan',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'urutan' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Mengambil butir kesepahaman yang berlaku untuk program tertentu (termasuk butir umum).
     */
    public function scopeForProgram(Builder $query, ?int $programId = null): Builder
    {
        return $query->where(function ($q) use ($programId) {
            $q->whereNull('program_id');
            if ($programId) {
                $q->orWhere('program_id', $programId);
            }
        })->orderBy('urutan', 'asc');
    }
}
