<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    @include('frontEnd.includes.css')
    @include('frontEnd.includes.meta')
</head>
<body>

@include('frontEnd.includes.navigation')

@yield('content')

@include('frontEnd.includes.footer')


</body>

@include('frontEnd.includes.js')

</html>