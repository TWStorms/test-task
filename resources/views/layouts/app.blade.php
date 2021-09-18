<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

{{--Load Header--}}
@include('layouts.header')
<body>
    {{--Load Preloader--}}
    @include('layouts.preloader')
    <br><br><br>
    <div class="content">

        {{--Load Navbar--}}
        @include('layouts.navbar')

        <main>

            {{--Load Body--}}
            @yield('content')

            @yield('page-js')

        </main>
    </div>


    {{--Load Footer--}}
    <div style="position: page; bottom: 0px; width: 100%;">
        @include('layouts.footer')
    </div>
</body>
</html>
