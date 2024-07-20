<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseFeedback;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function PHPUnit\Framework\isEmpty;

class CourseFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() :View
    {
        // just want to show a form to look up which course to get feedback for
        return view('courseFeedback.index');
    }

    /**
     * find a course for displaying reviews
     */
    public function find(Request $request) :View
    {
        // return feedback, or course if there is no feedback yet
        $code = $request->input('code');
        return $this->getView($code, 'show');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        // return feedback, or course if there is no feedback yet
        $code = $request->input('code');
        return $this->getView($code, 'create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseFeedback $courseFeedback): View
    {
        return view('courseFeedback.show', [
            'courseFeedback' => $courseFeedback,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseFeedback $courseFeedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseFeedback $courseFeedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseFeedback $courseFeedback)
    {
        //
    }

    private function getView($code, $type): View
    {
        // look up feedback by course code
        $courseFeedback = CourseFeedback::where('code', $code)->get();
        $viewName = 'courseFeedback.'.$type;

        // pass feedback if we have it
        if($courseFeedback->isEmpty()) {
            return view($viewName, [
                'course' => Course::where('code', $code)->first(),
            ]);
        }
        // otherwise, pass the course
        else {
            return view($viewName, [
                'courseFeedback' => CourseFeedback::where('code', $code)->get(),
            ]);
        }
    }
}
