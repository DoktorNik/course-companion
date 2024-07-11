<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CompletedCourses extends Model
{
    use HasFactory;

    public function Course(): BelongsToMany
    {
        return $this->BelongsToMany(Course::class, 'completed_courses_courses');
    }
}
