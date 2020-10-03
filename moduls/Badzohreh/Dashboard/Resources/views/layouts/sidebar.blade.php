

<div class="sidebar__nav border-top border-left  ">
    <span class="bars d-none padding-0-18"></span>
    <a class="header__logo  d-none" href="https://webamooz.net"></a>
    <x-user-profile />
    <ul>


        @foreach(config()->get("sidebar.items") as $items)
            <li class="item-li {{$items["icon"]}} @if(request()->url() == $items['link']) is-active @endif"><a href="{{$items["link"]}}">{{$items["title"]}}</a></li>
        @endforeach



    </ul>

</div>