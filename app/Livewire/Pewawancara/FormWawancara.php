<?php

namespace App\Livewire\Pewawancara;

use App\Enums\StatusPendaftaran;
use App\Models\CalonSiswa;
use App\Models\Wawancara;
use App\Services\BeasiswaScoringService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormWawancara extends Component
{
    public ?int $calon_siswa_id = null;
    public ?CalonSiswa $calonSiswa = null;

    // Form fields
    public ?string $jadwal = null;
    public ?string $link_meet = null;
    public string $nilai_fisik_rambut = '#1a1a1a';
    public string $nilai_fisik_seragam = '#ffffff';
    public string $kemampuan_quran = 'Iqro';
    public int $jumlah_juz = 0;
    public ?string $catatan_rahasia = null;

    // Beasiswa Scoring preview
    public ?float $skorBeasiswa = null;
    public ?array $scoreBreakdown = null;

    public bool $isSaved = false;

    public function mount(?int $calonSiswaId = null): void
    {
        if ($calonSiswaId) {
            $this->selectCalonSiswa($calonSiswaId);
        } else {
            // Default pilih calon siswa pertama yang berstatus menunggu wawancara jika ada
            $firstCandidate = CalonSiswa::whereIn('status_pendaftaran', [
                StatusPendaftaran::MENUNGGU_WAWANCARA,
                StatusPendaftaran::SELESAI_WAWANCARA,
            ])->first();

            if ($firstCandidate) {
                $this->selectCalonSiswa($firstCandidate->id);
            }
        }
    }

    public function updatedCalonSiswaId(?int $id): void
    {
        if ($id) {
            $this->selectCalonSiswa($id);
        }
    }

    public function selectCalonSiswa(int $id): void
    {
        $this->calon_siswa_id = $id;
        $this->calonSiswa = CalonSiswa::with(['user', 'program', 'jurusan', 'wawancara'])->find($id);

        if (! $this->calonSiswa) {
            return;
        }

        // Kalkulasi skor beasiswa
        $service = app(BeasiswaScoringService::class);
        $this->skorBeasiswa = $service->calculateScore($this->calonSiswa);
        $this->scoreBreakdown = $service->getScoreBreakdown($this->calonSiswa);

        // Jika sudah ada wawancara tersimpan, muat datanya
        $existing = $this->calonSiswa->wawancara;
        if ($existing) {
            $this->jadwal = $existing->jadwal?->format('Y-m-d\TH:i');
            $this->link_meet = $existing->link_meet;
            $this->nilai_fisik_rambut = $existing->nilai_fisik_rambut ?: '#1a1a1a';
            $this->nilai_fisik_seragam = $existing->nilai_fisik_seragam ?: '#ffffff';
            $this->kemampuan_quran = $existing->kemampuan_quran;
            $this->jumlah_juz = (int) $existing->jumlah_juz;
            $this->catatan_rahasia = $existing->catatan_rahasia;
        } else {
            // Nilai bawaan form baru
            $this->jadwal = now()->addHour()->format('Y-m-d\TH:i');
            $this->link_meet = 'https://meet.google.com/spmb-test';
            $this->nilai_fisik_rambut = '#1a1a1a';
            $this->nilai_fisik_seragam = '#ffffff';
            $this->kemampuan_quran = 'Iqro';
            $this->jumlah_juz = 0;
            $this->catatan_rahasia = null;
        }

        $this->isSaved = false;
        $this->resetValidation();
    }

    public function submitWawancara(): void
    {
        $this->validate([
            'calon_siswa_id'      => ['required', 'exists:calon_siswa,id'],
            'jadwal'              => ['required', 'date'],
            'link_meet'           => ['nullable', 'string', 'max:255'],
            'nilai_fisik_rambut'  => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'nilai_fisik_seragam' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'kemampuan_quran'     => ['required', 'in:Iqro,Tahsin,Tahfidz'],
            'jumlah_juz'          => ['required', 'integer', 'min:0', 'max:30'],
            'catatan_rahasia'     => ['nullable', 'string'],
        ], [
            'calon_siswa_id.required'      => 'Pilih calon siswa yang akan dinilai.',
            'jadwal.required'              => 'Waktu sesi wawancara wajib diisi.',
            'nilai_fisik_rambut.required'  => 'Pilih warna indikator observasi fisik rambut.',
            'nilai_fisik_rambut.regex'     => 'Format warna rambut harus berupa kode HEX valid (misal: #000000).',
            'nilai_fisik_seragam.required' => 'Pilih warna indikator observasi seragam.',
            'nilai_fisik_seragam.regex'    => 'Format warna seragam harus berupa kode HEX valid (misal: #ffffff).',
            'kemampuan_quran.required'     => 'Tentukan tingkat kemampuan membaca Al-Qur\'an.',
            'jumlah_juz.min'               => 'Jumlah juz minimal 0.',
            'jumlah_juz.max'               => 'Jumlah juz maksimal 30.',
        ]);

        $pewawancaraId = Auth::id() ?: 1;

        Wawancara::updateOrCreate(
            ['calon_siswa_id' => $this->calon_siswa_id],
            [
                'pewawancara_id'      => $pewawancaraId,
                'jadwal'              => $this->jadwal,
                'link_meet'           => $this->link_meet,
                'nilai_fisik_rambut'  => $this->nilai_fisik_rambut,
                'nilai_fisik_seragam' => $this->nilai_fisik_seragam,
                'kemampuan_quran'     => $this->kemampuan_quran,
                'jumlah_juz'          => $this->jumlah_juz,
                'catatan_rahasia'     => $this->catatan_rahasia,
            ]
        );

        // Transisi status calon siswa ke SELESAI_WAWANCARA
        if ($this->calonSiswa) {
            $this->calonSiswa->update([
                'status_pendaftaran' => StatusPendaftaran::SELESAI_WAWANCARA,
            ]);
            $this->calonSiswa->refresh();
        }

        $this->isSaved = true;
        session()->flash('success', 'Hasil penilaian wawancara berhasil disimpan! Status calon siswa telah diperbarui menjadi Selesai Wawancara.');
    }

    public function render()
    {
        $candidates = CalonSiswa::with(['program', 'jurusan'])
            ->whereIn('status_pendaftaran', [
                StatusPendaftaran::MENUNGGU_WAWANCARA,
                StatusPendaftaran::SELESAI_WAWANCARA,
            ])
            ->latest()
            ->get();

        return view('livewire.pewawancara.form-wawancara', [
            'candidates' => $candidates,
        ]);
    }
}
