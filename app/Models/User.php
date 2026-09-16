<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role_id', 'birth_place', 'birth_date', 'gender', 'address', 'phone'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birth_date' => 'date',
            'password' => 'hashed',
        ];
    }

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole(string $roleName): bool
    {
        if (!$this->role) {
            return false;
        }

        return strcasecmp($this->role->nama, $roleName) === 0;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isSenpai(): bool
    {
        return $this->hasRole('Senpai');
    }

    public function isKohai(): bool
    {
        return $this->hasRole('Kohai');
    }

    public function getDashboardRoute(): string
    {
        if ($this->isAdmin()) {
            return route('admin.dashboard');
        } elseif ($this->isSenpai()) {
            return route('senpai.dashboard');
        } elseif ($this->isKohai()) {
            return route('kohai.dashboard');
        }

        return route('login');
    }

    public function kumiteAsSenpai(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(KumiteReport::class, 'senpai_id');
    }

    public function kumiteAsAka(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(KumiteReport::class, 'aka_kohai_id');
    }

    public function kumiteAsAo(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(KumiteReport::class, 'ao_kohai_id');
    }

    public function allKohaiKumiteReports()
    {
        return KumiteReport::where('aka_kohai_id', $this->id)
            ->orWhere('ao_kohai_id', $this->id);
    }

    public function attendanceSessionsAsSenpai(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AttendanceSession::class, 'senpai_id');
    }

    public function attendancesAsKohai(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Attendance::class, 'kohai_id');
    }
}
