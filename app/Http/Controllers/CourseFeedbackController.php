<?php

namespace App\Http\Controllers;

use App\Models\CourseFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

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
    public function findCourseFeedback(Request $request) :View
    {
        // look up feedback by course code
        $code = $request->input('code');

        // return the course feedback view
        return view('courseFeedback.show', [
            'courseFeedback' => CourseFeedback::where('code', $code)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('courseFeedback.create');
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
}
