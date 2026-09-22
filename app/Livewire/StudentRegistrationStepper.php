<?php

namespace App\Livewire;

use App\Enums\StatusPendaftaran;
use App\Enums\UserRole;
use App\Models\CalonSiswa;
use App\Models\KomponenBiaya;
use App\Models\Program;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class StudentRegistrationStepper extends Component
{
    use WithFileUploads;

    public int $currentStep = 1;

    // --- STEP 1: Akun & Pendaftaran Awal ---
    public string $nisn = '';
    public string $nama_lengkap = '';
    public string $email = '';
    public ?int $program_id = null;
    public string $referensi_promotor = '';
    public string $detail_promotor = '';
    public string $hp_siswa = '';

    // --- STEP 2: Pembayaran Seleksi ---
    public $bukti_transfer = null;
    public string $catatan_bayar = '';
    public float $nominal_seleksi = 0;

    // --- STEP 3: Biodata Siswa & Wilayah ---
    public string $nik_siswa = '';
    public string $no_kk = '';
    public string $tempat_lahir = '';
    public string $tanggal_lahir = '';
    public string $jenis_kelamin = 'L';
    public string $kewarganegaraan = 'WNI';
    public string $agama = 'Islam';
    
    public string $asal_sekolah = '';
    
    public string $alamat_detail = '';
    public ?int $provinsi_id = null;
    public ?int $kota_kab_id = null;
    public ?int $kecamatan_id = null;
    public ?int $desa_id = null;
    public string $kode_pos = '';
    
    public string $status_tempat_tinggal = '';
    public string $transportasi = '';
    public string $jarak_ke_sekolah = '';
    public ?int $waktu_tempuh = null;
    
    public ?int $tinggi_badan = null;
    public ?int $berat_badan = null;
    public string $golongan_darah = 'Belum Tahu';
    
    public string $hobi = '';
    public string $hobi_lainnya = '';
    public string $cita_cita = '';
    public string $cita_cita_lainnya = '';

    // --- STEP 4: Biodata Orang Tua ---
    public string $nama_ayah = '';
    public string $pekerjaan_ayah = '';
    public $penghasilan_ayah = 0;
    public string $hp_ayah = '';
    public string $nama_ibu = '';
    public string $pekerjaan_ibu = '';
    public $penghasilan_ibu = 0;
    public string $hp_ibu = '';

    // --- STEP 5: Akademik & Prestasi ---
    public array $subjects = [
        'matematika' => 'Matematika',
        'b_indo'     => 'Bahasa Indonesia',
        'b_inggris'  => 'Bahasa Inggris',
        'pai'        => 'Pendidikan Agama Islam (PAI)',
        'ipa'        => 'Ilmu Pengetahuan Alam (IPA)',
    ];

    public array $semesters = [1, 2, 3, 4, 5];

    public array $nilai_raport = [
        'matematika' => [1 => null, 2 => null, 3 => null, 4 => null, 5 => null],
        'b_indo'     => [1 => null, 2 => null, 3 => null, 4 => null, 5 => null],
        'b_inggris'  => [1 => null, 2 => null, 3 => null, 4 => null, 5 => null],
        'pai'        => [1 => null, 2 => null, 3 => null, 4 => null, 5 => null],
        'ipa'        => [1 => null, 2 => null, 3 => null, 4 => null, 5 => null],
    ];

    public array $prestasi = [];

    public bool $isComplete = false;

    public function mount(): void
    {
        // Ambil nominal biaya seleksi dari master data
        $biayaSeleksi = KomponenBiaya::where('nama_biaya', 'like', '%Seleksi%')->first();
        $this->nominal_seleksi = $biayaSeleksi ? $biayaSeleksi->nominal : 250000;

        // Jika user sudah login sebagai siswa, muat datanya
        if (Auth::check() && Auth::user()->isSiswa()) {
            $calon = Auth::user()->calonSiswa;
            if ($calon) {
                $this->loadCalonSiswaData($calon);
            }
        }
    }

    protected function loadCalonSiswaData(CalonSiswa $calon): void
    {
        $this->nisn = (string) $calon->nisn;
        $this->nama_lengkap = (string) $calon->nama_lengkap;
        $this->email = (string) $calon->user->email;
        $this->program_id = $calon->program_id;
        $this->referensi_promotor = (string) $calon->referensi_promotor;
        $this->detail_promotor = (string) $calon->detail_promotor;
        $this->hp_siswa = (string) $calon->hp_siswa;

        $this->nik_siswa = (string) $calon->nik_siswa;
        $this->no_kk = (string) $calon->no_kk;
        $this->tempat_lahir = (string) $calon->tempat_lahir;
        $this->tanggal_lahir = $calon->tanggal_lahir ? $calon->tanggal_lahir->format('Y-m-d') : '';
        $this->jenis_kelamin = $calon->jenis_kelamin ?? 'L';
        $this->kewarganegaraan = $calon->kewarganegaraan ?? 'WNI';
        $this->agama = $calon->agama ?? 'Islam';
        $this->asal_sekolah = (string) $calon->asal_sekolah;
        
        $this->alamat_detail = (string) $calon->alamat_detail;
        $this->provinsi_id = $calon->provinsi_id;
        $this->kota_kab_id = $calon->kota_kab_id;
        $this->kecamatan_id = $calon->kecamatan_id;
        $this->desa_id = $calon->desa_id;
        $this->kode_pos = (string) $calon->kode_pos;
        
        $this->status_tempat_tinggal = (string) $calon->status_tempat_tinggal;
        $this->transportasi = (string) $calon->transportasi;
        $this->jarak_ke_sekolah = (string) $calon->jarak_ke_sekolah;
        $this->waktu_tempuh = $calon->waktu_tempuh;
        
        $this->tinggi_badan = $calon->tinggi_badan;
        $this->berat_badan = $calon->berat_badan;
        $this->golongan_darah = $calon->golongan_darah ?? 'Belum Tahu';
        
        $this->hobi = (string) $calon->hobi;
        $this->cita_cita = (string) $calon->cita_cita;

        $this->nama_ayah = (string) $calon->nama_ayah;
        $this->pekerjaan_ayah = (string) $calon->pekerjaan_ayah;
        $this->penghasilan_ayah = $calon->penghasilan_ayah ?? 0;
        $this->hp_ayah = (string) $calon->hp_ayah;
        $this->nama_ibu = (string) $calon->nama_ibu;
        $this->pekerjaan_ibu = (string) $calon->pekerjaan_ibu;
        $this->penghasilan_ibu = $calon->penghasilan_ibu ?? 0;
        $this->hp_ibu = (string) $calon->hp_ibu;

        if (! empty($calon->nilai_raport) && is_array($calon->nilai_raport)) {
            $this->nilai_raport = array_replace_recursive($this->nilai_raport, $calon->nilai_raport);
        }

        if (! empty($calon->prestasi) && is_array($calon->prestasi)) {
            $this->prestasi = $calon->prestasi;
        }

        // Tentukan step berdasarkan status pendaftaran
        $this->currentStep = match ($calon->status_pendaftaran) {
            StatusPendaftaran::REGISTER => 1,
            StatusPendaftaran::BAYAR_SELEKSI => 2,
            StatusPendaftaran::ISI_BIODATA_SISWA => 3,
            StatusPendaftaran::ISI_BIODATA_ORTU => 4,
            StatusPendaftaran::ISI_RAPORT => 5,
            default => 5,
        };

        if ($calon->status_pendaftaran->stepNumber() >= 6) {
            $this->isComplete = true;
        }
    }

    // --- STEP 1: Submit Registrasi Akun & Calon Siswa ---
    public function submitStep1(): void
    {
        $userId = Auth::id();

        $this->validate([
            'nisn' => ['required', 'numeric', 'digits:10'],
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email,' . $userId],
            'program_id' => ['required', 'exists:program,id'],
            'referensi_promotor' => ['required', 'string'],
            'detail_promotor' => ['nullable', 'string', 'max:150'],
            'hp_siswa' => ['required', 'string', 'min:9', 'max:20'],
        ], [
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.digits' => 'NISN harus berjumlah tepat 10 digit.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Alamat email ini telah terdaftar, silakan gunakan email lain atau login.',
            'program_id.required' => 'Pilihlah salah satu program pendidikan.',
            'referensi_promotor.required' => 'Pilih dari mana Anda mengetahui info sekolah ini.',
            'hp_siswa.required' => 'Nomor WhatsApp/HP siswa wajib diisi.',
        ]);

        if (Auth::check() && Auth::user()->isSiswa()) {
            $user = Auth::user();
            $user->update([
                'name' => $this->nama_lengkap,
                'email' => $this->email,
                'phone' => $this->hp_siswa,
            ]);

            $user->calonSiswa()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nisn' => $this->nisn,
                    'nama_lengkap' => $this->nama_lengkap,
                    'program_id' => $this->program_id,
                    'referensi_promotor' => $this->referensi_promotor,
                    'detail_promotor' => $this->detail_promotor,
                    'hp_siswa' => $this->hp_siswa,
                    'status_pendaftaran' => StatusPendaftaran::BAYAR_SELEKSI,
                ]
            );
        } else {
            // Buat akun baru: password = NISN
            $user = User::create([
                'name' => $this->nama_lengkap,
                'email' => $this->email,
                'password' => Hash::make($this->nisn),
                'role' => UserRole::SISWA,
                'phone' => $this->hp_siswa,
                'email_verified_at' => now(),
            ]);

            CalonSiswa::create([
                'user_id' => $user->id,
                'nisn' => $this->nisn,
                'nama_lengkap' => $this->nama_lengkap,
                'asal_sekolah' => '-',
                'program_id' => $this->program_id,
                'referensi_promotor' => $this->referensi_promotor,
                'detail_promotor' => $this->detail_promotor,
                'hp_siswa' => $this->hp_siswa,
                'status_pendaftaran' => StatusPendaftaran::BAYAR_SELEKSI,
            ]);

            Auth::login($user);
        }

        session()->flash('success', 'Akun pendaftaran berhasil dibuat! Silakan lanjutkan ke pembayaran biaya seleksi.');
        $this->currentStep = 2;
    }

    // --- STEP 2: Submit Bukti Pembayaran Seleksi ---
    public function submitStep2(): void
    {
        $this->validate([
            'bukti_transfer' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'catatan_bayar' => ['nullable', 'string', 'max:255'],
        ], [
            'bukti_transfer.required' => 'Unggah foto struk / resi bukti transfer bank.',
            'bukti_transfer.mimes' => 'Format berkas harus berupa JPG, PNG, atau PDF.',
            'bukti_transfer.max' => 'Ukuran berkas maksimal 2 MB.',
        ]);

        $user = Auth::user();
        $calon = $user->calonSiswa;

        if ($this->bukti_transfer) {
            $path = $this->bukti_transfer->store('bukti_transfer', 'public');

            $calon->update([
                'bukti_bayar_seleksi' => $path,
                'catatan_bayar' => $this->catatan_bayar,
                // BUG FIX: Tetap di BAYAR_SELEKSI, menunggu ACC Bendahara
                // Sebelumnya: langsung ke ISI_BIODATA_SISWA (salah!)
                'status_pendaftaran' => StatusPendaftaran::BAYAR_SELEKSI,
            ]);
        }

        session()->flash('success', 'Bukti pembayaran seleksi berhasil diunggah! Menunggu verifikasi Bendahara sebelum bisa melanjutkan.');
        // Jangan pindah step — UI Dashboard akan menampilkan "Menunggu Validasi"
    }

    public function simpanSementaraStep3(): void
    {
        $calon = Auth::user()->calonSiswa;
        
        $hobiFinal = $this->hobi === 'Lainnya' ? $this->hobi_lainnya : $this->hobi;
        $citaCitaFinal = $this->cita_cita === 'Lainnya' ? $this->cita_cita_lainnya : $this->cita_cita;

        $calon->update([
            'nik_siswa' => $this->nik_siswa,
            'no_kk' => $this->no_kk,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir ?: null,
            'jenis_kelamin' => $this->jenis_kelamin,
            'kewarganegaraan' => $this->kewarganegaraan,
            'agama' => $this->agama,
            'asal_sekolah' => $this->asal_sekolah,
            'alamat_detail' => $this->alamat_detail,
            'provinsi_id' => $this->provinsi_id,
            'kota_kab_id' => $this->kota_kab_id,
            'kecamatan_id' => $this->kecamatan_id,
            'desa_id' => $this->desa_id,
            'kode_pos' => $this->kode_pos,
            'status_tempat_tinggal' => $this->status_tempat_tinggal,
            'transportasi' => $this->transportasi,
            'jarak_ke_sekolah' => $this->jarak_ke_sekolah,
            'waktu_tempuh' => $this->waktu_tempuh,
            'tinggi_badan' => $this->tinggi_badan,
            'berat_badan' => $this->berat_badan,
            'golongan_darah' => $this->golongan_darah,
            'hobi' => $hobiFinal,
            'cita_cita' => $citaCitaFinal,
        ]);

        session()->flash('success_sementara', 'Data biodata berhasil disimpan sementara.');
    }

    // --- STEP 3: Submit Biodata Diri Siswa & Wilayah ---
    public function submitStep3(): void
    {
        $calon = Auth::user()->calonSiswa;

        $this->validate([
            'nik_siswa' => ['required', 'numeric', 'digits:16', 'unique:calon_siswa,nik_siswa,' . $calon?->id],
            'no_kk' => ['required', 'numeric', 'digits:16'],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'kewarganegaraan' => ['required', 'in:WNI,WNA'],
            'agama' => ['required', 'in:Islam'],
            'asal_sekolah' => ['required', 'string', 'max:150'],
            'alamat_detail' => ['required', 'string', 'max:255'],
            'provinsi_id' => ['nullable', 'exists:wilayah,id'],
            'kota_kab_id' => ['nullable', 'exists:wilayah,id'],
            'kecamatan_id' => ['nullable', 'exists:wilayah,id'],
            'desa_id' => ['nullable', 'exists:wilayah,id'],
            'kode_pos' => ['required', 'numeric', 'digits:5'],
            'status_tempat_tinggal' => ['required', 'string'],
            'transportasi' => ['required', 'string'],
            'jarak_ke_sekolah' => ['required', 'string'],
            'waktu_tempuh' => ['required', 'numeric', 'min:1'],
            'tinggi_badan' => ['required', 'numeric', 'min:50', 'max:250'],
            'berat_badan' => ['required', 'numeric', 'min:20', 'max:200'],
            'golongan_darah' => ['required', 'string'],
            'hobi' => ['required', 'string'],
            'cita_cita' => ['required', 'string'],
        ], [
            'nik_siswa.required' => 'NIK Siswa sesuai Kartu Keluarga (KK) wajib diisi.',
            'nik_siswa.digits' => 'NIK harus berjumlah tepat 16 digit.',
            'no_kk.required' => 'Nomor Kartu Keluarga (KK) wajib diisi.',
            'no_kk.digits' => 'Nomor KK harus berjumlah tepat 16 digit.',
            'tempat_lahir.required' => 'Kota/tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'asal_sekolah.required' => 'Nama sekolah asal (SMP/MTs) wajib diisi.',
            'alamat_detail.required' => 'Alamat lengkap jalan/RT/RW wajib diisi.',
            'kode_pos.required' => 'Kode pos wajib diisi.',
            'kode_pos.digits' => 'Kode pos harus berupa 5 digit angka.',
            'status_tempat_tinggal.required' => 'Status tempat tinggal wajib diisi.',
            'transportasi.required' => 'Transportasi ke sekolah wajib diisi.',
            'jarak_ke_sekolah.required' => 'Jarak ke sekolah wajib diisi.',
            'waktu_tempuh.required' => 'Waktu tempuh wajib diisi.',
            'tinggi_badan.required' => 'Tinggi badan wajib diisi.',
            'berat_badan.required' => 'Berat badan wajib diisi.',
        ]);

        $hobiFinal = $this->hobi === 'Lainnya' ? $this->hobi_lainnya : $this->hobi;
        $citaCitaFinal = $this->cita_cita === 'Lainnya' ? $this->cita_cita_lainnya : $this->cita_cita;

        $calon->update([
            'nik_siswa' => $this->nik_siswa,
            'no_kk' => $this->no_kk,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'kewarganegaraan' => $this->kewarganegaraan,
            'agama' => $this->agama,
            'asal_sekolah' => $this->asal_sekolah,
            'alamat_detail' => $this->alamat_detail,
            'provinsi_id' => $this->provinsi_id,
            'kota_kab_id' => $this->kota_kab_id,
            'kecamatan_id' => $this->kecamatan_id,
            'desa_id' => $this->desa_id,
            'kode_pos' => $this->kode_pos,
            'status_tempat_tinggal' => $this->status_tempat_tinggal,
            'transportasi' => $this->transportasi,
            'jarak_ke_sekolah' => $this->jarak_ke_sekolah,
            'waktu_tempuh' => $this->waktu_tempuh,
            'tinggi_badan' => $this->tinggi_badan,
            'berat_badan' => $this->berat_badan,
            'golongan_darah' => $this->golongan_darah,
            'hobi' => $hobiFinal,
            'cita_cita' => $citaCitaFinal,
            'status_pendaftaran' => StatusPendaftaran::ISI_BIODATA_ORTU,
        ]);

        session()->flash('success', 'Biodata diri tersimpan! Sekarang lengkapi data orang tua.');
        $this->currentStep = 4;
    }

    // --- STEP 4: Submit Biodata Orang Tua ---
    public function submitStep4(): void
    {
        $this->validate([
            'nama_ayah' => ['required', 'string', 'max:150'],
            'pekerjaan_ayah' => ['required', 'string', 'max:100'],
            'penghasilan_ayah' => ['required', 'numeric', 'min:0'],
            'hp_ayah' => ['nullable', 'string', 'max:20'],
            'nama_ibu' => ['required', 'string', 'max:150'],
            'pekerjaan_ibu' => ['required', 'string', 'max:100'],
            'penghasilan_ibu' => ['required', 'numeric', 'min:0'],
            'hp_ibu' => ['nullable', 'string', 'max:20'],
        ], [
            'nama_ayah.required' => 'Nama lengkap ayah kandung/wali wajib diisi.',
            'pekerjaan_ayah.required' => 'Pekerjaan ayah wajib dipilih/diisi.',
            'nama_ibu.required' => 'Nama lengkap ibu kandung wajib diisi.',
            'pekerjaan_ibu.required' => 'Pekerjaan ibu wajib dipilih/diisi.',
        ]);

        $calon = Auth::user()->calonSiswa;

        $calon->update([
            'nama_ayah' => $this->nama_ayah,
            'pekerjaan_ayah' => $this->pekerjaan_ayah,
            'penghasilan_ayah' => $this->penghasilan_ayah,
            'hp_ayah' => $this->hp_ayah,
            'nama_ibu' => $this->nama_ibu,
            'pekerjaan_ibu' => $this->pekerjaan_ibu,
            'penghasilan_ibu' => $this->penghasilan_ibu,
            'hp_ibu' => $this->hp_ibu,
            'status_pendaftaran' => StatusPendaftaran::ISI_RAPORT,
        ]);

        session()->flash('success', 'Data orang tua berhasil disimpan! Silakan lengkapi nilai rapor dan prestasi.');
        $this->currentStep = 5;
    }

    // --- STEP 5: Submit Akademik (Raport) & Prestasi ---
    public function addPrestasi(): void
    {
        $this->prestasi[] = [
            'kategori'      => '',
            'perolehan'     => '',
            'tingkat'       => 'Kab',
            'penyelenggara' => '',
        ];
    }

    public function removePrestasi(int $index): void
    {
        unset($this->prestasi[$index]);
        $this->prestasi = array_values($this->prestasi);
    }

    public function getSubjectAverage(string $subject): float
    {
        $scores = array_filter($this->nilai_raport[$subject] ?? [], fn ($v) => is_numeric($v) && $v > 0);
        return count($scores) > 0 ? round(array_sum($scores) / count($scores), 2) : 0;
    }

    public function getOverallAverage(): float
    {
        $allScores = [];
        foreach ($this->nilai_raport as $subjectScores) {
            foreach ($subjectScores as $score) {
                if (is_numeric($score) && $score > 0) {
                    $allScores[] = (float) $score;
                }
            }
        }
        return count($allScores) > 0 ? round(array_sum($allScores) / count($allScores), 2) : 0;
    }

    public function submitStep5(): void
    {
        $rules = [];
        $messages = [];

        // Validasi 5 mapel x 5 semester
        foreach (array_keys($this->subjects) as $subj) {
            foreach ($this->semesters as $sem) {
                $rules["nilai_raport.{$subj}.{$sem}"] = ['required', 'numeric', 'min:0', 'max:100'];
                $messages["nilai_raport.{$subj}.{$sem}.required"] = 'Nilai rapor semester ' . $sem . ' wajib diisi.';
            }
        }

        // Validasi prestasi jika ada yang ditambahkan
        foreach ($this->prestasi as $index => $item) {
            $rules["prestasi.{$index}.kategori"] = ['required', 'string', 'max:100'];
            $rules["prestasi.{$index}.perolehan"] = ['required', 'string', 'max:100'];
            $rules["prestasi.{$index}.tingkat"] = ['required', 'in:Desa,Kec,Kab,Prov,Nasional,Internasional'];
            $rules["prestasi.{$index}.penyelenggara"] = ['required', 'string', 'max:150'];

            $messages["prestasi.{$index}.kategori.required"] = 'Bidang/kategori prestasi baris #' . ($index + 1) . ' wajib diisi.';
            $messages["prestasi.{$index}.perolehan.required"] = 'Perolehan kejuaraan baris #' . ($index + 1) . ' wajib diisi.';
            $messages["prestasi.{$index}.penyelenggara.required"] = 'Instansi penyelenggara baris #' . ($index + 1) . ' wajib diisi.';
        }

        $this->validate($rules, $messages);

        $calon = Auth::user()->calonSiswa;
        $calon->update([
            'nilai_raport' => $this->nilai_raport,
            'prestasi' => $this->prestasi,
            'rata_rata_raport' => $this->getOverallAverage(),
            'status_pendaftaran' => StatusPendaftaran::MENUNGGU_WAWANCARA,
        ]);

        $this->isComplete = true;
        session()->flash('success', 'Selamat! Seluruh tahapan pendaftaran telah lengkap. Data Anda siap untuk tahap wawancara.');
    }

    public function goToStep(int $step): void
    {
        // Hanya izinkan navigasi mundur atau ke step yang sudah pernah dicapai
        if ($step < $this->currentStep) {
            $this->currentStep = $step;
        }
    }

    public function render()
    {
        $programs = Program::active()->get();

        // Wilayah hierarki lengkap untuk Alpine.js cascading
        $wilayahTree = Wilayah::provinsi()
            ->with(['children.children.children'])
            ->get();

        return view('livewire.student-registration-stepper', [
            'programs' => $programs,
            'wilayahTree' => $wilayahTree,
        ]);
    }
}
