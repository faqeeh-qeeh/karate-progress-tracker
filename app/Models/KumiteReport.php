<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KumiteReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'senpai_id',
        'aka_kohai_id',
        'ao_kohai_id',
        'match_date',
        'match_time',
        'duration_seconds',
        'senshu_corner',
        'aka_ippon',
        'aka_wazaari',
        'aka_yuko',
        'aka_fouls',
        'aka_score_attack',
        'aka_score_accuracy',
        'aka_total_score',
        'aka_evaluation_notes',
        'ao_ippon',
        'ao_wazaari',
        'ao_yuko',
        'ao_fouls',
        'ao_score_attack',
        'ao_score_accuracy',
        'ao_total_score',
        'ao_evaluation_notes',
        'winner_id',
    ];

    protected $casts = [
        'match_date' => 'date',
        'duration_seconds' => 'integer',
        'aka_score_accuracy' => 'float',
        'ao_score_accuracy' => 'float',
        'aka_fouls' => 'integer',
        'ao_fouls' => 'integer',
    ];

    public function getFormattedDurationAttribute(): string
    {
        $duration = $this->duration_seconds ?: 180;
        $minutes = floor($duration / 60);
        $seconds = $duration % 60;
        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    public function getHumanDurationAttribute(): string
    {
        $duration = $this->duration_seconds ?: 180;
        $minutes = floor($duration / 60);
        $seconds = $duration % 60;
        if ($seconds > 0) {
            return "{$minutes}m {$seconds}s";
        }
        return "{$minutes} Menit";
    }

    public function senpai(): BelongsTo
    {
        return $this->belongsTo(User::class, 'senpai_id');
    }

    public function akaKohai(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aka_kohai_id');
    }

    public function aoKohai(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ao_kohai_id');
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function senshuLogs()
    {
        return $this->hasMany(KumiteSenshuLog::class, 'kumite_report_id')->orderBy('sequence', 'asc');
    }

    public function hasAkaSenshu(): bool
    {
        return $this->senshu_corner === 'aka';
    }

    public function hasAoSenshu(): bool
    {
        return $this->senshu_corner === 'ao';
    }

    public function hasSenshu(): bool
    {
        return in_array($this->senshu_corner, ['aka', 'ao']);
    }

    public static function calculatePoints(int $ippon, int $wazaari, int $yuko): int
    {
        return ($ippon * 3) + ($wazaari * 2) + ($yuko * 1);
    }
}
