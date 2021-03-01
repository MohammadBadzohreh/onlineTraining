@extends("Dashboard::master")
@section("css")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css"/>
    <link rel="stylesheet" href="/panel/css/jquery.toast.min.css" type="text/css">
@endsection



@section('content')
    <div class="content">
        @include("Dashboard::layouts.header")
        @include("Dashboard::layouts.breadcrumb")


        <div class="main-content padding-0 categories">
            <div class="row no-gutters">

                <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                    <p>کل فروش ۳۰ روز گذشته سایت </p>
                    <p>{{ number_format($alllast30DaysPayments) }} تومان</p>
                </div>
                <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                    <p>درامد خالص ۳۰ روز گذشته سایت</p>
                    <p>{{ number_format($alllast30DaysPaymentsSite) }} تومان</p>
                </div>
                <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                    <p>کل فروش سایت</p>
                    <p>{{ number_format($allPayments) }} تومان</p>
                </div>
                <div class="col-3 padding-20 border-radius-3 bg-white margin-bottom-10">
                    <p> کل درآمد خالص سایت</p>
                    <p>{{ number_format($allPaymentsSite) }} تومان</p>
                </div>

                <div class="col-12 bg-white padding-30 margin-bottom-20">
                    <div id="container"></div>
                </div>


                <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
                    <div class="d-flex flex-space-between item-center flex-wrap padding-30 border-radius-3 bg-white">
                        <p class="margin-bottom-10">همه تراکنش ها</p>
                        <div class="t-header-search">
                            <form action="">
                                <div class="t-header-searchbox font-size-13">
                                    <input type="text" class="text search-input__box font-size-13"
                                           placeholder="جستجوی تراکنش">
                                    <div class="t-header-search-content " style="display: none;">
                                        <input type="text" name="email" value="{{ request()->email }}" class="text"
                                               placeholder="ایمیل">
                                        <input type="text" name="amount" value="{{ request()->amount }}" class="text"
                                               placeholder="مبلغ به تومان">
                                        <input type="text" name="invoice_id" value="{{ request()->invoice_id }}"
                                               class="text" placeholder="شماره">
                                        <input type="text" name="start_date" value="{{ request()->start_date }}"
                                               class="text"
                                               placeholder="از تاریخ : 1399/10/11">
                                        <input type="text" name="end_date" value="{{ request()->end_date }}"
                                               class="text margin-bottom-20"
                                               placeholder="تا تاریخ : 1399/10/12">
                                        <button class="btn btn-webamooz_net">جستجو</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table__box">
                        <table class="table">
                            <thead role="rowgroup">
                            <tr role="row" class="title-row">
                                <th>ای دی</th>
                                <th>نام و نام خانوادگی</th>
                                <th>شناسه پرداخت</th>
                                <th>ایمیل پرداخت کننده</th>
                                <th>مبلغ (تومان)</th>
                                <th>درامد مدرس</th>
                                <th>درامد سایت</th>
                                <th>نام دوره</th>
                                <th>تاریخ و ساعت</th>
                                <th>وضعیت</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>{{ $payment->buyer->name }}</td>
                                    <td>{{ $payment->invoice_id }}</td>
                                    <td>{{ $payment->buyer->email }}</td>
                                    <td>{{ $payment->amount }}</td>
                                    <td>{{ $payment->seller_share }}</td>
                                    <td>{{ $payment->site_share }}</td>
                                    <td>{{ $payment->paymentable->title }}</td>
                                    <td style="direction: ltr">{{ \Morilog\Jalali\Jalalian::fromCarbon($payment->created_at)->format("Y/m/d H:i:s")}}</td>
                                    <td class="@if($payment->status == "accepted") text-success @else text-error @endif">@lang($payment->status) </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection

@section("js")
@include("Dashboard::chart")
@endsection








