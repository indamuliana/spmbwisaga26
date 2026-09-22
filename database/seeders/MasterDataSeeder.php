<?php

namespace Database\Seeders;

use App\Models\Beasiswa;
use App\Models\Gelombang;
use App\Models\Jurusan;
use App\Models\Program;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Wilayah Hierarkis (Provinsi -> Kota/Kab -> Kecamatan -> Desa)
        $jabar = Wilayah::updateOrCreate(
            ['kode' => '32'],
            ['level' => 'provinsi', 'nama' => 'Jawa Barat', 'parent_id' => null]
        );

        $dki = Wilayah::updateOrCreate(
            ['kode' => '31'],
            ['level' => 'provinsi', 'nama' => 'DKI Jakarta', 'parent_id' => null]
        );

        // Kota/Kab di Jabar
        $kotaBandung = Wilayah::updateOrCreate(
            ['kode' => '32.73'],
            ['level' => 'kota_kab', 'nama' => 'Kota Bandung', 'parent_id' => $jabar->id]
        );

        $kabBandung = Wilayah::updateOrCreate(
            ['kode' => '32.04'],
            ['level' => 'kota_kab', 'nama' => 'Kabupaten Bandung', 'parent_id' => $jabar->id]
        );

        // Kota di DKI
        $jaksel = Wilayah::updateOrCreate(
            ['kode' => '31.74'],
            ['level' => 'kota_kab', 'nama' => 'Kota Jakarta Selatan', 'parent_id' => $dki->id]
        );

        // Kecamatan di Kota Bandung
        $coblong = Wilayah::updateOrCreate(
            ['kode' => '32.73.01'],
            ['level' => 'kecamatan', 'nama' => 'Kecamatan Coblong', 'parent_id' => $kotaBandung->id]
        );

        $lengkong = Wilayah::updateOrCreate(
            ['kode' => '32.73.02'],
            ['level' => 'kecamatan', 'nama' => 'Kecamatan Lengkong', 'parent_id' => $kotaBandung->id]
        );

        // Kecamatan di Jaksel
        $tebet = Wilayah::updateOrCreate(
            ['kode' => '31.74.01'],
            ['level' => 'kecamatan', 'nama' => 'Kecamatan Tebet', 'parent_id' => $jaksel->id]
        );

        // Desa/Kelurahan di Coblong
        Wilayah::updateOrCreate(
            ['kode' => '32.73.01.1001'],
            ['level' => 'desa', 'nama' => 'Kelurahan Dago', 'parent_id' => $coblong->id]
        );
        Wilayah::updateOrCreate(
            ['kode' => '32.73.01.1002'],
            ['level' => 'desa', 'nama' => 'Kelurahan Lebak Siliwangi', 'parent_id' => $coblong->id]
        );

        // Desa di Lengkong
        Wilayah::updateOrCreate(
            ['kode' => '32.73.02.1001'],
            ['level' => 'desa', 'nama' => 'Kelurahan Malabar', 'parent_id' => $lengkong->id]
        );

        // Desa di Tebet
        Wilayah::updateOrCreate(
            ['kode' => '31.74.01.1001'],
            ['level' => 'desa', 'nama' => 'Kelurahan Tebet Barat', 'parent_id' => $tebet->id]
        );

        // 2. Program Pendidikan
        $reguler = Program::updateOrCreate(
            ['nama_program' => 'Reguler'],
            ['kuota' => 120, 'deskripsi' => 'Program pendidikan kurikulum nasional standar.', 'is_active' => true]
        );

        $unggulan = Program::updateOrCreate(
            ['nama_program' => 'Unggulan'],
            ['kuota' => 60, 'deskripsi' => 'Program kelas industri, sertifikasi internasional & pengayaan bahasa asing.', 'is_active' => true]
        );

        // 3. Jurusan / Konsentrasi Keahlian
        $rpl = Jurusan::updateOrCreate(
            ['kode_jurusan' => 'RPL'],
            ['nama_jurusan' => 'Rekayasa Perangkat Lunak', 'is_active' => true]
        );

        $tkj = Jurusan::updateOrCreate(
            ['kode_jurusan' => 'TKJ'],
            ['nama_jurusan' => 'Teknik Komputer & Jaringan', 'is_active' => true]
        );

        $dkv = Jurusan::updateOrCreate(
            ['kode_jurusan' => 'DKV'],
            ['nama_jurusan' => 'Desain Komunikasi Visual', 'is_active' => true]
        );

        // Relasi Many-to-Many Program <-> Jurusan
        $reguler->jurusans()->syncWithoutDetaching([
            $rpl->id => ['kuota' => 40],
            $tkj->id => ['kuota' => 40],
            $dkv->id => ['kuota' => 40],
        ]);

        $unggulan->jurusans()->syncWithoutDetaching([
            $rpl->id => ['kuota' => 30],
            $tkj->id => ['kuota' => 30],
        ]);

        // 4. Gelombang Pendaftaran
        Gelombang::updateOrCreate(
            ['nama' => 'Gelombang 1 - Early Bird'],
            [
                'tgl_mulai' => '2026-01-01',
                'tgl_selesai' => '2026-03-31',
                'diskon_persen' => 15.00,
                'diskon_nominal' => 500000,
                'is_active' => true,
            ]
        );

        Gelombang::updateOrCreate(
            ['nama' => 'Gelombang 2 - Reguler'],
            [
                'tgl_mulai' => '2026-04-01',
                'tgl_selesai' => '2026-06-30',
                'diskon_persen' => 0.00,
                'diskon_nominal' => 0,
                'is_active' => true,
            ]
        );

        Gelombang::updateOrCreate(
            ['nama' => 'Gelombang 3 - Terakhir'],
            [
                'tgl_mulai' => '2026-07-01',
                'tgl_selesai' => '2026-07-31',
                'diskon_persen' => 0.00,
                'diskon_nominal' => 0,
                'is_active' => false,
            ]
        );

        // 5. Beasiswa
        Beasiswa::updateOrCreate(
            ['nama_beasiswa' => 'Beasiswa Prestasi Akademik'],
            [
                'potongan_nominal' => 1500000,
                'potongan_persen' => 50.00,
                'keterangan' => 'Untuk peraih peringkat 1-3 paralel atau OSN tingkat Kabupaten/Kota.',
                'kuota' => 20,
                'is_active' => true,
            ]
        );

        Beasiswa::updateOrCreate(
            ['nama_beasiswa' => 'Beasiswa Tahfidz Al-Qur\'an'],
            [
                'potongan_nominal' => 2500000,
                'potongan_persen' => 100.00,
                'keterangan' => 'Hafal minimal 3 Juz Al-Qur\'an dibuktikan dengan sertifikat syahadah.',
                'kuota' => 10,
                'is_active' => true,
            ]
        );

        Beasiswa::updateOrCreate(
            ['nama_beasiswa' => 'Beasiswa KIP / Afirmasi'],
            [
                'potongan_nominal' => 1000000,
                'potongan_persen' => 30.00,
                'keterangan' => 'Bagi calon siswa pemilik Kartu Indonesia Pintar (KIP) atau terdaftar DTKS.',
                'kuota' => 30,
                'is_active' => true,
            ]
        );
    }
}
