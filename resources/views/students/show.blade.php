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
                                <span class="font-bold text-lg">{{ $student->name }}</a></span>
                                <span class="ml-1.5 text-gray-700">{{ $student->number }}</span>
                                <span class="ml-3.5 text-gray-700">{{ $student->major }} {{ __('major') }}</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            @if(!is_null($student->concentration))
                                <span class="ml-5 text-gray-700">{{ __('Concentration in ') }}{{ $student->concentration }}</span>
                            @else
                                <span class="ml-5 text-gray-700">{{ __('No concentration') }}</span>
                            @endif
                        </div>

                    </div>
                </div>
        </div>
        <div class="mt-2 flex justify-between w-full">
            <div class="w-full">
                <p class="font-bold">Credits Completed</p>
                <input readonly
                   type="text"
                   name="creditsCompleted"
                   value="{{$student->creditsCompleted}}"
                   class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
            </div>
            <div class="pl-1 w-full">
                <p class="font-bold">Major Credits Completed</p>
                <input readonly
                   type="text"
                   name="creditsCompletedMajor"
                   value="{{$student->creditsCompletedMajor}}"
                   class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
            </div>
        </div>
        <div class = "mt-2">
            <p class="font-bold">Completed Courses</p>
            <textarea readonly
                name="coursesCompleted"
                class="h-auto block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >@foreach($student->coursesCompleted as $cc){{$cc}}@if ($loop->remaining > 0){{ "," }}@endif @endforeach</textarea>
        </div>
        <div class = "mt-2">
            <p class="font-bold">Eligible Courses Required by Major</p>
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
            <p class = "mt-1 text-red-500">{{ __('* Minimum grade required to continue major')}}</p>
        </div>
        @if(is_array($student->eligibleConcentrationCourses))
        <div class = "mt-2">
            <p class="font-bold">Eligible Courses in Concentration</p>
            <div
                class="p-2 bg-white border border-gray-300 block w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >@php
                    // concentration
                    $out = "";
                    foreach($student->eligibleConcentrationCourses as $cc=>$ec) {
                        $out.= $cc.": ".$ec."<br />";
                    }
                    $out = rtrim($out, "<br />");
                    if ($out == "")
                        $out = "None";
                    echo $out;
                @endphp</div>
        </div>
        @endif
        <div class = "mt-2">
            <p class="font-bold">Eligible Major Elective Courses</p>
            <div class="p-2 bg-white border border-gray-300 block w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >@php
                // major electives
                $out = "";
                foreach($student->eligibleElectiveMajorCourses as $cc=>$ec) {
                    $out.= $cc.": ".$ec."<br />";
                }
                $out = rtrim($out, "<br />");
                if($out == "")
                    $out = "None";
                echo $out;
            @endphp</div>
        </div>
        <div class = "mt-2">
            <p class="font-bold">Eligible Non-Major Elective Courses</p>
        <div
            class="p-2 bg-white border border-gray-300 block w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        >@php
                // non-major electives
                $out = "";
                foreach($student->eligibleElectiveNonMajorCourses as $cc=>$ec) {
                    $out.= $cc.": ".$ec."<br />";
                }
                $out = rtrim($out, "<br />");
                if($out == "")
                    $out = "None";
                echo $out;
            @endphp</div>
        </div>
        @endif
        <div class="mt-4 space-x-2">
            <a href="{{ route('students.index') }}">{{ __('< Students') }}</a>
        </div>
    </div>
</x-app-layout>
