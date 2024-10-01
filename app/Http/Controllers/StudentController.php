<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Rules\uniqueStudentPerUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

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
    public function create(): View
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // validate
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'number' => ['required', 'numeric', 'digits:7', new uniqueStudentPerUser],
            'major' => 'required|string|max:4',
            'concentration' => 'string|nullable|max:255',
        ]);

        $completedCourseCodes = explode(", ", $request->get("coursesCompleted"));
        /** @var Student $student */
        $student = $request->user()->students()->create($validated);
        $student->updateCoursesTaken($completedCourseCodes);

        return redirect(route('students.show', [
            'student' => $student,
        ]));
    }

    /**
     * find a student for display
     */
    public function findStudent(Request $request): View
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
        $completedCourseCodes = explode(", ", $request->get("coursesCompleted"));
        DB::transaction(function () use ($student, $validated, $completedCourseCodes) {
            $student->update($validated);
            $student->updateCoursesTaken($completedCourseCodes);
        });

        return redirect(route('students.show', [
            'student' => $student,
        ]));
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
}
