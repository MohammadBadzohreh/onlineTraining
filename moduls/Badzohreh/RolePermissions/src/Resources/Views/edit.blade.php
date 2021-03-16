@extends("Dashboard::master")

@section("content")
    <div class="content">
        @include("Dashboard::layouts.header")
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route("home")}}" title="پیشخوان">پیشخوان</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="row no-gutters">
                <div class="col-12 bg-white">
                    <p class="box__title">ایجاد دسته بندی جدید</p>
                    <form action="{{route("permissions.update",$role->id)}}" method="post" class="padding-30">
                        @method("patch")
                        @csrf
                        <input type="text" name="name" required placeholder="نام دسته بندی"
                               class="text" value="{{$role->name}}">


                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <p class="box__title margin-bottom-15">انتخاب مجوز ها</p>



                        @foreach($permissions as $permission)
                            <label class="ui-checkbox">
                                <input type="checkbox" name="permissions[{{$permission->name}}]"
                                       class="sub-checkbox" data-id="1"
                                       @if($role->hasPermissionTo($permission))
                                               checked
                                               @endif
                                       value="{{$permission->name}}"
                                >
                                <span class="checkmark"></span>
                                @lang($permission->name)
                            </label>
                        @endforeach


                        @error('permissions')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <br>


                        @error('permission')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <br>




                        <button type="submit" class="btn btn-webamooz_net">بروزرسانی</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection