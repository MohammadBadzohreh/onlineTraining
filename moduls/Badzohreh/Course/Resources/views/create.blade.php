@extends("Dashboard::master")

@section("content")


    <div class="content">

        @include("Dashboard::layouts.header")
        @include("Dashboard::layouts.breadcrumb")

        <div class="main-content padding-0">
            <p class="box__title">ایجاد دوره جدید</p>
            <div class="row no-gutters bg-white">
                <div class="col-12">
                    <form action="{{route("course.store")}}" method="post" class="padding-30">
                        @csrf
                        <input type="text" name="title" class="text" placeholder="عنوان دوره">
                        <input type="text" name="slug" class="text text-left " placeholder="نام انگلیسی دوره">

                        <div class="d-flex multi-text">
                            <input type="text" name="priority" class="text text-left mlg-15" placeholder="ردیف دوره">
                            <input type="text" name="price" placeholder="مبلغ دوره" class="text-left text mlg-15">
                            <input type="text" name="percent" placeholder="درصد مدرس" class="text-left text">
                        </div>
                        <select name="teacher_id">
                            {{--Todo teacher users--}}
                            <option value="">انتخاب مدرس دوره</option>
                            @foreach($teachers as $teacher)
                            <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                                @endforeach
                        </select>

                        <ul class="tags-input-ul">
                            <li class="tags-new">
                                <input type="text" class="" placeholder="برچسب ها">
                            </li>
                        </ul>
                        <select name="type">
                            @foreach(\Badzohreh\Course\Models\Course::$TYPES as $type)
                                <option value="{{$type}}">@lang($type)</option>
                            @endforeach
                        </select>
                        <select name="status">
                            @foreach(\Badzohreh\Course\Models\Course::$STATUSES as $status)
                                <option value="{{$status}}">@lang($status)</option>

                            @endforeach
                        </select>

                        <select name="category_id">

                            {{--todo  add categories--}}


                            @foreach($categories as $category)

                                <option value="{{$category->id}}">{{$category->title}}</option>
                                @endforeach

                        </select>
                        <div class="file-upload">
                            <div class="i-file-upload">
                                <span>آپلود بنر دوره</span>
                                <input type="file" class="file-upload" id="files" name="image"/>
                            </div>
                            <span class="filesize"></span>
                            <span class="selectedFiles">فایلی انتخاب نشده است</span>
                        </div>
                        <textarea placeholder="توضیحات دوره" class="text h"></textarea>
                        <button class="btn btn-webamooz_net">ایجاد دوره</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("js")
    <script src="js/tagsInput.js"></script>

@endsection