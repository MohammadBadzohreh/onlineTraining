@extends("Dashboard::master")
@section("css")

    <link rel="stylesheet" href="/panel/css/jquery.toast.min.css" type="text/css">
@endsection



@section('content')

@section("breadcrumb")

    <li><a href="{{route("categories.index")}}" title="دسته بندی">دسته بندی</a></li>

@endsection
    <div class="content">
        @include("Dashboard::layouts.header")
        <div class="breadcrumb">
            <ul>
                <li><a href="index.html">پیشخوان</a></li>
                <li><a href="categories.html.html" class="is-active">دسته بندی ها</a></li>
            </ul>
        </div>
        <div class="main-content padding-0 categories">
            <div class="row no-gutters">
                <div class="col-8 margin-left-10 margin-bottom-15 border-radius-3">
                    <p class="box__title">دسته بندی ها</p>
                    <div class="table__box">
                        <table class="table">
                            <thead role="rowgroup">
                            <tr role="row" class="title-row">
                                <th>شناسه</th>
                                <th>نام دسته بندی</th>
                                <th>نام انگلیسی دسته بندی</th>
                                <th>دسته پدر</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($categories as $category)
                                <tr role="row" class="">
                                    <td><a href="">{{$category->id}}</a></td>
                                    <td><a href="">{{$category->title}}</a></td>
                                    <td>{{$category->slug}}</td>
                                    <td>{{$category->parent}}</td>
                                    <td>
                                        <a href="" class="item-delete mlg-15"
                                           onclick="handleDeleteItem(event,'{{route('categories.destroy',$category->id)}}')"
                                           title="حذف"></a>
                                        <a href="" target="_blank" class="item-eye mlg-15" title="مشاهده"></a>
                                        <a href="{{route("categories.edit",$category->id)}}" class="item-edit "
                                           title="ویرایش"></a>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @include("Categories::create")

            </div>
        </div>
    </div>
@endsection


@section("js")

    <script src="/panel/js/jquery.toast.min.js" type="text/javascript"></script>
    <script>
        function handleDeleteItem(event, route) {

            event.preventDefault();

            if (confirm('ایتم مورد نظر حذف شود؟')) {
                $.post(route, {_method: "delete", _token: "{{csrf_token()}}"})
                    .done(function (response) {
                        event.target.closest('tr').remove();

                        $.toast({
                            heading: 'عملیات موفقیت آمیز',
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




