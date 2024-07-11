<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

   public function CompletedCourses(): HasOne
   {
       return $this->hasOne(CompletedCourses::class);
   }

    public function EligibleCoursesMajor(): HasOne
    {
        return $this->hasOne(EligibleCoursesMajor::class);
    }

    public function EligibleCoursesConcentration(): hasOne
    {
        return $this->hasOne(EligibleCoursesConcentration::class);
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
