@extends("Dashboard::master")

@section('content')
    <div class="content">
        @include("Dashboard::layouts.header")
        @include("Dashboard::layouts.breadcrumb")

        <div class="main-content">
            <form action="{{ route("settlement.update",$sattlement->id) }}" method="post"
                  class="padding-30 bg-white font-size-14">
                @csrf
                @method("put")
                <x-input type="text" name="to[name]"
                         value="{{ is_array($sattlement->to) && array_key_exists('name',$sattlement->to) ? $sattlement->to['name'] : ''  }}"
                         placeholder="نام صاحب حساب فرستنده"/>

                <x-input type="text" name="to[cart_number]"
                         value="{{ is_array($sattlement->to) && array_key_exists('cart_number',$sattlement->to) ? $sattlement->to['cart_number'] : ''  }}"
                         placeholder="شماره صاحب حساب فرستنده"/>

                <x-input type="text" name="from[name]"
                         value="{{ is_array($sattlement->from) && array_key_exists('name',$sattlement->from) ? $sattlement->from['name'] : ''  }}"
                         placeholder=" نام صاحب حساب"/>

                <x-input type="text" name="from[cart_number]"
                         value="{{ is_array($sattlement->from) && array_key_exists('cart_number',$sattlement->from) ? $sattlement->from['cart_number'] : ''  }}"
                         placeholder="نام شماره کارت"/>

                <x-input type="text" name="amount" value="{{ $sattlement->amount }}" placeholder="مبلغ به تومان"
                         class="mb-10"/>

                <x-select-box name="status">
                    @foreach(\Badzohreh\Payment\Models\Settlement::$STATUSES as $status)
                        <option value="{{ $status }}"
                                @if($status == $sattlement->status) selected @endif>@lang($status)</option>
                    @endforeach
                </x-select-box>

                <div class="row no-gutters w-100 border-2 margin-bottom-15 mt-15 text-center">
                    <div class="w-50 padding-20 w-50">موجودی قابل برداشت :‌</div>
                    <div class="bg-fafafa padding-20 w-50">{{ number_format(auth()->user()->balance) }} تومان</div>
                </div>
                <div class="row no-gutters border-2 text-center margin-bottom-15">
                    <div class="w-50 padding-20">حداکثر زمان واریز :‌</div>
                    <div class="w-50 bg-fafafa padding-20">۳ روز</div>
                </div>
                <button type="submit" class="btn btn-webamooz_net">بروزرسانی</button>
            </form>
        </div>


@endsection
