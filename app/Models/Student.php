<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

/**
 * @property int id
 * @property string name
 * @property int number
 * @property string major
 * @property ?string concentration
 * @property float creditsCompleted
 * @property float creditsCompletedMajor
 * @property float creditsCompletedFirstYear
 * @property float electivesCompletedSecondYear
 * @property Collection<int, Course> eligibleConcentrationCourses
 * @property Collection<int, Course> eligibleMajorCourses
 * @property Collection<int, Course> completedCoursesV2
 * @property Collection<int, Course> eligibleElectiveMajorCourses
 * @property Collection<int, Course> eligibleElectiveCourses
 * @property Collection<int, Course> eligibleContextCourses
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

    protected static function booted(): void
    {
        static::created(function (self $student) {
            $student->fillChildren();
        });
        static::updating(function (self $student) {
            $student->updateCreditsCompleted();
            $student->updateEligibleCourses();
        });
    }

    /**
     * @param array<int, string> $completedCourseCodes
     */
    public function updateCoursesTaken(array $completedCourseCodes): void
    {
        /** @var \Illuminate\Database\Eloquent\Collection<int, Course> $courses */
        $courses = Course::whereIn('code', $completedCourseCodes)->get();
        DB::transaction(function () use ($courses) {
            foreach ($courses as $course) {
                // add to completed
                $this->markAsComplete($course);
                // remove from eligibles
                $this->markAsNoLongerEligibleForMajorCourse($course);
                $this->markAsNoLongerEligibleForConcentrationCourse($course);
                $this->markAsNoLongerEligibleForElectiveMajorCourse($course);
                $this->markAsNoLongerEligibleForElectiveCourse($course);
            }
        });
    }

    private function updateEligibleCourses(): void
    {
        $courses = Course::all()
            ->reject(fn(Course $course) => $this->hasCompleted($course))
            ->filter(fn(Course $course) => $this->creditCountMetFor($course))
            ->filter(fn(Course $course) => $this->hasSatisfiedPrerequisitesFor($course));

        DB::transaction(function () use ($courses) {
            foreach ($courses as $course)
                if ($this->requiresCourseForMajor($course))
                    $this->markAsEligibleForMajorCourse($course);
                elseif ($this->canUseCourseForConcentration($course))
                    $this->markAsEligibleForConcentrationCourse($course);
                elseif ($this->canUseCourseForElectiveMajor($course))
                    $this->markAsEligibleForElectiveMajorCourse($course);
                else
                    $this->markAsEligibleForElectiveCourse($course);
        });
    }

    private function updateCreditsCompleted(): void
    {
        $creditsCompleted = $this->completedCoursesV2
            ->sum(fn(Course $course) => $course->credit());

        $creditsCompletedMajor = $this->completedCoursesV2
            ->filter(fn(Course $course) => $this->canUseCourseForMajor($course))
            ->sum(fn(Course $course) => $course->credit());

        $creditsCompletedFirstYear = $this->completedCoursesV2
            ->filter(fn(Course $course) => $course->isForFirstYear())
            ->sum(fn(Course $course) => $course->credit());

        $electivesCompletedSecondYear = $this->completedCoursesV2
            ->filter(fn(Course $course) => !$this->canUseCourseForMajor($course) && !$course->isForFirstYear())
            ->sum(fn(Course $course) => $course->credit());

        $this->update([
            'creditsCompleted' => $creditsCompleted,
            'creditsCompletedMajor' => $creditsCompletedMajor,
            'creditsCompletedFirstYear' => $creditsCompletedFirstYear,
            'electivesCompletedSecondYear' => $electivesCompletedSecondYear,
        ]);
    }

    private function fillChildren(): void
    {
        // setup children if necessary
        if (!isset($this->completedCourses)) { // TODO: remove the following once 'completed_courses_courses' table is gone
            $this->completedCourses()->create();
        }
        if (!isset($this->eligibleCoursesMajor)) { // TODO: remove the following once 'eligible_courses_major_courses' table is gone
            $this->eligibleCoursesMajor()->create();
        }
        if (!isset($this->eligibleCoursesConcentration)) { // TODO: remove the following once 'eligible_courses_concentration_courses' table is gone
            $this->eligibleCoursesConcentration()->create();
        }
        if (!isset($this->eligibleCoursesElectiveMajor)) { // TODO: remove the following once 'eligible_courses_elective_major_courses' table is gone
            $this->eligibleCoursesElectiveMajor()->create();
        }
        if (!isset($this->eligibleCoursesContext)) { // TODO: remove the following once 'eligible_courses_context_courses' table is gone
            $this->eligibleCoursesContext()->create();
        }
        if (!isset($this->eligibleCoursesElective)) { // TODO: remove the following once 'eligible_courses_elective_courses' table is gone
            $this->eligibleCoursesElective()->create();
        }
    }

    private function hasCompleted(Course $course): bool
    {
        return $this->completedCoursesV2
            ->some(fn(Course $c) => $course->code === $c->code);
    }

    private function hasSatisfiedPrerequisitesFor(Course $course): bool
    {
        return collect($course->prereqs)
            ->reject(fn(string $code, string $name) => $code === 'MATH 1P20') // override for a course most people aren't actually required to take // 3
            ->every(fn(string $code, string $name) => $this->hasCompletedCourseWithCode($code));
    }

    private function hasCompletedCourseWithCode(string $code): bool
    {
        return $this->completedCoursesV2
            ->some(fn(Course $c) => $code === $c->code);
    }

    private function creditCountMetFor(Course $course): bool
    {
        return $this->creditsCompleted >= $course->prereqCreditCount
            && $this->creditsCompletedMajor >= $course->prereqCreditCountMajor;
    }

    private function canUseCourseForConcentration(Course $course): bool
    {
        return collect($course->concentration)
            ->some(fn(string $concentration) => $this->concentration === $concentration);
    }

    private function requiresCourseForMajor(Course $course): bool
    {
        return $course->isRequiredByMajor === $this->major;
    }

    private function canUseCourseForMajor(Course $course): bool
    {
        return $this->requiresCourseForMajor($course)
            || $this->major === $course->major();
    }

    private function canUseCourseForElectiveMajor(Course $course): bool
    {
        return !$this->requiresCourseForMajor($course)
            && $course->major() === $this->major;
    }

    private function markAsComplete(Course $course): void
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

    private function markAsNoLongerEligibleForConcentrationCourse(Course $course): void
    {
        $this->eligibleConcentrationCourses()->detach($course);
        // TODO: remove the following once 'eligible_courses_concentration_courses' table is gone
        if (isset($this->eligibleCoursesConcentration)) {
            $course->eligibleCoursesConcentration()->detach($this->eligibleCoursesConcentration);
        }
    }

    private function markAsNoLongerEligibleForMajorCourse(Course $course): void
    {
        $this->eligibleMajorCourses()->detach($course);
        // TODO: remove the following once 'eligible_courses_major_courses' table is gone
        if (isset($this->eligibleCoursesMajor)) {
            $course->eligibleCoursesMajor()->detach($this->eligibleCoursesMajor);
        }
    }

    private function markAsNoLongerEligibleForElectiveMajorCourse(Course $course): void
    {
        $this->eligibleElectiveMajorCourses()->detach($course);
        // TODO: remove the following once 'eligible_courses_elective_major_courses' table is gone
        if (isset($student->eligibleCoursesElectiveMajor)) {
            $course->eligibleCoursesElectiveMajor()->detach($student->eligibleCoursesElectiveMajor);
        }
    }

    private function markAsNoLongerEligibleForElectiveCourse(Course $course): void
    {
        $this->eligibleElectiveCourses()->detach($course);
        // TODO: remove the following once 'eligible_courses_elective_courses' table is gone
        if (isset($student->eligibleCoursesElective)) {
            $course->eligibleCoursesElective()->detach($student->eligibleCoursesElective);
        }
    }

    private function markAsEligibleForConcentrationCourse(Course $course): void
    {
        /* `syncWithoutDetaching` works similar to `attach`
         * but doesn't raise an exception when the record already exists
         * which is what we want */
        $this->eligibleConcentrationCourses()->syncWithoutDetaching($course);
        // TODO: remove the following once 'eligible_courses_concentration_courses' table is gone
        $course->eligibleCoursesConcentration()->attach($this->eligibleCoursesConcentration);
    }

    private function markAsEligibleForMajorCourse(Course $course): void
    {
        /* `syncWithoutDetaching` works similar to `attach`
         * but doesn't raise an exception when the record already exists
         * which is what we want */
        $this->eligibleMajorCourses()->syncWithoutDetaching($course);
        // TODO: remove the following once 'eligible_courses_major_courses' table is gone
        $course->eligibleCoursesMajor()->attach($this->eligibleCoursesMajor);
    }

    private function markAsEligibleForElectiveMajorCourse(Course $course): void
    {
        /* `syncWithoutDetaching` works similar to `attach`
         * but doesn't raise an exception when the record already exists
         * which is what we want */
        $this->eligibleElectiveMajorCourses()->syncWithoutDetaching($course);
        // TODO: remove the following once 'eligible_courses_elective_major_courses' table is gone
        $course->eligibleElectiveMajorStudents()->attach($this->eligibleCoursesMajor);
    }

    private function markAsEligibleForElectiveCourse(Course $course): void
    {
        /* `syncWithoutDetaching` works similar to `attach`
         * but doesn't raise an exception when the record already exists
         * which is what we want */
        $this->eligibleElectiveCourses()->syncWithoutDetaching($course);
        // TODO: remove the following once 'eligible_courses_elective_courses' table is gone
        $course->eligibleElectiveStudents()->attach($this->eligibleCoursesElective);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * TODO: remove once 'completed_courses_courses' table is gone
     * @deprecated use {@link self::completedCoursesV2()} instead
     */
    public function completedCourses(): HasOne
    {
        return $this->hasOne(CompletedCourses::class);
    }

    public function completedCoursesV2(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'completed_courses_v2');
    }

    /**
     * TODO: remove once 'eligible_courses_major_courses' table is gone
     * @deprecated use {@link self::eligibleConcentrationMajors()} instead
     */
    public function EligibleCoursesMajor(): HasOne
    {
        return $this->hasOne(EligibleCoursesMajor::class);
    }

    public function eligibleMajorCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'eligible_major_courses');
    }

    /**
     * TODO: remove once 'eligible_courses_concentration_courses' table is gone
     * @deprecated use {@link self::eligibleConcentrationCourses()} instead
     */
    public function EligibleCoursesConcentration(): hasOne
    {
        return $this->hasOne(EligibleCoursesConcentration::class);
    }

    public function eligibleConcentrationCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'eligible_concentration_courses');
    }

    /**
     * TODO: remove once 'eligible_courses_elective_major_courses' table is gone
     * @deprecated use {@link self::eligibleElectiveMajorCourses()} instead
     */
    public function EligibleCoursesElectiveMajor(): hasOne
    {
        return $this->hasOne(EligibleCoursesElectiveMajor::class);
    }

    public function eligibleElectiveMajorCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'eligible_elective_major_courses');
    }

    /**
     * TODO: remove once 'eligible_courses_context_courses' table is gone
     * @deprecated use {@link self::eligibleContextCourses()} instead
     */
    public function EligibleCoursesContext(): hasOne
    {
        return $this->hasOne(EligibleCoursesContext::class);
    }

    public function eligibleContextCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'eligible_context_courses');
    }

    /**
     * TODO: remove once 'eligible_courses_elective_courses' table is gone
     * @deprecated use {@link self::eligibleElectiveCourses()} instead
     */
    public function EligibleCoursesElective(): hasOne
    {
        return $this->hasOne(EligibleCoursesElective::class);
    }

    public function eligibleElectiveCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'eligible_elective_courses');
    }

}
