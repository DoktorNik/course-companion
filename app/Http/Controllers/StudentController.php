<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // view the students created by this user
        return view('students.index', [
            'students' => Student::where('user_id', '=', Auth::id())->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): View
    {

        // validate
        $validated = $request->validate([
            'studentName' => 'required|string|max:255',
            'studentNumber' => 'required|numeric|digits:7',
            'major' => 'required|string|max:4',
            'coursesCompleted' => 'nullable|string'
        ]);

        if ($validated['coursesCompleted']) {
            $validated['coursesCompleted'] = explode(', ', $validated['coursesCompleted']);
        }

        // create
        $student = $request->user()->students()->create($validated);

        // update computed properties
        $this->updateStudent($student);
        $student->save();

        // show student entry
        return view('students.show', [
            'student' => $student,
        ]);
    }

    /**
     * find a student for display
     */
    public function findStudent(Request $request) :View
    {

        // get the student from database
        $studentNumber = $request->input('studentNumber');

        // get the student
        $student = Student::where('studentNumber', $studentNumber)
            ->where('user_id', auth()->user()->getAuthIdentifier())
            ->first();

        // bail out if the student isn't found
        if (is_null($student)) {
            // view the students created by this user
            return view('students.index', [
                'students' => Student::where('user_id', '=', Auth::id())->get(),
            ]);
        }

        // authorization check
        Gate::authorize('view', $student);

        // update computed student properties
        Gate::authorize('update', $student);
        $this->updateStudent($student);
        $student->save();

        // return the student view
        return view('students.show', [
            'student' => $student,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student): View
    {
        // update computed student properties
        //if ($student->user()->is(auth()->user())) {
        Gate::authorize('view', $student);
            $this->updateStudent($student);
            $student->save();
        //}

        // view the student
        return view('students.show', [
            'student' => $student,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student): View
    {
        //Gate::authorize('update', $student);
        if ($student->user()->is(auth()->user())) {
            return view('students.edit', [
                'student' => $student,
            ]);
        }
        return view('students.index', [
            'students' => Student::with('user')->latest()->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        Gate::authorize('update', $student);

        $validated = $request->validate([
            'studentName' => 'required|string|max:255',
            'studentNumber' => 'required|numeric|digits:7',
            'major' => 'required|string|max:4',
        ]);
        $student->update($validated);

        // update courses taken manually because validator breaks casting
        $student->coursesCompleted = explode(", ", $request->get("coursesCompleted"));

        // update computed student properties
        $this->updateStudent($student);
        $student->save();

        return redirect(route('students.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student): RedirectResponse
    {
        //
        Gate::authorize('delete', $student);

        $student->delete();

        return redirect(route('students.index'));
    }

    private function updateCreditsCompleted(student $student): void
    {
        // count completed credits
        $creditsCompleted = 0.0;

        if($student->coursesCompleted) {
            foreach ($student->coursesCompleted as $coursesCompleted) {
                $count = 0;

                if (Str::substr($coursesCompleted, 6, 1) == "P") {
                    $count += 0.5;
                } elseif (Str::substr($coursesCompleted, 6, 1) == "F") {
                    $count += 1;
                }

                // major?
                $course = Course::where('courseCode', $coursesCompleted)->first();

                if (!is_null($course)) {
                    if ($course->requiredByMajor == $student->major) {
                        $student->majorCreditsCompleted += $count;
                    }
                }
                $creditsCompleted += $count;
            }
        }

        $student->creditsCompleted = $creditsCompleted;
    }

    private function updateEligibleCourses(Student $student): void
    {
        // reset list of eligible courses
        $student->eligibleRequiredCourses = array();
        $student->eligibleElectiveCourses = array();

        $courses = Course::all();

        // go through each course
        foreach ($courses as $course) {

//            if ($course->courseCode == "COSC 1P03")
//                dd($course->coursePrereqs);

            // skip if course is already completed
            if ($student->coursesCompleted) {
                foreach ($student->coursesCompleted as $courseCompleted) {
                    //dd($course->courseName, $courseCompleted);
                    if ($course->courseCode == $courseCompleted)
                        continue 2;
                }
            }

            // skip if we don't meet required credit count
            if ($student->creditsCompleted < $course->coursePrereqCredits) {
                continue;
            }

            // if there are prereqs
            //if ($course->coursePrereqs[0] != "") {  // why is this always an array instead of null like the others? *cries*
            if ($course->coursePrereqs) {
                //dd($course->coursePrereqs);
                // go through the required prereqs
                foreach ($course->coursePrereqs as $coursePrereq=>$coursePrereqName) {

                    if ($coursePrereq == "MATH 1P20")
                        continue;

                    // default to not completed
                    $completed = false;

                    if ($student->coursesCompleted) {
                        // go through each course completed by the student
                        foreach ($student->coursesCompleted as $courseCompleted) {

                            // set it to completed if there's a match
//                            if($course->courseCode == "COSC 1P03")
//                                dd($courseCompleted, $coursePrereq);
                            if ($courseCompleted == $coursePrereq) {
                                $completed = true;
                                break;
                            }
                        }

                     //   dd($completed, $student->coursesCompleted);

                    }
                    // if it hasn't been completed, skip this course
                    if (!$completed) {
                        continue 2;
                    }
                }
            }

            //dd($course->courseName);
            // all checks passed, so add it to as eligible
            // does the course major match the student major
            if ($course->requiredByMajor == $student->major) {
                $student->eligibleRequiredCourses = Arr::add($student->eligibleRequiredCourses, $course->courseCode, $course->courseName);
            }
            else {
                $student->eligibleElectiveCourses = Arr::add($student->eligibleElectiveCourses, $course->courseCode, $course->courseName);
            }
        }
    }

    private function updateStudent(Student $student): void
    {
        $this->updateCreditsCompleted($student);
        $this->updateEligibleCourses($student);
    }
}
