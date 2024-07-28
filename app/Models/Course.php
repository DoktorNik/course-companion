<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int id
 * @property string code
 * @property string name
 * @property string duration
 * @property ?string isRequiredByMajor the major that this course is required by (eg. COSC)
 * @property ?string concentration
 * @property ?int minimumGrade
 * @property int prereqCreditCount
 * @property int prereqCreditCountMajor
 * @property ?string prereqs
 */
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
        'isRequiredByMajor',
        'minimumGrade',
    ];

    protected function casts(): array
    {
        return [
            'prereqs' => 'array',
            'concentration' => 'array',
        ];
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function completedCourses(): BelongsToMany
    {
        return $this->belongsToMany(CompletedCourses::class, 'completed_courses_courses');
    }

    public function EligibleCoursesMajor(): BelongsToMany
    {
        return $this->BelongsToMany(EligibleCoursesMajor::class, 'eligible_courses_major_courses');
    }

    /**
     * TODO: remove once 'eligible_courses_concentration_courses' table is gone
     * @deprecated use `eligibleConcentrationStudents()` instead
     */
    public function EligibleCoursesConcentration(): BelongsToMany
    {
        return $this->BelongsToMany(EligibleCoursesConcentration::class, 'eligible_courses_concentration_courses');
    }

    public function eligibleConcentrationStudents(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'eligible_concentration_courses');
    }

    public function EligibleCoursesElectiveMajor(): BelongsToMany
    {
        return $this->BelongsToMany(EligibleCoursesElectiveMajor::class, 'eligible_courses_elective_major_courses');
    }

    public function EligibleCoursesElective(): BelongsToMany
    {
        return $this->BelongsToMany(EligibleCoursesElective::class, 'eligible_courses_elective_courses');
    }

    public function CourseFeedback(): HasMany
    {
        return $this->hasMany(CourseFeedback::class);
    }
}
