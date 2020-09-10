<!DOCTYPE html>
<html lang="en">
@include('Dashboard::layouts.head')
<body>
@include('Dashboard::layouts.sidebar')
@yield("content")
</body>
@include('Dashboard::layouts.js')
</html>