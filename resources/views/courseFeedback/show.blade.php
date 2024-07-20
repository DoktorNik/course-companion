<head>
    <title></title>
    @push('scripts')
        @vite(['resources/js/updateArray.js'])
    @endpush
    @stack('scripts')
</head>
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
                        @if(isset($course))
                            <input type = "hidden" value="{{$course->code}}" name="code">
                        @else
                            <input type = "hidden" value="{{$courseFeedback->code}}" name="code">
                        @endif
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(isset($course))
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-4">
                <div class="p-6 text-gray-900">
                    <p class="font-bold text-lg">{{ $course->code }}: {{$course->name}}</p>
                    <p class="font-bold text-red-500">There is no feedback available for this course yet!</p>
                    <p class="text-sm ml-3">Please be the first to add feedback</p>
                </div>
            </div>
            @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-4">
                <div class="p-6 text-gray-900">
{{--                    {{ dd($courseFeedback) }}--}}
                    <p class="font-bold text-lg">{{ $courseFeedback->course->code }}: {{$courseFeedback->course->name}}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
