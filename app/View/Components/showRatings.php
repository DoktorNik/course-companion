<?php

namespace App\View\Components;

use App\Models\Course;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class showRatings extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Course $course, public int $ml)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.show-ratings');
    }
}
