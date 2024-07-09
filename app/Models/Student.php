<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    protected $fillable  = [
        'name',
        'number',
        'major',
        'concentration',
        'creditsCompleted',
        'creditsCompletedMajor',
        'coursesCompleted',
    ];

    protected $casts = [
        'coursesCompleted' => 'array',
        'eligibleRequiredCourses' => 'array',
        'eligibleConcentrationCourses' =>'array',
        'eligibleElectiveMajorCourses' => 'array',
        'eligibleElectiveNonMajorCourses' => 'array',
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
