@extends("Dashboard::master")
@section("css")
    <link rel="stylesheet" href="/panel/css/jquery.toast.min.css" type="text/css">
@endsection
s
@section("content")
    <div class="content">
        @include("Dashboard::layouts.header")
        @include("Dashboard::layouts.breadcrumb")
        <div class="main-content padding-0">
            <p class="box__title">بروزرسانی کاربر </p>
            <div class="row no-gutters bg-white">
                <div class="col-12">
                    <form action="{{route("users.update",$user->id)}}" method="post" enctype="multipart/form-data"
                          class="padding-30">
                        @csrf
                        @method("PATCH")

                        <x-input type="text" name="name" value="{{$user->name}}" placeholder="نام کاربر" required/>

                        <x-input type="text" name="email" class="text-left" value="{{$user->email}}" placeholder="ایمیل"
                                 required/>

                        <div class="d-flex multi-text">
                            <x-input type="text" name="username" class="text-left mlg-15" value="{{$user->username}}"
                                     placeholder="نام کاربری"/>
                            <x-input type="text" name="mobile" placeholder="شماره تلفن کاربر" value="{{$user->mobile}}"
                                     class="text-left text mlg-15"
                            />
                            <x-input type="text" name="headline" placeholder="عنوان کاربر" value="{{$user->percent}}"
                                     class="text mlg-15"
                            />
                        </div>


                        <div class="d-flex multi-text">
                            <x-input type="text" name="website" class="text-left mlg-15" value="{{$user->website}}"
                                     placeholder="وب سایت"/>
                        </div>




                        <x-input type="text" name="telegram" class="text-left mlg-15"
                                 placeholder="پسورد جدید"/>


                        <x-input type="text" name="password" class="text-left mlg-15" value="{{$user->telegram}}"
                                 placeholder="telegram"/>


                        <x-select-box name="status">
                            @foreach(\Badzohreh\User\Models\User::$STATUSES as $status)
                                <option value="{{$status}}"
                                        @if($status == $user->status) selected @endif

                                >@lang($status)</option>
                            @endforeach
                        </x-select-box>


                        <x-uploaded-file name="image" title="انتخاب پروفایل" :value="$user->banner"/>


                        <x-textarea placeholder="بیوگرافی" name="bio">
                            {{$user->bio}}
                        </x-textarea>
                        <br>
                        <button class="btn btn-webamooz_net">بروزرسانی دوره</button>
                    </form>
                </div>
            </div>
        </div>
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

    </script>

@endsection