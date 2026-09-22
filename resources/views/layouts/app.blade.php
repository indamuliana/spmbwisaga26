<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'PPDB / SPMB 2026' }} - Sistem Penerimaan Siswa Baru</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS (CDN standalone script for instant modern design) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    @livewireStyles
</head>
<body class="h-full font-sans antialiased text-slate-800" x-data="{ mobileMenuOpen: false }">
    <div class="min-h-full flex flex-col">
        <!-- Top Navigation -->
        <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Brand / Logo -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-indigo-500 flex items-center justify-center text-white font-black text-xl shadow-md shadow-indigo-100 group-hover:scale-105 transition-transform">
                                P
                            </div>
                            <div>
                                <span class="text-lg font-black tracking-tight text-slate-900 block leading-tight">PPDB ONLINE</span>
                                <span class="text-[11px] font-semibold tracking-wider text-indigo-600 uppercase">Tahun Ajaran 2026/2027</span>
                            </div>
                        </a>
                    </div>

                    <!-- Right Navigation / Profile Dropdown -->
                    <div class="flex items-center space-x-3">
                        @auth
                            <!-- Role Badge -->
                            @if(auth()->user()->role)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ auth()->user()->role->badgeClasses() }}">
                                    {{ auth()->user()->role->label() }}
                                </span>
                            @endif

                            <!-- Alpine.js User Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" type="button" class="flex items-center space-x-2 py-1.5 px-3 rounded-lg hover:bg-slate-100 transition text-sm text-slate-700 focus:outline-none">
                                    <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600 uppercase">
                                        {{ substr(auth()->user()->name, 0, 2) }}
                                    </div>
                                    <span class="font-medium hidden sm:inline-block">{{ auth()->user()->name }}</span>
                                    <svg class="w-4 h-4 text-slate-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-show="open" 
                                     @click.away="open = false" 
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95" 
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75" 
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-100 py-1.5 z-50 divide-y divide-slate-100" 
                                     style="display: none;">
                                    <div class="px-4 py-2.5">
                                        <p class="text-xs text-slate-500 font-medium">Masuk sebagai</p>
                                        <p class="text-xs font-bold text-slate-800 truncate">{{ auth()->user()->email }}</p>
                                    </div>

                                    <div class="py-1">
                                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition">
                                            Panel Dashboard
                                        </a>
                                    </div>

                                    <div class="py-1">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 transition flex items-center space-x-2">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                <span>Keluar (Logout)</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 px-3 py-2 rounded-lg transition">Masuk</a>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 rounded-lg shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition">Daftar Akun</a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-4">
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between shadow-xs mb-3">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center justify-between shadow-xs mb-3">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Main Content Area -->
        <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
            {{ $slot ?? '' }}
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 mt-auto py-5">
            <div class="max-w-7xl mx-auto px-4 text-center text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2">
                <span>&copy; 2026 PPDB / SPMB Online System. Seluruh hak cipta dilindungi.</span>
                <span class="text-slate-400">Teknologi: Laravel 12 &bull; Livewire 3 &bull; Alpine.js &bull; TailwindCSS</span>
            </div>
        </footer>
    </div>

    @livewireScripts
</body>
</html>
