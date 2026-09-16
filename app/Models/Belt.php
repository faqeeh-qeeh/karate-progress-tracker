<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'color_code', 'description'])]
class Belt extends Model
{
    use HasFactory;

    public function ranks(): HasMany
    {
        return $this->hasMany(Rank::class)->orderBy('order', 'asc');
    }
}
