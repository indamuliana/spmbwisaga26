<?php

namespace App\Livewire\Admin;

use App\Enums\StatusPendaftaran;
use App\Enums\UserRole;
use App\Models\CalonSiswa;
use App\Models\User;
use App\Models\Wawancara;
use Livewire\Component;
use Livewire\WithPagination;

class BulkAssignmentWawancara extends Component
{
    use WithPagination;

    // Search & Filter
    public string $search = '';

    // Checkbox State
    public array $selected = [];
    public bool $selectAll = false;

    // Bulk Form Inputs
    public ?int $pewawancara_id = null;
    public ?string $jadwal = null;
    public ?string $link_meet = null;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount(): void
    {
        // Nilai bawaan jadwal: Besok jam 09:00
        $this->jadwal = now()->addDay()->setHour(9)->setMinute(0)->format('Y-m-d\TH:i');
        $this->link_meet = 'https://meet.google.com/spmb-wawancara';
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
        $this->selected = [];
        $this->selectAll = false;
    }

    public function updatedSelectAll(bool $value): void
    {
        if ($value) {
            $this->selected = $this->getQuery()->pluck('id')->map(fn ($id) => (int) $id)->all();
        } else {
            $this->selected = [];
        }
    }

    public function updatedSelected(): void
    {
        $totalOnList = $this->getQuery()->count();
        $this->selectAll = $totalOnList > 0 && count($this->selected) === $totalOnList;
    }

    protected function getQuery()
    {
        return CalonSiswa::query()
            ->with(['program', 'jurusan', 'wawancara.pewawancara'])
            ->where('status_pendaftaran', StatusPendaftaran::MENUNGGU_WAWANCARA)
            ->when(! empty($this->search), function ($q) {
                $q->where(function ($sub) {
                    $sub->where('nama_lengkap', 'like', '%' . $this->search . '%')
                        ->orWhere('nisn', 'like', '%' . $this->search . '%')
                        ->orWhere('asal_sekolah', 'like', '%' . $this->search . '%');
                });
            });
    }

    /**
     * Eksekusi Penugasan Masal (Bulk Assignment) Sesi Wawancara
     */
    public function assignBulk(): void
    {
        $this->validate([
            'selected'        => ['required', 'array', 'min:1'],
            'pewawancara_id'  => ['required', 'exists:users,id'],
            'jadwal'          => ['required', 'date'],
            'link_meet'       => ['nullable', 'string', 'max:255'],
        ], [
            'selected.required'       => 'Pilih minimal satu calon siswa yang ingin ditugaskan.',
            'selected.min'            => 'Pilih minimal satu calon siswa dengan mencentang kotak seleksi.',
            'pewawancara_id.required' => 'Pilih pewawancara yang akan ditugaskan.',
            'pewawancara_id.exists'   => 'Pewawancara yang dipilih tidak valid.',
            'jadwal.required'         => 'Tentukan jadwal pelaksanaan wawancara.',
        ]);

        $pewawancara = User::findOrFail($this->pewawancara_id);
        $totalAssigned = 0;

        foreach ($this->selected as $calonId) {
            Wawancara::updateOrCreate(
                ['calon_siswa_id' => $calonId],
                [
                    'pewawancara_id' => $this->pewawancara_id,
                    'jadwal'         => $this->jadwal,
                    'link_meet'      => $this->link_meet,
                ]
            );
            $totalAssigned++;
        }

        $this->selected = [];
        $this->selectAll = false;

        $jadwalFormatted = date('d M Y, H:i', strtotime($this->jadwal));
        session()->flash('success', "Sukses! Sebanyak {$totalAssigned} calon siswa berhasil ditugaskan ke {$pewawancara->name} pada jadwal {$jadwalFormatted} WIB.");
    }

    public function render()
    {
        $calonList = $this->getQuery()->latest('id')->paginate(10);

        $pewawancaraList = User::where('role', UserRole::PEWAWANCARA)
            ->orderBy('name')
            ->get();

        $totalWaiting = CalonSiswa::where('status_pendaftaran', StatusPendaftaran::MENUNGGU_WAWANCARA)->count();

        return view('livewire.admin.bulk-assignment-wawancara', [
            'calonList' => $calonList,
            'pewawancaraList' => $pewawancaraList,
            'totalWaiting' => $totalWaiting,
        ]);
    }
}
