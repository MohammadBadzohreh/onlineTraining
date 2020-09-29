@extends("Dashboard::master")
@section("css")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css"/>
    <link rel="stylesheet" href="/panel/css/jquery.toast.min.css" type="text/css">
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
                                        <ul>
                                        @foreach($user->roles as $userRole)
                                            <li>
                                                <a href="">{{$userRole->name}}</a>
                                                <a href=""
                                                   onclick="handleDeleteItem(event,
                                                           '{{route("give.role.user",["user"=>$user->id,"role"=>$userRole->name])}}')"
                                                   class="item-delete mlg-15 deleteRole"></a>
                                            </li>
                                            <br>
                                        @endforeach
                                        </ul>
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
    <script src="/panel/js/jquery.toast.min.js" type="text/javascript"></script>

    <script>

        @if(session()->has("feedbacks"))
                $.toast({
                    heading: "{{session()->get("feedbacks")["title"]}}",
                    text: "{{session()->get("feedbacks")["body"]}}",
                    showHideTransition: 'slide',
                    icon: 'success'
                });
        @endif




        function setFormAction(userId) {
            $("#selectModal").attr('action', "{{route("add.role",0)}}".replace('/0/', '/' + userId + '/'))
        }

        function handleDeleteItem(event, route) {

            event.preventDefault();

            if (confirm('ایتم مورد نظر حذف شود؟')) {
                $.post(route, {_method: "delete", _token: "{{csrf_token()}}"})
                    .done(function (response) {
                        event.target.closest('li').remove();

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
@endsection









