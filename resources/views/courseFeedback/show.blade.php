<head>
    <title></title>
    @push('scripts')
        @vite(['resources/js/validateCourseFeedback.js'])
    @endpush
    @stack('scripts')
</head>
@php
// handle which type of data we've gotten: a course, a courseFeedback, or a courseFeedback collection
if(isset($courseFeedback)) {

    // if it's a collection, we are using first result as it is 1 per page
    if(isset($courseFeedback[0])) {
        $courseFeedbackCollection = $courseFeedback;    // collection for pagination links
        $courseFeedback = $courseFeedback[0];
    }

    // course is the feedback's parent
    $course = $courseFeedback->course;
}
// sanity check
if(is_null($course))
    dd(false); // ruh roh 2do: bailout
@endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div class = "w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Course Feedback / ') }} {{ $course->code }}
                </h2>
            </div>

            <div class="flex w-full justify-end">
                <form class="m-0" method="POST" action="{{ route('courseFeedback.create') }}">
                    @csrf
                    @method('GET')
                    <input type = "hidden" value="{{$course->code}}" name="code">
                    <div class="flex">
                        <x-primary-button class="ml-1">
                            Add Feedback
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>
    {{--    main div--}}
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-4 mx-auto">
                <div class="p-6 text-gray-900">
                    <a class="font-bold text-xl ml-5" href="{{ route('courses.findCourse', ['code' => $course->code]) }}">{{ $course->code }}: {{$course->name}}</a>
                    <div class="flex justify-start w-full">
                        <x-show-ratings :course="$course" ml="8"></x-show-ratings>
                    </div>
{{--                no feedback yet--}}
                    <div class="p-2 w-10/12 my-4 m-auto">
                        @if(!isset($courseFeedback))
                            <p class="font-bold text-red-500">There is no feedback available for this course yet!</p>
                            <p class="text-sm ml-3">Please be the first to add feedback</p>
                        {{--                otherwise show the feedback--}}
                        @else
                            <div class = "border-2 border-gray-300 rounded-lg p-2 w-10/12 m-auto">
                                <div class = "flex justify-center items-center w-full">
                                    @if(isset($courseFeedbackCollection))
                                        <div class = "flex flex-col items-center">
                                            <p class="font-bold text-xl mt-4">Lecturer: <i>{{ $courseFeedback->lecturer }}</i></p>
                                            <p class="text-sm font-normal italic">{{$courseFeedback->created_at}}</p>
                                        </div>
                                    @else
                                    <p class="text-xl font-bold">New Feedback Entry</p>
                                    @endif
                                </div>
                                <div class = "m-auto px-16 pt-2 mt-6">
                                    <div class="flex justify-between">
                                        <div class="w-full flex flex-col items-center">
                                            <p class="font-bold" title="How challenging you found the course">Difficulty</p>
                                            <x-five-star id="difficulty"></x-five-star>
                                        </div>
                                        <div class="w-full flex flex-col items-center">
                                            <p class="font-bold" title="How much work you did in this course">Workload</p>
                                            <x-five-star id="workload"></x-five-star>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex justify-between w-full">
                                        <div class="w-full flex flex-col items-center">
                                            <p class="font-bold" title="How clear the course material is">Clarity</p>
                                            <x-five-star id="clarity"></x-five-star>
                                        </div>
                                        <div class="w-full flex flex-col items-center">
                                            <p class="font-bold" title="How relevant the course material is">Relevance</p>
                                            <x-five-star id="relevance"></x-five-star>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex justify-between w-full">
                                        <div class="w-full flex flex-col items-center">
                                            <p class="font-bold" title="How interesting the course is">Interest</p>
                                            <x-five-star id="interest"></x-five-star>
                                        </div>
                                        <div class="w-full flex flex-col items-center">
                                            <p class="font-bold" title="How helpful the course is">Helpfulness</p>
                                            <x-five-star id="helpfulness"></x-five-star>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex justify-between w-full">
                                        <div class="w-full flex flex-col items-center">
                                            <p class="font-bold" title="How much experience you gained in the course">Experiential</p>
                                            <x-five-star id="experiential"></x-five-star>
                                        </div>
                                        <div class="w-full flex flex-col items-center">
                                            <p class="font-bold" title="How positive you felt during the course">Positive Affect</p>
                                            <x-five-star id="affect"></x-five-star>
                                        </div>
                                    </div>
                                </div>
                                <div class="mx-8 mt-8 mb-2">
                                    {!!$courseFeedback->comment!!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
{{--        pagination--}}
            @if(isset($courseFeedbackCollection))
                <div>
                    {{ $courseFeedbackCollection->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
@if(isset($courseFeedback))
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        setRating("difficulty", {{$courseFeedback->ratingDifficulty}});
        setRating("workload", {{$courseFeedback->ratingWorkload}});
        setRating("clarity", {{$courseFeedback->ratingClarity}});
        setRating("relevance", {{$courseFeedback->ratingRelevance}});
        setRating("interest", {{$courseFeedback->ratingInterest}});
        setRating("helpfulness", {{$courseFeedback->ratingHelpfulness}});
        setRating("experiential", {{$courseFeedback->ratingExperiential}});
        setRating("affect", {{$courseFeedback->ratingAffect}});
    }, false);
</script>
@endif
