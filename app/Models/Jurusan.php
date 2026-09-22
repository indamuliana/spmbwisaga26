<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';

    protected $fillable = [
        'kode_jurusan',
        'nama_jurusan',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Program yang membuka jurusan ini.
     */
    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'program_jurusan')
            ->withPivot('kuota')
            ->withTimestamps();
    }

    /**
     * Komponen biaya yang terikat khusus pada jurusan ini.
     */
    public function komponenBiaya(): HasMany
    {
        return $this->hasMany(KomponenBiaya::class, 'jurusan_id');
    }

    /**
     * Seluruh calon siswa yang memilih jurusan ini.
     */
    public function calonSiswa(): HasMany
    {
        return $this->hasMany(CalonSiswa::class, 'jurusan_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
