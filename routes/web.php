<?php

use App\Enums\StatusKelulusan;
use App\Enums\StatusPendaftaran;
use App\Enums\UserRole;
use App\Http\Controllers\DokumenKesepahamanController;
use App\Models\CalonSiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $pengumumans = \App\Models\Pengumuman::where('is_aktif', true)->latest()->get();
    return view('welcome', compact('pengumumans'));
})->name('home');

Route::get('/daftar', \App\Livewire\Siswa\RegisterSiswa::class)->name('pendaftaran');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    })->name('login.post');

    Route::get('/register', function () {
        return redirect()->route('pendaftaran');
    })->name('register');

    // Quick Login Helper for Development & Role Testing
    Route::post('/quick-login/{role}', function (string $role, Request $request) {
        $user = User::where('role', $role)->first();
        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Berhasil masuk sebagai ' . $user->role->label());
        }
        return back()->with('error', 'Akun demo untuk role ' . $role . ' tidak ditemukan.');
    })->name('login.quick');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/')->with('success', 'Anda telah berhasil keluar dari sistem.');
})->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard Central Dispatcher
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->get('/dashboard', function () {
    $role = auth()->user()->role;
    $roleValue = $role instanceof UserRole ? $role->value : (string) $role;

    return match ($roleValue) {
        'admin'        => redirect()->route('admin.dashboard'),
        'bendahara'    => redirect()->route('bendahara.dashboard'),
        'pewawancara'  => redirect()->route('pewawancara.dashboard'),
        'siswa'        => redirect()->route('siswa.dashboard'),
        'kepsek'       => redirect()->route('kepsek.dashboard'),
        default        => abort(403, 'Peran akun tidak dikenali.'),
    };
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| 1. Role: ADMINISTRATOR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', function () {
            // Rekap per tahap pendaftaran
            $rekapTahap = collect(StatusPendaftaran::cases())->map(function ($status) {
                return [
                    'label'  => $status->label(),
                    'value'  => $status->value,
                    'badge'  => $status->badgeClasses(),
                    'jumlah' => CalonSiswa::where('status_pendaftaran', $status->value)->count(),
                ];
            });

            // Stats ringkas
            $stats = [
                'total'       => CalonSiswa::count(),
                'diterima'    => CalonSiswa::where('status_kelulusan', StatusKelulusan::DITERIMA->value)->count(),
                'cadangan'    => CalonSiswa::where('status_kelulusan', StatusKelulusan::CADANGAN->value)->count(),
                'ditolak'     => CalonSiswa::where('status_kelulusan', StatusKelulusan::DITOLAK->value)->count(),
                'pengguna'    => User::count(),
            ];

            // Seluruh pendaftar
            $pendaftars = CalonSiswa::with(['jurusan', 'user'])
                ->latest()
                ->get();

            return view('admin.dashboard', compact('rekapTahap', 'stats', 'pendaftars'));
        })->name('dashboard');

        // Modul Master Data & Operasional PPDB
        Route::get('/users', \App\Livewire\Admin\ManajemenPengguna::class)->name('users');
        Route::get('/gelombang', fn () => 'Halaman Master Gelombang Pendaftaran')->name('gelombang');
        Route::get('/jurusan', \App\Livewire\Admin\ManajemenJurusan::class)->name('jurusan');
        Route::get('/penugasan-wawancara', fn () => view('admin.penugasan-wawancara'))->name('penugasan-wawancara');
        Route::get('/laporan', fn () => 'Halaman Rekapitulasi Data PPDB')->name('laporan');
        Route::get('/pengumuman', \App\Livewire\Admin\KelolaPengumuman::class)->name('pengumuman');
    });

/*
|--------------------------------------------------------------------------
| 2. Role: BENDAHARA (Keuangan)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:bendahara'])
    ->prefix('bendahara')
    ->name('bendahara.')
    ->group(function () {
        Route::get('/dashboard', function () {
            // Rekap per tahap
            $rekapTahap = collect(StatusPendaftaran::cases())->map(function ($status) {
                return [
                    'label'  => $status->label(),
                    'value'  => $status->value,
                    'badge'  => $status->badgeClasses(),
                    'jumlah' => CalonSiswa::where('status_pendaftaran', $status->value)->count(),
                ];
            });

            // Stats keuangan
            $stats = [
                'total'               => CalonSiswa::count(),
                'menunggu_verifikasi' => CalonSiswa::where('status_pendaftaran', StatusPendaftaran::BAYAR_SELEKSI->value)
                                                   ->whereNotNull('bukti_bayar_seleksi')->count(),
                'sudah_bayar'         => CalonSiswa::where('status_pendaftaran', '!=', StatusPendaftaran::BAYAR_SELEKSI->value)
                                                   ->where('status_pendaftaran', '!=', StatusPendaftaran::REGISTER->value)->count(),
                'belum_bayar'         => CalonSiswa::where('status_pendaftaran', StatusPendaftaran::BAYAR_SELEKSI->value)
                                                   ->whereNull('bukti_bayar_seleksi')->count(),
            ];

            // Seluruh pendaftar
            $pendaftars = CalonSiswa::with(['jurusan', 'user'])
                ->latest()
                ->get();

            return view('bendahara.dashboard', compact('rekapTahap', 'stats', 'pendaftars'));
        })->name('dashboard');

        // Modul Pembayaran
        Route::get('/verifikasi-bayar', fn () => view('bendahara.verifikasi'))->name('verifikasi');
        Route::get('/rekap-keuangan', fn () => 'Halaman Rekapitulasi Keuangan PPDB')->name('rekap');
    });

/*
|--------------------------------------------------------------------------
| 3. Role: PEWAWANCARA (Tim Penguji)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pewawancara'])
    ->prefix('pewawancara')
    ->name('pewawancara.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('pewawancara.dashboard');
        })->name('dashboard');

        // Modul Pengujian & Wawancara
        Route::get('/jadwal', fn () => 'Halaman Jadwal Sesi Wawancara Siswa')->name('jadwal');
        Route::get('/penilaian/{calonSiswaId?}', function (?int $calonSiswaId = null) {
            return view('pewawancara.penilaian', ['calonSiswaId' => $calonSiswaId]);
        })->name('penilaian');
    });

/*
|--------------------------------------------------------------------------
| 4. Role: SISWA (Calon Peserta Didik)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/dashboard', \App\Livewire\Siswa\DashboardSiswa::class)->name('dashboard');

        // Modul Calon Siswa
        Route::get('/biodata', fn () => view('pendaftaran'))->name('biodata');
        Route::get('/dokumen', fn () => 'Halaman Upload Berkas Persyaratan')->name('dokumen');
        Route::get('/pembayaran', fn () => view('pendaftaran'))->name('pembayaran');
        Route::get('/daftar-ulang', fn () => view('siswa.daftar-ulang'))->name('daftar-ulang');
        Route::get('/status-kelulusan', fn () => 'Halaman Pengumuman Seleksi Siswa')->name('status');
        Route::get('/cetak-kartu', fn () => 'Halaman Cetak Kartu Ujian Siswa')->name('cetak-kartu');
    });

/*
|--------------------------------------------------------------------------
| Cetak Dokumen PDF (Kesepahaman Siswa & Orang Tua, Akun)
|--------------------------------------------------------------------------
*/
// Rute publik/sementara untuk cetak akun (tanpa auth untuk kemudahan setelah register)
Route::get('/cetak-akun/{calonSiswaId}', [\App\Http\Controllers\CetakAkunController::class, 'cetak'])->name('cetak-akun');

Route::middleware(['auth'])->group(function () {
    Route::get('/dokumen-kesepahaman/cetak/{calonSiswaId?}', [DokumenKesepahamanController::class, 'cetakPdf'])
        ->name('dokumen-kesepahaman.cetak');
});

/*
|--------------------------------------------------------------------------
| 5. Role: KEPALA SEKOLAH (Eksekutif & Pengesahan)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:kepsek'])
    ->prefix('kepsek')
    ->name('kepsek.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('kepsek.dashboard');
        })->name('dashboard');

        // Modul Pengawasan Eksekutif
        Route::get('/statistik', fn () => 'Halaman Statistik Komprehensif PPDB')->name('statistik');
        Route::get('/approval-kelulusan', fn () => 'Halaman Pengesahan SK Kelulusan Siswa')->name('approval');
    });

Route::post('/submit-message', function(Illuminate\Http\Request $request) {
    // Stub for contact form
    return response()->json(['status' => 'success', 'message' => 'Pesan terkirim!']);
});
