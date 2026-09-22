@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 flex flex-col items-center pt-10 pb-20 space-y-12">

    <!-- Header / Logo -->
    <div class="text-center space-y-4">
        <img src="https://spmb.smkwikrama1garut.sch.id/SPMB-Biru.png" alt="Logo SMK Wikrama 1 Garut" class="w-24 h-24 mx-auto rounded-full shadow-md object-contain bg-white p-2">
        <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 tracking-tight">
            Pendaftaran Peserta Didik Baru
        </h1>
        <p class="text-lg md:text-xl text-slate-600 max-w-2xl mx-auto">
            SMK Wikrama 1 Garut Tahun Ajaran 2026/2027.<br/>
            <span class="font-semibold italic">"Ilmu yang Amaliah, Amal yang Ilmiah, Akhlakul Karimah"</span>
        </p>
    </div>

    <!-- Main Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
        <a href="{{ route('pendaftaran') }}" class="w-full sm:w-auto px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold shadow-lg shadow-indigo-200 transition transform hover:-translate-y-1 text-center text-lg flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
            Daftar Sekarang
        </a>
        <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-white border-2 border-indigo-600 text-indigo-700 hover:bg-indigo-50 rounded-2xl font-bold shadow-md transition transform hover:-translate-y-1 text-center text-lg flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
            Login
        </a>
    </div>

    <!-- Secondary Links (Brosur, Lokasi, Chat) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto w-full px-4">
        <a href="https://brosur.smkwikrama1garut.sch.id" target="_blank" class="flex flex-col items-center justify-center p-6 bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-emerald-500 hover:shadow-md transition text-center group">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
            </div>
            <h3 class="font-bold text-slate-800">Download Brosur</h3>
            <p class="text-sm text-slate-500 mt-1">Lihat informasi lengkap PPDB</p>
        </a>
        <a href="https://bit.ly/wikramagarut" target="_blank" class="flex flex-col items-center justify-center p-6 bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-red-500 hover:shadow-md transition text-center group">
            <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            </div>
            <h3 class="font-bold text-slate-800">Lokasi Sekolah</h3>
            <p class="text-sm text-slate-500 mt-1">Cek rute via Google Maps</p>
        </a>
        <a href="https://wa.me/628112232880" target="_blank" class="flex flex-col items-center justify-center p-6 bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-green-500 hover:shadow-md transition text-center group">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
            </div>
            <h3 class="font-bold text-slate-800">Chat Admin</h3>
            <p class="text-sm text-slate-500 mt-1">Konsultasi via WhatsApp</p>
        </a>
    </div>

    <!-- Pengumuman Dinamis -->
    @if(count($pengumumans) > 0)
    <div class="w-full max-w-5xl mx-auto px-4" x-data="{ activeSlide: 0, interval: null, slides: {{ $pengumumans->count() }} }"
         x-init="interval = setInterval(() => { activeSlide = (activeSlide + 1) % slides }, 5000)">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
            <h2 class="text-2xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                Papan Pengumuman
            </h2>
            
            <div class="relative overflow-hidden rounded-2xl bg-slate-50 aspect-video md:aspect-[21/9]">
                @foreach($pengumumans as $index => $pengumuman)
                <div x-show="activeSlide === {{ $index }}"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 transform translate-x-full"
                     x-transition:enter-end="opacity-100 transform translate-x-0"
                     x-transition:leave="transition ease-in duration-300 absolute inset-0"
                     x-transition:leave-start="opacity-100 transform translate-x-0"
                     x-transition:leave-end="opacity-0 transform -translate-x-full"
                     class="w-full h-full"
                     style="display: none;">
                    
                    @if($pengumuman->gambar)
                        <img src="{{ Storage::url($pengumuman->gambar) }}" alt="{{ $pengumuman->judul }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-6 md:p-10 text-white">
                            <h3 class="text-2xl md:text-3xl font-bold">{{ $pengumuman->judul }}</h3>
                            @if($pengumuman->konten)
                                <p class="mt-2 text-sm md:text-base text-slate-200 line-clamp-2 md:line-clamp-3">{{ $pengumuman->konten }}</p>
                            @endif
                        </div>
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center p-8 bg-indigo-600 text-white text-center">
                            <h3 class="text-3xl md:text-4xl font-bold mb-4">{{ $pengumuman->judul }}</h3>
                            @if($pengumuman->konten)
                                <p class="text-lg md:text-xl text-indigo-100 max-w-2xl">{{ $pengumuman->konten }}</p>
                            @endif
                        </div>
                    @endif
                </div>
                @endforeach
            </div>

            <!-- Slider Controls -->
            <div class="flex justify-center mt-4 gap-2">
                @foreach($pengumumans as $index => $pengumuman)
                    <button @click="activeSlide = {{ $index }}; clearInterval(interval); interval = setInterval(() => { activeSlide = (activeSlide + 1) % slides }, 5000)" 
                            :class="activeSlide === {{ $index }} ? 'bg-indigo-600 w-8' : 'bg-slate-300 hover:bg-slate-400 w-3'"
                            class="h-3 rounded-full transition-all duration-300 focus:outline-none"></button>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Social Media -->
    <div class="text-center pt-8 border-t border-slate-200 w-full max-w-4xl mx-auto">
        <h3 class="text-slate-500 font-medium mb-6">Ikuti Kami di Sosial Media</h3>
        <div class="flex justify-center gap-6">
            <a href="https://www.instagram.com/smkwikrama1garut/" target="_blank" class="text-slate-400 hover:text-pink-600 transition transform hover:scale-110">
                <span class="sr-only">Instagram</span>
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
            </a>
            <a href="#" class="text-slate-400 hover:text-black transition transform hover:scale-110">
                <span class="sr-only">TikTok</span>
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93v7.2c0 1.63-.51 3.25-1.48 4.54-1.52 2.01-4.05 3.17-6.57 3.05-2.49-.11-4.83-1.42-6.1-3.48-1.3-2.12-1.51-4.84-.52-7.14.99-2.28 3.01-4.05 5.37-4.63 1.18-.29 2.42-.31 3.63-.07v4.06c-1.3-.23-2.67-.09-3.79.62-.98.63-1.64 1.64-1.84 2.78-.22 1.23.09 2.53.84 3.48.74.93 1.91 1.48 3.11 1.52 1.21.03 2.41-.47 3.18-1.35.79-.9 1.15-2.13 1.17-3.34V.02h-4.08z"/></svg>
            </a>
            <a href="#" class="text-slate-400 hover:text-blue-600 transition transform hover:scale-110">
                <span class="sr-only">Facebook</span>
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
            </a>
            <a href="#" class="text-slate-400 hover:text-red-600 transition transform hover:scale-110">
                <span class="sr-only">YouTube</span>
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd" /></svg>
            </a>
        </div>
    </div>
</div>
@endsection