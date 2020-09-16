@extends("Dashboard::master")

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
                                           onclick="handleDeleteItem(event,'{{route('categories.destroy',$role->id)}}')"
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









