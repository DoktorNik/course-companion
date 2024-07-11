<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable  = [
        'name',
        'number',
        'major',
        'concentration',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

   public function CoursesCompleted(): HasMany
   {
       return $this->hasMany(CoursesCompleted::class);
   }

    public function EligibleCoursesMajor(): HasMany
    {
        return $this->hasMany(EligibleCoursesMajor::class);
    }

    public function EligibleCoursesConcentration(): HasMany
    {
        return $this->hasMany(EligibleCoursesConcentration::class);
    }

    public function EligibleCoursesElectiveMajor(): HasMany
    {
        return $this->hasMany(EligibleCoursesElectiveMajor::class);
    }

    public function EligibleCoursesContext(): HasMany
    {
        return $this->hasMany(EligibleCoursesContext::class);
    }

    public function EligibleCoursesNonMajor(): HasMany
    {
        return $this->hasMany(EligibleCoursesNonMajor::class);
    }
}
