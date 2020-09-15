<div class="col-4 bg-white">
    <p class="box__title">ایجاد نقش کاربری جدید</p>
    <form action="{{ route("permissions.store") }}" method="post" class="padding-30">
        @csrf
        <input type="text" name="name" required placeholder="نام نقش کاربری" class="text">
        <p class="box__title margin-bottom-15">مجوز ها</p>
        @foreach($permissions as $permission)
            <label class="ui-checkbox">
                <input type="checkbox" class="sub-checkbox" data-id="1">
                <span class="checkmark"></span>
                @lang($permission->name)
            </label>
            @endforeach
        <button type="submit" class="btn btn-webamooz_net">اضافه کردن</button>
    </form>
</div>
