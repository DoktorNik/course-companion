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
                    <div class="flex justify-start w-full mb-12">
                        <div class="cursor-default ml-8" title="Difficulty">&#128547&nbsp;{{$course->ratingDifficulty}}</div>
                        <div class="cursor-default" title="Workload">&#128338&nbsp;{{$course->ratingWorkload}}</div>
                        <div class="cursor-default" title="Clarity">&#128302&nbsp;{{$course->ratingClarity}}</div>
                        <div class="cursor-default" title="Relevance">&#128175&nbsp;{{$course->ratingRelevance}}</div>
                        <div class="cursor-default" title="Interest">&#128373&nbsp;{{$course->ratingInterest}}</div>
                        <div class="cursor-default" title="Helpfulness">&#129309&nbsp;{{$course->ratingHelpfulness}}</div>
                        <div class="cursor-default" title="Experiential">&#127970&nbsp;{{$course->ratingExperiential}}</div>
                        <div class="cursor-default" title="Affect">&#128151&nbsp;{{$course->ratingAffect}}</div>
                        <div class="grow"></div>
                    </div>
{{--                no feedback yet--}}
                    <div class="border-2 border-gray-300 rounded-lg p-2 w-10/12 m-auto">
                        @if(!isset($courseFeedback))
                            <p class="font-bold text-red-500">There is no feedback available for this course yet!</p>
                            <p class="text-sm ml-3">Please be the first to add feedback</p>
                            {{--                otherwise show the feedback--}}
                        @else
                            <div class = "flex justify-between items-center w-4/5">
                                @if(isset($courseFeedbackCollection))
                                    <p class="text-xl font-bold">Feedback Entry #{{$courseFeedbackCollection->currentPage()}} <br/><span class="text-sm font-normal italic ml-3">{{$courseFeedback->created_at}}</span></p>
                                @else
                                <p class="text-xl font-bold">New Feedback Entry</p>
                                @endif
                                <p class="font-bold text-lg mt-6 mb-4">Lecturer: <i>{{ $courseFeedback->lecturer }}</i></p>
                            </div>
                            <div class = "">
                                <div class="mt-2 flex justify-between w-full">
                                    <div class="w-full">
                                        <p class="font-bold">Difficulty</p>
                                        <x-five-star id="difficulty"></x-five-star>
                                    </div>
                                    <div class="pl-1 w-full">
                                        <p class="font-bold">Workload</p>
                                        <x-five-star id="workload"></x-five-star>
                                    </div>
                                </div>
                                <div class="mt-2 flex justify-between w-full">
                                    <div class="w-full">
                                        <p class="font-bold">Clarity</p>
                                        <x-five-star id="clarity"></x-five-star>
                                    </div>
                                    <div class="pl-1 w-full">
                                        <p class="font-bold">Relevance</p>
                                        <x-five-star id="relevance"></x-five-star>
                                    </div>
                                </div>
                                <div class="mt-2 flex justify-between w-full">
                                    <div class="w-full">
                                        <p class="font-bold">Interest</p>
                                        <x-five-star id="interest"></x-five-star>
                                    </div>
                                    <div class="pl-1 w-full">
                                        <p class="font-bold">Helpfulness</p>
                                        <x-five-star id="helpfulness"></x-five-star>
                                    </div>
                                </div>
                                <div class="mt-2 flex justify-between w-full">
                                    <div class="w-full">
                                        <p class="font-bold">Experiential</p>
                                        <x-five-star id="experiential"></x-five-star>
                                    </div>
                                    <div class="pl-1 w-full">
                                        <p class="font-bold">Affect</p>
                                        <x-five-star id="affect"></x-five-star>
                                    </div>
                                </div>
                                <div class = "mt-6">
                                    <p class="text-lg font-bold">Comments</p>
                                    {!!$courseFeedback->comment!!}
                                </div>
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
