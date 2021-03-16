@extends("Dashboard::master")
@section("content")
    <div class="content">
        @include("Dashboard::layouts.header")

        @include("Dashboard::layouts.breadcrumb")

        <div class="main-content">
            <div class="row no-gutters font-size-13 margin-bottom-10">
                <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                    <p> موجودی حساب فعلی </p>
                    <p>{{ number_format(auth()->user()->balance) }} تومان</p>
                </div>
                <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                    <p> کل فروش دوره ها</p>
                    <p>{{ number_format($totalUserSales) }} تومان</p>
                </div>
                <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                    <p> کارمزد کسر شده </p>
                    <p>{{ number_format($totalUserSiteShare) }} تومان</p>
                </div>
                <div class="col-3 padding-20 border-radius-3 bg-white margin-bottom-10">
                    <p> درآمد خالص </p>
                    <p>{{ number_format($getUserTotalSellerShare) }} تومان</p>
                </div>
            </div>
            <div class="row no-gutters font-size-13 margin-bottom-10">
                <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                    <p> درآمد امروز </p>
                    <p>{{ number_format($getUserToadySales) }} تومان</p>
                </div>
                <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                    <p> درآمد 30 روز گذاشته</p>
                    <p>{{ number_format($getUser30DaysBenefit) }} تومان</p>
                </div>
                <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                    <p> تسویه حساب در حال انجام </p>
                    <p>0 تومان </p>
                </div>
                <div class="col-3 padding-20 border-radius-3 bg-white  margin-bottom-10">
                    <p>تراکنش های موفق امروز ({{ $todaySUseruccessCount }}) تراکنش </p>
                    <p>{{ $getUserTodaySales }} تومان</p>
                </div>
            </div>
            <div class="row no-gutters font-size-13 margin-bottom-10">
                <div class="col-8 padding-20 bg-white margin-bottom-10 margin-left-10 border-radius-3">
                    <div id="container"></div>
                </div>
                <div class="col-4 info-amount padding-20 bg-white margin-bottom-12-p margin-bottom-10 border-radius-3">
                    <p class="title icon-outline-receipt">موجودی قابل تسویه </p>
                    <p class="amount-show color-444">600,000<span> تومان </span></p>
                    <p class="title icon-sync">در حال تسویه</p>
                    <p class="amount-show color-444">0<span> تومان </span></p>
                    <a href="/" class=" all-reconcile-text color-2b4a83">همه تسویه حساب ها</a>
                </div>
            </div>
            <div class="row bg-white no-gutters font-size-13">
                <div class="title__row">
                    <p>تراکنش های اخیر شما</p>
                    <a class="all-reconcile-text margin-left-20 color-2b4a83">نمایش همه تراکنش ها</a>
                </div>
                <div class="table__box">
                    <table width="100%" class="table">
                        <thead role="rowgroup">
                        <tr role="row" class="title-row">
                            <th>شناسه پرداخت</th>
                            <th>ایمیل پرداخت کننده</th>
                            <th>مبلغ (تومان)</th>
                            <th>درامد شما</th>
                            <th>درامد سایت</th>
                            <th>نام دوره</th>
                            <th>تاریخ و ساعت</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($payments as $payment)
                            <tr role="row">
                                <td>{{ $payment->id }}</td>
                                <td>{{ $payment->buyer->email }}</td>
                                <td>{{ $payment->amount }}</td>
                                <td>{{ $payment->seller_share }}</td>
                                <td>{{ $payment->site_share }}</td>
                                <td>{{ $payment->paymentable->title }}</td>
                                <td style="direction: ltr">{{ \Morilog\Jalali\Jalalian::fromCarbon($payment->created_at)->format("Y/m/d H:i:s") }}</td>
                                <td><span class="text-success">@lang($payment->status)</span></td>
                                <td class="i__oprations">
                                    <a href="" class="item-delete margin-left-10" title="حذف"></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("js")
    @include("Dashboard::chart")
@endsection
