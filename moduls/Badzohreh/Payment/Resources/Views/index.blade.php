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


                <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
                    <p class="box__title">پرداخت ها</p>
                    <div class="table__box">
                        <table class="table">
                            <thead role="rowgroup">
                            <tr role="row" class="title-row">
                                <th>شناسه پرداخت</th>
                                <th>نام و نام خانوادگی</th>
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
                                    <td>{{ $payment->buyer->email }}</td>
                                    <td>{{ $payment->amount }}</td>
                                    <td>{{ $payment->seller_share }}</td>
                                    <td>{{ $payment->site_share }}</td>
                                    <td>{{ $payment->paymentable->title }}</td>
                                    <td>{{ $payment->created_at }}</td>
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








