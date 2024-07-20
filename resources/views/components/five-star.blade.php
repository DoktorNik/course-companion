<div class = "flex flex-row-reverse justify-end">
{{--    <div class = "flex mb-5 flex-row-reverse justify-end">--}}
{{--        <input class = "hidden checked:text-orange-400" type = "radio" id="{{$id}}5" name="rating" value="5">--}}
{{--        <label class = "text-2xl cursor-pointer hover:text-orange-400" for="{{$id}}5">&#9733;</label>--}}
{{--        <input class = "hidden checked:text-orange-400" type = "radio" id="{{$id}}4" name="rating" value="4">--}}
{{--        <label class = "text-2xl cursor-pointer hover:text-orange-400" for="{{$id}}4">&#9733;</label>--}}
{{--        <input class = "hidden checked:text-orange-400" type = "radio" id="{{$id}}3" name="rating" value="3">--}}
{{--        <label class = "text-2xl cursor-pointer hover:text-orange-400" for="{{$id}}3">&#9733;</label>--}}
{{--        <input class = "hidden checked:text-orange-400" type = "radio" id="{{$id}}2" name="rating" value="2">--}}
{{--        <label class = "text-2xl cursor- hover:text-orange-400" for="{{$id}}2">&#9733;</label>--}}
{{--        <input class = "hidden checked:text-orange-400" type = "radio" id="{{$id}}1" name="rating" value="1">--}}
{{--        <label class = "text-2xl cursor-pointer hover:text-orange-400" for="{{$id}}1">&#9733;</label>--}}
{{--    </div>--}}
    <input class="hidden bg-yellow-100 peer peer-hover:bg-yellow-500 hover:bg-yellow-400" type="radio" id="{{$id}}5 onClick=" name="{{$id}}Rating" value="5">
    <label class="text-5xl cursor-pointer hover:text-orange-400 peer peer-hover:text-orange-400" for="{{$id}}5" onclick="event.preventDefault(); updateRanking(5, {{$id}})">&#9733;</label>
    <input class="hidden bg-yellow-100 peer peer-hover:bg-yellow-500 hover:bg-yellow-400" type="radio" id="{{$id}}4" name="{{$id}}Rating" value="4">
    <label class="text-5xl cursor-pointer hover:text-orange-400 peer peer-hover:text-orange-400" for="{{$id}}4" onclick="event.preventDefault(); updateRanking(4, {{$id}})">&#9733;</label>
    <input class="hidden bg-yellow-100 peer peer-hover:bg-yellow-500 hover:bg-yellow-400" type="radio" id="{{$id}}3" name="{{$id}}Rating" value="3">
    <label class="text-5xl cursor-pointer hover:text-orange-400 peer peer-hover:text-orange-400" for="{{$id}}3" onclick="event.preventDefault(); updateRanking(3, {{$id}})">&#9733;</label>
    <input class="hidden bg-yellow-100 peer peer-hover:bg-yellow-500 hover:bg-yellow-400" type="radio" id="{{$id}}2" name="{{$id}}Rating" value="2">
    <label class="text-5xl cursor-pointer hover:text-orange-400 peer peer-hover:text-orange-400" for="{{$id}}2" onclick="event.preventDefault(); updateRanking(2, {{$id}})">&#9733;</label>
    <input class="hidden bg-yellow-100 peer peer-hover:bg-yellow-500 hover:bg-yellow-400" type="radio" id="{{$id}}1" name="{{$id}}Rating" value="1">
    <label class="text-5xl cursor-pointer hover:text-orange-400 peer peer-hover:text-orange-400" for="{{$id}}1" onclick="event.preventDefault(); updateRanking(1, {{$id}})">&#9733;</label>
</div>
