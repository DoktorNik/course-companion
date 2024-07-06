<head>
    @push('scripts')
        @vite(['resources/js/updateArray.js'])
    @endpush
    @stack('scripts')
</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Courses \ Edit') }}
        </h2>
    </x-slot>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="font-bold text-lg mb-3">Edit Course</div>
        <form method="POST" action="{{ route('courses.update', $course) }}">
            @csrf
            @method('patch')
            @if ($errors->any())
                <div class="bg-red-200 text-red-700 p-2.5 m-2">
                    <strong>Oh no, The supplied course data is invalid!</strong>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-2 flex justify-between">
                <div>
                    Code
                    <input
                        type = "text"
                        name = "courseCode"
                        placeholder = "{{__('COSC 1P02') }}"
                        value = "{{ old('courseCode', $course->courseCode) }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        required
                    >
                </div>
                <div>
                    Duration
                    <input
                        type = "text"
                        name = "courseDuration"
                        placeholder = "{{__('D1') }}"
                        value = "{{ old('courseDuration', $course->courseDuration) }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        required
                    >
                </div>
                <div>
                    Required By Major
                    <input
                        type = "text"
                        name = "requiredByMajor"
                        placeholder = "{{__('COSC')}}"
                        value = "{{ old('requiredByMajor', $course->requiredByMajor) }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        required
                    >
                </div>
            </div>
            <div class="mt-2 flex justify-between w-full">
                <div class="w-full">
                    Required Credits
                    <input
                        type = "text"
                        name = "coursePrereqCredits"
                        placeholder = "{{__('2') }}"
                        value = "{{ old('coursePrereqCredits', $course->coursePrereqCredits) }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        required
                    >
                </div>
                <div class = "pl-1 w-full">
                    Required Major Credits
                    <input
                        type = "text"
                        name = "coursesMajorPrereqCredits"
                        placeholder = "{{__('1') }}"
                        value = "{{ old('coursesMajorPrereqCredits', $course->coursesMajorPrereqCredits) }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        required
                    >
                </div>
            </div>
            <p class="mt-2">
            Course Name
                <input
                    type = "text"
                    name = "courseName"
                    placeholder = "{{__('Introduction to Computer Science') }}"
                    value = "{{ old('courseName', $course->courseName) }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    required
                >
            </p>
            <div class = "mt-2">
                Prerequisite Courses
                <div class="flex flex-nowrap w-full">
                    <input
                        id = "txtToken"
                        type = "text"
                        name = "course"
                        placeholder = "{{__('COSC 1P02')}}"
                        class="w-full block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    >
                    <x-primary-button class="ml-1" onclick="event.preventDefault(); updateArray(1)">
                        {{ __('Add') }}
                    </x-primary-button>
                    <x-primary-button class="ml-1" onclick="event.preventDefault(); updateArray(0)">
                        {{ __('Remove') }}
                    </x-primary-button>
                </div>
            </div>
            <textarea readonly
                      id="taArray"
                      name="coursePrereqs"
                      class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('coursePrereqs') }}@if(!old('coursePrereqs') && $course->coursePrereqs)@foreach($course->coursePrereqs as $cc=>$cp){{$cc}}@if ($loop->remaining > 0){{ "," }}@endif @endforeach @endif</textarea>
            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Update') }}</x-primary-button>
                <a href="{{ route('courses.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>

    </div>
</x-app-layout>
