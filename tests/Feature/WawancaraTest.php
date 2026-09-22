<?php

namespace Tests\Feature;

use App\Enums\StatusKelulusan;
use App\Enums\StatusPendaftaran;
use App\Livewire\Pewawancara\FormWawancara;
use App\Models\CalonSiswa;
use App\Models\User;
use App\Models\Wawancara;
use Database\Seeders\MasterDataSeeder;
use Database\Seeders\TagihanDinamisSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class WawancaraTest extends TestCase
{
    use RefreshDatabase;

    protected User $pewawancara;
    protected User $siswaUser;
    protected CalonSiswa $calonSiswa;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->seed(MasterDataSeeder::class);
        $this->seed(TagihanDinamisSeeder::class);

        $this->pewawancara = User::where('email', 'pewawancara@ppdb.test')->first();
        $this->siswaUser = User::where('email', 'siswa@ppdb.test')->first();

        // Buat atau sesuaikan calon siswa berstatus MENUNGGU_WAWANCARA
        $this->calonSiswa = CalonSiswa::updateOrCreate(
            ['user_id' => $this->siswaUser->id],
            [
                'nisn' => '0081234567',
                'nama_lengkap' => 'Ahmad Santri',
                'asal_sekolah' => 'SMP IT Al-Falah',
                'penghasilan_ayah' => 2500000,
                'penghasilan_ibu' => 0,
                'jumlah_tanggungan' => 3,
                'rata_rata_raport' => 88.50,
                'status_pendaftaran' => StatusPendaftaran::MENUNGGU_WAWANCARA,
                'status_kelulusan' => StatusKelulusan::PENDING,
            ]
        );
    }

    public function test_wawancara_model_relationships_and_casts(): void
    {
        $wawancara = Wawancara::create([
            'pewawancara_id' => $this->pewawancara->id,
            'calon_siswa_id' => $this->calonSiswa->id,
            'jadwal' => '2026-10-01 09:00:00',
            'link_meet' => 'https://meet.google.com/test-123',
            'nilai_fisik_rambut' => '#1a1a1a',
            'nilai_fisik_seragam' => '#ffffff',
            'kemampuan_quran' => 'Tahsin',
            'jumlah_juz' => 3,
            'catatan_rahasia' => 'Siswa berakhlak baik dan motivasi tinggi.',
        ]);

        $this->assertNotNull($wawancara->id);
        $this->assertEquals($this->pewawancara->id, $wawancara->pewawancara->id);
        $this->assertEquals($this->calonSiswa->id, $wawancara->calonSiswa->id);
        $this->assertInstanceOf(\Carbon\Carbon::class, $wawancara->jadwal);
        $this->assertIsInt($wawancara->jumlah_juz);
        $this->assertEquals(3, $wawancara->jumlah_juz);

        // Uji relasi balik dari CalonSiswa dan User
        $this->assertNotNull($this->calonSiswa->wawancara);
        $this->assertEquals($wawancara->id, $this->calonSiswa->wawancara->id);
        $this->assertTrue($this->pewawancara->sesiWawancara->contains($wawancara));
    }

    public function test_pewawancara_can_access_penilaian_page(): void
    {
        $response = $this->actingAs($this->pewawancara)->get('/pewawancara/penilaian');
        $response->assertStatus(200);
        $response->assertSeeLivewire('pewawancara.form-wawancara');
        $response->assertSee('Form Penilaian Wawancara');
    }

    public function test_siswa_cannot_access_pewawancara_penilaian_page(): void
    {
        $response = $this->actingAs($this->siswaUser)->get('/pewawancara/penilaian');
        $response->assertStatus(403);
    }

    public function test_form_wawancara_livewire_component_validates_and_saves_evaluation(): void
    {
        $this->actingAs($this->pewawancara);

        $component = Livewire::test(FormWawancara::class, ['calonSiswaId' => $this->calonSiswa->id]);

        // Verifikasi inisialisasi state awal
        $component->assertSet('calon_siswa_id', $this->calonSiswa->id)
            ->assertSet('nilai_fisik_rambut', '#1a1a1a')
            ->assertSet('nilai_fisik_seragam', '#ffffff');

        $this->assertNotNull($component->get('skorBeasiswa'));

        // Uji validasi warna harus format hex valid
        $component->set('nilai_fisik_rambut', 'bukan-hex')
            ->call('submitWawancara')
            ->assertHasErrors(['nilai_fisik_rambut']);

        // Input data penilaian yang valid
        $component->set('nilai_fisik_rambut', '#1a1a1a')
            ->set('nilai_fisik_seragam', '#ffffff')
            ->set('kemampuan_quran', 'Tahfidz')
            ->set('jumlah_juz', 5)
            ->set('jadwal', '2026-10-05T10:30')
            ->set('link_meet', 'https://meet.google.com/spmb-wawancara')
            ->set('catatan_rahasia', 'Hafalan Al-Qur\'an sangat lancar (mutqin), rekomendasi beasiswa penuh.')
            ->call('submitWawancara')
            ->assertHasNoErrors()
            ->assertSet('isSaved', true);

        // Verifikasi penyimpanan di tabel wawancara
        $wawancara = Wawancara::where('calon_siswa_id', $this->calonSiswa->id)->first();
        $this->assertNotNull($wawancara);
        $this->assertEquals('#1a1a1a', $wawancara->nilai_fisik_rambut);
        $this->assertEquals('#ffffff', $wawancara->nilai_fisik_seragam);
        $this->assertEquals('Tahfidz', $wawancara->kemampuan_quran);
        $this->assertEquals(5, $wawancara->jumlah_juz);
        $this->assertEquals('https://meet.google.com/spmb-wawancara', $wawancara->link_meet);

        // Verifikasi transisi status pendaftaran siswa ke SELESAI_WAWANCARA
        $calonFresh = $this->calonSiswa->fresh();
        $this->assertEquals(StatusPendaftaran::SELESAI_WAWANCARA, $calonFresh->status_pendaftaran);
    }
}
