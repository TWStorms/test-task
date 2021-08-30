<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

{{--Load Header--}}
@include('layouts.header')
<body>
    {{--Load Preloader--}}
    @include('layouts.preloader')
    <div class="content">

        {{--Load Navbar--}}
        @include('layouts.navbar')

        <main class="py-4">

            {{--Load Body--}}
            @yield('content')

            @yield('page-js')

        </main>
    </div>


    {{--Load Footer--}}
    @include('layouts.footer')
</body>
</html>
