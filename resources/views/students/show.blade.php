<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Students \ Show') }}
        </h2>
    </x-slot>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        @if(is_null($student))
            <div class="bg-red-200 text-red-700 p-2.5 m-2">
                <strong>Unable to find student!</strong>
            </div>
        @else
        <div class="divide-y">
                <div class="p-6 flex space-x-2">
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="font-bold text-lg">{{ $student->studentName }}</a></span>
                                <span class="ml-1.5 text-gray-700">{{ $student->studentNumber }}</span>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <p class = "mt-2">
            Credits Completed
            <input readonly
                   type="text"
                   name="creditsCompleted"
                   value="{{$student->creditsCompleted}}"
                   class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >
        </p>
        <p class = "mt-2">
            Completed Courses
            <textarea readonly
                name="coursesCompleted"
                class="h-auto block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >@foreach($student->coursesCompleted as $cc){{$cc}}@if ($loop->remaining > 0){{ "," }}@endif @endforeach</textarea>
        </p>
        <p class = "mt-2">
            Eligible Courses
            <div
                class="p-2 bg-white border border-gray-300 block w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >@php
                $out = "";
                foreach($student->eligibleCourses as $cc=>$ec) {
                    $out.= $cc.": ".$ec."<br />";
                }
                $out = rtrim($out, "<br />");
                echo $out;
                @endphp</div>
            </p>
        @endif
        <div class="mt-4 space-x-2">
            <a href="{{ route('students.index') }}">{{ __('Back') }}</a>
        </div>
    </div>
</x-app-layout>
