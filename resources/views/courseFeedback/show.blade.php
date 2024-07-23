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
        <div class="flex justify-between w-full">
            <div class="w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('View Course Feedback') }}
                </h2>
            </div>
            <div class="flex justify-between w-full">
                <div class="w-full">
                    <form method="POST" action="{{ route('courseFeedback.create') }}">
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
                <div class="w-full">
                    <form method="POST" action="{{ route('courseFeedback.find') }}">
                        @csrf
                        @method('GET')
                        <div class="flex">
                            <input
                                type = "text"
                                name="code"
                                placeholder="COSC 1P02"
                                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            >
                            <x-primary-button class="ml-1">
                                Lookup
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
    {{--    main div--}}
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-4 mx-auto">
                <div class="p-6 text-gray-900">
                    <p class="font-bold text-xl ml-5">{{ $course->code }}: {{$course->name}}</p>
                    <div class="flex justify-start w-full mb-8">
{{--                    show ?s to more accurately represent no data, when we don't have it --}}
                        @if($course->ratingDifficulty == 0)
                            <div class="cursor-default ml-8" title="Difficulty">&#128547&nbsp;<span class="-ml-1">?</span></div>
                            <div class="cursor-default ml-2" title="Workload">&#128338&nbsp;<span class="-ml-1">?</span></div>
                            <div class="cursor-default ml-2" title="Clarity">&#128302&nbsp;<span class="-ml-1">?</span></div>
                            <div class="cursor-default ml-2" title="Relevance">&#128175&nbsp;<span class="-ml-1">?</span></div>
                            <div class="cursor-default ml-2" title="Interest">&#128373&nbsp;<span class="-ml-1">?</span></div>
                            <div class="cursor-default ml-2" title="Helpfulness">&#129309&nbsp;<span class="-ml-1">?</span></div>
                            <div class="cursor-default ml-2" title="Experiential">&#127970&nbsp;<span class="-ml-1">?</span></div>
                            <div class="cursor-default ml-2" title="Affect">&#128151&nbsp;<span class="-ml-1">?</span></div>
                        @else
                            <div class="cursor-default ml-8" title="Difficulty">&#128547&nbsp;<span class="-ml-1">{{$course->ratingDifficulty}}</span></div>
                            <div class="cursor-default ml-2" title="Workload">&#128338&nbsp;<span class="-ml-1">{{$course->ratingWorkload}}</span></div>
                            <div class="cursor-default ml-2" title="Clarity">&#128302&nbsp;<span class="-ml-1">{{$course->ratingClarity}}</span></div>
                            <div class="cursor-default ml-2" title="Relevance">&#128175&nbsp;<span class="-ml-1">{{$course->ratingRelevance}}</span></div>
                            <div class="cursor-default ml-2" title="Interest">&#128373&nbsp;<span class="-ml-1">{{$course->ratingInterest}}</span></div>
                            <div class="cursor-default ml-2" title="Helpfulness">&#129309&nbsp;<span class="-ml-1">{{$course->ratingHelpfulness}}</span></div>
                            <div class="cursor-default ml-2" title="Experiential">&#127970&nbsp;<span class="-ml-1">{{$course->ratingExperiential}}</span></div>
                            <div class="cursor-default ml-2" title="Affect">&#128151&nbsp;<span class="-ml-1">{{$course->ratingAffect}}</span></div>
                        @endif
                        <div class="grow"></div>
                    </div>
{{--                no feedback yet--}}
                    @if(!isset($courseFeedback))
                    <div class="p-2 w-10/12 m-auto">
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
                                        <p class="font-bold" title="How positive you felt during the course">Affect</p>
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

{{-- paginator auto capitilizing property names?!?!?! --}}
{{-- https://laracasts.com/discuss/channels/laravel/paginator-automatically-changing-variable-case --}}
