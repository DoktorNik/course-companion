<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'lecturer',
        'comment',
        'ratingDifficulty',
        'ratingWorkload',
        'ratingClarity',
        'ratingRelevance',
        'ratingInterest',
        'ratingHelpfulness',
        'ratingExperiential',
        'ratingAffect'
    ];

    public function Course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
