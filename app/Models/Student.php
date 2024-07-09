<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

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
        'eligibleRequiredCourses' => 'array',
        'eligibleConcentrationCourses' =>'array',
        'eligibleElectiveMajorCourses' => 'array',
        'eligibleElectiveNonMajorCourses' => 'array',
    ];
    // 'coursesCompleted' => 'array',

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

   public function studentcoursescompleted(): HasMany
   {
       return $this->hasMany(StudentCoursescompleted::class);
   }
}
