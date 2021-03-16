@extends("Dashboard::master")
@section("css")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css"/>
    <link rel="stylesheet" href="/panel/css/jquery.toast.min.css" type="text/css">
@endsection

@section('content')
    <div class="content">
        @include("Dashboard::layouts.header")
        @include("Dashboard::layouts.breadcrumb")

        <div class="main-content">
            <div class="user-info bg-white padding-30 font-size-13">

                <x-user-profile/>
                <form action="{{route("users.profile")}}" method="post">
                    @csrf
                    <x-input type="text" class="text" name="name" placeholder="نام کاربری"
                             value="{{auth()->user()->name}}"/>
                    <x-input type="text" class="text" name="email" class="text" placeholder="ایمیل"
                             value="{{auth()->user()->email}}"/>
                    <x-input type="text" class="text" name="mobile" class="text text-left" placeholder="شماره موبایل"
                             value="{{auth()->user()->mobile}}"/>
                    <x-input type="text" class="text" name="headline" class="text " placeholder="عنوان"
                             value="{{auth()->user()->headline}}"/>
                    <x-input type="text" class="text" name="username" class="text text-left"
                             placeholder="نام کاربری و آدرس پروفایل" value="{{auth()->user()->username}}"/>
                    <p class="input-help text-left margin-bottom-12" dir="ltr">
                        {{auth()->user()->profilePath()}}
                    </p>
                    <x-input type="password" name="password" class="text" placeholder="رمز عبور"/>
                    <p class="rules">رمز عبور باید حداقل ۶ کاراکتر و ترکیبی از حروف بزرگ، حروف کوچک، اعداد و کاراکترهای
                        غیر الفبا مانند <strong>!@#$%^&amp;*()</strong> باشد.</p>
                    <br>


                    @if(auth()->user()->hasPermissionTo(\Badzohreh\RolePermissions\Models\Permission::PERMISSION_TEACH))
                        <x-input type="text" class="text" name="card_number"
                                 class="text text-left" placeholder="شماره کارت بانکی"
                                 value="{{auth()->user()->card_number}}"
                        />

                        <x-input type="text" class="text" name="shaba" class="text text-left"
                                 placeholder="شماره شبا بانکی" value="{{auth()->user()->shaba}}"/>

                        <x-textarea name="bio" class="text" placeholder="درباره من مخصوص مدرسین">
                            {{auth()->user()->bio}}
                        </x-textarea>


                    @endif
                    <br>
                    <br>
                    <button class="btn btn-webamooz_net" type="submit">ذخیره تغییرات</button>
                </form>

            </div>

        </div>
    </div>

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