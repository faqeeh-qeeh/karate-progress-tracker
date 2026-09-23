<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'athlete_name',
        'event_name',
        'title',
        'medal_type',
        'event_date',
        'location',
        'description',
        'is_featured',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Dapatkan nama atlet yang tampil (dari relasi user atau nama manual).
     */
    public function getAthleteDisplayNameAttribute(): string
    {
        if ($this->user) {
            return $this->user->name;
        }

        return $this->athlete_name ?: 'Atlet Karate Polindra';
    }

    /**
     * Dapatkan ikon emoji medali.
     */
    public function getMedalEmojiAttribute(): string
    {
        return match ($this->medal_type) {
            'gold' => '🥇',
            'silver' => '🥈',
            'bronze' => '🥉',
            'trophy' => '🏆',
            default => '🎖️',
        };
    }

    /**
     * Dapatkan label medali dalam Bahasa Indonesia.
     */
    public function getMedalLabelAttribute(): string
    {
        return match ($this->medal_type) {
            'gold' => 'Medali Emas',
            'silver' => 'Medali Perak',
            'bronze' => 'Medali Perunggu',
            'trophy' => 'Juara Umum / Trophy',
            default => 'Penghargaan',
        };
    }

    /**
     * Dapatkan CSS class badge medali.
     */
    public function getMedalClassAttribute(): string
    {
        return match ($this->medal_type) {
            'gold' => 'medal-gold',
            'silver' => 'medal-silver',
            'bronze' => 'medal-bronze',
            'trophy' => 'medal-gold',
            default => 'medal-silver',
        };
    }

    /**
     * Dapatkan string meta lokasi & tanggal format Indonesia (e.g. "Jakarta · Agustus 2024").
     */
    public function getFormattedMetaAttribute(): string
    {
        $parts = [];

        if (!empty($this->location)) {
            $parts[] = $this->location;
        }

        if ($this->event_date) {
            $parts[] = Carbon::parse($this->event_date)->translatedFormat('F Y');
        }

        return implode(' · ', $parts);
    }

    /**
     * Scope untuk prestasi yang dipublish.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope untuk urutan tampilan default.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')
            ->orderBy('event_date', 'desc')
            ->orderBy('id', 'desc');
    }
}
