<head>
    <title></title>
</head>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div class="w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Students') }}
                </h2>
            </div>

            <div class="flex w-full justify-end">
                <form class="m-0" method="POST" action="{{ route('students.create') }}">
                    @csrf
                    @method('GET')
                    <input type = "hidden" name="code">
                    <div class="flex">
                        <x-primary-button class="ml-1">
                            Add Student
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>
{{--    main div--}}
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <! -- student list -->
        <div class="font-bold text-lg mt-6 mb-3">Student Listing</div>
        <div class="bg-white shadow-sm rounded-lg divide-y">
            @foreach ($students as $student)
                <div class="p-6 flex space-x-2">
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="font-bold"><a href="{{ route('students.show', $student) }}">{{ $student->name }}</a></span>
                                @can('update', $student)
                                    <small class="ml-2 text-sm text-gray-600"><a href="{{ route('students.show', $student) }}">{{ $student->number }}</a></small>
                                @endcan
                                @cannot('update', $student)
                                    <small class="ml-1.5 text-red-300">{{ $student->number }}</small>
                                @endcannot
                            </div>
                        </div>
                        <p class="mt-2 ml-3 text-gray-700">
                            Credits Completed: {{ $student->creditsCompleted }}
                        </p>
                        <p class="mt-2 ml-3 text-gray-700">
                            Major Credits Completed: {{ $student->creditsCompletedMajor }}
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
