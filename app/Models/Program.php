<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use HasFactory;

    protected $table = 'program';

    protected $fillable = [
        'nama_program',
        'kuota',
        'deskripsi',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'kuota' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Jurusan yang tersedia di program ini.
     */
    public function jurusans(): BelongsToMany
    {
        return $this->belongsToMany(Jurusan::class, 'program_jurusan')
            ->withPivot('kuota')
            ->withTimestamps();
    }

    /**
     * Komponen biaya yang terikat pada program ini.
     */
    public function komponenBiaya(): HasMany
    {
        return $this->hasMany(KomponenBiaya::class, 'program_id');
    }

    /**
     * Butir kesepahaman yang terikat pada program ini.
     */
    public function dokumenKesepahaman(): HasMany
    {
        return $this->hasMany(DokumenKesepahaman::class, 'program_id');
    }

    /**
     * Seluruh calon siswa yang mendaftar di program ini.
     */
    public function calonSiswa(): HasMany
    {
        return $this->hasMany(CalonSiswa::class, 'program_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
