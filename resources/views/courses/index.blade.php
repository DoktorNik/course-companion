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
                    {{ __('Courses') }}
                </h2>
            </div>
            <div class = "flex w-full justify-end">
                <form method="POST" action="{{ route('courses.findCourse') }}">
                @csrf
                @method('GET')
                <div class="flex">
                    <input
                        type = "text"
                        name="code"
                        placeholder="COSC 1P02"
                        class="block w-56 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
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
        @can('create', \App\Models\Course::class)
        <div class="font-bold text-lg mb-3">Add New Course</div>
        <form method="POST" action="{{ route('courses.store') }}">
            @csrf
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
                        name = "code"
                        placeholder = "{{__('COSC 1P02') }}"
                        value = "{{ old('code') }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        required
                    >
                </div>
                <div>
                    <p class="font-bold">Duration</p>
                    <input
                        type = "text"
                        name = "duration"
                        placeholder = "{{__('D1') }}"
                        value = "{{ old('duration') }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        required
                    >
                </div>
                <div>
                    <p class="font-bold">Required By Major</p>
                    <input
                        type = "text"
                        name = "isRequiredByMajor"
                        placeholder = "{{__('COSC')}}"
                        value = "{{ old('isRequiredByMajor') }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    >
                </div>
            </div>
            <div class="mt-2 flex justify-between w-full">
                <div class="w-full">
                    <p class="font-bold">Required Credits</p>
                    <input
                        type = "text"
                        name = "prereqCreditCount"
                        placeholder = "{{__('2') }}"
                        value = "{{ old('prereqCreditCount') }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        required
                    >
                </div>
                <div class = "pl-1 w-full">
                    <p class="font-bold">Required Major Credits</p>
                    <input
                        type = "text"
                        name = "prereqCreditCountMajor"
                        placeholder = "{{__('1') }}"
                        value = "{{ old('prereqCreditCountMajor') }}"
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
                        value = "{{ old('minimumGrade') }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    >
                </div>
            </div>
            <div class = "mt-2">
                <p class="font-bold">Course Name</p>
                <input
                    type = "text"
                    name = "name"
                    placeholder = "{{__('Introduction to Computer Science') }}"
                    value = "{{ old('name') }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    required
                >
            </div>
            <div class = "mt-2">
                <p class="font-bold">Prerequisites Courses</p>
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
                <textarea readonly
                          id="taArray"
                          name="prereqs"
                          class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >{{ old('prereqs') }}</textarea>
            </div>
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
            >{{ old('concentration') }}</textarea>
            <x-primary-button class="mt-2">{{ __('Save') }}</x-primary-button>
        </form>
        @endcan

        <!-- course list -->
        <div class="font-bold text-lg mt-6 mb-3">Course Listing</div>
        <div class="bg-white shadow-sm rounded-lg divide-y">
            @foreach ($courses as $course)
                <div class="p-4 flex space-x-2">
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div class="my-1.5">
                                <span class="font-bold"><a href="{{ route('courses.show', $course) }}">{{ $course->code }}</a></span><span class="ml-1"><a href="{{ route('courses.show', $course) }}">{{$course->name}}</a></span>
                                <small class="ml-2 text-sm text-gray-600">{{ $course->duration }}</small>
                                <div class="flex justify-start w-full">
                                    <x-show-ratings :course="$course" ml="2"></x-show-ratings>
                                </div>
                            </div>
                            @if ($course->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('courses.edit', $course)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('courses.destroy', $course) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('courses.destroy', $course)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>
{{--                        <p class="mt-1.5 text-lg text-gray-900"><a href="{{ route('courses.show', $course) }}">{{ $course->name }}</a></p>--}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
