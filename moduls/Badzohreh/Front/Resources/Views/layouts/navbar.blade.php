<nav id="navigation" class="navigation">
    <div class="container">
        <ul class="nav">
            @foreach($categories as $category)
                <li class="main-menu @if($category->category_children) has-sub @endif"><a
                            href="#">{{$category->title}}</a>
                    @if($category->category_children)

                        @foreach($category->category_children as $childItem)
                            <div class="sub-menu">
                                <div class="container">
                                    <div><a href="android.html">{{$childItem->title}}</a></div>
                                </div>
                            </div>
                            <div class="triangle"></div>
                        @endforeach
                    @endif
                </li>
            @endforeach
            <li class="main-menu d-none"><a href="#">درباره ما</a></li>
            <li class="main-menu"><a href="contact-us.html">تماس ما</a></li>
            <li class="main-menu join-teachers-li"><a href="become-a-teacher.html">تدریس در وب آموز</a></li>
            <li class="main-menu"><a href="https://www.webamooz.net/blog">مقالات</a></li>
        </ul>

        <div class="dark-light">
            <svg class="moon" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" fill="none"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
            </svg>
            <svg class="sun" fill="#ffce45" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path d="M277.3 32h-42.7v64h42.7V32zm129.1 43.7L368 114.1l29.9 29.9 38.4-38.4-29.9-29.9zm-300.8 0l-29.9 29.9 38.4 38.4 29.9-29.9-38.4-38.4zM256 128c-70.4 0-128 57.6-128 128s57.6 128 128 128 128-57.6 128-128-57.6-128-128-128zm224 106.7h-64v42.7h64v-42.7zm-384 0H32v42.7h64v-42.7zM397.9 368L368 397.9l38.4 38.4 29.9-29.9-38.4-38.4zm-283.8 0l-38.4 38.4 29.9 29.9 38.4-38.4-29.9-29.9zm163.2 48h-42.7v64h42.7v-64z"></path>
            </svg>
        </div>
        </ul>
    </div>
</nav>