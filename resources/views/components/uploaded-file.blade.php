<div class="file-upload mb-0 mt-15">
    <div class="i-file-upload">
        <span>{{$title}}</span>
        <input type="file" class="file-upload" id="files" name="{{$name}}" required/>
    </div>
    <span class="filesize"></span>
    <span class="selectedFiles">فایلی انتخاب نشده است</span>
</div>
<x-error-message field="{{$name}}" />
