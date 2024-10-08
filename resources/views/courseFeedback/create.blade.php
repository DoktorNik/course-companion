<head>
    <title></title>
    @push('scripts')
        @vite(['resources/js/validateCourseFeedback.js'])

    @endpush
    @stack('scripts')
</head>
@php
if(!isset($course))
    $course = null;
@endphp
<x-app-layout>
    @if(is_null($course))
        @if(isset($courseFeedback))
            @php
                $course = $courseFeedback[0]->course;
            @endphp
        @else
{{--        // 2do: bail out--}}
        @endif
    @endif
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div class="w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Course Feedback \ New') }}
                </h2>
            </div>
        </div>
    </x-slot>
    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
        <!-- add new feedback -->
        <div>
            <p class="font-bold text-lg mt-4">New Course Feedback</p>
            <p class="ml-3">{{$course->code}}: {{$course->name}}</p>
        </div>

        <form method="POST" id ="courseFeedbackForm" action="{{ route('courseFeedback.store') }}">
            @csrf
                <div id="errorList" class="hidden bg-red-200 text-red-700 p-2.5 m-2">
                @if ($errors->any())
                    <strong>Oh no, The supplied course feedback is invalid!</strong>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                </div>
            <div class = "mt-4 font-bold">
                <input
                    type = "text"
                    id = "lecturer"
                    name = "lecturer"
                    placeholder = "Lecturer"
                    value = "{{ old('lecturer') }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    required
                >
            </div>
            <div class="mt-6 flex justify-between w-full">
                <div class="w-full flex flex-col items-center">
                    <p class="font-bold" title="How challenging you found the course">Difficulty</p>
                    <x-five-star id="difficulty"></x-five-star>
                </div>
                <div class="w-full flex flex-col items-center">
                    <p class="font-bold" title="How much work you did in this course">Workload</p>
                    <x-five-star id="workload"></x-five-star>
                </div>
            </div>
            <div class="mt-2 flex justify-between w-full">
                <div class="w-full flex flex-col items-center">
                    <p class="font-bold" title="How clear the course material is">Clarity</p>
                    <x-five-star id="clarity"></x-five-star>
                </div>
                <div class="w-full flex flex-col items-center">
                    <p class="font-bold" title="How relevant the course material is">Relevance</p>
                    <x-five-star id="relevance"></x-five-star>
                </div>
            </div>
            <div class="mt-2 flex justify-between w-full">
                <div class="w-full flex flex-col items-center">
                    <p class="font-bold" title="How interesting the course is">Interest</p>
                    <x-five-star id="interest"></x-five-star>
                </div>
                <div class="w-full flex flex-col items-center">
                    <p class="font-bold" title="How helpful the course is">Helpfulness</p>
                    <x-five-star id="helpfulness"></x-five-star>
                </div>
            </div>
            <div class="mt-2 flex justify-between w-full">
                <div class="w-full flex flex-col items-center">
                    <p class="font-bold" title="How much experience you gained in the course">Experiential</p>
                    <x-five-star id="experiential"></x-five-star>
                </div>
                <div class="w-full flex flex-col items-center">
                    <p class="font-bold" title="How positive you felt during the course">Positive Affect</p>
                    <x-five-star id="affect"></x-five-star>
                </div>
            </div>
            <div class = "mt-8">
                <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
                <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
                <link
                    rel="stylesheet"
                    href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css"
                />
                <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />

                <div id="toolbar-container">
                  <span class="ql-formats">
                    <select class="ql-font"></select>
                    <select class="ql-size"></select>
                  </span>
                <span class="ql-formats">
                    <button class="ql-bold"></button>
                    <button class="ql-italic"></button>
                    <button class="ql-underline"></button>
                    <button class="ql-strike"></button>
                  </span>
                <span class="ql-formats">
                    <select class="ql-color"></select>
                    <select class="ql-background"></select>
                  </span>
                <span class="ql-formats">
                    <button class="ql-script" value="sub"></button>
                    <button class="ql-script" value="super"></button>
                  </span>
                <span class="ql-formats">
                    <button class="ql-header" value="1"></button>
                    <button class="ql-header" value="2"></button>
                    <button class="ql-blockquote"></button>
                  </span>
                <span class="ql-formats">
                    <button class="ql-list" value="ordered"></button>
                    <button class="ql-list" value="bullet"></button>
                    <button class="ql-indent" value="-1"></button>
                    <button class="ql-indent" value="+1"></button>
                  </span>
                    <span class="ql-formats">
                    <button class="ql-clean"></button>
                  </span>
                </div>
                <div style="background:#FFFFFF; height:20em;" id="editor">
                </div>
            <x-primary-button class="mt-2" onclick="event.preventDefault(); validateCourseFeedback();">{{ __('Submit Feedback') }}</x-primary-button>
                @if(isset($course->courseFeedback) && count($course->courseFeedback) > 1)
                    <p class="italic text-center pt-8">Your feedback is entry #{{count($course->courseFeedback)+1}}</p>
                @else
                    <p class="italic text-center pt-8 text-green-700 ">Thank you for contributing the first feedback entry for this course!</p>
                @endif
            </div>
            <input type = "hidden" name="comment" id="quill-editor-area">
            <input
                type = "hidden"
                name = "code"
                value = "{{$course->code}}"
            >

            <!-- Initialize Quill editor -->
            <script>
                const quill = new Quill('#editor', {
                    modules: {
                        syntax: true,
                        toolbar: '#toolbar-container',
                    },
                    placeholder: 'Please leave your detailed comments on this course for your fellow students.',
                    theme: 'snow',
                });

                // put the quill text in hidden input
                let quillEditor = document.getElementById('quill-editor-area');
                quill.on('text-change', function() {
                    quillEditor.value = quill.root.innerHTML;
                });

                quillEditor.addEventListener('input', function() {
                    quill.root.innerHTML = quillEditor.value;
                });
            </script>

        </form>
    </div>
</x-app-layout>
