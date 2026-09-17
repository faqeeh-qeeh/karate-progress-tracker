<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role_id', 'birth_place', 'birth_date', 'gender', 'address', 'phone', 'google_id'])]
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

    public function senpaiProfile(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(SenpaiProfile::class);
    }

    public function kohaiProfile(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(KohaiProfile::class);
    }

    /**
     * Dapatkan inisial nama pengguna (misal: "Admin" -> "A", "Adi Jaya" -> "AJ", "Kohai Budi Pratama" -> "BP").
     */
    public function getInitialsAttribute(): string
    {
        $cleanName = trim($this->name ?? '');
        if (empty($cleanName)) {
            return 'U';
        }

        // Pisahkan nama per kata
        $words = array_values(array_filter(preg_split('/\s+/', $cleanName)));

        // Jika lebih dari 1 kata dan diawali kata role murid/senpai umum, ambil nama aslinya
        if (count($words) > 1 && in_array(strtolower($words[0]), ['kohai', 'senpai'])) {
            array_shift($words);
        }

        if (count($words) >= 2) {
            return strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
        } elseif (count($words) === 1) {
            return strtoupper(mb_substr($words[0], 0, 1));
        }

        return 'U';
    }
}
