@extends("Dashboard::master")
@section("css")
    <link rel="stylesheet" href="/panel/css/jquery.toast.min.css" type="text/css">
@endsection



@section('content')
    <div class="content">
        @include("Dashboard::layouts.header")
        @include("Dashboard::layouts.breadcrumb")


        <div class="main-content padding-0 categories">
            <div class="row no-gutters">
                <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
                    <p class="box__title">دوره ها</p>
                    <div class="table__box">
                        <table class="table">
                            <thead role="rowgroup">
                            <tr role="row" class="title-row">
                                <th>بنر دوره</th>
                                <th>ای دی</th>
                                <th>عنوان دوره</th>
                                <th>ردیف</th>
                                <th>مدرس دوره</th>
                                <th>قیمت دوره</th>
                                <th>حالت دوره</th>
                                <th>درصد مدرس</th>
                                <th>وضعیت دوره</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($courses as $course)
                                <tr role="row" class="">
                                    <td>
                                        <img src="{{$course->banner->thumb}}" alt="{{$course->title}}" width="150">
                                    </td>
                                    <td><a href="">{{$course->id}}</a></td>
                                    <td><a href="">{{$course->title}}</a></td>
                                    <td><a href="">{{$course->priority}}</a></td>
                                    <td>{{$course->teacher->name}}</td>
                                    <td>{{$course->price}}</td>
                                    <td class="confirmation_status">@lang($course->confirmation_status)</td>
                                    <td>{{$course->percent}}</td>
                                    <td class="status">@lang($course->status)</td>
                                    <td>
                                        <a href="" class="item-delete mlg-15"
                                           onclick="handleDeleteItem(event,'{{route('course.destroy',$course->id)}}')"
                                           title="حذف"></a>
                                        <a href="" target="_blank" class="item-eye mlg-15" title="مشاهده"></a>
                                        <a href="{{route("course.edit",$course->id)}}" class="item-edit mlg-15"
                                           title="ویرایش"></a>

                                        <a href=""
                                           onclick="handleChangeStatus(event,
                                                   '{{route("course.change.accept",
                                                   $course->id)}}',
                                                   'ایا از تایید این دوره مطمئن هستید؟',
                                                   'تایید'
                                                   )"
                                           class="item-confirm mlg-15"
                                           title="تایید"></a>


                                        <a href=""
                                           onclick="handleChangeStatus(event,
                                                   '{{route("course.change.rejected",
                                                   $course->id)}}',
                                                   'ایا از رد این دوره مطمئن هستید؟',
                                                   'رد'
                                                   )"
                                           class="item-reject mlg-15" title="رد"></a>


                                        <a href="" class="item-lock mlg-15"

                                           onclick="handleChangeStatus(event,
                                                   '{{route("course.change.locked",
                                                   $course->id)}}',
                                                   'ایا از قفل این دوره مطمئن هستید؟',
                                                   'قفل',
                                                   true
                                                   )"

                                           title="قفل کردن"></a>

                                    </td>

                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


@section("js")

    <script src="/panel/js/jquery.toast.min.js" type="text/javascript"></script>
    <script>


        function handleChangeStatus(event, route, alertText,text,status = false) {
            event.preventDefault();
            if (confirm(alertText)) {
                $.post(route, {_method: "PATCH", _token: "{{csrf_token()}}"})
                    .done(function (response) {

                        if (!status){
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






