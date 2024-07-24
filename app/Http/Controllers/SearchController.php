<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * find the thing in the app
     */
    public function find(Request $request) :View
    {
        $TYPE_UNKNOWN = 0;
        $TYPE_STUDENT_NUMBER = 1;
        $TYPE_COURSE_CODE = 2;

        // what we're searching for
        $searchStr = $request->query('searchString');

        // figure out what it is
        $type = $TYPE_UNKNOWN;

        // student number = 7 digits
        if(floor(log10(floatval($searchStr))+1) == 7) {
            $type = $TYPE_STUDENT_NUMBER;
        }
        // course code = 9 characters, 2 sets of 4 seperated by a space
        else if(strlen($searchStr) == 9 && substr($searchStr, 5, 1) == " ") {
            $type = $TYPE_COURSE_CODE;
        }

        // now search
        // get student by number
        if ($type == $TYPE_STUDENT_NUMBER) {
            $result = Student::where('number', $searchStr)->first();
            if(!is_null($result)) {
                // authorization check
                Gate::authorize('view', $result);
                return view('students.show', ['student' => $result]);
            }
        }

        // get course by code
        if ($type == $TYPE_COURSE_CODE) {
            $result = Course::where('code', $searchStr)->first();
            if (!is_null($result))
                return view('courses.show', ['course' => $result]);
        }

        // we don't know what it is, so do a string search
        // is it a course name?
        $result = Course::where('name', 'LIKE', "%{$searchStr}%")->get();
        if($result->isNotEmpty()) {
            return view('search.results', ['result' => $result]);
        }

        // is it a student name?
        $result = Student::where('name', 'LIKE', "%{$searchStr}%")
            ->where('id', '=', Auth::id())
            ->get();

        if($result->isNotEmpty()) {
            return view('search.results', ['result' => $result]);
        }

        // since we can't find it, return failure
        return View('search.noResults');
    }
}
