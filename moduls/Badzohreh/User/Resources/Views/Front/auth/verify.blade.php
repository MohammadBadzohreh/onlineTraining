@extends('User::Front.auth.master')

@section('content')
    <form action="{{route('verification.verify')}}" class="form" method="post">
        @csrf
        <a class="account-logo" href="index.html">
            <img src="img/weblogo.png" alt="">
        </a>
        <div class="card-header">
            <p class="activation-code-title">کد فرستاده شده به ایمیل <span>Mohammadniko3@gmail.com</span> را وارد کنید
            </p>
        </div>
        <div class="form-content form-content1">
            <input class="activation-code-input" name="verification_code" placeholder="فعال سازی">
            @error('verification_code')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <br>
            <button class="btn i-t">تایید</button>
            <a href="#" onclick="event.preventDefault();
        document.getElementById('resned_verification_code').submit()">
                ارسال مجدد کد فعال سازی
            </a>


        </div>

        <div class="form-footer">
            <a href="{{route('login')}}">صفحه ورود</a>
        </div>
    </form>
    <form id="resned_verification_code" action="{{route('verification.resend')}}" method="post">
        @csrf
    </form>
@endsection

@section('js')
    <script src="/js/jquery-3.4.1.min.js"></script>
    <script src="/js/activation-code.js"></script>
@endsection
