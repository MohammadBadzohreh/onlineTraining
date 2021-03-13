@extends("Dashboard::master")
@section("content")
    <div class="content">
        @include("Dashboard::layouts.header")
        @include("Dashboard::layouts.breadcrumb")
        <div class="main-content">
            <div class="tab__box">
                <div class="tab__items">
                    <a class="tab__item  @if(!request()->has('status')) is-active @endif" href="?"> همه تسویه ها</a>
                    <a class="tab__item @if(request()->has('status')) is-active @endif"
                       href="?status={{ \Badzohreh\Payment\Models\Settlement::STATUS_SATTELED }}">تسویه های واریز
                        شده</a>
                    <a class="tab__item " href="{{ route('settlement.create') }}">درخواست تسویه جدید</a>
                </div>
            </div>
            <div class="bg-white padding-20">
                <div class="t-header-search">
                    <form action="" onclick="event.preventDefault();">
                        <div class="t-header-searchbox font-size-13">
                            <input type="text" class="text search-input__box font-size-13"
                                   placeholder="جستجوی در تسویه حساب ها">
                            <div class="t-header-search-content ">
                                <input type="text" class="text" placeholder="شماره کارت">
                                <input type="text" class="text" placeholder="شماره">
                                <input type="text" class="text" placeholder="تاریخ">
                                <input type="text" class="text" placeholder="ایمیل">
                                <input type="text" class="text margin-bottom-20" placeholder="نام و نام خانوادگی">
                                <btutton class="btn btn-webamooz_net">جستجو</btutton>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>شناسه تسویه</th>
                        <th>نام درخواست دهنده</th>
                        <th>مبدا</th>
                        <th>مقصد</th>
                        <th>شماره کارت</th>
                        <th>تاریخ درخواست واریز</th>
                        <th>تاریخ واریز شده</th>
                        <th>مبلغ (تومان )</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($settlements as $settlement)
                        <tr role="row">
                            <td>{{ $settlement->transaction_id }}</td>
                            <td>
                                <a href="{{ route('user.info',$settlement->user_id) }}">{{ $settlement->user->name }}</a>
                            </td>
                            <td>{{ $settlement->from ? $settlement->from["name"] : "-" }}</td>
                            <td>{{ $settlement->to ? $settlement->to["name"] : "-"  }}</td>
                            <td>{{ $settlement->from ? $settlement->from["cart_number"] : "-" }}</td>
                            <td>{{ $settlement->created_at->diffForHumans() }}</td>
                            <td> {{ $settlement->setteld_at ? $settlement->setteld_at->diffForHumans() : "-"  }}</td>
                            <td>{{ $settlement->amount }}</td>
                            <td><span
                                    class="{{ $settlement->sattlementClassColor() }}">@lang($settlement->status)</span>
                            </td>
                            <td>
                                <a href="" class="item-delete mlg-15" title="حذف"></a>
                                <a href="show-comment.html" class="item-reject mlg-15" title="رد"></a>
                                <a href="show-comment.html" class="item-confirm mlg-15" title="تایید"></a>
                                <a href="{{ route("settlement.edit",$settlement->id) }}" class="item-edit "
                                   title="ویرایش"></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
