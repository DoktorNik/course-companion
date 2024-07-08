<head>
    <title></title>
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
                    <p class="font-bold">Code</p>
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
                    <p class="font-bold">Duration</p>
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
                    <p class="font-bold">Required By Major</p>
                    <input
                        type = "text"
                        name = "requiredByMajor"
                        placeholder = "{{__('COSC')}}"
                        value = "{{ old('requiredByMajor', $course->requiredByMajor) }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    >
                </div>
            </div>
            <div class="mt-2 flex justify-between w-full">
                <div class="w-full">
                    <p class="font-bold">Required Credits</p>
                    <input
                        type = "text"
                        name = "prereqCredits"
                        placeholder = "{{__('2') }}"
                        value = "{{ old('prereqCredits', $course->prereqCredits) }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        required
                    >
                </div>
                <div class = "pl-1 w-full">
                    <p class="font-bold">Required Major Credits</p>
                    <input
                        type = "text"
                        name = "prereqMajorCredits"
                        placeholder = "{{__('1') }}"
                        value = "{{ old('prereqMajorCredits', $course->prereqMajorCredits) }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        required
                    >
                </div>
                <div class = "pl-1 w-full">
                    <p class="font-bold">Minimum Grade</p>
                    <input
                        type = "text"
                        name = "minimumGrade"
                        placeholder = "{{__('60') }}"
                        value = "{{ old('minimumGrade', $course->minimumGrade) }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    >
                </div>
            </div>
            <div class="mt-2">
                <p class="font-bold">Course Name</p>
                <input
                    type = "text"
                    name = "courseName"
                    placeholder = "{{__('Introduction to Computer Science') }}"
                    value = "{{ old('courseName', $course->courseName) }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    required
                >
            </div>
            <div class = "mt-2">
                <p class="font-bold">Prerequisite Courses</p>
                <div class="flex flex-nowrap w-full">
                    <input
                        id = "txtToken"
                        type = "text"
                        name = "course"
                        placeholder = "{{__('COSC 1P02')}}"
                        class="w-full block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    >
                    <x-primary-button class="ml-1" onclick="event.preventDefault(); updateArray(1, 'txtToken', 'taArray')">
                        {{ __('Add') }}
                    </x-primary-button>
                    <x-primary-button class="ml-1" onclick="event.preventDefault(); updateArray(0, 'txtToken', 'taArray')">
                        {{ __('Remove') }}
                    </x-primary-button>
                </div>
            </div>
            <textarea readonly
                      id="taArray"
                      name="coursePrereqs"
                      class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('coursePrereqs') }}@if(!old('coursePrereqs') && $course->coursePrereqs)@foreach($course->coursePrereqs as $cc=>$cp){{$cp}}@if ($loop->remaining > 0){{ "," }}@endif @endforeach @endif</textarea>
            <div class = "mt-2">
                <p class="font-bold">Concentrations</p>
                <div class="flex flex-nowrap w-full">
                    <input
                        id = "txtToken2"
                        type = "text"
                        name = "concentrationToken"
                        placeholder = "{{__('Artificial Intelligence')}}"
                        class="w-full block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    >
                    <x-primary-button class="ml-1" onclick="event.preventDefault(); updateArray(1, 'txtToken2', 'taArray2')">
                        {{ __('Add') }}
                    </x-primary-button>
                    <x-primary-button class="ml-1" onclick="event.preventDefault(); updateArray(0, 'txtToken2', 'taArray2')">
                        {{ __('Remove') }}
                    </x-primary-button>
                </div>
            </div>
            <textarea readonly
                      id="taArray2"
                      name="concentration"
                      class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('concentration') }}@if(!old('concentration') && $course->concentration)@foreach($course->concentration as $cc){{$cc}}@if ($loop->remaining > 0){{ "," }}@endif @endforeach @endif</textarea>
        <div class="mt-4 space-x-2">
            <x-primary-button>{{ __('Update') }}</x-primary-button>
            <a href="{{ route('courses.index') }}">{{ __('Cancel') }}</a>
        </div>
        </form>
    </div>
</x-app-layout>
