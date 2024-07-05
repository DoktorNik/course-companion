<head>
    @push('scripts')
        @vite(['resources/js/updateArray.js'])
    @endpush
    @stack('scripts')
</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Students \ Edit') }}
        </h2>
    </x-slot>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('students.update', $student) }}">
            @csrf
            @method('patch')
            <div class="font-bold text-lg mb-3">Edit Student</div>
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
            <p class="mt-2">
                Student Name
                <input
                    type = "text"
                    name = "studentName"
                    placeholder = "{{__('Thomas Anderson') }}"
                    value = "{{ old('studentName', $student->studentName) }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
            </p>
            <div class="mt-2 flex justify-between w-full">
                <div class="w-full">
                    Student Number
                    <input
                        type = "text"
                        name = "studentNumber"
                        placeholder = "{{__('1234567') }}"
                        value = "{{ old('studentNumber', $student->studentNumber) }}"
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
                        value = "{{ old('major', $student->major) }}"
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
            >{{ old('coursesCompleted') }}@if(!old('coursesCompleted') && $student->coursesCompleted)@foreach($student->coursesCompleted as $cc){{$cc}}@if ($loop->remaining > 0){{ "," }}@endif @endforeach @endif</textarea>
            <div class="mt-4 space-x-2">
                <x-primary-button class="mt-4">{{ __('Update') }}</x-primary-button>
                    <a href="{{ route('students.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
