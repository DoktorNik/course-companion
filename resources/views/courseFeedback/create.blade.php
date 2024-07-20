<head>
    <title></title>
    @push('scripts')
        @vite(['resources/js/updateArray.js'])
    @endpush
    @stack('scripts')
</head>
<x-app-layout>
    @if(!isset($course))
        @if(isset($courseReview[0]))
            $course = $courseReview[0]->$course;
        @else
{{--//            bailout--}}
        @endif
    @endif
    <x-slot name="header">
        <div class="flex justify-between w-full">
            <div class="w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Submit Course Feedback') }}
                </h2>
            </div>
            <div class="flex justify-end w-full">
                <form method="POST" action="{{ route('courseFeedback.find') }}">
                    @csrf
                    @method('GET')
                    <div class="flex">
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
    </x-slot>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <!-- add new feedback -->
        <div>
            <p class="font-bold text-lg mt-4">New Course Feedback</p>
            <p class="ml-3">{{$course->code}}: {{$course->name}}</p>
        </div>

        <form method="POST" action="{{ route('courseFeedback.store') }}">
            @csrf
            @if ($errors->any())
                <div class="bg-red-200 text-red-700 p-2.5 m-2">
                    <strong>Oh no, The supplied course feedback is invalid!</strong>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class = "mt-2">
                <p class="font-bold">Lecturer</p>
                <input
                    type = "text"
                    name = "lecturer"
                    value = "{{ old('lecturer') }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    required
                >
            </div>
            <div class="mt-2 flex justify-between w-full">
                <div class="w-full">
                    <p class="font-bold">Difficulty</p>
                    <x-five-star id="difficulty"></x-five-star>
                </div>
                <div class="pl-1 w-full">
                    <p class="font-bold">Workload</p>
                    <x-five-star id="workload"></x-five-star>
                </div>
            </div>
            <div class="mt-2 flex justify-between w-full">
                <div class="w-full">
                    <p class="font-bold">Clarity</p>
                    <x-five-star id="clarity"></x-five-star>
                </div>
                <div class="pl-1 w-full">
                    <p class="font-bold">Relevance</p>
                    <x-five-star id="relevance"></x-five-star>
                </div>
            </div>
            <div class="mt-2 flex justify-between w-full">
                <div class="w-full">
                    <p class="font-bold">Interest</p>
                    <x-five-star id="interest"></x-five-star>
                </div>
                <div class="pl-1 w-full">
                    <p class="font-bold">Helpfulness</p>
                    <x-five-star id="helpfulness"></x-five-star>
                </div>
            </div>
            <div class="mt-2 flex justify-between w-full">
                <div class="w-full">
                    <p class="font-bold">Experiential</p>
                    <x-five-star id="experiential"></x-five-star>
                </div>
                <div class="pl-1 w-full">
                    <p class="font-bold">Affect</p>
                    <x-five-star id="affect"></x-five-star>
                </div>
            </div>
            <div class = "mt-2">
                <p class="font-bold">Comments:</p>
                <textarea
                    id="comment"
                    name="comment"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >{{ old('comment')}}</textarea>
            </div>
            <x-primary-button class="mt-2">{{ __('Submit Feedback') }}</x-primary-button>
        </form>
        @if(isset($courseFeedback))
            <p class="italic text-center pt-3">Your feedback is entry #" {{count($courseFeedback)}}</p>
        @else
            <p class="italic text-center pt-3 text-green-700 ">Thank you for contributing the first feedback entry for this course!</p>
        @endif
    </div>
</x-app-layout>
