<div class="space-y-6">
<style>
.mp-nav-bar {
    display: flex; gap: 6px; flex-wrap: wrap; background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 10px 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.04);
}
.mp-nav-item {
    display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 10px; font-size: 0.82rem; font-weight: 600; color: #475569; text-decoration: none; transition: all 0.2s ease; border: 1px solid transparent; white-space: nowrap;
}
.mp-nav-item:hover { background: #eef2ff; color: #4f46e5; border-color: #c7d2fe; }
.mp-nav-item.active { background: linear-gradient(135deg, #6366f1, #4f46e5); color: #fff; border-color: transparent; box-shadow: 0 3px 10px rgba(99,102,241,0.3); }
.mp-nav-item.warning { background: #fffbeb; color: #92400e; border-color: #fcd34d; }
</style>

    {{-- ── HEADER ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-5 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Manajemen Jurusan</h1>
            <p class="text-sm text-slate-500 mt-0.5">Kelola data jurusan / peminatan untuk PPDB</p>
        </div>
        <button wire:click="create()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-xl shadow-md transition inline-flex items-center gap-2">
            <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Tambah Jurusan
        </button>
    </div>

    {{-- ── MASTER NAV BAR ── --}}
    <div class="mp-nav-bar">
        <a href="{{ route('admin.dashboard') }}" class="mp-nav-item">🏠 Dashboard</a>
        <a href="{{ route('admin.users') }}" class="mp-nav-item">👥 Manajemen Pengguna</a>
        <a href="{{ route('admin.gelombang') }}" class="mp-nav-item">📅 Gelombang PPDB</a>
        <a href="{{ route('admin.jurusan') }}" class="mp-nav-item active">🎓 Master Jurusan</a>
        <a href="{{ route('admin.penugasan-wawancara') }}" class="mp-nav-item warning">
            <span style="width:7px;height:7px;border-radius:50%;background:#d97706;display:inline-block;animation:pulse-dot 1.5s infinite;"></span>
            Penugasan Wawancara
        </a>
        <a href="{{ route('admin.pengumuman') }}" class="mp-nav-item">📣 Pengumuman</a>
        <a href="{{ route('admin.laporan') }}" class="mp-nav-item">📊 Laporan</a>
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kode Jurusan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nama Jurusan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($jurusans as $jurusan)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-slate-900">{{ $jurusan->kode_jurusan }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-slate-900">{{ $jurusan->nama_jurusan }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($jurusan->is_active)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">Aktif</span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <button wire:click="edit({{ $jurusan->id }})" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-md transition">Edit</button>
                        <button wire:click="delete({{ $jurusan->id }})" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-md transition" onclick="confirm('Yakin ingin menghapus jurusan ini?') || event.stopImmediatePropagation()">Hapus</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-center text-slate-500">
                        Belum ada data jurusan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    @if($isModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form wire:submit.prevent="store">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Kode Jurusan</label>
                                <input type="text" wire:model="kode_jurusan" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('kode_jurusan') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Nama Jurusan</label>
                                <input type="text" wire:model="nama_jurusan" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('nama_jurusan') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" wire:model="is_active" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded">
                                <label class="ml-2 block text-sm text-slate-900">Aktif (Tersedia untuk dipilih)</label>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Simpan
                        </button>
                        <button type="button" wire:click="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
