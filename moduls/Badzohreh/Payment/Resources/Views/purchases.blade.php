@extends("Dashboard::master")
@section("css")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css"/>
    <link rel="stylesheet" href="/panel/css/jquery.toast.min.css" type="text/css">
@endsection

@section('content')
    <div class="content">
        @include("Dashboard::layouts.header")
        @include("Dashboard::layouts.breadcrumb")
        <div class="main-content">
            <div class="table__box">
                <table class="table">
                    <thead>
                    <tr class="title-row">
                        <th>عنوان دوره</th>
                        <th>تاریخ پرداخت</th>
                        <th>مقدار پرداختی</th>
                        <th>وضعیت پرداخت</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td>{{ $payment->paymentable->title }}</td>
                            <td>{{\Morilog\Jalali\Jalalian::fromCarbon($payment->created_at)->format("%d %B %Y") }}</td>
                            <td>{{ $payment->amount }} تومان</td>
                            <td class="@if($payment->status == \Badzohreh\Payment\Models\Payment::STATUS_ACCEPTED) text-success @else text-error @endif">@lang($payment->status)</td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
            {{-- todo add pagination--}}

        </div>
    </div>



@endsection
