<?php

namespace Tests\Feature;

use App\Enums\StatusKelulusan;
use App\Enums\StatusPendaftaran;
use App\Models\CalonSiswa;
use App\Models\User;
use App\Services\BeasiswaScoringService;
use Database\Seeders\MasterDataSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BeasiswaScoringServiceTest extends TestCase
{
    use RefreshDatabase;

    protected BeasiswaScoringService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->seed(MasterDataSeeder::class);
        $this->service = app(BeasiswaScoringService::class);
    }

    public function test_penghasilan_rendah_mendapatkan_skor_lebih_tinggi_bobot_50(): void
    {
        // Siswa A: Ortu penghasilan rendah (1.2jt)
        $skorRendah = $this->service->calculatePenghasilanScore(1200000);
        // Siswa B: Ortu penghasilan menengah (5jt)
        $skorMenengah = $this->service->calculatePenghasilanScore(5000000);
        // Siswa C: Ortu penghasilan tinggi (15jt)
        $skorTinggi = $this->service->calculatePenghasilanScore(15000000);

        $this->assertEquals(100.0, $skorRendah);
        $this->assertEquals(60.0, $skorMenengah);
        $this->assertEquals(10.0, $skorTinggi);

        $this->assertGreaterThan($skorMenengah, $skorRendah);
        $this->assertGreaterThan($skorTinggi, $skorMenengah);
    }

    public function test_tanggungan_banyak_mendapatkan_skor_lebih_tinggi_bobot_25(): void
    {
        $skor5Anak = $this->service->calculateTanggunganScore(5);
        $skor3Anak = $this->service->calculateTanggunganScore(3);
        $skor1Anak = $this->service->calculateTanggunganScore(1);

        $this->assertEquals(100.0, $skor5Anak);
        $this->assertEquals(70.0, $skor3Anak);
        $this->assertEquals(30.0, $skor1Anak);

        $this->assertGreaterThan($skor3Anak, $skor5Anak);
        $this->assertGreaterThan($skor1Anak, $skor3Anak);
    }

    public function test_prestasi_internasional_memberikan_skor_akademik_maksimal_100(): void
    {
        // Rapor rendah (65), tapi punya prestasi internasional
        $prestasiInternasional = [
            [
                'kategori' => 'Robotik',
                'perolehan' => 'Gold Medal',
                'tingkat' => 'Internasional',
                'penyelenggara' => 'World Youth Robotics',
            ],
        ];

        $skorAkademik = $this->service->calculateAkademikDanPrestasiScore(65.0, $prestasiInternasional);
        $this->assertEquals(100.0, $skorAkademik);
    }

    public function test_prestasi_nasional_dan_provinsi_memberikan_poin_ekstra(): void
    {
        $prestasiNasional = [
            ['tingkat' => 'Nasional'],
        ];
        $prestasiProv = [
            ['tingkat' => 'Prov'],
        ];

        // Rapor 80 + bonus nasional 15 = 95
        $skorNasional = $this->service->calculateAkademikDanPrestasiScore(80.0, $prestasiNasional);
        $this->assertEquals(95.0, $skorNasional);

        // Rapor 80 + bonus provinsi 10 = 90
        $skorProv = $this->service->calculateAkademikDanPrestasiScore(80.0, $prestasiProv);
        $this->assertEquals(90.0, $skorProv);
    }

    public function test_calculate_score_computes_accurate_weighted_total(): void
    {
        $user = User::factory()->create(['role' => 'siswa']);

        // Siswa dhuafa berprestasi tinggi:
        // - Penghasilan total: 1.000.000 (Skor 100 * 50% = 50.0)
        // - Tanggungan: 5 anak (Skor 100 * 25% = 25.0)
        // - Akademik: Prestasi Internasional (Skor 100 * 25% = 25.0)
        // Total = 50.0 + 25.0 + 25.0 = 100.0
        $calonA = CalonSiswa::create([
            'user_id' => $user->id,
            'nama_lengkap' => 'Anak Dhuafa Hebat',
            'asal_sekolah' => 'SMPN 1',
            'penghasilan_ayah' => 1000000,
            'penghasilan_ibu' => 0,
            'jumlah_tanggungan' => 5,
            'rata_rata_raport' => 85.0,
            'prestasi' => [['tingkat' => 'Internasional']],
            'status_pendaftaran' => StatusPendaftaran::MENUNGGU_WAWANCARA,
            'status_kelulusan' => StatusKelulusan::PENDING,
        ]);

        $scoreA = $this->service->calculateScore($calonA->id);
        $this->assertEquals(100.0, $scoreA);

        $breakdown = $this->service->getScoreBreakdown($calonA);
        $this->assertArrayHasKey('total_score', $breakdown);
        $this->assertArrayHasKey('penghasilan', $breakdown);
        $this->assertArrayHasKey('tanggungan', $breakdown);
        $this->assertArrayHasKey('akademik', $breakdown);
        $this->assertEquals(100.0, $breakdown['total_score']);
        $this->assertStringContainsString('Sangat Direkomendasikan', $breakdown['kategori']);
    }
}
