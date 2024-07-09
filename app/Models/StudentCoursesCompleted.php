<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentCoursesCompleted extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
