@php
    $p = 'px-'.$p;
@endphp
<div class="{!!$p!!} flex space-x-2">
    <div class="flex-1">
        <div class="flex justify-between items-center">
            <div class="my-1.5">
                <span class="font-bold"><a href="{{ route('courses.show', $course) }}">{{ $course->code }}</a></span><span class="ml-1"><a href="{{ route('courses.show', $course) }}">{{$course->name}}</a></span>
                <small class="ml-2 text-sm text-gray-600">{{ $course->duration }}</small>
                <div class="flex justify-start w-full">
                    <x-show-ratings :course="$course" ml="2"></x-show-ratings>
                </div>
            </div>
        </div>
    </div>
</div>
