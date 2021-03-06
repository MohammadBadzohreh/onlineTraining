<form id="profileForm" action="{{route("userProfileImage")}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="profile__info border cursor-pointer text-center">
        <div class="avatar__img"><img src="@if(auth()->user()->banner){{auth()->user()->banner->thumb}}@else/panel/img/pro.jpg @endif" class="avatar___img">
            <input type="file" accept="image/*"
                   class="hidden avatar-img__input"
                   name="image"
                   onchange="$('#profileForm').submit()">
            <div class="v-dialog__container" style="display: block;"></div>
            <div class="box__camera default__avatar"></div>
        </div>
        <span class="profile__name">کاربر : {{auth()->user()->name}}</span>
    </div>
</form>
