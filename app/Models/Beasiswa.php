<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beasiswa extends Model
{
    use HasFactory;

    protected $table = 'beasiswa';

    protected $fillable = [
        'nama_beasiswa',
        'potongan_nominal',
        'potongan_persen',
        'keterangan',
        'kuota',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'potongan_nominal' => 'float',
            'potongan_persen' => 'float',
            'kuota' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
