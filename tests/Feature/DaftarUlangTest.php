<?php

namespace Tests\Feature;

use App\Enums\StatusKelulusan;
use App\Enums\StatusPendaftaran;
use App\Livewire\Siswa\DaftarUlang;
use App\Models\CalonSiswa;
use App\Models\PesananSeragam;
use App\Models\Program;
use App\Models\Seragam;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Database\Seeders\TagihanDinamisSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class DaftarUlangTest extends TestCase
{
    use RefreshDatabase;

    protected User $siswaUser;
    protected CalonSiswa $calon;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->seed(MasterDataSeeder::class);
        $this->seed(TagihanDinamisSeeder::class);

        $this->siswaUser = User::where('email', 'siswa@ppdb.test')->first();
        $reguler = Program::where('nama_program', 'Reguler')->first();

        $this->calon = CalonSiswa::updateOrCreate(
            ['user_id' => $this->siswaUser->id],
            [
                'nisn' => '0099112233',
                'nama_lengkap' => 'Alif Firmansyah',
                'asal_sekolah' => 'SMP Negeri 2 Bandung',
                'jenis_kelamin' => 'L',
                'program_id' => $reguler->id,
                'status_pendaftaran' => StatusPendaftaran::PENGUMUMAN,
                'status_kelulusan' => StatusKelulusan::DITERIMA,
            ]
        );
    }

    public function test_siswa_can_access_daftar_ulang_page(): void
    {
        $response = $this->actingAs($this->siswaUser)->get('/siswa/daftar-ulang');
        $response->assertStatus(200);
        $response->assertSeeLivewire('siswa.daftar-ulang');
        $response->assertSee('Daftar Ulang');
        $response->assertSee('Checkout Seragam');
    }

    public function test_daftar_ulang_component_auto_selects_mandatory_uniforms(): void
    {
        $this->actingAs($this->siswaUser);

        $component = Livewire::test(DaftarUlang::class);

        $wajibItems = Seragam::forGender('L')->wajib()->get();
        foreach ($wajibItems as $item) {
            $this->assertTrue($component->get("selectedSeragam.{$item->id}"));
            $this->assertEquals('L', $component->get("ukuranSeragam.{$item->id}"));
        }

        // Total biaya seragam harus mencakup item wajib
        $expectedTotal = $wajibItems->sum('harga');
        $this->assertGreaterThanOrEqual($expectedTotal, $component->instance()->getTotalBiayaSeragam());
    }

    public function test_submit_daftar_ulang_saves_nominal_seragam_and_loker_berkas(): void
    {
        Storage::fake('public');
        $this->actingAs($this->siswaUser);

        $fileIjazah = UploadedFile::fake()->create('ijazah.pdf', 300, 'application/pdf');
        $fileKk = UploadedFile::fake()->create('kk.jpg', 200, 'image/jpeg');

        // Pilih item seragam dan ubah ukuran salah satu item ke 'XL'
        $firstSeragam = Seragam::forGender('L')->first();

        Livewire::test(DaftarUlang::class)
            ->set('nominal_kesanggupan_awal', 2000000)
            ->set("ukuranSeragam.{$firstSeragam->id}", 'XL')
            ->set('upload_ijazah', $fileIjazah)
            ->set('upload_kk', $fileKk)
            ->call('submitDaftarUlang')
            ->assertHasNoErrors()
            ->assertSet('isSubmitted', true);

        // 1. Verifikasi data calon siswa terupdate
        $this->calon->refresh();
        $this->assertEquals(2000000, $this->calon->nominal_kesanggupan_awal);
        $this->assertEquals(StatusPendaftaran::DAFTAR_ULANG, $this->calon->status_pendaftaran);

        // 2. Verifikasi Loker Berkas
        $this->assertIsArray($this->calon->berkas_susulan);
        $this->assertArrayHasKey('ijazah', $this->calon->berkas_susulan);
        $this->assertArrayHasKey('kk', $this->calon->berkas_susulan);
        Storage::disk('public')->assertExists($this->calon->berkas_susulan['ijazah']);
        Storage::disk('public')->assertExists($this->calon->berkas_susulan['kk']);

        // 3. Verifikasi Pesanan Seragam tersimpan di tabel pivot
        $pesanan = PesananSeragam::where('calon_siswa_id', $this->calon->id)
            ->where('seragam_id', $firstSeragam->id)
            ->first();

        $this->assertNotNull($pesanan);
        $this->assertEquals('XL', $pesanan->ukuran);
        $this->assertEquals($firstSeragam->harga, $pesanan->harga_saat_pesan);
    }
}
