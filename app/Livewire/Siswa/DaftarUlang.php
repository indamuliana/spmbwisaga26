<?php

namespace App\Livewire\Siswa;

use App\Enums\StatusPendaftaran;
use App\Models\CalonSiswa;
use App\Models\PesananSeragam;
use App\Models\Seragam;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class DaftarUlang extends Component
{
    use WithFileUploads;

    public ?CalonSiswa $calonSiswa = null;

    // 1. Kesanggupan Nominal Bayar Awal
    public ?float $nominal_kesanggupan_awal = null;

    // 2. Checkout Seragam: [seragam_id => bool] dan [seragam_id => ukuran]
    public array $selectedSeragam = [];
    public array $ukuranSeragam = [];

    // 3. Loker Berkas (Upload Berkas Susulan)
    public $upload_ijazah = null;
    public $upload_kk = null;
    public $upload_akta = null;
    public $upload_tambahan = null;
    public array $lokerBerkas = [];

    public bool $isSubmitted = false;

    public function mount(): void
    {
        $user = Auth::user();
        if ($user && $user->isSiswa()) {
            $this->calonSiswa = $user->calonSiswa;
        } else {
            $this->calonSiswa = CalonSiswa::with(['program', 'jurusan', 'pesananSeragam'])->first();
        }

        if (! $this->calonSiswa) {
            return;
        }

        // Muat nominal kesanggupan awal jika sudah tersimpan
        $this->nominal_kesanggupan_awal = $this->calonSiswa->nominal_kesanggupan_awal ?: 1500000;

        // Muat loker berkas yang sudah pernah diunggah
        $this->lokerBerkas = is_array($this->calonSiswa->berkas_susulan) ? $this->calonSiswa->berkas_susulan : [];

        // Muat item seragam sesuai gender siswa (L / P / unisex)
        $gender = $this->calonSiswa->jenis_kelamin ?: 'L';
        $seragams = Seragam::forGender($gender)->get();

        // Muat pesanan seragam yang tersimpan jika ada
        $existingPesanan = $this->calonSiswa->pesananSeragam->keyBy('seragam_id');

        foreach ($seragams as $item) {
            if ($existingPesanan->has($item->id)) {
                $this->selectedSeragam[$item->id] = true;
                $this->ukuranSeragam[$item->id] = $existingPesanan[$item->id]->ukuran;
            } else {
                // Item wajib sekolah tercentang otomatis secara default
                $this->selectedSeragam[$item->id] = (bool) $item->wajib_sekolah;
                $this->ukuranSeragam[$item->id] = 'L'; // Ukuran standar bawaan
            }
        }

        if ($this->calonSiswa->status_pendaftaran === StatusPendaftaran::DAFTAR_ULANG) {
            $this->isSubmitted = true;
        }
    }

    /**
     * Hitung total biaya seragam yang tercentang secara dinamis
     */
    public function getTotalBiayaSeragam(): float
    {
        if (! $this->calonSiswa) {
            return 0.0;
        }

        $gender = $this->calonSiswa->jenis_kelamin ?: 'L';
        $seragams = Seragam::forGender($gender)->get();
        $total = 0.0;

        foreach ($seragams as $item) {
            if (! empty($this->selectedSeragam[$item->id])) {
                $total += (float) $item->harga;
            }
        }

        return $total;
    }

    /**
     * Simpan proses checkout seragam, nominal kesanggupan, dan loker berkas
     */
    public function submitDaftarUlang(): void
    {
        $this->validate([
            'nominal_kesanggupan_awal' => ['required', 'numeric', 'min:0'],
            'ukuranSeragam.*'          => ['required', 'in:S,M,L,XL,XXL'],
            'upload_ijazah'            => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'upload_kk'                => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'upload_akta'              => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'upload_tambahan'          => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ], [
            'nominal_kesanggupan_awal.required' => 'Nominal kesanggupan bayar awal wajib diisi.',
            'nominal_kesanggupan_awal.numeric'  => 'Nominal kesanggupan harus berupa angka.',
            'nominal_kesanggupan_awal.min'      => 'Nominal kesanggupan tidak boleh bernilai negatif.',
            'upload_ijazah.mimes'               => 'Berkas ijazah harus berformat PDF, JPG, atau PNG.',
            'upload_kk.mimes'                   => 'Berkas Kartu Keluarga harus berformat PDF, JPG, atau PNG.',
            'upload_akta.mimes'                 => 'Berkas Akta Kelahiran harus berformat PDF, JPG, atau PNG.',
        ]);

        if (! $this->calonSiswa) {
            session()->flash('error', 'Data calon siswa tidak ditemukan.');
            return;
        }

        // 1. Simpan Berkas Susulan ke Loker Berkas Disk Publik
        $berkas = $this->lokerBerkas;
        if ($this->upload_ijazah) {
            $berkas['ijazah'] = $this->upload_ijazah->store('loker_berkas/ijazah', 'public');
        }
        if ($this->upload_kk) {
            $berkas['kk'] = $this->upload_kk->store('loker_berkas/kk', 'public');
        }
        if ($this->upload_akta) {
            $berkas['akta'] = $this->upload_akta->store('loker_berkas/akta', 'public');
        }
        if ($this->upload_tambahan) {
            $berkas['tambahan'] = $this->upload_tambahan->store('loker_berkas/tambahan', 'public');
        }
        $this->lokerBerkas = $berkas;

        // 2. Eksekusi Checkout Seragam (Tabel pesanan_seragam)
        PesananSeragam::where('calon_siswa_id', $this->calonSiswa->id)->delete();

        $gender = $this->calonSiswa->jenis_kelamin ?: 'L';
        $seragams = Seragam::forGender($gender)->get();

        foreach ($seragams as $item) {
            // Pastikan item wajib selalu tercentang
            if ($item->wajib_sekolah || ! empty($this->selectedSeragam[$item->id])) {
                $ukuran = $this->ukuranSeragam[$item->id] ?? 'L';
                PesananSeragam::create([
                    'calon_siswa_id'   => $this->calonSiswa->id,
                    'seragam_id'       => $item->id,
                    'ukuran'           => $ukuran,
                    'harga_saat_pesan' => $item->harga,
                ]);
            }
        }

        // 3. Simpan Nominal Kesanggupan & Transisi Status ke DAFTAR_ULANG
        $this->calonSiswa->update([
            'nominal_kesanggupan_awal' => $this->nominal_kesanggupan_awal,
            'berkas_susulan'           => $this->lokerBerkas,
            'status_pendaftaran'       => StatusPendaftaran::DAFTAR_ULANG,
        ]);

        $this->isSubmitted = true;
        session()->flash('success', 'Formulir Daftar Ulang, Pesanan Seragam, dan Dokumen Loker Berkas berhasil disimpan!');
    }

    public function render()
    {
        $gender = $this->calonSiswa?->jenis_kelamin ?: 'L';
        $seragams = Seragam::forGender($gender)->get();

        return view('livewire.siswa.daftar-ulang', [
            'seragams' => $seragams,
            'totalSeragam' => $this->getTotalBiayaSeragam(),
        ]);
    }
}
