@extends("Dashboard::master")
@section("css")
    <link rel="stylesheet" href="/panel/css/jquery.toast.min.css" type="text/css">
@endsection



@section('content')
    <div class="content">
        @include("Dashboard::layouts.header")
        @include("Dashboard::layouts.breadcrumb")
        <div class="main-content padding-0 course__detial">
            <div class="row no-gutters  ">
                <div class="col-8 bg-white padding-30 margin-left-10 margin-bottom-15 border-radius-3">
                    <div class="margin-bottom-20 flex-wrap font-size-14 d-flex bg-white padding-0">
                        <p class="mlg-15">دوره مقدماتی تا پیشرفته لاراول</p>
                        <a class="color-2b4a83" href="{{route("lessons.create",$course->id)}}">آپلود جلسه جدید</a>
                    </div>
                    <div class="d-flex item-center flex-wrap margin-bottom-15 operations__btns">
                        <button class="btn all-confirm-btn">تایید همه جلسات</button>
                        <button class="btn confirm-btn">تایید جلسات</button>
                        <button class="btn reject-btn">رد جلسات</button>
                        <button class="btn delete-btn" onclick="multiple('{{route("delete.multiple.lessons")}}')">حذف
                            جلسات
                        </button>

                    </div>
                    <div class="table__box">
                        <table class="table">
                            <thead role="rowgroup">
                            <tr role="row" class="title-row">
                                <th style="padding: 13px 30px;">
                                    <label class="ui-checkbox">
                                        <input type="checkbox" class="checkedAll">
                                        <span class="checkmark"></span>
                                    </label>
                                </th>
                                <th>شناسه</th>
                                <th>عنوان جلسه</th>
                                <th>عنوان فصل</th>
                                <th>مدت زمان جلسه</th>
                                <th>وضعیت تایید</th>
                                <th>سطح دسترسی</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lessons as $lesson)
                                <tr role="row" class="" data-row-id="{{$lesson->id}}">
                                    <td>
                                        <label class="ui-checkbox">
                                            <input type="checkbox" class="sub-checkbox" data-id="{{$lesson->id}}">
                                            <span class="checkmark"></span>
                                        </label>
                                    </td>
                                    <td><a href="">{{$lesson->number}}</a></td>
                                    <td><a href="">{{$lesson->title}}</a></td>
                                    <td>{{$lesson->seasonTitle}}</td>
                                    <td>{{$lesson->time}}</td>
                                    <td class="confirmation_status">@lang($lesson->confirmation_staus)</td>
                                    <td class="status">
                                        @if($lesson->status == \Badzohreh\Course\Models\Lesson::STATUS_OPENED)
                                            @if($lesson->free)
                                                رایگان
                                            @else
                                                شرکت کنندگان
                                            @endif
                                        @else
                                            قفل
                                        @endif
                                    </td>
                                    <td>
                                        <a href=""
                                           onclick="handleDeleteItem(event,'{{route('lesson.destroy',[$course->id,$lesson->id])}}')"
                                           class="item-delete mlg-15" data-id="1" title="حذف"></a>
                                        <a href="" class="item-reject mlg-15" onclick="handleChangeStatus(event,
                                                '{{route("lesson.reject",
                                                   $lesson->id)}}',
                                                'ایا از رد این دوره مطمئن هستید؟',
                                                'رد'
                                                )" title="رد"></a>
                                        <a href="" class="item-lock mlg-15 text-success"
                                           onclick="handleChangeStatus(event,
                                                   '{{route("lesson.unlock",
                                                   $lesson->id)}}',
                                                   'ایا از باز این دوره مطمئن هستید؟',
                                                   'باز',
                                                   true
                                                   )"
                                           title="باز"></a>
                                        <a href="" onclick="handleChangeStatus(event,
                                                '{{route("lesson.accpet",
                                                   $lesson->id)}}',
                                                'ایا از تایید این دوره مطمئن هستید؟',
                                                'تایید'
                                                )" class="item-confirm mlg-15 " title="تایید"></a>


                                        <a href="" class="item-lock mlg-15 text-error"

                                           onclick="handleChangeStatus(event,
                                                   '{{route("lesson.lock",
                                                   $lesson->id)}}',
                                                   'ایا از قفل این دوره مطمئن هستید؟',
                                                   'قفل',
                                                   true
                                                   )"
                                           title="قفل کردن"></a>


                                        <a href="" class="item-edit " title="ویرایش"></a>
                                    </td>
                                </tr>

                            @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-4">

                    <div class="col-12 bg-white margin-bottom-15 border-radius-3">
                        @include("Course::seasons.create")

                        @include("Course::seasons.showSeasson")
                    </div>
                    <div class="col-12 bg-white margin-bottom-15 border-radius-3">


                        <p class="box__title">اضافه کردن دانشجو به دوره</p>
                        <form action="" method="post" class="padding-30">
                            <select name="" id="">
                                <option value="0">انتخاب کاربر</option>
                                <option value="1">mohammadniko3@gmail.com</option>
                                <option value="2">sayad@gamil.com</option>
                            </select>
                            <div class="dropdown-select wide " tabindex="0"><span class="current">انتخاب کاربر</span>
                                <div class="list">
                                    <div class="dd-search"><input id="txtSearchValue" autocomplete="off"
                                                                  onkeyup="filter()" class="dd-searchbox" type="text">
                                    </div>
                                    <ul>
                                        <li class="option selected" data-value="0" data-display-text="">انتخاب کاربر
                                        </li>
                                        <li class="option " data-value="1" data-display-text="">
                                            mohammadniko3@gmail.com
                                        </li>
                                        <li class="option " data-value="2" data-display-text="">sayad@gamil.com</li>
                                    </ul>
                                </div>
                            </div>
                            <input type="text" placeholder="مبلغ دوره" class="text">
                            <p class="box__title">کارمزد مدرس ثبت شود ؟</p>
                            <div class="notificationGroup">
                                <input id="course-detial-field-1" name="course-detial-field" type="radio" checked="">
                                <label for="course-detial-field-1">بله</label>
                            </div>
                            <div class="notificationGroup">
                                <input id="course-detial-field-2" name="course-detial-field" type="radio">
                                <label for="course-detial-field-2">خیر</label>
                            </div>
                            <button class="btn btn-webamooz_net">اضافه کردن</button>
                        </form>


                        <div class="table__box padding-30">
                            <table class="table">
                                <thead role="rowgroup">
                                <tr role="row" class="title-row">
                                    <th class="p-r-90">شناسه</th>
                                    <th>نام و نام خانوادگی</th>
                                    <th>ایمیل</th>
                                    <th>مبلغ (تومان)</th>
                                    <th>درامد شما</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr role="row" class="">
                                    <td><a href="">1</a></td>
                                    <td><a href="">توفیق حمزه ای</a></td>
                                    <td><a href="">Mohammadniko3@gmail.com</a></td>
                                    <td><a href="">40000</a></td>
                                    <td><a href="">20000</a></td>
                                    <td>
                                        <a href="" class="item-delete mlg-15" title="حذف"></a>
                                        <a href="" class="item-edit " title="ویرایش"></a>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection



@section("js")
    <script src="/panel/js/jquery.toast.min.js" type="text/javascript"></script>

    <script>
        function handleChangeStatus(event, route, alertText, text, status = false) {
            event.preventDefault();
            if (confirm(alertText)) {
                $.post(route, {_method: "PATCH", _token: "{{csrf_token()}}"})
                    .done(function (response) {

                        if (!status) {
                            $(event.target).closest('.confirmation_status').text(status);
                            $(".confirmation_status").text(text);
                        } else {
                            $(".status").text(text);
                        }
                        $.toast({
                            heading: response.message,
                            text: text,
                            showHideTransition: 'slide',
                            icon: 'success'
                        });
                    }).fail(function (response) {
                    $.toast({
                        heading: response.message,
                        text: "خطا در عملیات",
                        showHideTransition: 'fade',
                        icon: 'error'
                    })
                });
            }
        }


        function handleDeleteItem(event, route) {
            event.preventDefault();
            if (confirm('ایتم مورد نظر حذف شود؟')) {
                $.post(route, {_method: "delete", _token: "{{csrf_token()}}"})
                    .done(function (response) {
                        event.target.closest('tr').remove();

                        $.toast({
                            heading: response.message,
                            text: 'ایتم مورد نظر با موفقیت حذف شد.',
                            showHideTransition: 'slide',
                            icon: 'success'
                        });
                    })
                    .fail(function (response) {
                        $.toast({
                            heading: 'خطایی به وجود آمده است',
                            showHideTransition: 'fade',
                            icon: 'error'
                        })
                    });
            }
        }
    </script>
@endsection

