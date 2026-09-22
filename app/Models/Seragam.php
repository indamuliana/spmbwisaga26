<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seragam extends Model
{
    use HasFactory;

    protected $table = 'seragam';

    protected $fillable = [
        'nama_item',
        'kategori_gender',
        'wajib_sekolah',
        'harga',
    ];

    protected function casts(): array
    {
        return [
            'wajib_sekolah' => 'boolean',
            'harga' => 'float',
        ];
    }

    public function pesanan(): HasMany
    {
        return $this->hasMany(PesananSeragam::class, 'seragam_id');
    }

    public function scopeWajib(Builder $query): Builder
    {
        return $query->where('wajib_sekolah', true);
    }

    public function scopeOptional(Builder $query): Builder
    {
        return $query->where('wajib_sekolah', false);
    }

    /**
     * Filter seragam yang sesuai dengan jenis kelamin calon siswa.
     */
    public function scopeForGender(Builder $query, string $gender): Builder
    {
        return $query->whereIn('kategori_gender', [$gender, 'unisex']);
    }
}
