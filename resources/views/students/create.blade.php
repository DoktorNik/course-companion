<head>
<title></title>
    @push('scripts')
        @vite(['resources/js/updateArray.js'])
    @endpush
    @stack('scripts')
</head>
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div class="w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Student \ New') }}
                </h2>
            </div>
        </div>
    </x-slot>
    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
        <!-- add new student -->
        <div class="font-bold text-lg mt-8 mb-3">Add New Student</div>
        <form method="POST" action="{{ route('students.store') }}">
            @csrf
            @method('POST')
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
            <div class = "mt-2">
                <p class="font-bold">Student Name</p>
                <input
                    type = "text"
                    name = "name"
                    placeholder = "{{__('Thomas Anderson') }}"
                    value = "{{ old('name') }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    required
                >
            </div>
            <div class="mt-2 flex justify-between w-full">
                <div class="w-full">
                    <p class="font-bold">Student Number</p>
                    <input
                        type = "text"
                        name = "number"
                        placeholder = "{{__('1234567') }}"
                        value = "{{ old('number') }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        required
                    >
                </div>
                <div class="pl-1 w-full">
                    <p class="font-bold">Major</p>
                    <input
                        type = "text"
                        name = "major"
                        placeholder= "{{__('COSC') }}"
                        value = "{{ old('major') }}"
                        class = "block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        required
                    >
                </div>
                <div class="pl-1 w-full">
                    <p class="font-bold">Concentration</p>
                    <input
                        type = "text"
                        name = "concentration"
                        placeholder= "{{__('Artificial Intelligence') }}"
                        value = "{{ old('concentration') }}"
                        class = "block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    >
                </div>
            </div>
            <div class = "mt-2">
                <p class="font-bold">Completed Courses</p>
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
                      name="coursesCompleted"
                      class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('coursesCompleted') }}</textarea>
            <x-primary-button class="mt-2">{{ __('Save') }}</x-primary-button>
        </form>
    </div>
</x-app-layout>
