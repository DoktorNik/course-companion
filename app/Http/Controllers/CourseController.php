<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        //
        return view('courses.index', [
            'courses' => Course::all(),
        ]);
    }

    /**
     * find a course for display
     */
    public function findCourse(Request $request) :View
    {
        // get the course from database
        $code = $request->input('code');
        $course = Course::where('code', $code)->first();

        // return the student view
        return view('courses.show', [
            'course' => $course,
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
    public function store(Request $request): RedirectResponse
    {
        // save the course
        //dd($request);
        Gate::authorize('create', Course::class);

        $validated = $request->validate([
            'code' => 'required|string|max:9',
            'duration' => 'required|string|max:4',
            'prereqCreditCount' => 'nullable|numeric|max:20',
            'name' => 'required|string|max:255',
            'isRequiredByMajor' => 'nullable|string|min:4',
            'prereqCreditCountMajor' => 'numeric|max:20',
            'concentration' => 'string|nullable|max:255',
            'minimumGrade' => 'numeric|nullable|min:50|max:100',
        ]);

        // explode in to array
        $validated['prereqs'] = explode(", ", $request->input('prereqs'));
        $validated['concentration'] = explode(", ", $request->input('concentration'));

        // create the course
        $request->user()->courses()->create($validated);

        return redirect(route('courses.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course): View
    {
        Gate::authorize('view', $course);
        //
        return view('courses.show', [
            'course' => $course,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course): View
    {
        //
        Gate::authorize('update', $course);

        return view('courses.edit', [
            'course' => $course,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course): RedirectResponse
    {
        //
        Gate::authorize('update', $course);


        $validated = $request->validate([
            'code' => 'required|string|max:9',
            'duration' => 'required|string|max:4',
            'prereqCreditCount' => 'nullable|numeric|max:20',
            'name' => 'required|string|max:255',
            'isRequiredByMajor' => 'nullable|string|min:4',
            'prereqCreditCountMajor' => 'numeric|max:20',
            'concentration' => 'string|nullable|max:255',
            'minimumGrade' => 'numeric|nullable|min:50|max:100',
        ]);

        // explode in to array
        $validated['prereqs'] = explode(", ", $request->input('prereqs'));
        $validated['concentration'] = explode(", ", $request->input('concentration'));

        // update the course
        $course->update($validated);

        return redirect(route('courses.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): RedirectResponse
    {
        //
        Gate::authorize('delete', $course);

        $course->delete();

        return redirect(route('courses.index'));
    }

    private function fillPreqeqs($prereqs): array
    {
        // new array for prereqs with names
        $prereqFull = array();
        if($prereqs[0] != "") {

            // get data for each prereq and place in to new array
            foreach ($prereqs as $prereq) {
                $pcourse = Course::where('code', $prereq)->get();
                $pcourse = $pcourse[0];
                //dd($pcourse[0]);

                $prereqFull = Arr::add($prereqFull, $pcourse->code, $pcourse->name."   [".$pcourse->duration."]");
            }
        }
        return $prereqFull;
    }
}
