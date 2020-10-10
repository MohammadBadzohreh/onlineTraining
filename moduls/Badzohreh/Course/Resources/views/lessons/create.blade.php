@extends("Dashboard::master")

@section("content")
    <div class="content">
        @include("Dashboard::layouts.header")
        @include("Dashboard::layouts.breadcrumb")
        <div class="main-content padding-0">
            <p class="box__title">ایجاد درس جدید</p>
            <div class="row no-gutters bg-white">
                <div class="col-12">
                    <form action="" method="post" enctype="multipart/form-data" class="padding-30">
                        @csrf

                        <x-input type="text" name="title" placeholder="عنوان درس" required/>

                        <x-input type="text" name="slug" class="text-left" placeholder="نام انگلیسی درس" required/>

                        <x-input type="number" name="time" placeholder="مدت زمان جلسه *" class="text-left" required />
                        <x-input type="number" name="number" placeholder="شماره جلسه" class="text-left"/>

                        <div class="w-50">
                            <p class="box__title">ایا این درس رایگان است ؟ </p>
                            <div class="notificationGroup">
                                <input id="lesson-upload-field-1" name="free" value="1" type="radio" checked="">
                                <label for="lesson-upload-field-1">خیر</label>
                            </div>
                            <div class="notificationGroup">
                                <input id="lesson-upload-field-2" name="free" value="0" type="radio">
                                <label for="lesson-upload-field-2">بله</label>
                            </div>
                        </div>


                        @if(count($seassons))

                        <x-select-box name="season_id">
                            <option value="">سرفصل ها</option>
                            @foreach($seassons as $seasson)
                                <option value="{{$seasson->id}}">{{$seasson->title}}</option>
                            @endforeach
                        </x-select-box>
                        @endif
                        <x-uploaded-file name="lesson-upload" title="آپلود درس" required/>
                        <x-textarea placeholder="توضیحات درس" name="body" />
                        <br>
                        <button class="btn btn-webamooz_net">ایجاد درس</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("js")
    <script src="js/tagsInput.js"></script>

@endsection