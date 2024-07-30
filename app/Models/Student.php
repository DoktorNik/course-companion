<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int id
 * @property string name
 * @property int number
 * @property string major
 * @property ?string concentration
 * @property float creditsCompleted
 * @property float creditsCompletedMajor
 * @property Collection<int, Course> eligibleConcentrationCourses
 * @property Collection<int, Course> completedCoursesV2
 */
class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number',
        'major',
        'concentration',
    ];

    public function markAsComplete(Course $course): void
    {
        /* `syncWithoutDetaching` works similar to `attach`
         * but doesn't raise an exception when the record already exists
         * which is what we want */
        $this->completedCoursesV2()->syncWithoutDetaching($course);
        // TODO: remove the following once 'completed_courses_courses' table is gone
        if (is_null($this->completedCourses))
            $this->completedCourses()->create();
        $course->completedCourses()->attach($this->completedCourses);
    }

    public function markAsNoLongerEligibleForConcentrationCourse(Course $course): void
    {
        $this->eligibleConcentrationCourses()->detach($course);
        // TODO: remove the following once 'eligible_courses_concentration_courses' table is gone
        if (isset($this->eligibleCoursesConcentration)) {
            $course->eligibleCoursesConcentration()->detach($this->eligibleCoursesConcentration);
        }
    }

    public function markAsEligibleForConcentrationCourse(Course $course): void
    {
        /* `syncWithoutDetaching` works similar to `attach`
         * but doesn't raise an exception when the record already exists
         * which is what we want */
        $this->eligibleConcentrationCourses()->syncWithoutDetaching($course);
        // TODO: remove the following once 'eligible_courses_concentration_courses' table is gone
        $course->eligibleCoursesConcentration()->attach($this->eligibleCoursesConcentration);
    }

    public function fillChildren(): void
    {
        // setup children if necessary
        if (!isset($this->completedCourses)) { // TODO: remove the following once 'completed_courses_courses' table is gone
            $this->completedCourses()->create();
        }
        if (!isset($this->eligibleCoursesMajor)) {
            $this->eligibleCoursesMajor()->create();
        }
        if (!isset($this->eligibleCoursesConcentration)) { // TODO: remove the following once 'eligible_courses_concentration_courses' table is gone
            $this->eligibleCoursesConcentration()->create();
        }
        if (!isset($this->eligibleCoursesElectiveMajor)) {
            $this->eligibleCoursesElectiveMajor()->create();
        }
        if (!isset($this->eligibleCoursesContext)) {
            $this->eligibleCoursesContext()->create();
        }
        if (!isset($this->eligibleCoursesElective)) {
            $this->eligibleCoursesElective()->create();
        }
        $this->save();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * TODO: remove once 'completed_courses_courses' table is gone
     * @deprecated use `completedCoursesV2()` instead
     */
    public function completedCourses(): HasOne
    {
        return $this->hasOne(CompletedCourses::class);
    }

    public function completedCoursesV2(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'completed_courses_v2');
    }

    public function EligibleCoursesMajor(): HasOne
    {
        return $this->hasOne(EligibleCoursesMajor::class);
    }

    /**
     * TODO: remove once 'eligible_courses_concentration_courses' table is gone
     * @deprecated use `eligibleConcentrationCourses()` instead
     */
    public function EligibleCoursesConcentration(): hasOne
    {
        return $this->hasOne(EligibleCoursesConcentration::class);
    }

    public function eligibleConcentrationCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'eligible_concentration_courses');
    }

    public function EligibleCoursesElectiveMajor(): hasOne
    {
        return $this->hasOne(EligibleCoursesElectiveMajor::class);
    }

    public function EligibleCoursesContext(): hasOne
    {
        return $this->hasOne(EligibleCoursesContext::class);
    }

    public function EligibleCoursesElective(): hasOne
    {
        return $this->hasOne(EligibleCoursesElective::class);
    }

}
