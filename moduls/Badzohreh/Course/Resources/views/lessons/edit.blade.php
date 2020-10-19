@extends("Dashboard::master")

@section("content")
    <div class="content">
        @include("Dashboard::layouts.header")
        @include("Dashboard::layouts.breadcrumb")
        <div class="main-content padding-0">
            <p class="box__title">ایجاد درس جدید</p>
            <div class="row no-gutters bg-white">
                <div class="col-12">
                    <form action="{{route("lesson.update",[$course->id,$lesson->id])}}" method="post"
                          enctype="multipart/form-data" class="padding-30">
                        @csrf
                        @method("PATCH")

                        <x-input type="text" value="{{$lesson->title}}" name="title" placeholder="عنوان درس" required/>

                        <x-input type="text" value="{{$lesson->slug}}" name="slug" class="text-left"
                                 placeholder="نام انگلیسی درس" required/>

                        <x-input type="number" value="{{$lesson->time}}" name="time" placeholder="مدت زمان جلسه *"
                                 class="text-left" required/>
                        <x-input type="number" value="{{$lesson->number}}" name="number" placeholder="شماره جلسه"
                                 class="text-left"/>

                        <div class="w-50">
                            <p class="box__title">ایا این درس رایگان است ؟ </p>
                            <div class="notificationGroup">
                                <input id="lesson-upload-field-1" name="is_free" value="1" type="radio"
                                       @if(!$lesson->is_free) checked="checked" @endif >
                                <label for="lesson-upload-field-1">خیر</label>
                            </div>
                            <div class="notificationGroup">
                                <input id="lesson-upload-field-2" name="is_free" value="0" type="radio"
                                       @if($lesson->is_free) checked="checked" @endif>
                                <label for="lesson-upload-field-2">بله</label>
                            </div>
                        </div>


                        @if(count($seassons))
                            <x-select-box name="season_id">
                                <option value="">سرفصل ها</option>
                                @foreach($seassons as $seasson)
                                    <option value="{{$seasson->id}}"
                                            @if($lesson->seasson &&
                                             $seasson->id == $lesson->seasson->id)
                                            selected
                                            @endif
                                    >{{$seasson->title}}</option>
                                @endforeach
                            </x-select-box>
                        @endif
                        <x-uploaded-file name="lesson-upload" title="آپلود درس"/>
                        <x-textarea placeholder="توضیحات درس" name="body">
                            {{$lesson->body}}
                        </x-textarea>
                        <br>
                        <button class="btn btn-webamooz_net">ویرایش درس</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("js")
    <script src="js/tagsInput.js"></script>

@endsection