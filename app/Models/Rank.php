<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['belt_id', 'category', 'name', 'order', 'description'])]
class Rank extends Model
{
    use HasFactory;

    public function belt(): BelongsTo
    {
        return $this->belongsTo(Belt::class);
    }
}
