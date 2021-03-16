@extends("Front::layouts.master")

@section("content")
    <main id="index">
        <article class="container article">
            @include("Front::layouts.ads")
            @include("Front::layouts.top-info")
            @include("Front::layouts.lastest-course")
            @include("Front::layouts.popular-course")
        </article>
    </main>
    @include("Front::layouts.blog")
@endsection








