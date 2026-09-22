@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="text-center max-w-xl mx-auto mb-6">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
            Formulir Pendaftaran Siswa Baru 2026/2027
        </span>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-2">
            Portal PPDB Online Terpadu
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            Lengkapi 4 langkah mudah pendaftaran: Buat Akun, Bayar Seleksi, Biodata Siswa, dan Data Orang Tua.
        </p>
    </div>

    <livewire:student-registration-stepper />
</div>
@endsection
