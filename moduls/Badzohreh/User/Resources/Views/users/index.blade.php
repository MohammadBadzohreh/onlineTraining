@extends("Dashboard::master")
@section("css")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css"/>

@endsection



@section('content')
    <div class="content">
        @include("Dashboard::layouts.header")
        @include("Dashboard::layouts.breadcrumb")


        <div class="main-content padding-0 categories">
            <div class="row no-gutters">
                <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
                    <p class="box__title">کاربران</p>
                    <div class="table__box">
                        <table class="table">
                            <thead role="rowgroup">
                            <tr role="row" class="title-row">
                                <th>ای دی</th>
                                <th>نام</th>
                                <th>شماره همراه</th>
                                <th>نقش کاربری</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($users as $user)
                                <tr role="row" class="">

                                    <td><a href="">{{$user->id}}</a></td>
                                    <td><a href="">{{$user->name}}</a></td>
                                    <td>{{$user->mobile}}</td>
                                    <td>
                                        @foreach($user->roles as $userRole)
                                            <a href="">{{$userRole->name}}</a>
                                        @endforeach
                                        <p><a href="#rolsModal" rel="modal:open"
                                              onclick="setFormAction('{{$user->id}}')" data-modal>افزودن نقش کاربری</a>
                                        </p>
                                    </td>
                                    <td>delete,edit</td>


                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <div id="rolsModal" class="modal">
        <form id="selectModal" action="" method="post">
            @csrf
            <select name="role" id="">
                <option value="" style="display: none;">نقش کاربری</option>
                @foreach($roles as $role)
                    <option value="{{$role->name}}">{{$role->name}}</option>
                @endforeach
            </select>


            <button type="submit" class="btn btn-webamooz_net">اضافه کردن</button>

        </form>
    </div>
@endsection
@section("js")
    <script>
        function setFormAction(userId) {
            $("#selectModal").attr('action', "{{route("add.role",0)}}".replace('/0/', '/' + userId + '/'))
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
@endsection









