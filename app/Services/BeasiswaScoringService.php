<?php

namespace App\Services;

use App\Models\CalonSiswa;

class BeasiswaScoringService
{
    /**
     * Hitung total skor kelayakan beasiswa calon siswa (skala 0 - 100).
     *
     * Bobot:
     * - 50%: Penghasilan Orang Tua (Makin kecil angka = makin besar poin)
     * - 25%: Tanggungan Anak (Makin banyak = makin besar poin)
     * - 25%: Rata-rata Raport + Poin Ekstra Prestasi (Internasional = poin maksimal)
     */
    public function calculateScore(int|CalonSiswa $calonSiswaId): float
    {
        $calon = $calonSiswaId instanceof CalonSiswa
            ? $calonSiswaId
            : CalonSiswa::findOrFail($calonSiswaId);

        // 1. Bobot 50%: Penghasilan Orang Tua
        $totalPenghasilan = (float) (($calon->penghasilan_ayah ?? 0) + ($calon->penghasilan_ibu ?? 0));
        $skorPenghasilan = $this->calculatePenghasilanScore($totalPenghasilan);

        // 2. Bobot 25%: Tanggungan Anak
        $tanggungan = (int) ($calon->jumlah_tanggungan ?? 1);
        $skorTanggungan = $this->calculateTanggunganScore($tanggungan);

        // 3. Bobot 25%: Rata-rata Raport + Poin Ekstra Prestasi
        $rataRataRaport = (float) ($calon->rata_rata_raport ?? 0);
        $prestasi = is_array($calon->prestasi) ? $calon->prestasi : [];
        $skorAkademik = $this->calculateAkademikDanPrestasiScore($rataRataRaport, $prestasi);

        // Total Terbobot
        $totalScore = ($skorPenghasilan * 0.50) + ($skorTanggungan * 0.25) + ($skorAkademik * 0.25);

        return round(min(100.0, max(0.0, $totalScore)), 2);
    }

    /**
     * Dapatkan rincian lengkap skor per kriteria beserta kategori kelayakan.
     */
    public function getScoreBreakdown(int|CalonSiswa $calonSiswaId): array
    {
        $calon = $calonSiswaId instanceof CalonSiswa
            ? $calonSiswaId
            : CalonSiswa::findOrFail($calonSiswaId);

        $totalPenghasilan = (float) (($calon->penghasilan_ayah ?? 0) + ($calon->penghasilan_ibu ?? 0));
        $skorPenghasilan = $this->calculatePenghasilanScore($totalPenghasilan);

        $tanggungan = (int) ($calon->jumlah_tanggungan ?? 1);
        $skorTanggungan = $this->calculateTanggunganScore($tanggungan);

        $rataRataRaport = (float) ($calon->rata_rata_raport ?? 0);
        $prestasi = is_array($calon->prestasi) ? $calon->prestasi : [];
        $skorAkademik = $this->calculateAkademikDanPrestasiScore($rataRataRaport, $prestasi);

        $weightedPenghasilan = round($skorPenghasilan * 0.50, 2);
        $weightedTanggungan = round($skorTanggungan * 0.25, 2);
        $weightedAkademik = round($skorAkademik * 0.25, 2);
        $total = round(min(100.0, max(0.0, $weightedPenghasilan + $weightedTanggungan + $weightedAkademik)), 2);

        $highestPrestasi = $this->getHighestPrestasiTier($prestasi);

        return [
            'total_score' => $total,
            'kategori' => $this->getKategoriKelayakan($total),
            'penghasilan' => [
                'total_nominal' => $totalPenghasilan,
                'raw_score' => $skorPenghasilan,
                'weight' => '50%',
                'weighted_score' => $weightedPenghasilan,
            ],
            'tanggungan' => [
                'jumlah_anak' => $tanggungan,
                'raw_score' => $skorTanggungan,
                'weight' => '25%',
                'weighted_score' => $weightedTanggungan,
            ],
            'akademik' => [
                'rata_rata_raport' => $rataRataRaport,
                'highest_prestasi' => $highestPrestasi,
                'raw_score' => $skorAkademik,
                'weight' => '25%',
                'weighted_score' => $weightedAkademik,
            ],
        ];
    }

    /**
     * Hitung skor penghasilan orang tua (0 - 100).
     * Makin kecil nominal penghasilan, makin besar poin bantuan.
     */
    public function calculatePenghasilanScore(float $totalPenghasilan): float
    {
        return match (true) {
            $totalPenghasilan <= 1500000 => 100.0,
            $totalPenghasilan <= 2500000 => 90.0,
            $totalPenghasilan <= 4000000 => 75.0,
            $totalPenghasilan <= 6000000 => 60.0,
            $totalPenghasilan <= 8000000 => 45.0,
            $totalPenghasilan <= 12000000 => 25.0,
            default => 10.0,
        };
    }

    /**
     * Hitung skor tanggungan anak (0 - 100).
     * Makin banyak tanggungan, makin besar poin.
     */
    public function calculateTanggunganScore(int $tanggungan): float
    {
        return match (true) {
            $tanggungan >= 5 => 100.0,
            $tanggungan === 4 => 85.0,
            $tanggungan === 3 => 70.0,
            $tanggungan === 2 => 50.0,
            $tanggungan === 1 => 30.0,
            default => 20.0,
        };
    }

    /**
     * Hitung skor akademik & prestasi (0 - 100).
     * Jika memiliki prestasi internasional, langsung mendapat poin maksimal (100).
     */
    public function calculateAkademikDanPrestasiScore(float $rataRataRaport, array $prestasi): float
    {
        $hasInternasional = false;
        $bonus = 0.0;

        foreach ($prestasi as $item) {
            $tingkat = $item['tingkat'] ?? '';
            if (strcasecmp($tingkat, 'Internasional') === 0) {
                $hasInternasional = true;
                break;
            }

            $currentBonus = match (strtolower($tingkat)) {
                'nasional' => 15.0,
                'prov', 'provinsi' => 10.0,
                'kab', 'kabupaten' => 6.0,
                'kec', 'kecamatan' => 3.0,
                'desa' => 1.0,
                default => 0.0,
            };

            if ($currentBonus > $bonus) {
                $bonus = $currentBonus;
            }
        }

        if ($hasInternasional) {
            return 100.0;
        }

        return round(min(100.0, max(0.0, $rataRataRaport + $bonus)), 2);
    }

    /**
     * Dapatkan tingkat kejuaraan tertinggi.
     */
    protected function getHighestPrestasiTier(array $prestasi): ?string
    {
        $hierarchy = ['internasional', 'nasional', 'prov', 'provinsi', 'kab', 'kabupaten', 'kec', 'kecamatan', 'desa'];
        $highest = null;
        $highestIndex = 999;

        foreach ($prestasi as $item) {
            $tingkat = strtolower($item['tingkat'] ?? '');
            $idx = array_search($tingkat, $hierarchy, true);
            if ($idx !== false && $idx < $highestIndex) {
                $highestIndex = $idx;
                $highest = $item['tingkat'];
            }
        }

        return $highest;
    }

    /**
     * Label kategori rekomendasi penerima beasiswa berdasarkan total skor.
     */
    public function getKategoriKelayakan(float $score): string
    {
        return match (true) {
            $score >= 85.0 => 'Sangat Direkomendasikan (Prioritas Utama)',
            $score >= 70.0 => 'Direkomendasikan (Prioritas Reguler)',
            $score >= 50.0 => 'Dipertimbangkan (Cadangan)',
            default => 'Kurang Memenuhi Kriteria Prioritas',
        };
    }
}
