<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Courses \ Show') }}
        </h2>
    </x-slot>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        @if(is_null($course))
            <div class="bg-red-200 text-red-700 p-2.5 m-2">
                <strong>Unable to find course!</strong>
            </div>
        @else
        <div class="divide-y">
            <div class="p-6 flex space-x-2">
                <div class="flex-1">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="font-bold text-lg">{{ $course->courseCode }}: {{$course->courseName}}</span>
                            <span class="ml-1.5 text-gray-700">{{ $course->courseDuration }}</span>
                        </div>
                    </div>
                    <div>
                        <small class="ml-2 text-sm text-gray-600">{{ $course->coursePrereqCredits }} credits required</small>
                        <small class="ml-2 text-sm text-gray-600">{{ $course->coursesMajorPrereqCredits }} major credits required</small>
                    </div>
                </div>
            </div>
        </div>
        <p class = "mt-2">
            Prerequisite Courses
            <textarea readonly
                      id="taArray"
                      name="coursePrereqs"
                      class="h-auto block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >@php
                if(!is_null($course->coursePrereqs)) {
                    $out = "";
                    foreach($course->coursePrereqs as $cc=>$cn) {
                        $out.= $cc.": ".$cn."&#013;";
                    }
                    $out = substr($out, 0, -1);
                    echo $out;
                }
                @endphp</textarea>
        </p>
        @endif
        <div class="mt-4 space-x-2">
            <a href="{{ route('courses.index') }}">{{ __('Back') }}</a>
        </div>
    </div>
</x-app-layout>
