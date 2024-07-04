<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    protected $fillable  = [
        'studentName',
        'studentNumber',
        'coursesCompleted',
        'eligibleCourses',
        'creditsCompleted',
    ];

    protected $casts = [
        'coursesCompleted' => 'array',
        'eligibleCourses' => 'array',
    ];

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
}
