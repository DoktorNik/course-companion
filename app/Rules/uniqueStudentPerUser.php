<?php

namespace App\Rules;

use App\Models\Student;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class uniqueStudentPerUser implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $student = Student::where('studentNumber', $value)->first();
        if (!is_null($student)) {
            $fail('Student with this number ' . $value . ' already exists.');
        }
    }
}
