<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Profil data calon siswa (jika role siswa).
     */
    public function calonSiswa(): HasOne
    {
        return $this->hasOne(CalonSiswa::class, 'user_id');
    }

    /**
     * Sesi wawancara yang dilakukan oleh user bertindak sebagai pewawancara.
     */
    public function sesiWawancara(): HasMany
    {
        return $this->hasMany(Wawancara::class, 'pewawancara_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    /**
     * Check if user matches one or more roles.
     */
    public function hasRole(UserRole|string ...$roles): bool
    {
        foreach ($roles as $r) {
            $roleValue = $r instanceof UserRole ? $r->value : $r;
            $currentRole = $this->role instanceof UserRole ? $this->role->value : $this->role;
            if ($currentRole === $roleValue) {
                return true;
            }
        }

        return false;
    }

    /**
     * Role checking helper shortcuts.
     */
    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    public function isBendahara(): bool
    {
        return $this->role === UserRole::BENDAHARA;
    }

    public function isPewawancara(): bool
    {
        return $this->role === UserRole::PEWAWANCARA;
    }

    public function isSiswa(): bool
    {
        return $this->role === UserRole::SISWA;
    }

    public function isKepsek(): bool
    {
        return $this->role === UserRole::KEPSEK;
    }
}
