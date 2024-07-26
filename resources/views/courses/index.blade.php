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
                    {{ __('Courses') }}
                </h2>
            </div>

            <div class="flex w-full justify-end">
                <form class="m-0" method="POST" action="{{ route('courses.create') }}">
                    @csrf
                    @method('GET')
                    <input type = "hidden" name="code">
                    <div class="flex">
                        <x-primary-button class="ml-1">
                            Add Course
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>

        <!-- course list -->
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="font-bold text-lg mt-6 mb-3">Course Listing</div>
        <div class="bg-white shadow-sm rounded-lg divide-y">
            @foreach ($courses as $course)
                <x-course-highlight :course="$course" :p="4"></x-course-highlight>
            @endforeach
        </div>
    </div>
</x-app-layout>
