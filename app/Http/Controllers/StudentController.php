<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\CoursesCompleted;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Rules\uniqueStudentPerUser;
use function PHPUnit\Framework\isEmpty;

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
            'name' => 'required|string|max:255',
            'number' => ['required', 'numeric', 'digits:7', new uniqueStudentPerUser],
            'major' => 'required|string|max:4',
            'concentration' => 'string|nullable|max:255',
        ]);

        // create
        $student = $request->user()->students()->create($validated);

        // update courses taken
        $this->updateCoursesTaken($request, $student);

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
        $number = $request->input('number');

        // get the student
        $student = Student::where('number', $number)
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
        Gate::authorize('view', $student);
            $this->updateStudent($student);
            $student->save();

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
        Gate::authorize('update', $student);
            return view('students.edit', [
                'student' => $student,
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        Gate::authorize('update', $student);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'number' => ['required', 'numeric', 'digits:7'],
            'major' => 'required|string|max:4',
            'concentration' => 'string|nullable|max:255',
        ]);
        $student->update($validated);

        // update courses taken
        $this->updateCoursesTaken($request, $student);

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
        $creditsCompletedMajor = 0.00;

        if($student->CoursesCompleted) {

            foreach ($student->CoursesCompleted as $courseCompleted) {
                $count = 0;

                if (Str::substr($courseCompleted->code, 6, 1) == "P") {
                    $count += 0.5;
                } elseif (Str::substr($courseCompleted->code, 6, 1) == "F") {
                    $count += 1;
                }

                // major?
                $course = Course::where('code', $courseCompleted->code)->first();

                if (!is_null($course)) {
                    if ($course->isRequiredByMajor == $student->major || Str::substr($course->code, 0,4) == $student->major) {
                        $creditsCompletedMajor += $count;
                    }
                }
                $creditsCompleted += $count;
            }
        }

        $student->creditsCompleted = $creditsCompleted;
        $student->creditsCompletedMajor = $creditsCompletedMajor;
    }

    private function updateEligibleCourses(Student $student): void
    {
        $courses = Course::all();

        // go through each course
        foreach ($courses as $course) {

            // skip if course is already completed
            if ($student->CoursesCompleted) {
                foreach ($student->CoursesCompleted as $courseCompleted) {
                    if ($course->code == $courseCompleted->code)
                        continue 2;
                }
            }

            // skip if we don't meet required credit count
            if ($student->creditsCompleted < $course->prereqCreditCount || $student->creditsCompletedMajor < $course->prereqCreditCountMajor) {
                continue;
            }

            // if there are prereqs
            //if ($course->prereqs[0] != "") {  // why is this always an array instead of null like the others? *cries*
            if ($course->prereqs) {

                // go through the required prereqs
                foreach ($course->prereqs as $coursePrereqCode=>$coursePrereqName) {

                    // override for a course most people aren't actually required to take
                    if ($coursePrereqCode == "MATH 1P20")
                        continue;

                    // default to not completed
                    $completed = false;

                    if ($student->CoursesCompleted) {

                        // go through each course completed by the student
                        foreach ($student->CoursesCompleted as $courseCompleted) {

                            // set it to completed if there's a match
                            if ($courseCompleted->code == $coursePrereqCode) {
                                $completed = true;
                                break;
                            }
                        }
                    }

                    // if it hasn't been completed, skip this course
                    if (!$completed) {
                        continue 2;
                    }
                }
            }

            // all checks passed, so add it to as eligible
            // does the required major match the student major
            if ($course->isRequiredByMajor == $student->major) {
                $this->createRelatedCourseRecord($student, "Major", $course->code, $course->name);
            }
            else {

                // is it a concentration course?
                $concentration = false;

                // loop through each concentration this course is a part of to check
                if (is_array($course->concentration)) {
                    foreach ($course->concentration as $ccKey=>$courseConcentration) {
                        if ($student->concentration == $courseConcentration) {
                            $concentration = true;
                        }
                    }
                }

                // mark course as eligible as appropriate
                if ($concentration) {
                    $this->createRelatedCourseRecord($student, "Concentration", $course->code, $course->name);
                }
                else {
                    if (substr($course->code, 0, 4) == $student->major) {
                        $this->createRelatedCourseRecord($student, "ElectiveMajor", $course->code, $course->name);
                    } else {
                        $this->createRelatedCourseRecord($student, "NonMajor", $course->code, $course->name);
                    }
                }
            }
        }
    }

    private function updateStudent(Student $student): void
    {
        $this->updateCreditsCompleted($student);
        $this->updateEligibleCourses($student);
    }

    private function addAsteriskToCourseWithMinimumGrade($name): string
    {
        $course = Course::where('name', $name)->first();

        if ($course->minimumGrade > 0) {
            $name .= " *".$course->minimumGrade;
        }

        return $name;
    }

    private function updateCoursesTaken($request, $student)
    {
        // update courses taken using proper database design
        // create array from user input for parsing
        $coursesCompleted = explode(", ", $request->get("coursesCompleted"));

        // clear existing records
        DB::table('courses_completeds')->where('student_id', '=', $student->id)->delete();

        // add each entry in
        foreach ($coursesCompleted as $courseCompleted) {
            // get course for id
            $course = Course::where('code', $courseCompleted)->first();

            // new entry
            if (!is_null($course)) {
                // save to database
                $CoursesCompleted = $student->CoursesCompleted()->create([
                    'code' => $course->code,
                    'name' => $course->name,
                ]);
            }
        }
    }

    private function relatedCourseRecordExists($student, $code) : boolean
    {

    }

    private function createRelatedCourseRecord($student, $type, $code, $name)
    {
        2do:
        // needs to be this student though
        if ($type == "Major") {
            $exists = Student::whereHas('EligibleCoursesMajor', function ($query) use($code) {
                $query->where('code', $code);
            })->get();

            if (isEmpty($exists)) {
                $student->EligibleCoursesMajor()->create([
                    'code' => $code,
                    'name' => $name,
                ]);
            }
        }
        elseif ($type == "Concentration") {
            $student->EligibleCoursesConcentration()->create([
                'code' => $code,
                'name' => $name,
            ]);
        }
        elseif ($type == "ElectiveMajor") {
            $student->EligibleCoursesElectiveMajor()->create([
                'code' => $code,
                'name' => $name,
            ]);
        }
        elseif ($type == "Context") {
            $student->EligibleCoursesContext()->create([
                'code' => $code,
                'name' => $name,
            ]);
        }
        elseif ($type == "NonMajor") {
            $student->EligibleCoursesNonMajor()->create([
                'code' => $code,
                'name' => $name,
            ]);
        }

    }
}
