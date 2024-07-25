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
