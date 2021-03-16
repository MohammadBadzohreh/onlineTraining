<div class="col">
    <a href={{ $course->path() }}>
        <div class="course-status">
            @lang($course->status)
        </div>
        {{--<div class="discountBadge">--}}
            {{--<p>45%</p>--}}
            {{--تخفیف--}}
        {{--</div>--}}
        <div class="card-img" style="height: 250px"><img src="{{$course->banner->thumb}}" alt="{{$course->slug}}"></div>
        <div class="card-title"><h2>{{$course->title}}</h2></div>
        <div class="card-body">
            <img src="{{$course->teacher->thumb}}" alt="{{$course->teacher->name}}">
            <span>{{$course->teacher->name}}</span>
        </div>
        <div class="card-details">
            <div class="time">{{$course->getFormattedTime()}}</div>
            <div class="price">
                <div class="discountPrice">{{ $course->format_price() }}</div>
                <div class="endPrice">{{ $course->format_price() }}</div>
            </div>
        </div>
    </a>
</div>
