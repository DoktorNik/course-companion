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
                    {{ __('Course Feedback') }}
                </h2>
            </div>
        </div>
    </x-slot>
{{--    main div--}}
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-dashboard-text heading="Course Feedback" text="Course feedback is anonymously provided by students, for students."></x-dashboard-text>
            <x-dashboard-text heading="Anonymity" text="Only what you enter is included when providing course feedback. Your student number, login, and other identifying information is not saved."></x-dashboard-text>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-4">
                <div class="p-6 text-gray-900">
                    <p class="font-bold text-xl">Course Code</p>
                    <p class="italic ml-3">Lookup a course code to add or view feedback</p>
                    <br/>
                    <form method="POST" action="{{ route('courseFeedback.find') }}">
                        @csrf
                        @method('GET')
                        <div class="flex justify-between mb-3">
                            <input
                                type = "text"
                                name="code"
                                placeholder="COSC 1P02"
                                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            >
                            <x-primary-button class="ml-1">
                                Lookup
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
