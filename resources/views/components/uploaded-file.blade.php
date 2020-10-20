<div class="file-upload mb-0 mt-15">
    <div class="i-file-upload">
        <span>{{$title}}</span>
        <input type="file" class="file-upload" id="files" name="{{$name}}" {{$attributes}} />
    </div>


    <span class="filesize"></span>
    @if(!empty($value))
        <span class="selectedFiles">فایل فعلی</span>
        <span>{{$value->file_name}}</span>
        <img src="{{$value->thumb}}" width="100" height="100" alt="{{$value->file_name}}">
    @else
        <span class="selectedFiles">فایلی انتخاب نشده است</span>

    @endif


</div>
<x-error-message field="{{$name}}"/>
