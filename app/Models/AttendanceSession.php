<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class AttendanceSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'senpai_id',
        'title',
        'date',
        'qr_token',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relasi ke Senpai (User)
     */
    public function senpai(): BelongsTo
    {
        return $this->belongsTo(User::class, 'senpai_id');
    }

    /**
     * Relasi ke daftar Presensi Kohai
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'attendance_session_id');
    }

    /**
     * Nonaktifkan semua sesi absensi aktif milik Senpai tertentu
     */
    public static function deactivatePreviousForSenpai(int $senpaiId): void
    {
        static::where('senpai_id', $senpaiId)
            ->where('is_active', true)
            ->update(['is_active' => false]);
    }

    /**
     * Cari sesi absensi pada tanggal tertentu untuk Senpai ini (jika ada)
     */
    public static function findExistingForDate(int $senpaiId, string $date): ?self
    {
        return static::where('senpai_id', $senpaiId)
            ->whereDate('date', $date)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Aktifkan kembali sesi absensi yang ada (melanjutkan sesi)
     */
    public function reactivate(): self
    {
        // Nonaktifkan sesi aktif lainnya milik Senpai ini
        static::deactivatePreviousForSenpai($this->senpai_id);

        $this->update(['is_active' => true]);

        return $this;
    }

    /**
     * Generate sesi baru dengan otomatis me-nonaktifkan sesi lama
     */
    public static function createNewSession(int $senpaiId, string $title, string $date): self
    {
        // Nonaktifkan sesi sebelumnya milik Senpai ini
        static::deactivatePreviousForSenpai($senpaiId);

        // Generate token pendek unik 6 karakter (misal: "X7B29A")
        do {
            $token = strtoupper(Str::random(6));
        } while (static::where('qr_token', $token)->exists());

        return static::create([
            'senpai_id' => $senpaiId,
            'title' => $title,
            'date' => $date,
            'qr_token' => $token,
            'is_active' => true,
        ]);
    }
}
