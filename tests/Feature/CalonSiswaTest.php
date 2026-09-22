<?php

namespace Tests\Feature;

use App\Enums\StatusKelulusan;
use App\Enums\StatusPendaftaran;
use App\Models\CalonSiswa;
use App\Models\Jurusan;
use App\Models\Program;
use App\Models\Seragam;
use App\Models\User;
use Database\Seeders\CalonSiswaSeeder;
use Database\Seeders\MasterDataSeeder;
use Database\Seeders\TagihanDinamisSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalonSiswaTest extends TestCase
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

    public function test_phone_normalization_mutator(): void
    {
        $user = User::factory()->create(['role' => 'siswa']);

        $calonSiswa = CalonSiswa::create([
            'user_id' => $user->id,
            'nama_lengkap' => 'Budi Santoso',
            'asal_sekolah' => 'SMP Negeri 2 Bandung',
            'hp_siswa' => '0812-3456-7890',     // diawali 08 dan bertanda hubung
            'hp_ayah' => '+62 813-9988-7766',   // diawali +62 dan spasi
            'hp_ibu' => '85712345678',          // diawali 8 tanpa 0 atau 62
        ]);

        // Verifikasi dalam database nilai yang tersimpan berformat 628...
        $this->assertDatabaseHas('calon_siswa', [
            'id' => $calonSiswa->id,
            'hp_siswa' => '6281234567890',
            'hp_ayah' => '6281399887766',
            'hp_ibu' => '6285712345678',
        ]);

        $this->assertEquals('6281234567890', $calonSiswa->hp_siswa);
        $this->assertEquals('6281399887766', $calonSiswa->hp_ayah);
        $this->assertEquals('6285712345678', $calonSiswa->hp_ibu);
    }

    public function test_state_machine_and_graduation_enum_casts(): void
    {
        $siswaUser = User::where('email', 'siswa@ppdb.test')->first();
        $calonSiswa = $siswaUser->calonSiswa;

        $this->assertNotNull($calonSiswa);
        $this->assertInstanceOf(StatusPendaftaran::class, $calonSiswa->status_pendaftaran);
        $this->assertInstanceOf(StatusKelulusan::class, $calonSiswa->status_kelulusan);

        // Update status pendaftaran
        $calonSiswa->status_pendaftaran = StatusPendaftaran::MENUNGGU_WAWANCARA;
        $calonSiswa->save();

        $this->assertEquals(StatusPendaftaran::MENUNGGU_WAWANCARA, $calonSiswa->fresh()->status_pendaftaran);
        $this->assertEquals(6, $calonSiswa->status_pendaftaran->stepNumber());

        // Update status kelulusan
        $this->assertFalse($calonSiswa->isAccepted());
        $calonSiswa->status_kelulusan = StatusKelulusan::DITERIMA;
        $calonSiswa->save();

        $this->assertTrue($calonSiswa->fresh()->isAccepted());
    }

    public function test_calon_siswa_relationships(): void
    {
        $siswaUser = User::where('email', 'siswa@ppdb.test')->first();
        $calonSiswa = $siswaUser->calonSiswa;

        // 1. Relasi User
        $this->assertEquals($siswaUser->id, $calonSiswa->user->id);
        $this->assertEquals($calonSiswa->id, $siswaUser->calonSiswa->id);

        // 2. Relasi Program & Jurusan
        $this->assertInstanceOf(Program::class, $calonSiswa->program);
        $this->assertInstanceOf(Jurusan::class, $calonSiswa->jurusan);
        $this->assertEquals('Unggulan', $calonSiswa->program->nama_program);
        $this->assertEquals('RPL', $calonSiswa->jurusan->kode_jurusan);

        // 3. Relasi Pesanan Seragam
        $batik = Seragam::where('nama_item', 'Batik Khas Sekolah')->first();
        $calonSiswa->pesananSeragam()->create([
            'seragam_id' => $batik->id,
            'ukuran' => 'XL',
            'harga_saat_pesan' => $batik->harga,
        ]);

        $this->assertCount(1, $calonSiswa->fresh()->pesananSeragam);
        $this->assertEquals('XL', $calonSiswa->pesananSeragam->first()->ukuran);
    }
}
