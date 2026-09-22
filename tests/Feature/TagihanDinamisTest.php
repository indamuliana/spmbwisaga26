<?php

namespace Tests\Feature;

use App\Models\CalonSiswa;
use App\Models\DokumenKesepahaman;
use App\Models\KomponenBiaya;
use App\Models\PesananSeragam;
use App\Models\Program;
use App\Models\Seragam;
use App\Models\User;
use Database\Seeders\CalonSiswaSeeder;
use Database\Seeders\MasterDataSeeder;
use Database\Seeders\TagihanDinamisSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagihanDinamisTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->seed(MasterDataSeeder::class);
        $this->seed(TagihanDinamisSeeder::class);
        $this->seed(CalonSiswaSeeder::class);
    }

    public function test_komponen_biaya_universal_and_program_specific(): void
    {
        $reguler = Program::where('nama_program', 'Reguler')->first();
        $unggulan = Program::where('nama_program', 'Unggulan')->first();

        // 1. Biaya Seleksi bersifat universal
        $seleksi = KomponenBiaya::where('nama_biaya', 'like', '%Seleksi%')->first();
        $this->assertNotNull($seleksi);
        $this->assertNull($seleksi->program_id);
        $this->assertNull($seleksi->jurusan_id);
        $this->assertEquals(250000, $seleksi->nominal);

        // 2. Biaya Asrama hanya untuk Unggulan
        $asrama = KomponenBiaya::where('nama_biaya', 'like', '%Asrama%')->first();
        $this->assertNotNull($asrama);
        $this->assertEquals($unggulan->id, $asrama->program_id);
        $this->assertEquals(1200000, $asrama->nominal);

        // 3. Query biaya untuk Reguler tidak boleh memuat Asrama
        $biayaReguler = KomponenBiaya::forProgramAndJurusan($reguler->id)->get();
        $this->assertTrue($biayaReguler->contains('nama_biaya', 'Biaya Seleksi & Tes Masuk'));
        $this->assertTrue($biayaReguler->contains('nama_biaya', 'DSP (Dana Sumbangan Pendidikan) Reguler'));
        $this->assertFalse($biayaReguler->contains('nama_biaya', 'Biaya Asrama & Makan (Bulan Pertama)'));

        // 4. Query biaya untuk Unggulan harus memuat Asrama dan Seleksi
        $biayaUnggulan = KomponenBiaya::forProgramAndJurusan($unggulan->id)->get();
        $this->assertTrue($biayaUnggulan->contains('nama_biaya', 'Biaya Seleksi & Tes Masuk'));
        $this->assertTrue($biayaUnggulan->contains('nama_biaya', 'DSP (Dana Sumbangan Pendidikan) Unggulan'));
        $this->assertTrue($biayaUnggulan->contains('nama_biaya', 'Biaya Asrama & Makan (Bulan Pertama)'));
    }

    public function test_seragam_gender_and_requirement_filtering(): void
    {
        // 1. Filter seragam Putra (L + unisex)
        $seragamPutra = Seragam::forGender('L')->get();
        $this->assertTrue($seragamPutra->contains('nama_item', 'Seragam Putih Abu-abu (Putra)'));
        $this->assertTrue($seragamPutra->contains('nama_item', 'Batik Khas Sekolah'));
        $this->assertFalse($seragamPutra->contains('nama_item', 'Seragam Putih Abu-abu (Putri)'));
        $this->assertFalse($seragamPutra->contains('nama_item', 'Jilbab / Kerudung Sekolah (Set 3 Pcs)'));

        // 2. Filter seragam Putri (P + unisex)
        $seragamPutri = Seragam::forGender('P')->get();
        $this->assertTrue($seragamPutri->contains('nama_item', 'Seragam Putih Abu-abu (Putri)'));
        $this->assertTrue($seragamPutri->contains('nama_item', 'Batik Khas Sekolah'));
        $this->assertFalse($seragamPutri->contains('nama_item', 'Seragam Putih Abu-abu (Putra)'));

        // 3. Wajib vs Pilihan (Optional)
        $seragamWajib = Seragam::wajib()->get();
        $this->assertTrue($seragamWajib->contains('nama_item', 'Batik Khas Sekolah'));

        $seragamOpsional = Seragam::optional()->get();
        $this->assertTrue($seragamOpsional->contains('nama_item', 'Jilbab / Kerudung Sekolah (Set 3 Pcs)'));
    }

    public function test_pesanan_seragam_pivot_and_price_snapshot(): void
    {
        $calonSiswa = CalonSiswa::first();
        $batik = Seragam::where('nama_item', 'Batik Khas Sekolah')->first();

        $pesanan = PesananSeragam::create([
            'calon_siswa_id' => $calonSiswa->id,
            'seragam_id' => $batik->id,
            'ukuran' => 'L',
            'harga_saat_pesan' => $batik->harga,
        ]);

        $this->assertDatabaseHas('pesanan_seragam', [
            'id' => $pesanan->id,
            'calon_siswa_id' => $calonSiswa->id,
            'seragam_id' => $batik->id,
            'ukuran' => 'L',
            'harga_saat_pesan' => 150000,
        ]);

        // Test relasi
        $this->assertEquals($batik->id, $pesanan->seragam->id);
        $this->assertEquals($calonSiswa->id, $pesanan->calonSiswa->id);
    }

    public function test_dokumen_kesepahaman_program_filtering_and_ordering(): void
    {
        $reguler = Program::where('nama_program', 'Reguler')->first();
        $unggulan = Program::where('nama_program', 'Unggulan')->first();

        // 1. Program Reguler hanya mendapatkan 3 butir umum
        $pernyataanReguler = DokumenKesepahaman::forProgram($reguler->id)->get();
        $this->assertCount(3, $pernyataanReguler);
        $this->assertFalse($pernyataanReguler->contains(fn ($p) => str_contains($p->butir_pernyataan, 'asrama')));

        // 2. Program Unggulan mendapatkan 5 butir (3 umum + 2 khusus asrama/bahasa)
        $pernyataanUnggulan = DokumenKesepahaman::forProgram($unggulan->id)->get();
        $this->assertCount(5, $pernyataanUnggulan);
        $this->assertTrue($pernyataanUnggulan->contains(fn ($p) => str_contains($p->butir_pernyataan, 'asrama')));
        $this->assertTrue($pernyataanUnggulan->contains(fn ($p) => str_contains($p->butir_pernyataan, 'bahasa pengantar')));

        // 3. Memastikan pengurutan ascending sesuai urutan
        $urutanArray = $pernyataanUnggulan->pluck('urutan')->toArray();
        $this->assertEquals([1, 2, 3, 4, 5], $urutanArray);
    }
}
