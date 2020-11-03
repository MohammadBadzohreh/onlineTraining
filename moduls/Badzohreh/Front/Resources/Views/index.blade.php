@extends("Front::layouts.master")

@section("content")
    <article class="container article">
        @include("Front::layouts.ads")
        @include("Front::layouts.top-info")
        @include("Front::layouts.lastest-course")
        @include("Front::layouts.popular-course")
    </article>
    @include("Front::layouts.blog")
@endsection