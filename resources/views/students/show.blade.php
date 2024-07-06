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
                                <span class="ml-3.5 text-gray-700">{{ $student->major }} {{ __(' Major') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="mt-2 flex justify-between w-full">
            <div class="w-full">
                Credits Completed
                <input readonly
                   type="text"
                   name="creditsCompleted"
                   value="{{$student->creditsCompleted}}"
                   class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
            </div>
            <div class="pl-1 w-full">
                Major Credits Completed
                <input readonly
                   type="text"
                   name="majorCreditsCompleted"
                   value="{{$student->majorCreditsCompleted}}"
                   class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
            </div>
        </div>
        <p class = "mt-2">
            Completed Courses
            <textarea readonly
                name="coursesCompleted"
                class="h-auto block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >@foreach($student->coursesCompleted as $cc){{$cc}}@if ($loop->remaining > 0){{ "," }}@endif @endforeach</textarea>
        </p>
        <p class = "mt-2">
            Eligible Courses Required by Major
            <div
                class="p-2 bg-white border border-gray-300 block w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >@php
                // required by major
                $out = "";
                foreach($student->eligibleRequiredCourses as $cc=>$ec) {
                    $out.= $cc.": ".$ec."<br />";
                }
                $out = rtrim($out, "<br />");
                echo $out;
                @endphp</div>
        </p>
        <p class = "mt-2">
            Eligible Elective Courses
        <div
            class="p-2 bg-white border border-gray-300 block w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        >@php
                // required by major
                $out = "";
                foreach($student->eligibleElectiveCourses as $cc=>$ec) {
                    $out.= $cc.": ".$ec."<br />";
                }
                $out = rtrim($out, "<br />");
                echo $out;
            @endphp</div>
        </p>

        @endif
        <div class="mt-4 space-x-2">
            <a href="{{ route('students.index') }}">{{ __('< Students') }}</a>
        </div>
    </div>
</x-app-layout>
