<!DOCTYPE html>
<html>
<head>

    @include('admin.includes.meta')
    <title>@yield('title')</title>
    @include('admin.includes.css')
</head>
<body>

@yield('content')

@include('admin.includes.footer')


@include('admin.includes.js')
@yield('script')

</body>
</html>