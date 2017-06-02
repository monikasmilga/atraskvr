<!DOCTYPE html>
<html>
    <head>
        @include('front-end.includes.meta')
        <title>@yield('title')</title>
        @include('front-end.includes.css')
    </head>

    <body>

        @include('front-end.includes.navigation')
        @yield('content')

        @include('front-end.includes.js')
        @yield('script')

        @include('front-end.includes.footer')


    </body>
</html>