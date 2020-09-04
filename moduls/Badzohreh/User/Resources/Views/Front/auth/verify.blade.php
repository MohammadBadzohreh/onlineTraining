@extends('User::Front.auth.master')

@section('content')
    <form action="{{route('verification.verify')}}" class="form" method="post">
        <a class="account-logo" href="index.html">
            <img src="img/weblogo.png" alt="">
        </a>
        <div class="card-header">
            <p class="activation-code-title">کد فرستاده شده به ایمیل <span>Mohammadniko3@gmail.com</span> را وارد کنید
            </p>
        </div>
        <div class="form-content form-content1">
            <input class="activation-code-input" placeholder="فعال سازی">
            <br>
            <button class="btn i-t">تایید</button>

        </div>
        <div class="form-footer">
            <a href="{{route('login')}}">صفحه ورود</a>
        </div>
    </form>
@endsection

@section('js')
    <script src="/js/jquery-3.4.1.min.js"></script>
    <script src="/js/activation-code.js"></script>
@endsection
