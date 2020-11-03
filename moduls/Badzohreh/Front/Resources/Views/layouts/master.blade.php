<!doctype html>
<html lang="fa">
@include("Front::layouts.head")
<body>

@include("Front::layouts.header")

<main id="index">
    @yield("content")

</main>
@include("Front::layouts.footer")

<div class="overlay"></div>

@include("Front::layouts.foot")

</body>
</html>