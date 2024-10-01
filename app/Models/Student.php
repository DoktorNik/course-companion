<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'creditsCompleted',
        'creditsCompletedMajor',
        'creditsCompletedFirstYear',
        'electivesCompletedSecondYear',
    ];

    protected static function booted(): void
    {
        static::saved(function (self $student) {
            static::withoutEvents(function () use ($student) {
                $student->refresh(); // to get the latest relation data
                DB::transaction(function () use ($student) {
                    $student->updateCreditsCompleted();
                    $student->updateEligibleCourses();
                });
            });
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
            $this->save(); // to activate the `static::saved` hook
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

    private function hasCompleted(Course $course): bool
    {
        return $this->completedCoursesV2
            ->some(fn(Course $c) => $course->code === $c->code);
    }

    private function hasSatisfiedPrerequisitesFor(Course $course): bool
    {
        return collect($course->prereqs)
            ->reject(fn(string $code, string $name) => $code === 'MATH 1P20') // override for a course most people aren't actually required to take
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
    }

    private function markAsNoLongerEligibleForConcentrationCourse(Course $course): void
    {
        $this->eligibleConcentrationCourses()->detach($course);
    }

    private function markAsNoLongerEligibleForMajorCourse(Course $course): void
    {
        $this->eligibleMajorCourses()->detach($course);
    }

    private function markAsNoLongerEligibleForElectiveMajorCourse(Course $course): void
    {
        $this->eligibleElectiveMajorCourses()->detach($course);
    }

    private function markAsNoLongerEligibleForElectiveCourse(Course $course): void
    {
        $this->eligibleElectiveCourses()->detach($course);
    }

    private function markAsEligibleForConcentrationCourse(Course $course): void
    {
        /* `syncWithoutDetaching` works similar to `attach`
         * but doesn't raise an exception when the record already exists
         * which is what we want */
        $this->eligibleConcentrationCourses()->syncWithoutDetaching($course);
    }

    private function markAsEligibleForMajorCourse(Course $course): void
    {
        /* `syncWithoutDetaching` works similar to `attach`
         * but doesn't raise an exception when the record already exists
         * which is what we want */
        $this->eligibleMajorCourses()->syncWithoutDetaching($course);
    }

    private function markAsEligibleForElectiveMajorCourse(Course $course): void
    {
        /* `syncWithoutDetaching` works similar to `attach`
         * but doesn't raise an exception when the record already exists
         * which is what we want */
        $this->eligibleElectiveMajorCourses()->syncWithoutDetaching($course);
    }

    private function markAsEligibleForElectiveCourse(Course $course): void
    {
        /* `syncWithoutDetaching` works similar to `attach`
         * but doesn't raise an exception when the record already exists
         * which is what we want */
        $this->eligibleElectiveCourses()->syncWithoutDetaching($course);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function completedCoursesV2(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'completed_courses_v2');
    }

    public function eligibleMajorCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'eligible_major_courses');
    }

    public function eligibleConcentrationCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'eligible_concentration_courses');
    }

    public function eligibleElectiveMajorCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'eligible_elective_major_courses');
    }

    public function eligibleContextCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'eligible_context_courses');
    }

    public function eligibleElectiveCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'eligible_elective_courses');
    }

}
