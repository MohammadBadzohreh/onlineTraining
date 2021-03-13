@extends("Front::layouts.master")
@section("css")
    <link rel="stylesheet" href="/css/modal.css">
@endsection

@section("content")


    <main id="single">
        <div class="content">
            <div class="container">
                <article class="article">

                    {{--                    todo add to layouts adds--}}

                    {{--                    <div class="ads mb-10">--}}
                    {{--                        <a href="" rel="nofollow noopener"><img src="img/ads/1440px/test.jpg" alt=""></a>--}}
                    {{--                    </div>--}}
                    <div class="h-t">
                        <h1 class="title">{{ $course->title }}</h1>
                        <div class="breadcrumb">
                            <ul>

                                <li><a href="/" title="خانه">خانه</a></li>
                                @if($course->category->category_parent)
                                    <li><a href="{{ $course->category->category_parent->path()  }}"
                                           title="{{$course->category->category_parent->title}}">
                                            {{ $course->category->category_parent->title }}
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ $course->category->path() }}" title="{{  $course->category->title }}">
                                        {{ $course->category->title }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </article>
            </div>


            <div class="main-row container">
                <div class="sidebar-right">
                    <div class="sidebar-sticky">
                        <div class="product-info-box">
                            @auth()
                                @if($course->teacher_id == auth()->id())
                                    <p class="mycourse">شما مدرس این دوره هستید</p>
                                @elseif(auth()->user()->can("download",$course))
                                    <p class="mycourse">شما این دوره رو خریداری کرده اید</p>
                                @else
                                    <div class="discountBadge">
                                        <p>45%</p>
                                        تخفیف
                                    </div>
                                    <div class="sell_course">
                                        <strong>قیمت :</strong>
                                        <del class="discount-Price">{{  $course->getDiscountAmont()  }}</del>
                                        <p class="price">
                                    <span class="woocommerce-Price-amount amount">{{ $course->getFinalPrice() }}
                                        <span class="woocommerce-Price-currencySymbol">تومان</span>
                                    </span>
                                        </p>
                                    </div>
                                    <button class="btn buy btn-buy">خرید دوره</button>
                                @endif
                            @else
                                <div class="discountBadge">
                                    <p>45%</p>
                                    تخفیف
                                </div>
                                <div class="sell_course">
                                    <strong>قیمت :</strong>
                                    <del class="discount-Price">{{  $course->format_price()  }}</del>
                                    <p class="price">
                        <span class="woocommerce-Price-amount amount">{{ $course->format_price() }}
                            <span class="woocommerce-Price-currencySymbol">تومان</span>
                        </span>
                                    </p>
                                </div>
                                <p>برای خرید دوره ابتدا در سایت ثبت نام کنید</p>
                                <a href="{{ route("login") }}" class="btn text-white w-100">ورود به سایت</a>

                            @endauth

                            <div class="average-rating-sidebar">
                                <div class="rating-stars">
                                    <div class="slider-rating">
                                        <span class="slider-rating-span slider-rating-span-100" data-value="100%"
                                              data-title="خیلی خوب"></span>
                                        <span class="slider-rating-span slider-rating-span-80" data-value="80%"
                                              data-title="خوب"></span>
                                        <span class="slider-rating-span slider-rating-span-60" data-value="60%"
                                              data-title="معمولی"></span>
                                        <span class="slider-rating-span slider-rating-span-40" data-value="40%"
                                              data-title="بد"></span>
                                        <span class="slider-rating-span slider-rating-span-20" data-value="20%"
                                              data-title="خیلی بد"></span>
                                        <div class="star-fill"></div>
                                    </div>
                                </div>

                                <div class="average-rating-number">
                                    <span class="title-rate title-rate1">امتیاز</span>
                                    <div class="schema-stars">
                                        <span class="value-rate text-message"> 4 </span>
                                        <span class="title-rate">از</span>
                                        <span class="value-rate"> 555 </span>
                                        <span class="title-rate">رأی</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-info-box">
                            <div class="product-meta-info-list">
                                <div class="total_sales">
                                    تعداد دانشجو : <span>{{ count($course->students) }}</span>
                                </div>
                                <div class="meta-info-unit one">
                                    <span class="title">تعداد جلسات منتشر شده :  </span>
                                    <span class="vlaue">{{ $course->lessonCount() }}</span>
                                </div>
                                <div class="meta-info-unit two">
                                    <span class="title">مدت زمان دوره تا الان : </span>
                                    <span class="vlaue">{{ $course->getFormattedTime() }}</span>
                                </div>
                                <div class="meta-info-unit three">
                                    <span class="title">مدت زمان کل دوره : </span>
                                    <span class="vlaue">-</span>
                                </div>
                                <div class="meta-info-unit four">
                                    <span class="title">مدرس دوره : </span>
                                    <span class="vlaue">{{ $course->teacher->name }}</span>
                                </div>
                                <div class="meta-info-unit five">
                                    <span class="title">وضعیت دوره : </span>
                                    <span class="vlaue">@lang($course->confirmation_status)</span>
                                </div>
                                <div class="meta-info-unit six">
                                    <span class="title">پشتیبانی : </span>
                                    <span class="vlaue">دارد</span>
                                </div>
                            </div>
                        </div>
                        <div class="course-teacher-details">
                            <div class="top-part">
                                <a href="{{ route("tutor" , $course->teacher->name) }}"><img
                                        alt="{{ $course->teacher->name }}"
                                        class="img-fluid lazyloaded"
                                        src="img/profile.jpg"
                                        loading="lazy">
                                    <noscript>
                                        <img class="img-fluid" src="{{ $course->teacher->thumb }}"
                                             alt="{{ $course->teacher->name }}">
                                    </noscript>
                                </a>
                                <div class="name">
                                    <a href="{{ route("tutor" , $course->teacher->name) }}" class="btn-link">
                                        <h6>{{ $course->teacher->name }}</h6>
                                    </a>
                                    <span class="job-title">{{ $course->teacher->headline }}</span>
                                </div>
                            </div>
                            <div class="job-content">
                                {{-- <p>{{ $course->teacher->bio }}</p>--}}
                            </div>
                        </div>
                        <div class="short-link">
                            <div class="">
                                <span>لینک کوتاه</span>
                                <input class="short--link" value="{{ $course->shortLink() }}">
                                <a href="" class="short-link-a" data-link="{{ $course->shortLink() }}"></a>
                            </div>
                        </div>
                        @include("Front::layouts.sidebar-banners")

                    </div>
                </div>
                <div class="content-left">
                    @if(!is_null($lesson))
                        <div class="preview">
                            @if($lesson->media->type === "video")
                                <video width="100%" controls>
                                    <source src="{{ $lesson->downloadLink() }}" type="video/mp4">
                                </video>
                            @endif
                        </div>
                        <a href="{{ $lesson->downloadLink() }}" class="episode-download">دانلود این قسمت
                            (قسمت {{ $lesson->number }})</a>

                    @endif
                    <div class="course-description">

                        <div class="course-description-title">توضیحات دوره
                            <div class="study-mode"></div>
                        </div>
                        <p>
                            {!! $course->body  !!}
                        </p>

                        <div class="tags">
                            <ul>
                                <li><a href="">ری اکت</a></li>
                                <li><a href="">reactjs</a></li>
                                <li><a href="">جاوااسکریپت</a></li>
                                <li><a href="">javascript</a></li>
                                <li><a href="">reactjs چیست</a></li>
                            </ul>
                        </div>
                    </div>
                    @include("Front::layouts.episode-list")
                </div>
            </div>
        </div>

        <div id="Modal-buy" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <p>کد تخفیف را وارد کنید</p>
                    <div class="close">&times;</div>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route("course.buy" , $course->id) }}">
                        @csrf

                        <div><input type="text" class="txt" placeholder="کد تخفیف را وارد کنید"></div>
                        <button class="btn i-t ">اعمال</button>

                        <table class="table text-center table-bordered table-striped">
                            <tbody>
                            <tr>
                                <th>قیمت کل دوره</th>
                                <td> {{ $course->format_price()  }} تومان</td>
                            </tr>
                            <tr>
                                <th>درصد تخفیف</th>
                                <td>{{ $course->getDiscountPercent() }}%</td>
                            </tr>
                            <tr>
                                <th> مبلغ تخفیف</th>
                                <td class="text-red"> {{ $course->getDiscountAmont() }} تومان</td>
                            </tr>
                            <tr>
                                <th> قابل پرداخت</th>
                                <td class="text-blue"> {{ $course->getFinalPrice() }} تومان</td>
                            </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn i-t ">پرداخت آنلاین</button>
                    </form>
                </div>

            </div>
        </div>

    </main>
@endsection

@section("js")
    <script src="/js/modal.js"></script>
@endsection
