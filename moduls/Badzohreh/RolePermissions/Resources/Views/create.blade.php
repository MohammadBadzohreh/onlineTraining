<div class="col-4 bg-white">
    <p class="box__title">ایجاد نقش کاربری جدید</p>
    <form action="{{ route("permissions.store") }}" method="post" class="padding-30">
        @csrf
        <input type="text" name="name" required placeholder="نام نقش کاربری"
               class="text @error('name') is-invalid @enderror" value="{{old("name")}}">


        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <p class="box__title margin-bottom-15">مجوز ها</p>
        @foreach($permissions as $permission)
            <label class="ui-checkbox">
                <input type="checkbox" name="permissions[{{$permission->name}}]"
                       class="sub-checkbox" data-id="1"
                       @if(is_array(old("permissions")) &&
                        array_key_exists($permission->name,old("permissions")))
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
        <button type="submit" class="btn btn-webamooz_net">اضافه کردن</button>
    </form>
</div>



