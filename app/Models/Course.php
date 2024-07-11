<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'duration',
        'prereqCreditCount',
        'prereqCreditCountMajor',
        'name',
        'prereqs',
        'concentration',
        'isisRequiredByMajor',
        'minimumGrade',
    ];

    protected function casts(): array
    {
        return [
            'prereqs' => 'array',
            'concentration' => 'array',
        ];
    }

    public function CompletedCourses(): BelongsToMany
    {
        return $this->belongsToMany(CompletedCourses::class, 'completed_courses_courses');
    }
    public function EligibleCoursesMajor(): BelongsToMany
    {
        return $this->BelongsToMany(EligibleCoursesMajor::class, 'eligible_courses_major_courses');
    }
    public function EligibleCoursesConcentration(): BelongsToMany
    {
        return $this->BelongsToMany(EligibleCoursesConcentration::class, 'eligible_courses_concentration_courses');
    }
    public function EligibleCoursesElectiveMajor(): BelongsToMany
    {
        return $this->BelongsToMany(EligibleCoursesElectiveMajor::class, 'eligible_courses_elective_major_courses');
    }

    public function EligibleCoursesElective(): BelongsToMany
    {
        return $this->BelongsToMany(EligibleCoursesElective::class, 'eligible_courses_elective_courses');
    }

}
