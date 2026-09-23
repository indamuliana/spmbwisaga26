<?php

namespace App\Models;

use App\Enums\StatusKelulusan;
use App\Enums\StatusPendaftaran;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CalonSiswa extends Model
{
    use HasFactory;

    protected $table = 'calon_siswa';

    protected $fillable = [
        'user_id',
        'nomor_pendaftar',
        'nisn',
        'nik_siswa',
        'nama_lengkap',
        'asal_sekolah',
        'program_id',
        'jurusan_id',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_detail',
        'rt',
        'rw',
        'provinsi_id',
        'kota_kab_id',
        'kecamatan_id',
        'desa_id',
        'anak_ke',
        'dari_bersaudara',
        'nama_ayah',
        'status_ayah',
        'nik_ayah',
        'tahun_lahir_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'nama_ibu',
        'status_ibu',
        'nik_ibu',
        'tahun_lahir_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'jumlah_tanggungan',
        'hp_siswa',
        'hp_ayah',
        'hp_ibu',
        'nama_wali',
        'status_wali',
        'nik_wali',
        'tahun_lahir_wali',
        'pendidikan_wali',
        'pekerjaan_wali',
        'penghasilan_wali',
        'hp_wali',
        'bukti_bayar_seleksi',
        'catatan_bayar',
        'tanggal_transfer_seleksi',
        'nama_rekening_pengirim',
        'nominal_transfer_seleksi',
        'keterangan_tolak_bayar',
        'nilai_raport',
        'prestasi',
        'rata_rata_raport',
        'referensi_promotor',
        'detail_promotor',
        'nominal_kesanggupan_awal',
        'berkas_susulan',
        'status_pendaftaran',
        'status_kelulusan',
        'no_kk',
        'kewarganegaraan',
        'agama',
        'kode_pos',
        'status_tempat_tinggal',
        'transportasi',
        'jarak_ke_sekolah',
        'waktu_tempuh',
        'tinggi_badan',
        'berat_badan',
        'golongan_darah',
        'hobi',
        'cita_cita',
        'gelombang_id',
    ];

    /**
     * Cast enum state machine & status kelulusan.
     */
    protected function casts(): array
    {
        return [
            'status_pendaftaran' => StatusPendaftaran::class,
            'status_kelulusan' => StatusKelulusan::class,
            'tanggal_lahir' => 'date',
            'penghasilan_ayah' => 'float',
            'penghasilan_ibu' => 'float',
            'penghasilan_wali' => 'float',
            'jumlah_tanggungan' => 'integer',
            'anak_ke' => 'integer',
            'dari_bersaudara' => 'integer',
            'tahun_lahir_ayah' => 'integer',
            'tahun_lahir_ibu' => 'integer',
            'tahun_lahir_wali' => 'integer',
            'nominal_kesanggupan_awal' => 'float',
            'tanggal_transfer_seleksi' => 'date',
            'nominal_transfer_seleksi' => 'float',
            'berkas_susulan' => 'array',
            'nilai_raport' => 'array',
            'prestasi' => 'array',
            'rata_rata_raport' => 'float',
        ];
    }

    // ==========================================
    // PHONE NORMALIZATION MUTATOR / CASTS
    // ==========================================

    /**
     * Helper normalisasi: Mengubah 08..., +628..., 8..., dan karakter spasi/tanda hubung menjadi format 628...
     */
    public static function normalizePhoneNumber(?string $phone): ?string
    {
        if (blank($phone)) {
            return null;
        }

        // Hapus seluruh karakter selain angka
        $cleaned = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($cleaned, '0')) {
            return '62' . substr($cleaned, 1);
        }

        if (str_starts_with($cleaned, '62')) {
            return $cleaned;
        }

        // Jika user mengetik langsung 812...
        if (str_starts_with($cleaned, '8')) {
            return '62' . $cleaned;
        }

        return $cleaned;
    }

    protected function hpSiswa(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => self::normalizePhoneNumber($value)
        );
    }

    protected function hpAyah(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => self::normalizePhoneNumber($value)
        );
    }

    protected function hpIbu(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => self::normalizePhoneNumber($value)
        );
    }

    protected function hpWali(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => self::normalizePhoneNumber($value)
        );
    }

    // ==========================================
    // RELATIONS
    // ==========================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function gelombang(): BelongsTo
    {
        return $this->belongsTo(Gelombang::class, 'gelombang_id');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'provinsi_id');
    }

    public function kotaKab(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'kota_kab_id');
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'kecamatan_id');
    }

    public function desa(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'desa_id');
    }

    public function pesananSeragam(): HasMany
    {
        return $this->hasMany(PesananSeragam::class, 'calon_siswa_id');
    }

    public function wawancara(): HasOne
    {
        return $this->hasOne(Wawancara::class, 'calon_siswa_id');
    }

    // ==========================================
    // STATE MACHINE & BUSINESS LOGIC HELPERS
    // ==========================================

    /**
     * Cek apakah calon siswa telah dinyatakan diterima.
     */
    public function isAccepted(): bool
    {
        return $this->status_kelulusan === StatusKelulusan::DITERIMA;
    }

    /**
     * Persentase tahapan alur pendaftaran (1 - 9 step).
     */
    public function progressPercentage(): int
    {
        return (int) round(($this->status_pendaftaran->stepNumber() / 9) * 100);
    }

    public function scopeAccepted(Builder $query): Builder
    {
        return $query->where('status_kelulusan', StatusKelulusan::DITERIMA);
    }

    public function scopeInStep(Builder $query, StatusPendaftaran $status): Builder
    {
        return $query->where('status_pendaftaran', $status);
    }
}
