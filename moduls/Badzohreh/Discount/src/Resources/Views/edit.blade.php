@extends("Dashboard::master")

@section("content")
    <div class="content">
        @include("Dashboard::layouts.header")
        @include("Dashboard::layouts.breadcrumb")

        <div class="main-content padding-0 discounts">
            <div class="row no-gutters  ">
                <div class="col-12 bg-white">
                    <p class="box__title">ایجاد تخفیف جدید</p>
                    <form action="{{ route("discount.update",$discount->id) }}" method="post" class="padding-30">
                        @csrf
                        @method("put")
                        <x-input type="text" value="{{ $discount->code }}" placeholder="کد تخفیف" name="code"/>
                        <x-input type="text" value="{{ $discount->percent }}" name="percent" placeholder="درصد تخفیف"
                                 class="text"/>
                        <x-input type="text" value="{{ $discount->usage_limitation }}" name="usage_limitation"
                                 placeholder="محدودیت افراد" class="text"/>
                        <x-input id="date_picker" type="text"
                                 value="{{ $discount->expire_at ? \Morilog\Jalali\Jalalian::fromCarbon($discount->expire_at)->format('Y/n/d H:i') :  '' }}"
                                 name="expire_at"
                                 placeholder="محدودیت زمانی به ساعت"
                                 class="text"/>
                        <p class="box__title">این تخفیف برای</p>
                        <div class="notificationGroup">
                            <input id="discounts-field-1" class="discounts-field-pn" name="type" value="all"
                                   type="radio"
                                   @if($discount->type == \Badzohreh\Discount\Models\Discount::DISCOUNT_ALL_TYPE) checked @endif >
                            <label for="discounts-field-1">همه دوره ها</label>
                        </div>
                        <div class="notificationGroup">
                            <input id="discounts-field-2" class="discounts-field-pn" name="type" value="single"
                                   type="radio"
                                   @if($discount->type == \Badzohreh\Discount\Models\Discount::DISCOUNT_SINGLE_TYPE) checked @endif >
                            <label for="discounts-field-2">دوره خاص</label>
                        </div>

                        <div class="dropdown-select wide " tabindex="0">
                            <select name="courses[]" id="js_select_2" multiple="multiple"
                                    style="height: auto !important;">
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}"
                                            @if($discount->courses->contains($course->id)) selected @endif>{{ $course->title }}</option>
                                @endforeach
                            </select>

                            @error("courses")
                            <div class="text-red">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>
                        <x-input type="text" value="{{ $discount->link }}" name="link" placeholder="لینک اطلاعات بیشتر"
                                 class="text"/>
                        <x-input type="text" value="{{ $discount->description }}" name="description"
                                 placeholder="توضیحات"
                                 class="text margin-bottom-15"/>

                        <button class="btn btn-webamooz_net">ویرایش</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("css")
    <link rel="stylesheet" href="{{ asset('/css/persian_datePicker.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/select2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/custom.css') }}"/>

@endsection

@section("js")
    <script src="{{ asset('/js/persian_datePicker.js') }}"></script>
    <script src="{{ asset('/js/select2.js') }}"></script>
    <script>
        $("#date_picker").persianDatepicker({
            formatDate: "YYYY/MM/DD hh:mm"
        });
    </script>

    <script>
        $("#js_select_2").select2({width: '100%'});
    </script>
@endsection



