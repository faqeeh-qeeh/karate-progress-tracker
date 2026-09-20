<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_session_id',
        'kohai_id',
        'scanned_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'scanned_at' => 'datetime',
        ];
    }

    /**
     * Relasi ke Sesi Absensi
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(AttendanceSession::class, 'attendance_session_id');
    }

    public function attendanceSession(): BelongsTo
    {
        return $this->session();
    }

    /**
     * Relasi ke Kohai (User)
     */
    public function kohai(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kohai_id');
    }
}
