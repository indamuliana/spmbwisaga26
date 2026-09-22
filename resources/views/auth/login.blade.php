@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto my-8 bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Masuk Akun PPDB</h1>
        <p class="text-sm text-slate-500 mt-1">Gunakan email dan password Anda untuk masuk</p>
    </div>

    <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Alamat Email</label>
            <input type="email" name="email" id="email" required autofocus value="{{ old('email') }}"
                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('email') border-rose-500 @enderror">
            @error('email')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Password</label>
            <input type="password" name="password" id="password" required
                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
        </div>

        <div class="flex items-center justify-between text-xs">
            <label class="flex items-center space-x-2 text-slate-600">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                <span>Ingat saya</span>
            </label>
            <span class="text-slate-400">Default: password</span>
        </div>

        <button type="submit" class="w-full py-2.5 px-4 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-md shadow-indigo-100 transition">
            Masuk Sekarang
        </button>
    </form>
</div>
@endsection
