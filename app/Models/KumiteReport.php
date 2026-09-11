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
        'senshu_corner',
        'aka_ippon',
        'aka_wazaari',
        'aka_yuko',
        'aka_c1',
        'aka_c2',
        'aka_ce',
        'aka_hc',
        'aka_h',
        'aka_score_attack',
        'aka_score_accuracy',
        'aka_total_score',
        'aka_evaluation_notes',
        'ao_ippon',
        'ao_wazaari',
        'ao_yuko',
        'ao_c1',
        'ao_c2',
        'ao_ce',
        'ao_hc',
        'ao_h',
        'ao_score_attack',
        'ao_score_accuracy',
        'ao_total_score',
        'ao_evaluation_notes',
        'winner_id',
    ];

    protected $casts = [
        'match_date' => 'date',
        'aka_ce' => 'boolean',
        'aka_hc' => 'boolean',
        'aka_h' => 'boolean',
        'ao_ce' => 'boolean',
        'ao_hc' => 'boolean',
        'ao_h' => 'boolean',
    ];

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

    public function hasAkaSenshu(): bool
    {
        return $this->senshu_corner === 'aka';
    }

    public function hasAoSenshu(): bool
    {
        return $this->senshu_corner === 'ao';
    }

    public static function calculatePoints(int $ippon, int $wazaari, int $yuko): int
    {
        return ($ippon * 3) + ($wazaari * 2) + ($yuko * 1);
    }
}
