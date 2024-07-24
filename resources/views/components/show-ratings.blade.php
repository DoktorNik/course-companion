@php
//    {{--show ?s to more accurately represent no data, when we don't have it --}}
    $course->ratingDifficulty = ($course->ratingDifficulty < 1 ? "?":$course->ratingDifficulty);
    $course->ratingWorkload = ($course->ratingWorkload < 1 ? "?":$course->ratingWorkload);
    $course->ratingClarity = ($course->ratingClarity < 1 ? "?":$course->ratingClarity);
    $course->ratingRelevance = ($course->ratingRelevance < 1 ? "?":$course->ratingRelevance);
    $course->ratingInterest = ($course->ratingInterest < 1 ? "?":$course->ratingInterest);
    $course->ratingHelpfulness = ($course->ratingHelpfulness < 1 ? "?":$course->ratingHelpfulness);
    $course->ratingExperiential = ($course->ratingExperiential < 1 ? "?":$course->ratingExperiential);
    $course->ratingAffect = ($course->ratingAffect < 1 ? "?":$course->ratingAffect);

    // set left margin for first element
    $ml = "ml-".$ml;
@endphp
<a href="{{ route('courseFeedback.find', ['code' => $course->code])}}" class="{{$ml}}" title="Difficulty">&#128547&nbsp;<span class="-ml-1">{{$course->ratingDifficulty}}</span></a>
<a href="{{ route('courseFeedback.find', ['code' => $course->code])}}" class="ml-2" title="Workload">&#128338&nbsp;<span class="-ml-1">{{$course->ratingWorkload}}</span></a>
<a href="{{ route('courseFeedback.find', ['code' => $course->code])}}" class="ml-2" title="Clarity">&#128302&nbsp;<span class="-ml-1">{{$course->ratingClarity}}</span></a>
<a href="{{ route('courseFeedback.find', ['code' => $course->code])}}" class="ml-2" title="Relevance">&#128175&nbsp;<span class="-ml-1">{{$course->ratingRelevance}}</span></a>
<a href="{{ route('courseFeedback.find', ['code' => $course->code])}}" class="ml-2" title="Interest">&#128373&nbsp;<span class="-ml-1">{{$course->ratingInterest}}</span></a>
<a href="{{ route('courseFeedback.find', ['code' => $course->code])}}" class="ml-2" title="Helpfulness">&#129309&nbsp;<span class="-ml-1">{{$course->ratingHelpfulness}}</span></a>
<a href="{{ route('courseFeedback.find', ['code' => $course->code])}}" class="ml-2" title="Experiential">&#127970&nbsp;<span class="-ml-1">{{$course->ratingExperiential}}</span></a>
<a href="{{ route('courseFeedback.find', ['code' => $course->code])}}" class="ml-2" title="Affect">&#128151&nbsp;<span class="-ml-1">{{$course->ratingAffect}}</span></a>
<div class="grow"></div>
