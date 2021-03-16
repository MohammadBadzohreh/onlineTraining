@extends("Dashboard::master")

@section("content")
    <div class="content">
        @include("Dashboard::layouts.header")
        @include("Dashboard::layouts.breadcrumb")
        <div class="main-content padding-0">
            <p class="box__title">ایجاد دوره جدید</p>
            <div class="row no-gutters bg-white">
                <div class="col-12">
                    <form action="{{route("course.store")}}" method="post" enctype="multipart/form-data" class="padding-30">
                        @csrf

                        <x-input type="text" name="title" placeholder="عنوان دوره" required/>

                        <x-input type="text" name="slug" class="text-left" placeholder="نام انگلیسی دوره" required/>

                        <div class="d-flex multi-text">
                            <x-input type="text" name="priority" class="text-left mlg-15" placeholder="ردیف دوره"/>
                            <x-input type="text" name="price" placeholder="مبلغ دوره" class="text-left text mlg-15"
                                     required/>
                            <x-input type="text" name="percent" placeholder="درصد مدرس" class="text-left text mlg-15"
                                     required/>
                        </div>

                        <x-select-box name="teacher_id" required>
                            <option value="">انتخاب مدرس دوره</option>
                            @foreach($teachers as $teacher)
                                <option value="{{$teacher->id}}"
                                        @if($teacher->id == old('teacher_id')) selected @endif
                                >{{$teacher->name}}</option>

                            {{--todo: delete this line--}}
                            @endforeach
                            <option value="1">mohammad badzohreh</option>

                        </x-select-box>

                        <ul class="tags-input-ul mb-0 mt-15">
                            <li class="tags-new">
                                <input type="text" class="" placeholder="برچسب ها">
                            </li>
                        </ul>


                        <x-select-box name="type">
                            @foreach(\Badzohreh\Course\Models\Course::$TYPES as $type)
                                <option value="{{$type}}"
                                        @if($type == old('type')) selected @endif
                                >@lang($type)</option>
                            @endforeach
                        </x-select-box>

                        <x-select-box name="status">
                            @foreach(\Badzohreh\Course\Models\Course::$STATUSES as $status)
                                <option value="{{$status}}"
                                        @if($status == old('status')) selected @endif

                                >@lang($status)</option>
                            @endforeach
                        </x-select-box>

                        <x-select-box name="category_id">
                            <option value="">دسته بندی</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->title}}</option>
                            @endforeach
                        </x-select-box>

                        <x-uploaded-file name="image" title="انتخاب بنر دوره" required/>

                        <x-textarea placeholder="توضیحات دوره" name="body">
                            {{old("body")}}
                        </x-textarea>
                        <br>
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