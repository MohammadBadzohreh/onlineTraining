<div class="w-100 pr-5">
    <input type="{{$type}}" name="{{$name}}" class="text mb-0 mt-15" value="{{old($name)}}" placeholder="{{$placeholder}}" {{$attributes->merge(["class"=>"text"])}}>
<x-error-message field="{{$name}}" />
</div>


