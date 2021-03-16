<div class="episodes-list">
    <div class="episodes-list--title">
        فهرست جلسات

        @can("download",$course)
            <span class="text-info" style="font-size: 0.8em">
            <a href="{{ route("download.course",$course->id) }}">
            دریافت همه لینک های دانلود
            </a>
        </span>
        @endcan

    </div>
    <div class="episodes-list-section">
        <div class="episodes-list-group">
            <div class="episodes-list-group-head">
                <div class="head-right">
                    <span class="section-name">بخش اول </span>
                    <div class="section-title">پیاده سازی بخش بک اند پروژه آپارات</div>
                    <span class="episode-count"> 10 ویدیو </span>
                </div>
                <div class="head-left"></div>
            </div>
            <div class="episodes-list-group-body">
                @foreach($lessons as $lesson)
                    <div
                        class="episodes-list-item @cannot("download",$lesson) lock @endcannot">
                        <div class="section-right">
                            <span class="episodes-list-number">{{ $lesson->number }}</span>
                            <div class="episodes-list-title">
                                <a href="{{ $lesson->path() }}">{{ $lesson->title }}</a>
                            </div>
                        </div>
                        <div class="section-left">
                            <div class="episodes-list-details">
                                <div class="episodes-list-details">
                                    <span class="detail-type">{{ $lesson->is_free ? "رایگان" : "نقدی" }}</span>
                                    <span class="detail-time">{{ $lesson->durationTime() }}</span>
                                    <a class="detail-download"
                                       @can("download" , $lesson) href="{{ $lesson->downloadLink() }}" @endcan>
                                        <i class="icon-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
