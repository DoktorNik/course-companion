<head>
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
                    {{ __('Students') }}
                </h2>
            </div>
            <div class="flex justify-end w-full">
                <form method="POST" action="{{ route('students.findStudent') }}">
                    @csrf
                    @method('GET')
                    <div class="flex">
                        <input
                            type = "text"
                            name="studentNumber"
                            placeholder="1234567"
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
        <!-- add new student -->
        <div class="font-bold text-lg mt-8 mb-3">Add New Student</div>
        <form method="POST" action="{{ route('students.store') }}">
            @csrf
            @if ($errors->any())
                <div class="bg-red-200 text-red-700 p-2.5 m-2">
                    <strong>Oh no, The supplied student data is invalid!</strong>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <p class = "mt-2">
                Student Name
                <input
                    type = "text"
                    name = "studentName"
                    placeholder = "{{__('Thomas Anderson') }}"
                    value = "{{ old('studentName') }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    required
                >
            </p>
            <div class="mt-2 flex justify-between w-full">
                <div class="w-full">
                    Student Number
                    <input
                        type = "text"
                        name = "studentNumber"
                        placeholder = "{{__('1234567') }}"
                        value = "{{ old('studentNumber') }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        required
                    >
                </div>
                <div class="pl-1 w-full">
                    Major
                    <input
                        type = "text"
                        name = "major"
                        placeholder= "{{__('COSC') }}"
                        value = "{{ old('major') }}"
                        class = "block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        required
                    >
                </div>
            </div>
            <div class = "mt-2">
                Completed Courses
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
                name="coursesCompleted"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('coursesCompleted') }}</textarea>
            <x-primary-button class="mt-2">{{ __('Save') }}</x-primary-button>
        </form>

        <! -- student list -->
        <div class="font-bold text-lg mt-6 mb-3">Student Listing</div>
        <div class="bg-white shadow-sm rounded-lg divide-y">
            @foreach ($students as $student)
                <div class="p-6 flex space-x-2">
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-900"><a href="{{ route('students.show', $student) }}">{{ $student->studentName }}</a></span>
                                @can('update', $student)
                                    <small class="ml-2 text-sm text-gray-600"><a href="{{ route('students.show', $student) }}">{{ $student->studentNumber }}</a></small>
                                @endcan
                                @cannot('update', $student)
                                    <small class="ml-1.5 text-red-300">{{ $student->studentNumber }}</small>
                                @endcannot
                            </div>
                        </div>
                        <p class="mt-2 ml-3 text-gray-700">
                            Credits Completed: {{ $student->creditsCompleted }}
                        </p>
                        <p class="mt-2 ml-3 text-gray-700">
                            Major Credits Completed: {{ $student->majorCreditsCompleted }}
                        </p>
                    </div>
                    @if ($student->user->is(auth()->user()))
                        <x-dropdown>
                            <x-slot name="trigger">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('students.edit', $student)">
                                    {{ __('Edit') }}
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('students.destroy', $student) }}">
                                    @csrf
                                    @method('delete')
                                    <x-dropdown-link :href="route('students.destroy', $student)" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Delete') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
