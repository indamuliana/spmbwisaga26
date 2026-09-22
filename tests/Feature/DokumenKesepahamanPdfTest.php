<?php

namespace Tests\Feature;

use App\Models\CalonSiswa;
use App\Models\DokumenKesepahaman;
use App\Models\Program;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Database\Seeders\TagihanDinamisSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DokumenKesepahamanPdfTest extends TestCase
{
    use RefreshDatabase;

    protected User $siswaUser;
    protected CalonSiswa $calon;
    protected Program $unggulan;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->seed(MasterDataSeeder::class);
        $this->seed(TagihanDinamisSeeder::class);

        $this->siswaUser = User::where('email', 'siswa@ppdb.test')->first();
        $this->unggulan = Program::where('nama_program', 'Unggulan')->first();

        $this->calon = CalonSiswa::updateOrCreate(
            ['user_id' => $this->siswaUser->id],
            [
                'nisn' => '0088991122',
                'nama_lengkap' => 'Muhammad Fatih',
                'asal_sekolah' => 'SMP IT Robbani',
                'program_id' => $this->unggulan->id,
                'nama_ayah' => 'H. Abdullah',
            ]
        );
    }

    public function test_guest_cannot_access_cetak_pdf(): void
    {
        $response = $this->get('/dokumen-kesepahaman/cetak');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_siswa_can_generate_and_stream_pdf(): void
    {
        $response = $this->actingAs($this->siswaUser)->get('/dokumen-kesepahaman/cetak');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');

        // Verifikasi PDF dihasilkan dengan ukuran berkas valid
        $content = $response->getContent();
        $this->assertNotEmpty($content);
        $this->assertStringStartsWith('%PDF-', $content);
    }

    public function test_pdf_view_contains_program_statements_and_materai_box(): void
    {
        $butirKesepahaman = DokumenKesepahaman::forProgram($this->calon->program_id)
            ->active()
            ->get();

        $view = $this->view('pdf.dokumen-kesepahaman', [
            'calon' => $this->calon,
            'butirKesepahaman' => $butirKesepahaman,
        ]);

        $view->assertSee('Muhammad Fatih');
        $view->assertSee('0088991122');
        $view->assertSee('H. Abdullah');
        $view->assertSee('Unggulan');
        $view->assertSee('Materai 10000');

        // Pastikan butir pernyataan program unggulan ada
        foreach ($butirKesepahaman as $item) {
            $view->assertSee($item->butir_pernyataan);
        }
    }
}
