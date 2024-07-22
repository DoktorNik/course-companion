<head>
    <title></title>
    @push('scripts')
        @vite(['resources/js/validateCourseFeedback.js'])

    @endpush
    @stack('scripts')
</head>
@php
if(!isset($course))
    $course = null;
@endphp
<x-app-layout>
    @if(is_null($course))
        @if(isset($courseFeedback))
            @php
                $course = $courseFeedback[0]->course;
            @endphp
        @else
{{--        // 2do: bail out--}}
        @endif
    @endif
    <x-slot name="header">
        <div class="flex justify-between w-full">
            <div class="w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Submit Course Feedback') }}
                </h2>
            </div>
            <div class="flex justify-end w-full">
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
    </x-slot>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <!-- add new feedback -->
        <div>
            <p class="font-bold text-lg mt-4">New Course Feedback</p>
            <p class="ml-3">{{$course->code}}: {{$course->name}}</p>
        </div>

        <form method="POST" id ="courseFeedbackForm" action="{{ route('courseFeedback.store') }}">
            @csrf
                <div id="errorList" class="hidden bg-red-200 text-red-700 p-2.5 m-2">
                @if ($errors->any())
                    <strong>Oh no, The supplied course feedback is invalid!</strong>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                </div>
            <div class = "mt-2">
                <p class="font-bold">Lecturer</p>
                <input
                    type = "text"
                    id = "lecturer"
                    name = "lecturer"
                    value = "{{ old('lecturer') }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    required
                >
            </div>
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
            <div class = "mt-2">
                <p class="font-bold">Comments</p>
                <textarea
                    id="comment"
                    name="comment"
                    class="mt-1 block w-full h-40 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"

                >{{ old('comments')}}</textarea>
            </div>
            <x-primary-button class="mt-2" onclick="event.preventDefault(); validateCourseFeedback();">{{ __('Submit Feedback') }}</x-primary-button>
            <input
                type = "hidden"
                name = "code"
                value = "{{$course->code}}"
            >
        </form>
        @if(isset($courseFeedback))
            <p class="italic text-center pt-3">Your feedback is entry #{{count($courseFeedback)+1}}</p>
        @else
            <p class="italic text-center pt-3 text-green-700 ">Thank you for contributing the first feedback entry for this course!</p>
        @endif
    </div>
</x-app-layout>
