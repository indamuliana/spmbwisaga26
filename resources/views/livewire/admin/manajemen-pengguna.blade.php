<div class="space-y-6">

<style>
/* ── MANAJEMEN PENGGUNA STYLES ── */
.mp-nav-bar {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 10px 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
}
.mp-nav-item {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 10px;
    font-size: 0.82rem;
    font-weight: 600;
    color: #475569;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 1px solid transparent;
    white-space: nowrap;
}
.mp-nav-item:hover { background: #eef2ff; color: #4f46e5; border-color: #c7d2fe; text-decoration: none; }
.mp-nav-item.active { background: linear-gradient(135deg,#6366f1,#4f46e5); color:#fff; box-shadow:0 3px 10px rgba(99,102,241,0.3); }
.mp-nav-item.warning { background:#fffbeb;color:#92400e;border-color:#fcd34d; }
.mp-nav-item.warning:hover { background:#fef3c7; }

/* Role stat chips */
.role-chip {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 20px;
    background: #fff;
    border: 1px solid #e8edf5;
    border-radius: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}
.role-chip:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.07); border-color: #c7d2fe; }
.role-chip.selected { border-color: #6366f1; background: #eef2ff; box-shadow: 0 0 0 3px rgba(99,102,241,0.15); }

/* Table */
.mp-table { width: 100%; border-collapse: collapse; }
.mp-table thead th {
    background: #f8faff;
    padding: 11px 14px;
    text-align: left;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #94a3b8;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
    cursor: pointer;
    user-select: none;
}
.mp-table thead th:hover { color: #6366f1; }
.mp-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background 0.12s; }
.mp-table tbody tr:hover { background: #f8faff; }
.mp-table tbody td { padding: 12px 14px; font-size: 0.83rem; color: #334155; vertical-align: middle; }
.mp-table tbody tr:last-child { border-bottom: none; }

/* Modal overlay */
.mp-modal-overlay {
    position: fixed; inset: 0;
    background: rgba(15,23,42,0.55);
    backdrop-filter: blur(4px);
    z-index: 50;
    display: flex; align-items: center; justify-content: center;
    padding: 1rem;
}
.mp-modal {
    background: #fff;
    border-radius: 22px;
    box-shadow: 0 30px 80px rgba(0,0,0,0.2);
    width: 100%;
    max-width: 520px;
    max-height: 90vh;
    overflow-y: auto;
    animation: modal-in 0.25s cubic-bezier(.4,0,.2,1);
}
.mp-modal-sm { max-width: 420px; }
@keyframes modal-in { from { opacity:0; transform:scale(0.95) translateY(10px); } to { opacity:1; transform:scale(1) translateY(0); } }
.mp-modal-header { padding: 24px 28px 0; }
.mp-modal-body { padding: 20px 28px; }
.mp-modal-footer { padding: 0 28px 24px; display:flex; gap:10px; justify-content:flex-end; }

/* Form elements */
.mp-label { display:block; font-size:0.8rem; font-weight:700; color:#475569; margin-bottom:6px; letter-spacing:0.02em; }
.mp-input {
    width:100%; padding:10px 14px; border:1.5px solid #e2e8f0;
    border-radius:10px; font-size:0.9rem; color:#0f172a;
    transition:all 0.2s; background:#fff; outline:none;
}
.mp-input:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.12); }
.mp-input.error { border-color:#ef4444; box-shadow:0 0 0 3px rgba(239,68,68,0.1); }
.mp-select { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 12px center; background-size:16px; padding-right:36px; }
.mp-error { color:#ef4444; font-size:0.75rem; margin-top:4px; display:flex; align-items:center; gap:4px; }

/* Buttons */
.mp-btn { display:inline-flex; align-items:center; gap:8px; padding:10px 20px; border-radius:10px; font-size:0.85rem; font-weight:700; cursor:pointer; transition:all 0.2s; border:none; }
.mp-btn-primary { background:linear-gradient(135deg,#6366f1,#4f46e5); color:#fff; box-shadow:0 4px 12px rgba(99,102,241,0.3); }
.mp-btn-primary:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(99,102,241,0.4); }
.mp-btn-ghost { background:#f1f5f9; color:#475569; }
.mp-btn-ghost:hover { background:#e2e8f0; }
.mp-btn-danger { background:linear-gradient(135deg,#ef4444,#dc2626); color:#fff; box-shadow:0 4px 12px rgba(239,68,68,0.25); }
.mp-btn-danger:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(239,68,68,0.35); }
.mp-btn-warning { background:linear-gradient(135deg,#f59e0b,#d97706); color:#fff; box-shadow:0 4px 12px rgba(245,158,11,0.25); }
.mp-btn-warning:hover { transform:translateY(-1px); }
.mp-btn-sm { padding:6px 12px; font-size:0.75rem; border-radius:8px; }

/* Badge */
.badge-role { display:inline-block; padding:3px 10px; border-radius:999px; font-size:0.69rem; font-weight:700; border:1px solid transparent; }
</style>

    {{-- ── HEADER ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-5 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Manajemen Pengguna</h1>
            <p class="text-sm text-slate-500 mt-0.5">Kelola akun admin, bendahara, pewawancara, kepsek, dan calon siswa</p>
        </div>
        <button wire:click="openCreate" class="mp-btn mp-btn-primary" id="btn-tambah-pengguna">
            <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Tambah Pengguna
        </button>
    </div>

    {{-- ── MASTER NAV BAR ── --}}
    <div class="mp-nav-bar">
        <a href="{{ route('admin.dashboard') }}" class="mp-nav-item">🏠 Dashboard</a>
        <a href="{{ route('admin.users') }}" class="mp-nav-item active">👥 Manajemen Pengguna</a>
        <a href="{{ route('admin.gelombang') }}" class="mp-nav-item">📅 Gelombang PPDB</a>
        <a href="{{ route('admin.jurusan') }}" class="mp-nav-item">🎓 Master Jurusan</a>
        <a href="{{ route('admin.penugasan-wawancara') }}" class="mp-nav-item warning">
            <span style="width:7px;height:7px;border-radius:50%;background:#d97706;display:inline-block;animation:pulse-dot 1.5s infinite;"></span>
            Penugasan Wawancara
        </a>
        <a href="{{ route('admin.pengumuman') }}" class="mp-nav-item">📣 Pengumuman</a>
        <a href="{{ route('admin.laporan') }}" class="mp-nav-item">📊 Laporan</a>
    </div>

    {{-- ── FLASH MESSAGES ── --}}
    @if(session('success'))
    <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-14 text-sm font-semibold rounded-xl" x-data x-init="setTimeout(() => $el.remove(), 4000)">
        <span style="font-size:1.1rem;">✅</span> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 rounded-xl text-sm font-semibold" x-data x-init="setTimeout(() => $el.remove(), 5000)">
        <span style="font-size:1.1rem;">❌</span> {{ session('error') }}
    </div>
    @endif

    {{-- ── ROLE SUMMARY CHIPS ── --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        {{-- All --}}
        <button wire:click="$set('filterRole', '')" 
                class="role-chip {{ $filterRole === '' ? 'selected' : '' }}"
                style="flex-direction:column; align-items:flex-start;">
            <span style="font-size:1.3rem;">👥</span>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">Semua</span>
            <span class="text-xl font-black text-slate-800">{{ array_sum($this->roleCounts) }}</span>
        </button>
        @foreach($this->roles as $r)
        @php
            $cnt = $this->roleCounts[$r->value] ?? 0;
            $icon = match($r) {
                \App\Enums\UserRole::ADMIN       => '🛡️',
                \App\Enums\UserRole::BENDAHARA   => '💰',
                \App\Enums\UserRole::PEWAWANCARA => '🎙️',
                \App\Enums\UserRole::SISWA       => '🎒',
                \App\Enums\UserRole::KEPSEK      => '🏫',
            };
        @endphp
        <button wire:click="$set('filterRole', '{{ $r->value }}')"
                class="role-chip {{ $filterRole === $r->value ? 'selected' : '' }}"
                style="flex-direction:column; align-items:flex-start;">
            <span style="font-size:1.3rem;">{{ $icon }}</span>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">{{ $r->label() }}</span>
            <span class="text-xl font-black text-slate-800">{{ $cnt }}</span>
        </button>
        @endforeach
    </div>

    {{-- ── SEARCH & FILTER BAR ── --}}
    <div class="bg-white border border-slate-200 rounded-xl px-5 py-4 flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama, email, atau telepon..."
                   id="input-search-user"
                   class="mp-input" style="padding-left:36px;">
        </div>
        <select wire:model.live="filterRole" class="mp-input mp-select" style="width:auto;min-width:180px;" id="select-filter-role">
            <option value="">Semua Role</option>
            @foreach($this->roles as $r)
            <option value="{{ $r->value }}">{{ $r->label() }}</option>
            @endforeach
        </select>
        @if($search || $filterRole)
        <button wire:click="$set('search', ''); $set('filterRole', '')" class="mp-btn mp-btn-ghost text-xs">
            ✕ Reset
        </button>
        @endif
    </div>

    {{-- ── USER TABLE ── --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div style="overflow-x:auto;">
            <table class="mp-table">
                <thead>
                    <tr>
                        <th style="width:44px;">#</th>
                        <th wire:click="sortColumn('name')" class="cursor-pointer select-none">
                            Nama
                            @if($sortBy === 'name')
                                <span>{{ $sortDir === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th wire:click="sortColumn('email')">
                            Email / Telepon
                            @if($sortBy === 'email') <span>{{ $sortDir === 'asc' ? '↑' : '↓' }}</span> @endif
                        </th>
                        <th wire:click="sortColumn('role')">
                            Role
                            @if($sortBy === 'role') <span>{{ $sortDir === 'asc' ? '↑' : '↓' }}</span> @endif
                        </th>
                        <th wire:click="sortColumn('created_at')">
                            Bergabung
                            @if($sortBy === 'created_at') <span>{{ $sortDir === 'asc' ? '↑' : '↓' }}</span> @endif
                        </th>
                        <th style="text-align:right; width:140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->users as $idx => $user)
                    <tr wire:key="user-{{ $user->id }}">
                        <td class="text-slate-400 font-mono text-xs">{{ $this->users->firstItem() + $idx }}</td>
                        <td>
                            <div class="flex items-center gap-3">
                                {{-- Avatar --}}
                                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#818cf8);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:0.85rem;flex-shrink:0;">
                                    {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-800">{{ $user->name }}</div>
                                    @if($user->id === auth()->id())
                                    <span style="font-size:0.65rem;background:#eef2ff;color:#4f46e5;border-radius:999px;padding:1px 6px;font-weight:700;">Anda</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-slate-700">{{ $user->email }}</div>
                            @if($user->phone)
                            <div class="text-xs text-slate-400 mt-0.5">{{ $user->phone }}</div>
                            @endif
                        </td>
                        <td>
                            @php
                                $role = $user->role instanceof \App\Enums\UserRole ? $user->role : \App\Enums\UserRole::from($user->role);
                            @endphp
                            <span class="badge-role {{ $role->badgeClasses() }}">{{ $role->label() }}</span>
                        </td>
                        <td class="text-xs text-slate-400">
                            {{ $user->created_at?->format('d M Y') ?? '-' }}
                        </td>
                        <td style="text-align:right;">
                            <div class="flex items-center justify-end gap-1.5">
                                {{-- Edit --}}
                                <button wire:click="openEdit({{ $user->id }})"
                                        title="Edit Pengguna"
                                        class="mp-btn mp-btn-ghost mp-btn-sm">
                                    ✏️
                                </button>
                                {{-- Reset PW --}}
                                <button wire:click="openReset({{ $user->id }})"
                                        title="Reset Password"
                                        class="mp-btn mp-btn-warning mp-btn-sm">
                                    🔑
                                </button>
                                {{-- Delete --}}
                                @if($user->id !== auth()->id())
                                <button wire:click="openDelete({{ $user->id }})"
                                        title="Hapus"
                                        class="mp-btn mp-btn-danger mp-btn-sm">
                                    🗑️
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:3rem;">
                            <div style="font-size:2.5rem;">🔍</div>
                            <div class="font-semibold text-slate-500 mt-2">Tidak ada pengguna ditemukan</div>
                            <div class="text-xs text-slate-400 mt-1">Coba ubah kata kunci pencarian atau filter role</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($this->users->hasPages())
        <div class="px-5 py-4 border-t border-slate-100">
            {{ $this->users->links() }}
        </div>
        @endif
    </div>

    {{-- Total info --}}
    <p class="text-xs text-slate-400 text-center">
        Menampilkan {{ $this->users->firstItem() ?? 0 }}–{{ $this->users->lastItem() ?? 0 }} dari {{ $this->users->total() }} pengguna
    </p>


    {{-- ═══════════════════════════════════════════
         MODAL: TAMBAH / EDIT PENGGUNA
    ═══════════════════════════════════════════ --}}
    @if($showModal)
    <div class="mp-modal-overlay" wire:click.self="$set('showModal', false)">
        <div class="mp-modal">
            <div class="mp-modal-header">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-black text-slate-900">
                            {{ $isEditing ? '✏️ Edit Pengguna' : '➕ Tambah Pengguna Baru' }}
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">
                            {{ $isEditing ? 'Perbarui data akun pengguna' : 'Isi formulir untuk membuat akun baru' }}
                        </p>
                    </div>
                    <button wire:click="$set('showModal', false)" 
                            style="width:32px;height:32px;border-radius:8px;background:#f1f5f9;border:none;cursor:pointer;font-size:1.1rem;display:flex;align-items:center;justify-content:center;">
                        ✕
                    </button>
                </div>
                <div style="height:1px;background:#f1f5f9;margin:16px -28px 0;"></div>
            </div>

            <div class="mp-modal-body">
                <form wire:submit="save" class="space-y-4">

                    {{-- Nama --}}
                    <div>
                        <label class="mp-label">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input wire:model="name" type="text" placeholder="cth. Budi Santoso"
                               id="input-nama-pengguna"
                               class="mp-input {{ $errors->has('name') ? 'error' : '' }}">
                        @error('name') <p class="mp-error">⚠ {{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="mp-label">Email <span class="text-red-500">*</span></label>
                        <input wire:model="email" type="email" placeholder="cth. budi@smkwikrama.sch.id"
                               id="input-email-pengguna"
                               class="mp-input {{ $errors->has('email') ? 'error' : '' }}">
                        @error('email') <p class="mp-error">⚠ {{ $message }}</p> @enderror
                    </div>

                    {{-- Telepon --}}
                    <div>
                        <label class="mp-label">Nomor Telepon</label>
                        <input wire:model="phone" type="text" placeholder="cth. 08123456789"
                               id="input-phone-pengguna"
                               class="mp-input {{ $errors->has('phone') ? 'error' : '' }}">
                        @error('phone') <p class="mp-error">⚠ {{ $message }}</p> @enderror
                    </div>

                    {{-- Role --}}
                    <div>
                        <label class="mp-label">Role / Hak Akses <span class="text-red-500">*</span></label>
                        <select wire:model="role" id="select-role-pengguna"
                                class="mp-input mp-select {{ $errors->has('role') ? 'error' : '' }}">
                            <option value="">-- Pilih Role --</option>
                            @foreach($this->roles as $r)
                            <option value="{{ $r->value }}">{{ $r->label() }}</option>
                            @endforeach
                        </select>
                        @error('role') <p class="mp-error">⚠ {{ $message }}</p> @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="mp-label">
                            Password
                            @if($isEditing)
                            <span class="font-normal text-slate-400">(kosongkan jika tidak ingin mengubah)</span>
                            @else
                            <span class="text-red-500">*</span>
                            @endif
                        </label>
                        <input wire:model="password" type="password" 
                               placeholder="{{ $isEditing ? 'Biarkan kosong jika tidak diubah' : 'Minimal 8 karakter' }}"
                               id="input-password-pengguna"
                               class="mp-input {{ $errors->has('password') ? 'error' : '' }}">
                        @error('password') <p class="mp-error">⚠ {{ $message }}</p> @enderror
                    </div>

                    {{-- Confirm Password --}}
                    @if(!$isEditing || filled($password))
                    <div>
                        <label class="mp-label">Konfirmasi Password</label>
                        <input wire:model="password_confirmation" type="password" placeholder="Ulangi password"
                               id="input-password-confirm"
                               class="mp-input">
                    </div>
                    @endif

                </form>
            </div>

            <div class="mp-modal-footer" style="border-top:1px solid #f1f5f9; padding-top:16px;">
                <button wire:click="$set('showModal', false)" class="mp-btn mp-btn-ghost">Batal</button>
                <button wire:click="save" wire:loading.attr="disabled" class="mp-btn mp-btn-primary" id="btn-simpan-pengguna">
                    <span wire:loading.remove wire:target="save">
                        {{ $isEditing ? '💾 Simpan Perubahan' : '✅ Buat Pengguna' }}
                    </span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </div>
    </div>
    @endif


    {{-- ═══════════════════════════════════════════
         MODAL: RESET PASSWORD
    ═══════════════════════════════════════════ --}}
    @if($showResetModal)
    <div class="mp-modal-overlay" wire:click.self="$set('showResetModal', false)">
        <div class="mp-modal mp-modal-sm">
            <div class="mp-modal-header">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-black text-slate-900">🔑 Reset Password</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Reset password untuk <strong>{{ $resetUserName }}</strong></p>
                    </div>
                    <button wire:click="$set('showResetModal', false)"
                            style="width:32px;height:32px;border-radius:8px;background:#f1f5f9;border:none;cursor:pointer;">✕</button>
                </div>
                <div style="height:1px;background:#f1f5f9;margin:16px -28px 0;"></div>
            </div>

            <div class="mp-modal-body space-y-4">
                <div>
                    <label class="mp-label">Password Baru <span class="text-red-500">*</span></label>
                    <input wire:model="newPassword" type="password" placeholder="Minimal 8 karakter"
                           id="input-new-password"
                           class="mp-input {{ $errors->has('newPassword') ? 'error' : '' }}">
                    @error('newPassword') <p class="mp-error">⚠ {{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mp-label">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                    <input wire:model="newPassword_confirmation" type="password" placeholder="Ulangi password baru"
                           id="input-new-password-confirm"
                           class="mp-input">
                </div>
            </div>

            <div class="mp-modal-footer" style="border-top:1px solid #f1f5f9;padding-top:16px;">
                <button wire:click="$set('showResetModal', false)" class="mp-btn mp-btn-ghost">Batal</button>
                <button wire:click="confirmReset" class="mp-btn mp-btn-warning" id="btn-confirm-reset">
                    🔑 Reset Password
                </button>
            </div>
        </div>
    </div>
    @endif


    {{-- ═══════════════════════════════════════════
         MODAL: KONFIRMASI HAPUS
    ═══════════════════════════════════════════ --}}
    @if($showDeleteModal)
    <div class="mp-modal-overlay" wire:click.self="$set('showDeleteModal', false)">
        <div class="mp-modal mp-modal-sm">
            <div class="mp-modal-body" style="padding-top:28px; text-align:center;">
                <div style="width:64px;height:64px;border-radius:50%;background:#fff1f2;display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin:0 auto 16px;">🗑️</div>
                <h2 class="text-lg font-black text-slate-900">Hapus Pengguna?</h2>
                <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                    Anda akan menghapus akun <strong class="text-slate-800">{{ $deleteUserName }}</strong>.<br>
                    Tindakan ini <span class="text-red-600 font-bold">tidak dapat dibatalkan</span>.
                </p>
            </div>
            <div class="mp-modal-footer" style="justify-content:center; gap:12px;">
                <button wire:click="$set('showDeleteModal', false)" class="mp-btn mp-btn-ghost">
                    Batal
                </button>
                <button wire:click="confirmDelete" class="mp-btn mp-btn-danger" id="btn-confirm-delete">
                    Ya, Hapus Sekarang
                </button>
            </div>
        </div>
    </div>
    @endif

</div>

<style>
@keyframes pulse-dot { 0%,100%{opacity:1} 50%{opacity:0.3} }
</style>
