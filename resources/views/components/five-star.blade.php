@php
    // sanity check
    if(!isset($id))
        dd(null);

    // set emoji codes and tooltips
    $code = '&#';
    $tooltip = '';
    if($id == "difficulty") {
       $code .= '128547';   // persevering face
       $tooltip = "How challenging the course is";
   }
    elseif($id == "workload") {
        $code .= '128338';  // clock
        $tooltip = "How much work this course took";
    }
    elseif($id == "clarity") {
        $code .= '128302';   // crystal ball
        $tooltip = "How clear the course material is";
    }
    elseif($id == "relevance") {
        $code .= '128175';  // 100
        $tooltip = "How relevant the course material is";
    }
    elseif($id == "interest") {
        $code .= '128373';  // detective
        $tooltip = "How interesting the course is";
    }
    elseif($id == "helpfulness") {
        $code .= '129309';  // handshake
        $tooltip = "How helpful the course is";
    }
    elseif($id == "experiential") {
        $code .= '127970';  // office building
        $tooltip = "How much experience you gained in the course";
    }
    elseif($id == "affect") {
        $code .= '128151';  // growing heart
        $tooltip = "How positive you felt during the course";
    }
    else
        $code .= '127775';  // glowing star
@endphp
{{--display rating div--}}
<div class = "flex flex-row-reverse justify-end">
    <input class="hidden peer peer-checked:opacity-100" type="radio" id="{{$id}}5" name="rating{{ucfirst($id)}}" value="5">
    <label class="text-3xl cursor-pointer opacity-25 hover:opacity-100 peer peer-hover:opacity-100 peer-checked:opacity-100" for="{{$id}}5" title="{{$tooltip}} 5/5">{!!$code!!}</label>
    <input class="hidden peer peer-checked:opacity-100" type="radio" id="{{$id}}4" name="rating{{ucfirst($id)}}" value="4">
    <label class="text-3xl cursor-pointer opacity-25 hover:opacity-100 peer peer-hover:opacity-100 peer-checked:opacity-100" for="{{$id}}4" title="{{$tooltip}} 4/5">{!!$code!!}</label>
    <input class="hidden peer peer-checked:opacity-100" type="radio" id="{{$id}}3" name="rating{{ucfirst($id)}}" value="3">
    <label class="text-3xl cursor-pointer opacity-25 hover:opacity-100 peer peer-hover:opacity-100 peer-checked:opacity-100" for="{{$id}}3" title="{{$tooltip}} 3/5">{!!$code!!}</label>
    <input class="hidden peer peer-checked:opacity-100" type="radio" id="{{$id}}2" name="rating{{ucfirst($id)}}" value="2">
    <label class="text-3xl cursor-pointer opacity-25 hover:opacity-100 peer peer-hover:opacity-100 peer-checked:opacity-100" for="{{$id}}2" title="{{$tooltip}} 2/5">{!!$code!!}</label>
    <input class="hidden peer peer-checked:opacity-100" type="radio" id="{{$id}}1" name="rating{{ucfirst($id)}}" value="1">
    <label class="text-3xl cursor-pointer opacity-25 hover:opacity-100 peer peer-hover:opacity-100 peer-checked:opacity-100" for="{{$id}}1" title="{{$tooltip}} 1/5">{!!$code!!}</label>
</div>
