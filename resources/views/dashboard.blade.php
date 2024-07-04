<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    1) <a href="{{ route('students.index') }}">Add or update your student information on the <i>Students</i> page.</a><br />
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Don't worry it's private!
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    2) Lookup your student number to see available courses.
                    <form method="POST" action="{{ route('students.findStudent') }}">
                        @csrf
                        @method('GET')
                        <div class="flex justify-between mb-3">
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
            @can('create', \App\Models\Course::class)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    3) <a href="{{ route('courses.index') }}">Academic advisors can add, edit, and delete <i>courses</i> on the <i>courses</i> page.</a>
                </div>
            </div>
            @endcan
        </div>
    </div>
</x-app-layout>
