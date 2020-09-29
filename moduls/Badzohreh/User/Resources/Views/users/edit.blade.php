@extends("Dashboard::master")

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
                                     required/>
                            <x-input type="text" name="headline" placeholder="عنوان کاربر" value="{{$user->percent}}"
                                     class="text mlg-15"
                                     required/>
                        </div>


                        <div class="d-flex multi-text">
                            <x-input type="text" name="website" class="text-left mlg-15" value="{{$user->username}}"
                                     placeholder="وب سایت"/>
                            <x-input type="text" name="facebook" placeholder="facebook" value="{{$user->mobile}}"
                                     class="text-left text mlg-15"
                                     required/>
                            <x-input type="text" name="likedin" placeholder="likedin" value="{{$user->percent}}"
                                     class="text mlg-15"
                                     required/>
                        </div>


                        <div class="d-flex multi-text">
                            <x-input type="text" name="twitter" class="text-left mlg-15" value="{{$user->twitter}}"
                                     placeholder="twitter"/>
                            <x-input type="text" name="youtube" placeholder="youtube" value="{{$user->youtube}}"
                                     class="text-left text mlg-15"
                                     required/>
                            <x-input type="text" name="instagram" placeholder="instagram" value="{{$user->instagram}}"
                                     class="text mlg-15"
                                     required/>
                        </div>


                        <x-input type="text" name="telegram" class="text-left mlg-15" value="{{$user->telegram}}"
                                 placeholder="پسورد جدید"/>


                        <x-input type="password" name="password" class="text-left mlg-15"
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
    <script src="js/tagsInput.js"></script>

@endsection