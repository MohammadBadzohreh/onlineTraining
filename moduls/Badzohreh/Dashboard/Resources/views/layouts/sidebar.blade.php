

<div class="sidebar__nav border-top border-left  ">
    <span class="bars d-none padding-0-18"></span>
    <a class="header__logo  d-none" href="https://webamooz.net"></a>
    <x-user-profile />
    <ul>
        @foreach(config()->get("sidebar.items") as $item)
            @if(!array_key_exists('permission',$item)
            || auth()->user()->hasPermissionTo($item['permission'])
           || auth()->user()->hasPermissionTo(\Badzohreh\RolePermissions\Models\Permission::PERMISSION_SUPER_ADMIN))
                <li class="item-li {{$item["icon"]}} @if(request()->url() == $item['link']) is-active @endif"><a href="{{$item["link"]}}">{{$item["title"]}}</a></li>
            @endif
        @endforeach
    </ul>

</div>