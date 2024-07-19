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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <p class="font-semibold">1) <a href="{{ route('students.index') }}">Add or update your student information on the <i>Students</i> page.</a></p>
                    <p class="ml-4">Don't worry it's private!</p>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <p class="font-semibold">2) Lookup your student number to see available courses.</p>
                    <form method="POST" action="{{ route('students.findStudent') }}">
                        @csrf
                        @method('GET')
                        <div class="flex justify-between mb-3">
                            <input
                                type = "text"
                                name="number"
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
            @can('create', \App\Models\Course::class)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <p class="font-semibold">Academic Advisors</p>
                    <p class="ml-4">* <a href="{{ route('courses.index') }}">Academic advisors can add, edit, and delete <i>courses</i> on the <i>courses</i> page.</a></p>
                </div>
            </div>
            @endcan
        </div>
    </div>
</x-app-layout>
