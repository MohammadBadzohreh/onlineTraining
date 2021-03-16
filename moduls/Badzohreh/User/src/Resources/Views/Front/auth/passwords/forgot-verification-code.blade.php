@extends('User::Front.auth.master')

@section('content')

    <form action="{{route("reset.password.check")}}" class="form" method="post">
        @csrf
        <a class="account-logo" href="/">
            <img src="/img/weblogo.png" alt="">
        </a>
        <div class="card-header">
            <p class="activation-code-title">کد فرستاده شده به ایمیل <span>{{request()->email}}</span> را وارد کنید
            </p>
        </div>
        <input type="hidden" name="email" value="{{ request()->email }}">

        <div class="form-content form-content1">
            <input class="activation-code-input" name="verification_code" placeholder="فعال سازی">

            @error('verification_code')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <br>
            <button class="btn i-t">تایید</button>

        </div>
        <div class="form-footer">
            <a href="{{route('register')}}">صفحه ثبت نام</a>
        </div>
    </form>


@endsection


@section('js')
    <script src="/js/jquery-3.4.1.min.js"></script>
    <script src="/js/activation-code.js"></script>
@endsection
