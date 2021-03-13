@extends("Dashboard::master")

@section('content')
    <div class="content">
        @include("Dashboard::layouts.header")
        @include("Dashboard::layouts.breadcrumb")

        <div class="main-content">
            <form action="{{ route("settlement.store") }}" method="post" class="padding-30 bg-white font-size-14">
                @csrf
                <x-input type="text" name="name" placeholder="نام صاحب حساب"/>

                <x-input type="text" name="cart_number" placeholder="نام شماره کارت"/>

                <x-input type="text" name="amount" value="{{ auth()->user()->balance}}" placeholder="مبلغ به تومان"
                         class="mb-10"/>

                <div class="row no-gutters w-100 border-2 margin-bottom-15 mt-15 text-center">
                    <div class="w-50 padding-20 w-50">موجودی قابل برداشت :‌</div>
                    <div class="bg-fafafa padding-20 w-50">{{ number_format(auth()->user()->balance) }} تومان</div>
                </div>
                <div class="row no-gutters border-2 text-center margin-bottom-15">
                    <div class="w-50 padding-20">حداکثر زمان واریز :‌</div>
                    <div class="w-50 bg-fafafa padding-20">۳ روز</div>
                </div>
                <button type="submit" class="btn btn-webamooz_net">درخواست تسویه</button>
            </form>
        </div>


@endsection
