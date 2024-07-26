<?php

namespace App\View\Components;

use App\Models\Course;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class courseHighlight extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Course $course, public int $p)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.course-highlight');
    }
}
