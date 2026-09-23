<?php

namespace App\Livewire\Admin;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenPengguna extends Component
{
    use WithPagination;

    // ── FILTER & SEARCH ──
    public string $search = '';
    public string $filterRole = '';
    public string $sortBy = 'created_at';
    public string $sortDir = 'desc';

    // ── MODAL STATE ──
    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public bool $showResetModal = false;
    public bool $isEditing = false;

    // ── FORM FIELDS ──
    public ?int $userId = null;
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $role = '';
    public string $password = '';
    public string $password_confirmation = '';

    // ── RESET PW ──
    public string $newPassword = '';
    public string $newPassword_confirmation = '';
    public ?int $resetUserId = null;
    public string $resetUserName = '';

    // ── DELETE ──
    public ?int $deleteUserId = null;
    public string $deleteUserName = '';

    protected function rules(): array
    {
        $passwordRule = $this->isEditing
            ? 'nullable|string|min:8|confirmed'
            : 'required|string|min:8|confirmed';

        return [
            'name'     => 'required|string|max:100',
            'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($this->userId)],
            'phone'    => 'nullable|string|max:20',
            'role'     => ['required', Rule::in(array_column(UserRole::cases(), 'value'))],
            'password' => $passwordRule,
        ];
    }

    protected $messages = [
        'name.required'              => 'Nama wajib diisi.',
        'email.required'             => 'Email wajib diisi.',
        'email.email'                => 'Format email tidak valid.',
        'email.unique'               => 'Email ini sudah digunakan.',
        'role.required'              => 'Role wajib dipilih.',
        'password.required'          => 'Password wajib diisi untuk pengguna baru.',
        'password.min'               => 'Password minimal 8 karakter.',
        'password.confirmed'         => 'Konfirmasi password tidak cocok.',
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilterRole(): void
    {
        $this->resetPage();
    }

    public function sortColumn(string $col): void
    {
        if ($this->sortBy === $col) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy  = $col;
            $this->sortDir = 'asc';
        }
    }

    // ── OPEN MODALS ──
    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $user = User::findOrFail($id);
        $this->resetForm();
        $this->isEditing          = true;
        $this->userId             = $user->id;
        $this->name               = $user->name;
        $this->email              = $user->email;
        $this->phone              = $user->phone ?? '';
        $this->role               = $user->role instanceof UserRole ? $user->role->value : $user->role;
        $this->showModal          = true;
    }

    public function openDelete(int $id): void
    {
        $user                   = User::findOrFail($id);
        $this->deleteUserId     = $id;
        $this->deleteUserName   = $user->name;
        $this->showDeleteModal  = true;
    }

    public function openReset(int $id): void
    {
        $user                    = User::findOrFail($id);
        $this->resetUserId       = $id;
        $this->resetUserName     = $user->name;
        $this->newPassword       = '';
        $this->newPassword_confirmation = '';
        $this->showResetModal    = true;
    }

    // ── SAVE / UPDATE ──
    public function save(): void
    {
        $this->validate();

        $data = [
            'name'  => trim($this->name),
            'email' => trim($this->email),
            'phone' => trim($this->phone) ?: null,
            'role'  => $this->role,
        ];

        if (!$this->isEditing || filled($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->isEditing) {
            User::findOrFail($this->userId)->update($data);
            session()->flash('success', 'Pengguna berhasil diperbarui.');
        } else {
            User::create($data);
            session()->flash('success', 'Pengguna baru berhasil ditambahkan.');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    // ── DELETE ──
    public function confirmDelete(): void
    {
        if (!$this->deleteUserId) return;

        // Prevent deleting yourself
        if ($this->deleteUserId === auth()->id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            $this->showDeleteModal = false;
            return;
        }

        User::findOrFail($this->deleteUserId)->delete();
        session()->flash('success', "Pengguna \"{$this->deleteUserName}\" berhasil dihapus.");
        $this->showDeleteModal = false;
        $this->deleteUserId   = null;
        $this->deleteUserName = '';
    }

    // ── RESET PASSWORD ──
    public function confirmReset(): void
    {
        $this->validate([
            'newPassword'              => 'required|string|min:8|confirmed',
            'newPassword_confirmation' => 'required|string',
        ], [
            'newPassword.required'   => 'Password baru wajib diisi.',
            'newPassword.min'        => 'Password minimal 8 karakter.',
            'newPassword.confirmed'  => 'Konfirmasi password tidak cocok.',
        ]);

        User::findOrFail($this->resetUserId)->update([
            'password' => Hash::make($this->newPassword),
        ]);

        session()->flash('success', "Password \"{$this->resetUserName}\" berhasil direset.");
        $this->showResetModal = false;
        $this->resetUserId    = null;
    }

    private function resetForm(): void
    {
        $this->userId               = null;
        $this->name                 = '';
        $this->email                = '';
        $this->phone                = '';
        $this->role                 = '';
        $this->password             = '';
        $this->password_confirmation = '';
        $this->resetValidation();
    }

    #[Computed]
    public function users()
    {
        return User::query()
            ->when($this->search, fn($q) =>
                $q->where(fn($q2) =>
                    $q2->where('name', 'like', "%{$this->search}%")
                       ->orWhere('email', 'like', "%{$this->search}%")
                       ->orWhere('phone', 'like', "%{$this->search}%")
                )
            )
            ->when($this->filterRole, fn($q) =>
                $q->where('role', $this->filterRole)
            )
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate(15);
    }

    #[Computed]
    public function roleCounts(): array
    {
        return User::selectRaw('role, count(*) as total')
            ->groupBy('role')
            ->pluck('total', 'role')
            ->toArray();
    }

    #[Computed]
    public function roles(): array
    {
        return UserRole::cases();
    }

    public function render()
    {
        return view('livewire.admin.manajemen-pengguna');
    }
}
