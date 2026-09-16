<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'type',
    'rank_id',
    'study_program_id',
    'academic_class_id',
    'nim',
    'enrollment_year',
    'high_school',
    'institution',
    'weight',
    'height',
    'emergency_contact_name',
    'emergency_contact_phone',
])]
class KohaiProfile extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'enrollment_year' => 'integer',
            'weight' => 'decimal:2',
            'height' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class);
    }

    public function studyProgram(): BelongsTo
    {
        return $this->belongsTo(StudyProgram::class);
    }

    public function academicClass(): BelongsTo
    {
        return $this->belongsTo(AcademicClass::class, 'academic_class_id');
    }

    public function isPolindra(): bool
    {
        return $this->type === 'polindra';
    }

    public function isNonPolindra(): bool
    {
        return $this->type === 'non_polindra';
    }
}
