<textarea placeholder="{{$placeholder}}"  name="{{$name}}" class="text h mb-0 mt-15">
    {{$slot}}

</textarea>
<x-error-message field="{{$name}}" />
