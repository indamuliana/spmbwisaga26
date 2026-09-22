<?php

namespace App\Livewire\Bendahara;

use App\Enums\StatusPendaftaran;
use App\Models\CalonSiswa;
use App\Models\KomponenBiaya;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class VerifikasiPembayaran extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = 'all'; // 'all', 'menunggu', 'terverifikasi'

    public ?int $selectedCalonId = null;
    public ?CalonSiswa $previewCalon = null;
    public ?int $rejectingCalonId = null;
    public ?CalonSiswa $rejectingCalon = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => 'all'],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    /**
     * Setujui / ACC Pembayaran Seleksi
     * Mengubah state siswa ke tahap berikutnya: ISI_BIODATA_SISWA
     */
    public function accPembayaran(int $calonId): void
    {
        $calon = CalonSiswa::findOrFail($calonId);

        if ($calon->status_pendaftaran === StatusPendaftaran::BAYAR_SELEKSI) {
            $calon->update([
                'status_pendaftaran' => StatusPendaftaran::ISI_BIODATA_SISWA,
            ]);

            session()->flash('success', "Pembayaran seleksi calon siswa {$calon->nama_lengkap} (NISN: {$calon->nisn}) berhasil di-ACC! Status pendaftaran telah beralih ke Pengisian Biodata Siswa.");
        } else {
            session()->flash('info', "Calon siswa {$calon->nama_lengkap} telah berada pada tahap {$calon->status_pendaftaran->label()}.");
        }

        if ($this->selectedCalonId === $calonId) {
            $this->closePreview();
        }
    }

    public string $alasanTolak = '';

    public function openRejectModal(int $calonId): void
    {
        $this->rejectingCalonId = $calonId;
        $this->rejectingCalon = CalonSiswa::find($calonId);
        $this->alasanTolak = '';
    }

    public function closeRejectModal(): void
    {
        $this->rejectingCalonId = null;
        $this->rejectingCalon = null;
        $this->alasanTolak = '';
    }

    /**
     * Tolak Bukti Pembayaran (Minta Upload Ulang)
     */
    public function confirmTolak(): void
    {
        $this->validate(['alasanTolak' => 'required|string|max:255'], [
            'alasanTolak.required' => 'Alasan penolakan wajib diisi agar siswa mengetahuinya.',
        ]);

        $calon = CalonSiswa::findOrFail($this->rejectingCalonId);

        // Hapus berkas lama jika ada
        if ($calon->bukti_bayar_seleksi && Storage::disk('public')->exists($calon->bukti_bayar_seleksi)) {
            Storage::disk('public')->delete($calon->bukti_bayar_seleksi);
        }

        $calon->update([
            'bukti_bayar_seleksi' => null,
            'keterangan_tolak_bayar' => $this->alasanTolak,
            'status_pendaftaran' => StatusPendaftaran::BAYAR_SELEKSI,
        ]);

        session()->flash('error', "Bukti transfer calon siswa {$calon->nama_lengkap} telah ditolak.");
        
        $this->alasanTolak = '';
        $this->closeRejectModal();
        $this->closePreview();
    }

    public function showPreview(int $calonId): void
    {
        $this->selectedCalonId = $calonId;
        $this->previewCalon = CalonSiswa::with(['program', 'user'])->find($calonId);
    }

    public function closePreview(): void
    {
        $this->selectedCalonId = null;
        $this->previewCalon = null;
    }

    public function render()
    {
        // Tampilkan siswa yang punya bukti bayar ATAU berstatus BAYAR_SELEKSI (termasuk yang ditolak)
        $query = CalonSiswa::with(['program', 'user'])
            ->where(function ($q) {
                $q->whereNotNull('bukti_bayar_seleksi')
                  ->orWhere('status_pendaftaran', StatusPendaftaran::BAYAR_SELEKSI);
            });

        if (! empty($this->search)) {
            $query->where(function ($q) {
                $q->where('nama_lengkap', 'like', '%' . $this->search . '%')
                  ->orWhere('nisn', 'like', '%' . $this->search . '%')
                  ->orWhere('asal_sekolah', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus === 'menunggu') {
            $query->where('status_pendaftaran', StatusPendaftaran::BAYAR_SELEKSI);
        } elseif ($this->filterStatus === 'terverifikasi') {
            $query->where('status_pendaftaran', '!=', StatusPendaftaran::BAYAR_SELEKSI);
        }

        $calonList = $query->latest('updated_at')->paginate(10);

        // Ambil komponen biaya seleksi universal
        $biayaSeleksi = KomponenBiaya::where('nama_biaya', 'like', '%Seleksi%')->first();
        $nominalSeleksi = $biayaSeleksi ? $biayaSeleksi->nominal : 250000;

        // Hitung statistik ringkas
        $totalMenunggu = CalonSiswa::where('status_pendaftaran', StatusPendaftaran::BAYAR_SELEKSI)
            ->count();
        $totalDiverifikasi = CalonSiswa::whereNotNull('bukti_bayar_seleksi')
            ->where('status_pendaftaran', '!=', StatusPendaftaran::BAYAR_SELEKSI)
            ->where('status_pendaftaran', '!=', StatusPendaftaran::REGISTER)
            ->count();

        return view('livewire.bendahara.verifikasi-pembayaran', [
            'calonList' => $calonList,
            'nominalSeleksi' => $nominalSeleksi,
            'totalMenunggu' => $totalMenunggu,
            'totalDiverifikasi' => $totalDiverifikasi,
        ]);
    }
}
