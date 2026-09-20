<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KumiteSenshuLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'kumite_report_id',
        'sequence',
        'corner',
        'status',
        'notes',
    ];

    public function kumiteReport(): BelongsTo
    {
        return $this->belongsTo(KumiteReport::class, 'kumite_report_id');
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
