<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="font-bold text-xl">{{ __("Welcome to the course companion!") }}</p>
                    <p class="italic ml-3">{{ __("Proudly brought to you by the Computer Science Club") }}</p>
                </div>
            </div>
            <a href="{{ route('students.index') }}">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <p class="font-semibold">1) Student Information</p>
                    <p class="ml-4 mt-1">Add or update your student information on the <i>Students</i> page</p>
                </div>
            </div>
            </a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <p class="font-semibold">2) Lookup your student number to see available courses.</p>
                    <form method="POST" action="{{ route('students.findStudent') }}">
                        @csrf
                        @method('GET')
                        <div class="flex pl-4 mt-1 mb-3">
                            <input
                                type = "text"
                                name="number"
                                placeholder="1234567"
                                class="block w-36 mr-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            >
                            <x-primary-button class="ml-1">
                                Lookup
                            </x-primary-button>
                        </div>
                    </form>
                    <p class="ml-4">Hover over a course to see it's blurb</p>
                    <p class="ml-4">Click course name or rating in blurb for details</p>
                </div>
            </div>
            @can('create', \App\Models\Course::class)
            <a href="{{ route('courses.index') }}">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <p class="font-semibold">Academic Advisors</p>
                    <p class="ml-4">* Academic advisors can add, edit, and delete <i>courses</i> on the <i>courses</i> page</p>
                </div>
            </div>
            </a>
            @endcan
        </div>
    </div>
</x-app-layout>
