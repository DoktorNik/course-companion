<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseFeedback;
use Illuminate\Http\Request;
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
    public function store(Request $request): View
    {
        // 2do: validate while keeping the passed courseFeedback/course properly

//        $validated = $request->validate([
//            'lecturer' => 'string|max:128',
//            'ratingDifficulty' => 'required|numeric|min:1|max:5',
//            'ratingWorkload' => 'required|numeric|min:1|max:5',
//            'ratingClarity' => 'required|numeric|min:1|max:5',
//            'ratingRelevance' => 'required|numeric|min:1|max:5',
//            'ratingInterest' => 'required|numeric|min:1|max:5',
//            'ratingHelpfulness' => 'required|numeric|min:1|max:5',
//            'ratingExperiential' => 'required|numeric|min:1|max:5',
//            'ratingAffect' => 'required|numeric|min:1|max:5',
//            'comments' => 'string|max:8096',
//        ]);

        // get the course for this feedback
        $course = Course::where('code', $request->code)->first();

        // save feedback to course
        // 2do: why doesn't passing $validated work?!  =\
        $courseFeedback = $course->CourseFeedback()->create([
            'lecturer' => $request->input('lecturer'),
            'comment' => $request->input('comment'),
            'ratingDifficulty' => $request->input('ratingDifficulty'),
            'ratingWorkload' => $request->input('ratingWorkload'),
            'ratingClarity' => $request->input('ratingClarity'),
            'ratingRelevance' => $request->input('ratingRelevance'),
            'ratingInterest' => $request->input('ratingInterest'),
            'ratingHelpfulness' => $request->input('ratingHelpfulness'),
            'ratingExperiential' => $request->input('ratingExperiential'),
            'ratingAffect' => $request->input('ratingAffect'),
        ]);

        // update average for course
        $this->updateCourseAverage($course);

        // show what we've just entered
        return view('courseFeedback.show', [
            'courseFeedback' => $courseFeedback,
        ]);
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
        $course = Course::where('code', $code)->first();

        // bail out if we didn't get a proper course code
        if (is_null($course)) {
            return view('courseFeedback.index', []);
        }

        $courseFeedback = CourseFeedback::where('course_id', $course->id)->orderBy('created_at', 'DESC')->paginate(1);
        $courseFeedback->appends(['code' => $code]);
        $viewName = 'courseFeedback.'.$type;

        // pass feedback if we have it
        if(!$courseFeedback->isEmpty()) {
            return view($viewName, [
                'courseFeedback' => $courseFeedback,
            ]);
        }
        // otherwise, pass the course
        else {
            return view($viewName, [
                'course' => Course::where('code', $code)->first(),
            ]);
        }
    }

    // updates average for a course
    private function updateCourseAverage(Course $course) :void
    {
        // calculate new averages
        $count = 0;
        $totals = array(0,0,0,0,0,0,0,0);

        $courseFeedback = CourseFeedback::whereBelongsTo($course)->get();
        foreach ($courseFeedback as $feedback) {
            $count++;
            $totals[0] += $feedback->ratingDifficulty;
            $totals[1] += $feedback->ratingWorkload;
            $totals[2] += $feedback->ratingClarity;
            $totals[3] += $feedback->ratingRelevance;
            $totals[4] += $feedback->ratingInterest;
            $totals[5] += $feedback->ratingHelpfulness;
            $totals[6] += $feedback->ratingExperiential;
            $totals[7] += $feedback->ratingAffect;
        }

        $course->ratingDifficulty = round($totals[0] / $count, 1);
        $course->ratingWorkload = round($totals[1] / $count, 1);
        $course->ratingClarity = round($totals[2] / $count, 1);
        $course->ratingRelevance = round($totals[3] / $count, 1);
        $course->ratingInterest = round($totals[4] / $count, 1);
        $course->ratingHelpfulness = round($totals[5] / $count, 1);
        $course->ratingExperiential = round($totals[6] / $count, 1);
        $course->ratingAffect = round($totals[7] / $count, 1);
        $course->save();
    }
}
