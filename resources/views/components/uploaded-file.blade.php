<div class="file-upload mb-0 mt-15">
    <div class="i-file-upload">
        <span>{{$title}}</span>
        <input type="file" class="file-upload" id="files" name="{{$name}}" {{$attributes}} />
    </div>


    <span class="filesize"></span>
    @if(!empty($value))
        <span class="selectedFiles">تصویر فعلی</span>
        <img src="{{$value->thumb}}" alt="ss">

    @else

        <span class="selectedFiles">فایلی انتخاب نشده است</span>

    @endif



</div>
<x-error-message field="{{$name}}" />
