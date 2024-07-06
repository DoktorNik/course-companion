<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    protected $fillable  = [
        'studentName',
        'studentNumber',
        'major',
        'majorCreditsCompleted',
        'coursesCompleted',
        'eligibleCourses',
        'creditsCompleted',
        'concentration',
    ];

    protected $casts = [
        'coursesCompleted' => 'array',
        'eligibleRequiredCourses' => 'array',
        'eligibleElectiveMajorCourses' => 'array',
        'eligibleElectiveNonMajorCourses' => 'array',
        'eligibleConcentrationCourses' =>'array',
    ];

    /*
    protected function casts(): array
    {
        return [
            'coursesCompleted' => 'array',
            'eligibleCourses' => 'array',
        ];
    }
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
