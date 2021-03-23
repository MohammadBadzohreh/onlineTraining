@extends("Dashboard::master")

@section("content")
    <div class="content">
        @include("Dashboard::layouts.header")
        @include("Dashboard::layouts.breadcrumb")

        <div class="main-content padding-0 discounts">
            <div class="row no-gutters  ">
                <div class="col-8 margin-left-10 margin-bottom-15 border-radius-3">
                    <p class="box__title">دسته بندی ها</p>
                    <div class="table__box">
                        <div class="table-box">
                            <table class="table">
                                <thead role="rowgroup">
                                <tr role="row" class="title-row">
                                    <th>شناسه</th>
                                    <th>درصد</th>
                                    <th>محدودیت زمانی</th>
                                    <th>توضیحات</th>
                                    <th>استفاده شده</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($discounts as $discount)
                                    <tr role="row" class="">
                                        <td><a href="">{{ $discount->id }}</a></td>
                                        <td><a href="">{{ $discount->percent }}%</a></td>
                                        <td>{{ $discount->expire_at->diffForHumans() }}</td>
                                        <td>{{ $discount->discription }}</td>
                                        <td>{{ $discount->uses }}نفر</td>
                                        <td>
                                            <a href="#" onclick="handleDeleteDiscount(event,'{{ $discount->id }}')"
                                               class="item-delete mlg-15"></a>
                                            <a href="{{ route('discount.edit',$discount->id) }}" class="item-edit "
                                               title="ویرایش"></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-4 bg-white">
                    <p class="box__title">ایجاد تخفیف جدید</p>
                    <form action="{{ route("discount.store") }}" method="post" class="padding-30">
                        @csrf
                        <x-input type="text" placeholder="کد تخفیف" name="code"/>
                        <x-input type="text" name="percent" placeholder="درصد تخفیف" class="text"/>
                        <x-input type="text" name="usage_limitation" placeholder="محدودیت افراد" class="text"/>
                        <x-input id="date_picker" type="text" name="expire_at" placeholder="محدودیت زمانی به ساعت"
                                 class="text"/>
                        <p class="box__title">این تخفیف برای</p>
                        <div class="notificationGroup">
                            <input id="discounts-field-1" class="discounts-field-pn" name="type" value="all"
                                   type="radio">
                            <label for="discounts-field-1">همه دوره ها</label>
                        </div>
                        <div class="notificationGroup">
                            <input id="discounts-field-2" class="discounts-field-pn" name="type" value="single"
                                   type="radio">
                            <label for="discounts-field-2">دوره خاص</label>
                        </div>

                        <div class="dropdown-select wide " tabindex="0">
                            <select name="courses[]" id="js_select_2" multiple="multiple"
                                    style="height: auto !important;">
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            </select>

                            @error("courses")
                            <div class="text-red">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>
                        <x-input type="text" name="link" placeholder="لینک اطلاعات بیشتر" class="text"/>
                        <x-input type="text" name="description" placeholder="توضیحات"
                                 class="text margin-bottom-15"/>

                        <button class="btn btn-webamooz_net">اضافه کردن</button>
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
        $("#js_select_2").select2({width: '100%'});


        function handleDeleteDiscount(e, discount_id) {
            e.preventDefault();
            $.ajax(
                {
                    url: '/discount/' + discount_id + '+/delete',
                    type: 'DELETE',
                    data: {
                        "_token": '{{ csrf_token() }}',
                    },
                    success: function (respose) {
                        e.target.closest("tr").remove();
                        $.toast({
                            heading: "موفقیت آمیز",
                            text: 'ایتم مورد نظر با موفقیت حذف شد.',
                            showHideTransition: 'slide',
                            icon: 'success'
                        });
                    },
                    error: function (respose) {
                        $.toast({
                            heading: 'خطایی به وجود آمده است',
                            showHideTransition: 'fade',
                            icon: 'error'
                        });
                    }
                });


            console.log(discount_id);
        }


    </script>
@endsection



