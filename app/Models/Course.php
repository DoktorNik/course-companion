<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

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
 * @property Collection<int, Student> eligibleConcentrationStudents
 * @property Collection<int, Student> eligibleMajorStudents
 * @property Collection<int, Student> eligibleElectiveStudents
 * @property Collection<int, Student> eligibleElectiveMajorStudents
 * @property Collection<int, Student> completedStudents
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

    /**
     * the 4-letter department name in the course code
     * eg.
     * ```
     * Course(code='COSC 1P02')->major() === 'COSC'
     * ```
     * @return string
     */
    public function major(): string
    {
        return Str::substr($this->code, 0, 4);
    }

    public function credit(): float
    {
        if (Str::substr($this->code, 6, 1) == "P") {
            return 0.5;
        } elseif (Str::substr($this->code, 6, 1) == "F") {
            return 1.0;
        } else {
            return 0.0;
        }
    }

    public function isForFirstYear(): bool
    {
        return Str::substr($this->code, 5, 1) === "1";
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function completedStudents(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'completed_courses_v2');
    }


    public function eligibleMajorStudents(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'eligible_major_courses');
    }

    public function eligibleConcentrationStudents(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'eligible_concentration_courses');
    }

    public function eligibleElectiveMajorStudents(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'eligible_elective_major_courses');
    }

    public function eligibleElectiveStudents(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'eligible_elective_courses');
    }

    public function CourseFeedback(): HasMany
    {
        return $this->hasMany(CourseFeedback::class);
    }
}
