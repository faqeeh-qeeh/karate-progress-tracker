<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'type',
        'title',
        'start_time',
        'end_time',
        'days_of_week',
        'start_date',
        'end_date',
        'specific_date',
        'location_type',
        'location_detail',
        'maps_url',
        'email_reminder',
        'reminder_time',
        'notes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'days_of_week'   => 'array',
            'start_date'     => 'date',
            'end_date'       => 'date',
            'specific_date'  => 'date',
            'email_reminder' => 'boolean',
            'is_active'      => 'boolean',
        ];
    }

    /**
     * Relasi ke User (admin pembuat jadwal)
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Dapatkan label tipe jadwal dalam bahasa Indonesia
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'rutin'    => 'Latihan Rutin',
            'tambahan' => 'Latihan Tambahan',
            default    => 'Latihan',
        };
    }

    /**
     * Dapatkan label lokasi
     */
    public function getLocationLabelAttribute(): string
    {
        return $this->location_type === 'polindra' ? 'Polindra' : 'Luar Polindra';
    }

    /**
     * Dapatkan jam latihan terformat (e.g., "15.00 – 17.00")
     */
    public function getTimeRangeAttribute(): string
    {
        $start = substr($this->start_time, 0, 5);
        $start = str_replace(':', '.', $start);

        if ($this->end_time) {
            $end = substr($this->end_time, 0, 5);
            $end = str_replace(':', '.', $end);
            return "{$start} – {$end}";
        }

        return "Mulai {$start}";
    }

    /**
     * Dapatkan hari latihan sebagai string (e.g., "Senin, Rabu, Jumat")
     */
    public function getDaysStringAttribute(): string
    {
        if ($this->type === 'tambahan') {
            return $this->specific_date
                ? $this->specific_date->translatedFormat('l, d F Y')
                : '-';
        }

        if (!empty($this->days_of_week)) {
            return implode(', ', $this->days_of_week);
        }

        return '-';
    }

    /**
     * Scope: hanya jadwal aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Ambil jadwal mendatang (untuk widget dashboard)
     * Mengembalikan jadwal yang relevan dalam N hari ke depan
     */
    public static function getUpcoming(int $days = 7): \Illuminate\Database\Eloquent\Collection
    {
        $today = Carbon::today();
        $until = Carbon::today()->addDays($days);
        $todayDayName = self::getDayNameId($today->dayOfWeek);

        return static::active()
            ->where(function ($q) use ($today, $until, $todayDayName) {
                // Latihan Tambahan: specific_date dalam rentang
                $q->where(function ($q2) use ($today, $until) {
                    $q2->where('type', 'tambahan')
                        ->whereBetween('specific_date', [$today, $until]);
                })
                // Latihan Rutin: masih dalam periode berlaku
                ->orWhere(function ($q2) use ($today) {
                    $q2->where('type', 'rutin')
                        ->where('start_date', '<=', $today)
                        ->where(function ($q3) use ($today) {
                            $q3->whereNull('end_date')
                                ->orWhere('end_date', '>=', $today);
                        });
                });
            })
            ->orderByRaw("CASE WHEN type = 'tambahan' THEN specific_date ELSE start_date END ASC")
            ->orderBy('start_time')
            ->get();
    }

    /**
     * Dapatkan tanggal pelaksanaan terdekat (tanggal riil mendatang).
     * Sangat berguna untuk email pengingat dan widget jadwal.
     */
    public function getNextOccurrenceDate(?Carbon $fromDate = null): ?Carbon
    {
        $from = $fromDate ? $fromDate->copy()->startOfDay() : Carbon::today();

        if ($this->type === 'tambahan') {
            return $this->specific_date ? $this->specific_date->copy() : null;
        }

        if (empty($this->days_of_week) || !is_array($this->days_of_week)) {
            return null;
        }

        $dayMap = [
            'minggu' => 0,
            'senin'  => 1,
            'selasa' => 2,
            'rabu'   => 3,
            'kamis'  => 4,
            'jumat'  => 5,
            'sabtu'  => 6,
        ];

        $targetDays = [];
        foreach ($this->days_of_week as $d) {
            $key = strtolower(trim($d));
            if (isset($dayMap[$key])) {
                $targetDays[] = $dayMap[$key];
            }
        }

        if (empty($targetDays)) {
            return null;
        }

        for ($i = 0; $i <= 14; $i++) {
            $checkDate = $from->copy()->addDays($i);

            if ($this->start_date && $checkDate->lt($this->start_date)) {
                continue;
            }
            if ($this->end_date && $checkDate->gt($this->end_date)) {
                continue;
            }

            if (in_array($checkDate->dayOfWeek, $targetDays)) {
                return $checkDate;
            }
        }

        return null;
    }

    /**
     * Dapatkan format tanggal pelaksanaan mendatang dalam Bahasa Indonesia
     * Contoh: "Jumat, 25 September 2026"
     */
    public function getUpcomingDateFormattedAttribute(): string
    {
        $nextDate = $this->getNextOccurrenceDate();
        if ($nextDate) {
            return self::formatIndonesianDate($nextDate);
        }

        return $this->days_string;
    }

    /**
     * Format tanggal menjadi Bahasa Indonesia lengkap (e.g., "Jumat, 25 September 2026")
     */
    public static function formatIndonesianDate(Carbon $date): string
    {
        $dayName = self::getDayNameId($date->dayOfWeek);
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        $monthName = $months[$date->month] ?? $date->format('F');

        return "{$dayName}, {$date->day} {$monthName} {$date->year}";
    }

    /**
     * Cek apakah jadwal ini terjadi pada tanggal tertentu
     */
    public function occursOn(Carbon $date): bool
    {
        if ($this->type === 'tambahan') {
            return $this->specific_date && $this->specific_date->isSameDay($date);
        }

        // Rutin: cek apakah tanggal dalam periode dan hari cocok
        if ($this->start_date > $date) {
            return false;
        }
        if ($this->end_date && $this->end_date < $date) {
            return false;
        }

        $dayName = self::getDayNameId($date->dayOfWeek);
        return in_array($dayName, $this->days_of_week ?? []);
    }

    /**
     * Dapatkan nama hari dalam Bahasa Indonesia
     */
    public static function getDayNameId(int $dayOfWeek): string
    {
        return match($dayOfWeek) {
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            default => '',
        };
    }
}
