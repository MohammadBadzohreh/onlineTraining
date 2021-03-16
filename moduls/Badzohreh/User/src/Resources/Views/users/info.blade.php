@extends("Dashboard::master")
@section("content")
    <div class="content">
        @include("Dashboard::layouts.header")
        @include("Dashboard::layouts.breadcrumb")
        <div class="main-content">
            <div class="row no-gutters font-size-13 margin-bottom-10">
                <div class="col-12 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                    <table class="table">
                        <tr role="row">
                            <td class="margin-left-15"><strong>نام:</strong></td>
                            <td class="text-center">{{ $user->name }}</td>
                        </tr>
                        <tr role="row">
                            <td class="margin-left-15"><strong>ایمیل:</strong></td>
                            <td class="text-center">{{ $user->email }}</td>
                        </tr>
                        <tr role="row">
                            <td class="margin-left-15"><strong>موجودی:</strong></td>
                            <td class="text-center">{{ $user->balance }}</td>
                        </tr>

                        <tr role="row">
                            <td class="margin-left-15"><strong>موبایل:</strong></td>
                            <td class="text-center">{{ $user->mobile ? $user->mobile : "ندارد" }}</td>
                        </tr>

                        <tr role="row">
                            <td class="margin-left-15"><strong>تاریخ تایید ایمیل:</strong></td>
                            <td class="text-center">{{ $user->email_verified_at ? \Morilog\Jalali\Jalalian::fromCarbon($user->email_verified_at) : "تایید نشده" }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row no-gutters font-size-13 margin-bottom-10">
                <div class="col-6 padding-20">
                    <div class="title__row">
                        <p>پرداخت های شما</p>
                    </div>
                    <div class="table__box">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ای دی</th>
                                <th>مقدار پرداختی</th>
                                <th>درگاه پرداخت</th>
                                <th>وضعیت پرداخت</th>
                                <th>تاریخ پرداخت</th>
                            <tr>
                            </thead>
                            <tbody>
                            @foreach($user->payments as $payment)
                                <tr>
                                    <th>{{ $payment->id }}</th>
                                    <th>{{ $payment->amount }}</th>
                                    <th>{{ $payment->getway }}</th>
                                    <th>@lang($payment->status)</th>
                                    <th>{{ $payment->created_at }}</th>
                                <tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="col-6 padding-20">
                    <div class="title__row">
                        <p>خرید های شما</p>
                    </div>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>عنوان دوره</th>
                            <th>مقدار پرداختی</th>
                            <th>وضعیت دوره</th>
                            <th>تاریخ پرداخت</th>
                        <tr>
                        </thead>

                        <tbody>
                        @foreach($user->purchases as $purchase)
                            <tr>
                                <td>{{ $purchase->title }}</td>
                                <td>{{ $purchase->price }}</td>
                                <td>@lang($purchase->status)</td>
                                <td>{{\Morilog\Jalali\Jalalian::fromCarbon($purchase->created_at)}}</td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>


                </div>
            </div>

            <div class="row no-gutters font-size-13 margin-bottom-10">

                <div class="col-6 padding-20">
                    <div class="title__row">
                        <p>تدریس دوره</p>
                    </div>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>عنوان دوره</th>
                            <th>قیمت دوره</th>
                            <th>وضعیت دوره</th>
                            <th>تاریخ ایجاد دوره</th>
                        <tr>
                        </thead>

                        <tbody>
                        @foreach($user->courses as $course)
                            <tr>
                                <td>{{ $course->title }}</td>
                                <td>{{ $course->price }}</td>
                                <td>@lang($course->status)</td>
                                <td>{{\Morilog\Jalali\Jalalian::fromCarbon($course->created_at)}}</td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>


                </div>

                <div class="col-6 padding-20">
                    <div class="w-100 title__row">
                        <p>تسویه حساب ها</p>
                    </div>

                    <table class="table w-100">
                        <thead>
                        <tr>
                            <th>شماره کارت تسویه</th>
                            <th>قیمت تسویه</th>
                            <th>وضعیت تسویه</th>
                            <th>تاریخ ایجاد تسویه</th>
                        <tr>
                        </thead>

                        <tbody>
                        @foreach($user->settlemens as $settlement)
                            <tr>
                                <td>{{ $settlement->from["cart_number"] }}</td>
                                <td>{{ $settlement->amount }}</td>
                                <td>@lang($settlement->status)</td>
                                <td>{{\Morilog\Jalali\Jalalian::fromCarbon($settlement->created_at)}}</td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>


                </div>
            </div>


        </div>
@endsection
