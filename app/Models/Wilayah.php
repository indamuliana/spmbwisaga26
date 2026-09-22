<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wilayah extends Model
{
    use HasFactory;

    protected $table = 'wilayah';

    protected $fillable = [
        'parent_id',
        'level',
        'kode',
        'nama',
    ];

    /**
     * Parent wilayah relation (e.g. Desa belongsTo Kecamatan, Kecamatan belongsTo Kota/Kab, Kota/Kab belongsTo Provinsi).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'parent_id');
    }

    /**
     * All direct children of this wilayah.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Wilayah::class, 'parent_id');
    }

    /**
     * Direct Kota/Kabupaten children (if current model is a Provinsi).
     */
    public function kotaKab(): HasMany
    {
        return $this->children()->where('level', 'kota_kab');
    }

    /**
     * Direct Kecamatan children (if current model is a Kota/Kabupaten).
     */
    public function kecamatan(): HasMany
    {
        return $this->children()->where('level', 'kecamatan');
    }

    /**
     * Direct Desa/Kelurahan children (if current model is a Kecamatan).
     */
    public function desa(): HasMany
    {
        return $this->children()->where('level', 'desa');
    }

    // --- Query Scopes for Cascading Dropdowns ---

    public function scopeProvinsi(Builder $query): Builder
    {
        return $query->where('level', 'provinsi')->whereNull('parent_id');
    }

    public function scopeFilterKotaKab(Builder $query, ?int $provinsiId = null): Builder
    {
        return $query->where('level', 'kota_kab')
            ->when($provinsiId, fn ($q) => $q->where('parent_id', $provinsiId));
    }

    public function scopeFilterKecamatan(Builder $query, ?int $kotaKabId = null): Builder
    {
        return $query->where('level', 'kecamatan')
            ->when($kotaKabId, fn ($q) => $q->where('parent_id', $kotaKabId));
    }

    public function scopeFilterDesa(Builder $query, ?int $kecamatanId = null): Builder
    {
        return $query->where('level', 'desa')
            ->when($kecamatanId, fn ($q) => $q->where('parent_id', $kecamatanId));
    }

    public function scopeChildOf(Builder $query, int $parentId, ?string $level = null): Builder
    {
        return $query->where('parent_id', $parentId)
            ->when($level, fn ($q) => $q->where('level', $level));
    }
}
