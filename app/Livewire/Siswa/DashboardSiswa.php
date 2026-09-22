<?php

namespace App\Livewire\Siswa;

use App\Enums\StatusPendaftaran;
use App\Models\KomponenBiaya;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class DashboardSiswa extends Component
{
    use WithFileUploads;

    public $calonSiswa;
    public $tagihanSeleksi = 0;
    
    // Tab aktif
    public $activeTab = 'pembayaran';

    // Payment Fields
    public $bukti_transfer;
    public $tanggal_transfer;
    public $nama_rekening;
    public $nominal_transfer;

    public function mount()
    {
        $this->calonSiswa = Auth::user()->calonSiswa;
        
        $komponen = KomponenBiaya::where('nama_biaya', 'Seleksi')->first();
        if ($komponen) {
            $this->tagihanSeleksi = $komponen->nominal;
        }

        if ($this->calonSiswa) {
            $this->tanggal_transfer = $this->calonSiswa->tanggal_transfer_seleksi?->format('Y-m-d');
            $this->nama_rekening = $this->calonSiswa->nama_rekening_pengirim;
            $this->nominal_transfer = $this->calonSiswa->nominal_transfer_seleksi;
            
            // Set tab berdasarkan step
            $step = $this->calonSiswa->status_pendaftaran->stepNumber();
            if ($step >= 3 && $step <= 5) {
                $this->activeTab = 'biodata';
            } elseif ($step >= 6 && $step <= 8) {
                $this->activeTab = 'wawancara';
            } elseif ($step >= 9) {
                $this->activeTab = 'daftar_ulang';
            } else {
                $this->activeTab = 'pembayaran';
            }
        }
    }

    public function setTab($tab)
    {
        // Refresh data dari DB agar tidak stale
        $this->calonSiswa->refresh();
        
        $step = $this->calonSiswa->status_pendaftaran->stepNumber();
        $allowed = false;
        
        // Pembayaran bisa diakses sejak status Register (step 1)
        if ($tab === 'pembayaran' && $step >= 1) $allowed = true;
        if ($tab === 'biodata' && $step >= 3) $allowed = true;
        if ($tab === 'wawancara' && $step >= 6) $allowed = true;
        if ($tab === 'daftar_ulang' && $step >= 9) $allowed = true;
        
        if ($allowed) {
            $this->activeTab = $tab;
        } else {
            session()->flash('error_tab', 'Anda belum dapat mengakses tahapan ini. Selesaikan tahap sebelumnya terlebih dahulu.');
        }
    }

    public function simpanSementara()
    {
        // Menyimpan data tanpa validasi ketat, sehingga bisa dilanjutkan nanti
        $this->calonSiswa->update([
            'tanggal_transfer_seleksi' => $this->tanggal_transfer ?: null,
            'nama_rekening_pengirim' => $this->nama_rekening ?: null,
            'nominal_transfer_seleksi' => $this->nominal_transfer ?: null,
        ]);

        if ($this->bukti_transfer) {
            $path = $this->bukti_transfer->store('bukti_transfer', 'public');
            
            // Hapus yang lama jika ada (dan bukan sedang dikunci)
            if ($this->calonSiswa->bukti_bayar_seleksi) {
                Storage::disk('public')->delete($this->calonSiswa->bukti_bayar_seleksi);
            }
            
            $this->calonSiswa->update([
                'bukti_bayar_seleksi' => $path,
            ]);
        }

        session()->flash('message', 'Data pembayaran berhasil disimpan sementara.');
    }

    public function kirimVerifikasi()
    {
        $this->validate([
            'bukti_transfer' => $this->calonSiswa->bukti_bayar_seleksi 
                ? 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048' 
                : 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'tanggal_transfer' => 'required|date',
            'nama_rekening' => 'required|string|max:150',
            'nominal_transfer' => 'required|numeric|min:1',
        ], [
            'bukti_transfer.required' => 'Bukti transfer wajib diunggah.',
            'bukti_transfer.mimes' => 'Format berkas harus JPG, PNG, atau PDF.',
            'tanggal_transfer.required' => 'Tanggal transfer wajib diisi.',
            'nama_rekening.required' => 'Nama rekening pengirim wajib diisi.',
            'nominal_transfer.required' => 'Nominal transfer wajib diisi.',
        ]);

        $this->simpanSementara();

        // Ubah state pendaftaran ke BAYAR_SELEKSI agar masuk ke tabel Menunggu Bendahara
        $this->calonSiswa->update([
            'keterangan_tolak_bayar' => null,
            'status_pendaftaran' => \App\Enums\StatusPendaftaran::BAYAR_SELEKSI,
        ]);
        
        // Refresh model agar UI langsung menampilkan status terbaru
        $this->calonSiswa->refresh();

        session()->flash('message', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi Bendahara.');
    }

    public function render()
    {
        return view('livewire.siswa.dashboard-siswa')->layout('layouts.app');
    }
}
