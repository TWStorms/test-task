<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

{{--Load Header--}}
@include('layouts.header')
<body>
    {{--Load Preloader--}}
    @include('layouts.preloader')
    <br><br><br>
    <div class="content" style=" min-height: calc(100vh - 80px);">

        {{--Load Navbar--}}
        @include('layouts.navbar')

        <main>

            {{--Load Body--}}
            @yield('content')

            @yield('page-js')

        </main>
    </div>
        @include('layouts.footer')

</body>
</html>
