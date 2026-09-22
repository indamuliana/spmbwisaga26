<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KomponenBiaya extends Model
{
    use HasFactory;

    protected $table = 'komponen_biaya';

    protected $fillable = [
        'nama_biaya',
        'program_id',
        'jurusan_id',
        'nominal',
        'is_active',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'nominal' => 'float',
            'is_active' => 'boolean',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    // --- Query Scopes ---

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeUniversal(Builder $query): Builder
    {
        return $query->whereNull('program_id')->whereNull('jurusan_id');
    }

    /**
     * Mengambil biaya yang berlaku untuk program dan jurusan tertentu (termasuk biaya universal).
     */
    public function scopeForProgramAndJurusan(Builder $query, ?int $programId = null, ?int $jurusanId = null): Builder
    {
        return $query->where(function ($q) use ($programId) {
            $q->whereNull('program_id');
            if ($programId) {
                $q->orWhere('program_id', $programId);
            }
        })->where(function ($q) use ($jurusanId) {
            $q->whereNull('jurusan_id');
            if ($jurusanId) {
                $q->orWhere('jurusan_id', $jurusanId);
            }
        });
    }
}
