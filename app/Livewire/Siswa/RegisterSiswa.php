<?php

namespace App\Livewire\Siswa;

use App\Models\AsalSekolah;
use App\Models\CalonSiswa;
use App\Models\Program;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\StatusPendaftaran;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Str;

class RegisterSiswa extends Component
{
    // Form Inputs
    public $nisn;
    public $jenis_kelamin;
    public $nama_lengkap;
    public $pilihan_asal_sekolah;
    public $asal_sekolah_lainnya;
    public $email;
    public $hp_siswa;
    public $hp_ayah;
    public $hp_ibu;
    public $program_id;
    
    // Referensi
    public $kategori_referensi;
    public $detail_referensi_nama;
    public $detail_referensi_rayon;
    public $detail_referensi_nomor;

    // Master Data
    public $master_asal_sekolah = [];
    public $master_program = [];

    // State
    public $isSuccess = false;
    public $generatedAccount = null;

    public function mount()
    {
        $this->master_asal_sekolah = AsalSekolah::orderBy('nama_sekolah')->get();
        $this->master_program = Program::where('is_active', true)
            ->orderByRaw("CASE WHEN LOWER(nama_program) LIKE '%unggulan%' THEN 0 ELSE 1 END")
            ->orderBy('id')
            ->get();
    }

    public function submit()
    {
        $this->validate([
            'nisn' => 'required|numeric|digits_between:5,10|unique:calon_siswa,nisn',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_lengkap' => 'required|string|max:150',
            'pilihan_asal_sekolah' => 'required',
            'asal_sekolah_lainnya' => 'required_if:pilihan_asal_sekolah,Lainnya',
            'email' => 'required|email|unique:users,email',
            'hp_siswa' => 'required|string',
            'hp_ayah' => 'nullable|string',
            'hp_ibu' => 'nullable|string',
            'program_id' => 'required|exists:program,id',
            'kategori_referensi' => 'required',
            'detail_referensi_nama' => 'required|string|max:150',
            'detail_referensi_rayon' => 'required_if:kategori_referensi,Siswa SMK Wikrama Aktif',
            'detail_referensi_nomor' => 'required_if:kategori_referensi,Calon Siswa Wikrama',
        ]);

        // Tentukan Asal Sekolah Final
        $asalSekolahFinal = $this->pilihan_asal_sekolah;
        if ($this->pilihan_asal_sekolah === 'Lainnya') {
            $asalSekolahFinal = $this->asal_sekolah_lainnya;
            // Opsional: Simpan "Lainnya" ke master data untuk ke depannya
            AsalSekolah::firstOrCreate(['nama_sekolah' => $asalSekolahFinal]);
        }

        // Tentukan Detail Promotor
        $detailPromotor = $this->detail_referensi_nama;
        if ($this->kategori_referensi === 'Siswa SMK Wikrama Aktif') {
            $detailPromotor = $this->detail_referensi_nama . ' - Rayon: ' . $this->detail_referensi_rayon;
        } elseif ($this->kategori_referensi === 'Calon Siswa Wikrama') {
            $detailPromotor = 'No Seleksi: ' . $this->detail_referensi_nomor . ' - Nama: ' . $this->detail_referensi_nama;
        }

        // Generate Nomor Pendaftar
        $prefix = 'PPDB' . date('Y');
        $lastRecord = CalonSiswa::where('nomor_pendaftar', 'like', $prefix . '-%')->orderBy('id', 'desc')->first();
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->nomor_pendaftar, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        $nomorPendaftar = $prefix . '-' . $newNumber;

        // Buat Akun User
        $user = User::create([
            'name' => $this->nama_lengkap,
            'email' => $this->email,
            'password' => Hash::make($this->nisn),
            'role' => UserRole::SISWA,
        ]);

        // Buat Calon Siswa
        $calonSiswa = CalonSiswa::create([
            'user_id' => $user->id,
            'nomor_pendaftar' => $nomorPendaftar,
            'nisn' => $this->nisn,
            'nama_lengkap' => $this->nama_lengkap,
            'jenis_kelamin' => $this->jenis_kelamin,
            'asal_sekolah' => $asalSekolahFinal,
            'program_id' => $this->program_id,
            'hp_siswa' => $this->hp_siswa,
            'hp_ayah' => $this->hp_ayah,
            'hp_ibu' => $this->hp_ibu,
            'referensi_promotor' => $this->kategori_referensi,
            'detail_promotor' => $detailPromotor,
            'status_pendaftaran' => StatusPendaftaran::REGISTER,
        ]);

        $this->generatedAccount = [
            'id' => $calonSiswa->id,
            'nomor_pendaftar' => $nomorPendaftar,
            'username' => $this->email,
            'password' => $this->nisn,
            'nama' => $this->nama_lengkap,
        ];

        $this->isSuccess = true;
    }

    public function render()
    {
        return view('livewire.siswa.register-siswa')->layout('layouts.app');
    }
}
