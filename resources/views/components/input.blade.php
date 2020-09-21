
<div class="w-100 pr-5">
    <input type="{{$type}}" name="{{$name}}" class="text mb-0 mt-15"
           value="@if($value){{$value}}@else{{old($name)}}@endif"
           placeholder="{{$placeholder}}"
            {{$attributes->merge(["class"=>"text"])}}>
<x-error-message field="{{$name}}" />
</div>


