<head>
    <title></title>
</head>
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div class="w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Search Results') }}
                </h2>
            </div>
        </div>
    </x-slot>

    {{--    main div--}}
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="font-bold text-lg mt-6 mb-3">Search Results</div>
            <div class="bg-white shadow-sm rounded-lg divide-y">
                {{-- display search results--}}
                @foreach ($result as $res)
                    @if((get_class($res) == "App\Models\Course"))
                    <div class="p-4 flex space-x-2">
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <div class="my-1.5">
                                        <span class="font-bold"><a href="{{ route('courses.show', $res) }}">{{ $res->code }}</a></span><span class="ml-1"><a href="{{ route('courses.show', $res) }}">{{$res->name}}</a></span>
                                        <small class="ml-2 text-sm text-gray-600">{{ $res->duration }}</small>
                                        <div class="flex justify-start w-full">
                                            <x-show-ratings :course="$res" ml="2"></x-show-ratings>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-6 flex space-x-2">
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="font-bold"><a href="{{ route('students.show', $res) }}">{{ $res->name }}</a></span>
                                        @can('update', $res)
                                            <small class="ml-2 text-sm text-gray-600"><a href="{{ route('students.show', $res) }}">{{ $res->number }}</a></small>
                                        @endcan
                                        @cannot('update', $res)
                                            <small class="ml-1.5 text-red-300">{{ $res->number }}</small>
                                        @endcannot
                                    </div>
                                </div>
                                <p class="mt-2 ml-3 text-gray-700">
                                    Credits Completed: {{ $res->creditsCompleted }}
                                </p>
                                <p class="mt-2 ml-3 text-gray-700">
                                    Major Credits Completed: {{ $res->creditsCompletedMajor }}
                                </p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
