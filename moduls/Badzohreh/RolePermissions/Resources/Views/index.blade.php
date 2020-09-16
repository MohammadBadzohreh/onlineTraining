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
                <div class="col-8 margin-left-10 margin-bottom-15 border-radius-3">
                    <p class="box__title">نقش های کاربری</p>
                    <div class="table__box">
                        <table class="table">
                            <thead role="rowgroup">
                            <tr role="row" class="title-row">
                                <th>شناسه</th>
                                <th>نام نقش کاربری</th>
                                <th>مجوز ها</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($roles as $role)
                                <tr role="row" class="">
                                    <td><a href="">{{$role->id}}</a></td>
                                    <td><a href="">{{$role->name}}</a></td>
                                    <td>
                                        <ul>
                                            @foreach($role->permissions as $permission)

                                                <li>@lang($permission->name)</li>
                                            @endforeach

                                        </ul>


                                    </td>
                                    <td>
                                        <a href="" class="item-delete mlg-15"
                                           onclick="handleDeleteItem(event,'{{route('permissions.destroy',$role->id)}}')"
                                           title="حذف"></a>
                                        <a href="{{route("permissions.edit",$role->id)}}" class="item-edit "
                                           title="ویرایش"></a>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @include("RolePermissions::create")

            </div>
        </div>
    </div>
@endsection

@section("js")
    <script src="/panel/js/jquery.toast.min.js" type="text/javascript"></script>

    <script>




    function handleDeleteItem(event, route) {
            event.preventDefault();
            if (confirm("ایا از حذف این ایتم مطمئن هستید؟")) {

                $.post(route, {_method: "delete", _token: "{{csrf_token()}}"})
                    .done(function (response) {

                        console.log("dd");
                        event.target.closest('tr').remove();

                        $.toast({
                            heading: 'عملیات موفقیت آمیز',
                            text: 'ایتم مورد نظر با موفقیت حذف شد.',
                            showHideTransition: 'slide',
                            icon: 'success'
                        });
                    })
                    .fail(function (response) {
                        console.log("dd");
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









