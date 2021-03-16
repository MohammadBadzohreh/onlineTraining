@extends("Dashboard::master")

@section("content")
    <div class="content">
        @include("Dashboard::layouts.header")
        @include("Dashboard::layouts.breadcrumb")
        <div class="main-content padding-0">
            <p class="box__title">بروزرسانی سرفصل </p>
            <div class="row no-gutters bg-white">
                <div class="col-12">
                    <form action="{{route("season.update",$season->id)}}" method="post" class="padding-30">
                        @csrf
                        @method("PATCH")
                        <x-input type="text" name="title" value="{{$season->title}}" placeholder="عنوان سرفصل" required/>
                        <x-input type="text" name="number" value="{{$season->number}}" placeholder="شماره سرفصل"/>
                        <button class="btn btn-webamooz_net">بروزرسانی دوره</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("js")
    <script src="js/tagsInput.js"></script>

@endsection