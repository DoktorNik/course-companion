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
            <x-dashboard-text heading="No results found!" text="Unfortunately, there were no results found for your query."></x-dashboard-text>
        </div>
    </div>
</x-app-layout>
